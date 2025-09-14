<?php
/**
 * Base class to use when testing parts of the tokenizer.
 *
 * This is a near duplicate of the AbstractMethodTestCase class, with the
 * difference being that it allows for recording code coverage for tokenizer tests.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2018-2019 Juliette Reinders Folmer. All rights reserved.
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers;

use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHP_CodeSniffer\Tests\Core\AbstractMethodTestCase;
use PHP_CodeSniffer\Tokenizers\PHP;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

abstract class AbstractTokenizerTestCase extends TestCase
{

    /**
     * The tab width setting to use when tokenizing the file.
     *
     * This allows for test case files to use a different tab width than the default.
     *
     * @var integer
     */
    protected $tabWidth = 4;

    /**
     * The \PHP_CodeSniffer\Files\File object containing the parsed contents of the test case file.
     *
     * @var \PHP_CodeSniffer\Files\File
     */
    protected $phpcsFile;


    /**
     * Initialize & tokenize \PHP_CodeSniffer\Files\File with code from the test case file.
     *
     * The test case file for a unit test class has to be in the same directory
     * directory and use the same file name as the test class, using the .inc extension.
     *
     * @return void
     */
    protected function setUp(): void
    {
        if (isset($this->phpcsFile) === false) {
            $_SERVER['argv'] = [];
            $config          = new ConfigDouble();

            // Also set a tab-width to enable testing tab-replaced vs `orig_content`.
            $config->tabWidth = $this->tabWidth;

            $ruleset = new Ruleset($config);

            // Default to a file with the same name as the test class. Extension is property based.
            $relativeCN     = str_replace(__NAMESPACE__, '', static::class);
            $relativePath   = str_replace('\\', DIRECTORY_SEPARATOR, $relativeCN);
            $pathToTestFile = realpath(__DIR__) . $relativePath . '.inc';

            $this->phpcsFile = new LocalFile($pathToTestFile, $ruleset, $config);
            $this->phpcsFile->parse();
        }
    }


    /**
     * Test QA: verify that a test case file does not contain any duplicate test markers.
     *
     * When a test case file contains a lot of test cases, it is easy to overlook that a test marker name
     * is already in use.
     * A test wouldn't necessarily fail on this, but would not be testing what is intended to be tested as
     * it would be verifying token properties for the wrong token.
     *
     * This test safeguards against this.
     *
     * @coversNothing
     *
     * @return void
     */
    public function testTestMarkersAreUnique()
    {
        AbstractMethodTestCase::assertTestMarkersAreUnique($this->phpcsFile);
    }


    /**
     * Get the token pointer for a target token based on a specific comment found on the line before.
     *
     * Note: the test delimiter comment MUST start with "/* test" to allow this function to
     * distinguish between comments used *in* a test and test delimiters.
     *
     * @param string                       $commentString The delimiter comment to look for.
     * @param int|string|array<int|string> $tokenType     The type of token(s) to look for.
     * @param string                       $tokenContent  Optional. The token content for the target token.
     *
     * @return int
     */
    protected function getTargetToken($commentString, $tokenType, $tokenContent = null)
    {
        return AbstractMethodTestCase::getTargetTokenFromFile($this->phpcsFile, $commentString, $tokenType, $tokenContent);
    }


    /**
     * Clear the static "resolved tokens" cache property on the Tokenizer\PHP class.
     *
     * This method should be used selectively by tests to ensure the code under test is actually hit
     * by the test testing the code.
     *
     * @return void
     */
    public static function clearResolvedTokensCache()
    {
        $property = new ReflectionProperty(PHP::class, 'resolveTokenCache');
        (PHP_VERSION_ID < 80100) && $property->setAccessible(true);
        $property->setValue(null, []);
        (PHP_VERSION_ID < 80100) && $property->setAccessible(false);
    }
}
