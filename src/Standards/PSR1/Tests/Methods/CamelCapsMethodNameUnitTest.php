<?php
/**
 * Unit test class for the CamelCapsMethodName sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PSR1\Tests\Methods;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the CamelCapsMethodName sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\PSR1\Sniffs\Methods\CamelCapsMethodNameSniff
 */
final class CamelCapsMethodNameUnitTest extends AbstractSniffTestCase
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
            case 'CamelCapsMethodNameUnitTest.1.inc':
                return [
                    6  => 1,
                    7  => 1,
                    11 => 1,
                    12 => 1,
                    13 => 1,
                    17 => 1,
                    21 => 1,
                    25 => 1,
                    26 => 1,
                    77 => 1,
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
