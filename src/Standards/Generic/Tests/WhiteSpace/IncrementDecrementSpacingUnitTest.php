<?php
/**
 * Unit test class for the IncrementDecrementSpacing sniff.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2018 Juliette Reinders Folmer. All rights reserved.
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Tests\WhiteSpace;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffTestCase;

/**
 * Unit test class for the IncrementDecrementSpacing sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\IncrementDecrementSpacingSniff
 */
final class IncrementDecrementSpacingUnitTest extends AbstractSniffTestCase
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
            5  => 1,
            6  => 1,
            8  => 1,
            10 => 1,
            13 => 1,
            14 => 1,
            16 => 1,
            17 => 1,
            21 => 1,
            23 => 1,
            26 => 1,
            27 => 1,
            30 => 1,
            31 => 1,
            34 => 1,
            37 => 1,
            40 => 1,
            42 => 1,
            45 => 1,
            48 => 1,
            50 => 1,
            54 => 1,
            56 => 1,
            58 => 1,
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
