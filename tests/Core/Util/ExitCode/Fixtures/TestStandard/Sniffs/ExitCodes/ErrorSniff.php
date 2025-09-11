<?php
/**
 * Test fixture.
 *
 * @see \PHP_CodeSniffer\Tests\Core\Util\ExitCode\ExitCodeTest
 */

namespace TestStandard\Sniffs\ExitCodes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ErrorSniff implements Sniff
{

    public function register()
    {
        return [T_VARIABLE];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['content'] === '$var') {
            $phpcsFile->addError('Variables should have descriptive names. Found: $var', $stackPtr, 'VarFound');
        }
    }
}
