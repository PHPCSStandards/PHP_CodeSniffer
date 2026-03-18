<?php
/**
 * Unit test class for the ValidVariableName sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PEAR\Tests\NamingConventions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the ValidVariableName sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\PEAR\Sniffs\NamingConventions\ValidVariableNameSniff
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
                    12  => 1,
                    17  => 1,
                    22  => 1,
                    92  => 1,
                    93  => 1,
                    94  => 1,
                    99  => 1,
                    105 => 1,
                    111 => 1,
                    114 => 1,
                    119 => 1,
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
