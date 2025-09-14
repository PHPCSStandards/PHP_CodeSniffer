<?php
/**
 * Unit test class for the ControlSignature sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Tests\ControlStructures;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the ControlSignature sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ControlSignatureSniff
 */
final class ControlSignatureUnitTest extends AbstractSniffTestCase
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
    public function getErrorList($testFile = '')
    {

        switch ($testFile) {
            case 'ControlSignatureUnitTest.1.inc':
                return [
                    7   => 1,
                    12  => 1,
                    15  => 1,
                    18  => 1,
                    20  => 1,
                    22  => 2,
                    28  => 2,
                    32  => 1,
                    38  => 2,
                    42  => 1,
                    48  => 2,
                    52  => 1,
                    62  => 2,
                    66  => 2,
                    76  => 4,
                    80  => 2,
                    94  => 1,
                    99  => 1,
                    108 => 1,
                    112 => 1,
                    122 => 1,
                    130 => 2,
                    134 => 1,
                    150 => 1,
                    153 => 1,
                    158 => 1,
                    165 => 1,
                    170 => 2,
                    185 => 1,
                    190 => 2,
                    191 => 2,
                    195 => 1,
                    227 => 1,
                    234 => 1,
                    239 => 2,
                    243 => 2,
                    244 => 2,
                    248 => 1,
                    259 => 1,
                    262 => 1,
                    267 => 1,
                    269 => 1,
                    276 => 1,
                    279 => 1,
                    283 => 1,
                    306 => 3,
                    309 => 1,
                    315 => 1,
                ];

            default:
                return [];
        }
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
