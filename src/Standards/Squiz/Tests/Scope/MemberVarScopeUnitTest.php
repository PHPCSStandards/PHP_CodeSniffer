<?php
/**
 * Unit test class for the MemberVarScope sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Tests\Scope;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the MemberVarScope sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Squiz\Sniffs\Scope\MemberVarScopeSniff
 */
final class MemberVarScopeUnitTest extends AbstractSniffTestCase
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
            case 'MemberVarScopeUnitTest.1.inc':
                return [
                    7  => 1,
                    25 => 1,
                    29 => 1,
                    33 => 1,
                    39 => 1,
                    41 => 1,
                    66 => 2,
                    67 => 1,
                    71 => 1,
                    75 => 1,
                    80 => 1,
                    81 => 1,
                    82 => 1,
                    90 => 1,
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
