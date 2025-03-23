<?php
/**
 * Unit test class for the DeclareStatement sniff.
 *
 * @author    Sertan Danis <sdanis@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PSR12\Tests\Files;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the DeclareStatement sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\PSR12\Sniffs\Files\DeclareStatementSniff
 */
final class DeclareStatementUnitTest extends AbstractSniffUnitTest
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
        case 'DeclareStatementUnitTest.1.inc':
            return [
                2  => 1,
                3  => 1,
                4  => 1,
                5  => 2,
                6  => 1,
                7  => 1,
                9  => 2,
                10 => 1,
                11 => 3,
                12 => 2,
                13 => 2,
                14 => 1,
                16 => 3,
                18 => 1,
                19 => 3,
                21 => 1,
                24 => 1,
                26 => 2,
                28 => 3,
                34 => 2,
                38 => 1,
                43 => 1,
                46 => 1,
                47 => 1,
                49 => 1,
                54 => 6,
            ];
        case 'DeclareStatementUnitTest.4.inc':
            return [
                3  => 1,
                4  => 1,
                5  => 1,
                6  => 1,
                7  => 1,
                8  => 1,
                9  => 1,
                10 => 1,
                11 => 1,
                12 => 1,
                13 => 1,
                14 => 1,
                15 => 1,
                16 => 1,
                17 => 1,
                18 => 1,
                19 => 1,
                20 => 1,
                21 => 1,
                23 => 1,
                25 => 1,
                27 => 1,
                29 => 1,
                31 => 1,
                33 => 1,
                35 => 1,
                37 => 1,
                39 => 1,
                41 => 1,
                43 => 1,
                45 => 1,
                46 => 1,
                47 => 1,
                48 => 1,
                49 => 1,
                50 => 1,
                52 => 1,
                54 => 1,
                56 => 1,
                58 => 1,
                60 => 1,
                62 => 1,
            ];
        case 'DeclareStatementUnitTest.5.inc':
            return [
                3  => 1,
                6  => 1,
                10 => 2,
                18 => 1,
                19 => 1,
                20 => 1,
                23 => 1,
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
     * @return array<int, int>
     */
    public function getWarningList()
    {
        return [];

    }//end getWarningList()


}//end class
