<?php
/**
 * Unit test class for the DocCommentAlignment sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Tests\Commenting;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the DocCommentAlignment sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\DocCommentAlignmentSniff
 */
final class DocCommentAlignmentUnitTest extends AbstractSniffTestCase
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
            3   => 1,
            11  => 1,
            17  => 1,
            18  => 1,
            19  => 1,
            23  => 2,
            24  => 1,
            25  => 2,
            26  => 1,
            32  => 1,
            33  => 1,
            38  => 1,
            39  => 1,
            75  => 1,
            83  => 1,
            84  => 1,
            90  => 1,
            91  => 1,
            95  => 1,
            96  => 1,
            106 => 1,
            107 => 1,
            111 => 2,
            112 => 1,
            113 => 1,
            114 => 1,
            120 => 1,
            121 => 1,
            125 => 1,
            126 => 1,
            136 => 1,
            137 => 1,
            141 => 2,
            142 => 1,
            143 => 1,
            144 => 1,
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
