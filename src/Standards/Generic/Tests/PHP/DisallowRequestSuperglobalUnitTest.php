<?php
/**
 * Unit test class for the DisallowRequestSuperglobal sniff.
 *
 * @author    Jeantwan Teuma <jeant.m24@gmail.com>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Tests\PHP;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the DisallowRequestSuperglobal sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DisallowRequestSuperglobalSniff
 */
final class DisallowRequestSuperglobalUnitTest extends AbstractSniffTestCase
{


    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array<int, int>
     */
    protected function getErrorList()
    {
        return [
            2  => 1,
            12 => 1,
            13 => 1,
        ];
    }


    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array<int, int>
     */
    protected function getWarningList()
    {
        return [];
    }
}
