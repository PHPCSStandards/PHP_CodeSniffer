<?php
/**
 * Unit test class for the ValidLogicalOperators sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Tests\Operators;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the ValidLogicalOperators sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Squiz\Sniffs\Operators\ValidLogicalOperatorsSniff
 */
final class ValidLogicalOperatorsUnitTest extends AbstractSniffUnitTest
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
            5  => 1,
            11 => 1,
            17 => 2,
            29 => 1,
            30 => 1,
            31 => 1,
            32 => 1,
            33 => 1,
            34 => 1,
            35 => 1,
            36 => 1,
            37 => 1,
            38 => 1,
            39 => 1,
            40 => 1,
            41 => 1,
            42 => 1,
            43 => 1,
            45 => 1,
            46 => 2,
            47 => 1,
            48 => 1,
            49 => 2,
            50 => 2,
            52 => 1,
            53 => 1,
            54 => 2,
            55 => 1,
            56 => 1,
        ];

    }//end getErrorList()


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

    }//end getWarningList()


}//end class
