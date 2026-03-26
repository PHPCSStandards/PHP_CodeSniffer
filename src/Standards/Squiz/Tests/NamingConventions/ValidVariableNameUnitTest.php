<?php
/**
 * Unit test class for the ValidVariableName sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Tests\NamingConventions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the ValidVariableName sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Squiz\Sniffs\NamingConventions\ValidVariableNameSniff
 */
final class ValidVariableNameUnitTest extends AbstractSniffTestCase
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
            case 'ValidVariableNameUnitTest.1.inc':
                return [
                    3   => 1,
                    5   => 1,
                    10  => 1,
                    12  => 1,
                    15  => 1,
                    17  => 1,
                    20  => 1,
                    22  => 1,
                    25  => 1,
                    27  => 1,
                    31  => 1,
                    33  => 1,
                    36  => 1,
                    37  => 1,
                    39  => 1,
                    42  => 1,
                    44  => 1,
                    53  => 1,
                    58  => 1,
                    62  => 1,
                    63  => 1,
                    64  => 1,
                    67  => 1,
                    81  => 1,
                    106 => 1,
                    107 => 2,
                    108 => 1,
                    111 => 1,
                    112 => 1,
                    113 => 1,
                    114 => 1,
                    123 => 1,
                    138 => 1,
                    141 => 1,
                    146 => 1,
                    152 => 1,
                    155 => 1,
                    161 => 1,
                    167 => 1,
                    170 => 1,
                    175 => 1,
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
