<?php
/**
 * Unit test class for the PHPDoc Types sniff.
 *
 * @author    based on work by Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PSR5\Tests\Commenting;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the PHPDoc Types sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Generic\Sniffs\Commenting\PHPDocTypesSniff
 * @covers \PHP_CodeSniffer\Util\PHPDocTypesUtil
 */
final class PHPDocTypesUnitTest extends AbstractSniffUnitTest
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
        case 'PHPDocTypesUnitTest.wrong_type_non_php_fig.inc':
            return [
                23 => 1,
                31 => 1,
                33 => 1,
                47 => 1,
            ];
        case 'PHPDocTypesUnitTest.wrong_type_style.inc':
            return [
                17 => 1,
                25 => 1,
                32 => 1,
                39 => 1,
                48 => 1,
                50 => 1,
                51 => 1,
                65 => 1,
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
        case 'PHPDocTypesUnitTest.warn_docs_missing.inc':
            return [
                17 => 1,
                21 => 1,
                27 => 1,
            ];
        case 'PHPDocTypesUnitTest.warn_tags_missing.inc':
            return [
                22 => 2,
                31 => 1,
            ];
        default:
            return [];
        }//end switch

    }//end getWarningList()


}//end class
