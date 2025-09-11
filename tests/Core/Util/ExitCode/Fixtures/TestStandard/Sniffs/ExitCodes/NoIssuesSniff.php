<?php
/**
 * Test fixture.
 *
 * @see \PHP_CodeSniffer\Tests\Core\Util\ExitCode\ExitCodeTest
 */

namespace TestStandard\Sniffs\ExitCodes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class NoIssuesSniff implements Sniff
{

    public function register()
    {
        return [T_ECHO];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        // Do nothing.
    }
}
