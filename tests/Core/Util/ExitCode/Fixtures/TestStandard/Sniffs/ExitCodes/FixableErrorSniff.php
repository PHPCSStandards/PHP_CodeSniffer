<?php
/**
 * Test fixture.
 *
 * @see \PHP_CodeSniffer\Tests\Core\Util\ExitCode\ExitCodeTest
 */

namespace TestStandard\Sniffs\ExitCodes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class FixableErrorSniff implements Sniff
{

    public function register()
    {
        return [T_OPEN_TAG];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        $tokens     = $phpcsFile->getTokens();
        $contents   = $tokens[$stackPtr]['content'];
        $contentsLC = strtolower($contents);
        if ($contentsLC !== $contents) {
            $fix = $phpcsFile->addFixableError('Use lowercase open tag', $stackPtr, 'Found');
            if ($fix === true) {
                $phpcsFile->fixer->replaceToken($stackPtr, $contentsLC);
            }
        }
    }
}
