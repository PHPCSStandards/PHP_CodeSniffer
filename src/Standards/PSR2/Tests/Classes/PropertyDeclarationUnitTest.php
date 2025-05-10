<?php
/**
 * Unit test class for the PropertyDeclaration sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PSR2\Tests\Classes;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the PropertyDeclaration sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\PSR2\Sniffs\Classes\PropertyDeclarationSniff
 */
final class PropertyDeclarationUnitTest extends AbstractSniffTestCase
{


    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @param string $testFile The name of the file being tested.
     *
     * @return array<int, int>
     */
    public function getErrorList($testFile='')
    {
        switch ($testFile) {
        case 'PropertyDeclarationUnitTest.1.inc':
            return [
                7   => 1,
                9   => 2,
                10  => 1,
                11  => 1,
                17  => 1,
                18  => 1,
                23  => 1,
                38  => 1,
                41  => 1,
                42  => 1,
                50  => 2,
                51  => 1,
                55  => 1,
                56  => 1,
                61  => 1,
                62  => 1,
                68  => 1,
                69  => 1,
                71  => 1,
                72  => 1,
                76  => 1,
                80  => 1,
                82  => 1,
                84  => 1,
                86  => 1,
                90  => 1,
                94  => 1,
                95  => 1,
                96  => 1,
                97  => 2,
                106 => 2,
                110 => 1,
                112 => 1,
                114 => 1,
                116 => 1,
            ];

        default:
            return [];
        }//end switch

    }//end getErrorList()


    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @param string $testFile The name of the file being tested.
     *
     * @return array<int, int>
     */
    public function getWarningList($testFile='')
    {
        switch ($testFile) {
        case 'PropertyDeclarationUnitTest.1.inc':
            return [
                13  => 1,
                14  => 1,
                15  => 1,
                53  => 1,
                102 => 1,
            ];

        default:
            return [];
        }//end switch

    }//end getWarningList()


}//end class
