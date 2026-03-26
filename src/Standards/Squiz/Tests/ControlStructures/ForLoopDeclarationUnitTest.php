<?php
/**
 * Unit test class for the ForLoopDeclaration sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Tests\ControlStructures;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the ForLoopDeclaration sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ForLoopDeclarationSniff
 */
final class ForLoopDeclarationUnitTest extends AbstractSniffTestCase
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
            case 'ForLoopDeclarationUnitTest.1.inc':
                return [
                    8   => 2,
                    11  => 2,
                    14  => 2,
                    17  => 2,
                    21  => 6,
                    27  => 1,
                    30  => 1,
                    37  => 2,
                    39  => 2,
                    43  => 1,
                    49  => 1,
                    50  => 1,
                    53  => 1,
                    54  => 1,
                    59  => 4,
                    62  => 1,
                    63  => 1,
                    64  => 1,
                    66  => 1,
                    69  => 1,
                    74  => 1,
                    77  => 1,
                    82  => 2,
                    86  => 2,
                    91  => 1,
                    95  => 1,
                    101 => 2,
                    105 => 2,
                    110 => 1,
                    116 => 2,
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
     * @param string $testFile The name of the file being tested.
     *
     * @return array<int, int>
     */
    public function getWarningList($testFile = '')
    {
        return [];
    }
}
