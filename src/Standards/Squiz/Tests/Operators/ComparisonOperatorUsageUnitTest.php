<?php
/**
 * Unit test class for the ComparisonOperatorUsage sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Tests\Operators;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the ComparisonOperatorUsage sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Squiz\Sniffs\Operators\ComparisonOperatorUsageSniff
 */
final class ComparisonOperatorUsageUnitTest extends AbstractSniffTestCase
{


    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getErrorList()
    {
        return [
            6   => 1,
            7   => 1,
            10  => 1,
            11  => 1,
            18  => 1,
            19  => 1,
            22  => 1,
            23  => 1,
            29  => 2,
            32  => 2,
            38  => 4,
            47  => 2,
            69  => 1,
            72  => 1,
            75  => 1,
            78  => 1,
            80  => 1,
            82  => 1,
            83  => 1,
            89  => 1,
            92  => 1,
            100 => 1,
            106 => 1,
            112 => 1,
            123 => 1,
            127 => 1,
            131 => 1,
            135 => 1,
            145 => 1,
            146 => 1,
            147 => 1,
            148 => 1,
            156 => 2,
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
    public function getWarningList()
    {
        return [];
    }
}
