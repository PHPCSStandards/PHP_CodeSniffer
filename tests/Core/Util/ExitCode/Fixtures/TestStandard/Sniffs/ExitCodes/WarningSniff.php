<?php
/**
 * Test fixture.
 *
 * @see \PHP_CodeSniffer\Tests\Core\Util\ExitCode\ExitCodeTest
 */

namespace TestStandard\Sniffs\ExitCodes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class WarningSniff implements Sniff
{

    public function register()
    {
        return [T_COMMENT];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        $phpcsFile->addWarning('Commments are not allowed', $stackPtr, 'Found');
    }
}
