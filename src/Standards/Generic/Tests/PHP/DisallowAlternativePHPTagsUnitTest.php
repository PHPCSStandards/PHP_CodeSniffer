<?php
/**
 * Unit test class for the DisallowAlternativePHPTags sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Tests\PHP;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the DisallowAlternativePHPTags sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DisallowAlternativePHPTagsSniff
 */
final class DisallowAlternativePHPTagsUnitTest extends AbstractSniffTestCase
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
            case 'DisallowAlternativePHPTagsUnitTest.1.inc':
                return [
                    4  => 1,
                    7  => 1,
                    8  => 1,
                    11 => 1,
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
        if ($testFile === 'DisallowAlternativePHPTagsUnitTest.2.inc') {
            // Check if the Internal.NoCodeFound error can be expected on line 1.
            $option = (bool) ini_get('short_open_tag');
            $line1  = 1;
            if ($option === true) {
                $line1 = 0;
            }

            return [
                1 => $line1,
                2 => 1,
                3 => 1,
                4 => 1,
                5 => 1,
            ];
        }

        return [];
    }
}
