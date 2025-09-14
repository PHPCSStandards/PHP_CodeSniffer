<?php
/**
 * Unit test class for the ClassComment sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PEAR\Tests\Commenting;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the ClassComment sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\PEAR\Sniffs\Commenting\ClassCommentSniff
 */
final class ClassCommentUnitTest extends AbstractSniffTestCase
{


    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @param string $testFile The name of the test file being tested.
     *
     * @return array<int, int>
     */
    public function getErrorList($testFile = '')
    {
        switch ($testFile) {
            case 'ClassCommentUnitTest.1.inc':
                return [
                    4   => 1,
                    15  => 1,
                    51  => 1,
                    63  => 1,
                    65  => 2,
                    66  => 1,
                    68  => 1,
                    70  => 1,
                    71  => 1,
                    72  => 1,
                    74  => 2,
                    75  => 1,
                    76  => 1,
                    77  => 1,
                    85  => 1,
                    96  => 5,
                    106 => 5,
                    116 => 5,
                    126 => 5,
                    161 => 1,
                    163 => 1,
                ];

            case 'ClassCommentUnitTest.2.inc':
                return [
                    7 => 1,
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
     * @param string $testFile The name of the test file being tested.
     *
     * @return array<int, int>
     */
    public function getWarningList($testFile = '')
    {
        switch ($testFile) {
            case 'ClassCommentUnitTest.1.inc':
                return [
                    71 => 1,
                    73 => 1,
                ];

            default:
                return [];
        }
    }
}
