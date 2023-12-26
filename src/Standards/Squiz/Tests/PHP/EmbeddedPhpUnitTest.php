<?php
/**
 * Unit test class for the EmbeddedPhp sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Tests\PHP;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the EmbeddedPhp sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\EmbeddedPhpSniff
 */
final class EmbeddedPhpUnitTest extends AbstractSniffUnitTest
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
        case 'EmbeddedPhpUnitTest.1.inc':
            return [
                7   => 1,
                12  => 1,
                18  => 1,
                19  => 2,
                20  => 1,
                21  => 1,
                22  => 3,
                24  => 1,
                26  => 1,
                29  => 1,
                30  => 1,
                31  => 1,
                34  => 1,
                36  => 1,
                40  => 1,
                41  => 1,
                44  => 1,
                45  => 1,
                49  => 1,
                59  => 1,
                63  => 1,
                93  => 1,
                94  => 2,
                100 => 1,
                102 => 1,
                112 => 1,
                113 => 1,
                116 => 1,
                117 => 1,
                120 => 1,
                121 => 1,
                128 => 1,
                129 => 1,
                132 => 1,
                134 => 1,
                136 => 1,
                138 => 1,
                142 => 1,
                145 => 1,
                151 => 1,
                158 => 1,
                165 => 1,
                169 => 1,
                175 => 1,
                176 => 2,
                178 => 1,
                179 => 1,
                180 => 2,
                181 => 1,
            ];

        case 'EmbeddedPhpUnitTest.2.inc':
            return [
                5 => 2,
                6 => 2,
                7 => 2,
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
