<?php
/**
 * Test fixture.
 *
 * @see \PHP_CodeSniffer\Tests\Core\Ruleset\RegisterSniffsMissingInterfaceTest
 */

namespace Fixtures\TestStandard\Sniffs\MissingInterface;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractArraySniff;

final class ValidImplementsViaAbstractSniff extends AbstractArraySniff
{

    protected function processSingleLineArray(File $phpcsFile, int $stackPtr, int $arrayStart, int $arrayEnd, array $indices)
    {
        // Do something.
    }

    protected function processMultiLineArray(File $phpcsFile, int $stackPtr, int $arrayStart, int $arrayEnd, array $indices)
    {
        // Do something.
    }
}
