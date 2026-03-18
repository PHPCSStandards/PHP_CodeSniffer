<?php
/**
 * Test fixture.
 *
 * @see \PHP_CodeSniffer\Tests\Core\Util\ExitCode\ExitCodeTest
 */

namespace TestStandard\Sniffs\ExitCodes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class FixableWarningSniff implements Sniff
{

    public function register()
    {
        return [T_SEMICOLON];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[($stackPtr - 1)]['code'] === T_WHITESPACE) {
            $fix = $phpcsFile->addFixableWarning('There should be no whitespace before a semicolon', ($stackPtr - 1), 'Found');
            if ($fix === true) {
                $phpcsFile->fixer->replaceToken(($stackPtr - 1), '');
            }
        }
    }
}
