#!/usr/bin/env php
<?php
/**
 * Build a PHPCS phar.
 *
 * @author    Benjamin Pearson <bpearson@squiz.com.au>
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Exceptions\RuntimeException;
use PHP_CodeSniffer\Exceptions\TokenizerException;
use PHP_CodeSniffer\Tokenizers\PHP;
use PHP_CodeSniffer\Util\Timing;
use PHP_CodeSniffer\Util\Tokens;

error_reporting(E_ALL);

if (ini_get('phar.readonly') === '1') {
    echo 'Unable to build, phar.readonly in php.ini is set to read only.' . PHP_EOL;
    exit(1);
}

require_once dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/src/Util/Tokens.php';

if (defined('PHP_CODESNIFFER_VERBOSITY') === false) {
    define('PHP_CODESNIFFER_VERBOSITY', 0);
}


/**
 * Replacement for the PHP native php_strip_whitespace() function,
 * which doesn't handle attributes correctly for cross-version PHP.
 *
 * @param string                  $fullpath Path to file.
 * @param \PHP_CodeSniffer\Config $config   Perfunctory Config.
 *
 * @return string
 *
 * @throws \PHP_CodeSniffer\Exceptions\RuntimeException When tokenizer errors are encountered.
 */
function stripWhitespaceAndComments(string $fullpath, Config $config)
{
    $contents = file_get_contents($fullpath);

    try {
        $tokenizer = new PHP($contents, $config, "\n");
        $tokens    = $tokenizer->getTokens();
    } catch (TokenizerException $e) {
        throw new RuntimeException('Failed to tokenize file ' . $fullpath);
    }

    $stripped = '';
    foreach ($tokens as $token) {
        if ($token['code'] === T_ATTRIBUTE_END || $token['code'] === T_OPEN_TAG) {
            $stripped .= $token['content'] . "\n";
            continue;
        }

        if (isset(Tokens::EMPTY_TOKENS[$token['code']]) === false) {
            $stripped .= $token['content'];
            continue;
        }

        if ($token['code'] === T_WHITESPACE) {
            $stripped .= ' ';
        }
    }

    return $stripped;
}


Timing::startTiming();

$scripts = [
    'phpcs',
    'phpcbf',
];

foreach ($scripts as $script) {
    echo "Building $script phar" . PHP_EOL;

    $pharName = $script . '.phar';
    $pharFile = getcwd() . '/' . $pharName;
    echo "\t=> $pharFile" . PHP_EOL;
    if (file_exists($pharFile) === true) {
        echo "\t** file exists, removing **" . PHP_EOL;
        unlink($pharFile);
    }

    $phar = new Phar($pharFile, 0, $pharName);

    /*
        Add the files.
    */

    echo "\t=> adding files... ";

    $srcDir    = realpath(__DIR__ . '/../src');
    $srcDirLen = strlen($srcDir);

    $rdi = new RecursiveDirectoryIterator($srcDir, RecursiveDirectoryIterator::FOLLOW_SYMLINKS);
    $di  = new RecursiveIteratorIterator($rdi, 0, RecursiveIteratorIterator::CATCH_GET_CHILD);

    $config    = new Config();
    $fileCount = 0;

    foreach ($di as $file) {
        $filename = $file->getFilename();

        // Skip hidden files.
        if (substr($filename, 0, 1) === '.') {
            continue;
        }

        $fullpath = $file->getPathname();
        if (strpos($fullpath, DIRECTORY_SEPARATOR . 'Tests' . DIRECTORY_SEPARATOR) !== false) {
            continue;
        }

        $path = 'src' . substr($fullpath, $srcDirLen);

        if (substr($filename, -4) === '.xml') {
            $phar->addFile($fullpath, $path);
        } else {
            // PHP file.
            $phar->addFromString($path, stripWhitespaceAndComments($fullpath, $config));
        }

        ++$fileCount;
    }

    // Add requirements check.
    $phar->addFromString('requirements.php', stripWhitespaceAndComments(realpath(__DIR__ . '/../requirements.php'), $config));

    // Add autoloader.
    $phar->addFromString('autoload.php', stripWhitespaceAndComments(realpath(__DIR__ . '/../autoload.php'), $config));

    // Add licence file.
    $phar->addFile(realpath(__DIR__ . '/../licence.txt'), 'licence.txt');

    echo 'done' . PHP_EOL;
    echo "\t   Added " . $fileCount . ' files' . PHP_EOL;

    /*
        Add the stub.
    */

    echo "\t=> adding stub... ";
    $stub  = '#!/usr/bin/env php' . "\n";
    $stub .= '<?php' . "\n";
    $stub .= 'Phar::mapPhar(\'' . $pharName . '\');' . "\n";
    $stub .= 'require_once "phar://' . $pharName . '/requirements.php";' . "\n";
    $stub .= 'PHP_CodeSniffer\checkRequirements();' . "\n";
    $stub .= 'require_once "phar://' . $pharName . '/autoload.php";' . "\n";
    $stub .= '$runner = new PHP_CodeSniffer\Runner();' . "\n";
    $stub .= '$exitCode = $runner->run' . $script . '();' . "\n";
    $stub .= 'exit($exitCode);' . "\n";
    $stub .= '__HALT_COMPILER();';
    $phar->setStub($stub);

    echo 'done' . PHP_EOL;
}

Timing::printRunTime();

echo PHP_EOL;
echo 'Filesize generated phpcs.phar file: ' . number_format(filesize(dirname(__DIR__) . '/phpcs.phar'), 0, ',', '.') . ' bytes' . PHP_EOL;
echo 'Filesize generated phpcs.phar file: ' . number_format(filesize(dirname(__DIR__) . '/phpcbf.phar'), 0, ',', '.') . ' bytes' . PHP_EOL;
