<?php
/**
 * Unit test class for the ByteOrderMark sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Tests\Files;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the ByteOrderMark sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Generic\Sniffs\Files\ByteOrderMarkSniff
 */
final class ByteOrderMarkUnitTest extends AbstractSniffTestCase
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
            case 'ByteOrderMarkUnitTest.1.inc':
            case 'ByteOrderMarkUnitTest.4.inc':
            case 'ByteOrderMarkUnitTest.5.inc':
                return [1 => 1];

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
        switch ($testFile) {
            case 'ByteOrderMarkUnitTest.3.inc':
            case 'ByteOrderMarkUnitTest.4.inc':
            case 'ByteOrderMarkUnitTest.5.inc':
                if ((bool) ini_get('short_open_tag') === false) {
                    // Warning about "no code found in file".
                    return [1 => 1];
                }
                return [];

            default:
                return [];
        }
    }
}
