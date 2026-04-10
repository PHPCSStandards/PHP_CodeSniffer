<?php
/**
 * Unit test class for the ValidConstantName sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Tests\NamingConventions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the ValidConstantName sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff
 */
final class UpperCaseConstantNameUnitTest extends AbstractSniffTestCase
{


    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @param string $testFile The name of the test file to process.
     *
     * @return array<int, int>
     */
    public function getErrorList($testFile = '')
    {
        switch ($testFile) {
            case 'UpperCaseConstantNameUnitTest.1.inc':
                return [
                    8  => 1,
                    10 => 1,
                    12 => 1,
                    14 => 1,
                    19 => 1,
                    28 => 1,
                    30 => 1,
                    40 => 1,
                    41 => 1,
                    45 => 1,
                    51 => 1,
                    71 => 1,
                    73 => 1,
                    91 => 1,
                ];

            case 'UpperCaseConstantNameUnitTest.6.inc':
                return [
                    // Only the fully qualified `\define()` call should be flagged;
                    // the unqualified `define()` calls may resolve to the local
                    // `Foo\define` function declared further down in the file.
                    18 => 1,
                ];

            case 'UpperCaseConstantNameUnitTest.7.inc':
                return [
                    // `use function Bar\define;` brings a `define` symbol into scope,
                    // so unqualified `define()` calls must not be flagged. Only the
                    // fully qualified `\define()` call is.
                    12 => 1,
                ];

            case 'UpperCaseConstantNameUnitTest.8.inc':
                return [
                    // `use function Bar\define as something;` aliases AWAY from
                    // `define`, so the local `define` symbol is unaffected and
                    // unqualified `define()` calls should still be flagged.
                    8 => 1,
                ];

            case 'UpperCaseConstantNameUnitTest.9.inc':
                return [
                    // A custom define() in one namespace must not suppress
                    // checks for bare define() calls in a different namespace.
                    13 => 1,
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
