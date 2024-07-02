<?php
/**
 * Unit test class for the FunctionCallSignature sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PEAR\Tests\Functions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the FunctionCallSignature sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\PEAR\Sniffs\Functions\FunctionCallSignatureSniff
 */
final class FunctionCallSignatureUnitTest extends AbstractSniffUnitTest
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
        if ($testFile === 'FunctionCallSignatureUnitTest.js') {
            return [
                5  => 1,
                6  => 2,
                7  => 1,
                8  => 1,
                9  => 2,
                10 => 3,
                17 => 1,
                18 => 1,
                21 => 1,
                24 => 1,
                28 => 2,
                30 => 2,
                35 => 1,
                49 => 1,
                51 => 1,
                54 => 1,
                70 => 1,
                71 => 1,
            ];
        }//end if

        return [
            5   => 1,
            6   => 2,
            7   => 1,
            8   => 1,
            9   => 2,
            10  => 3,
            17  => 1,
            18  => 1,
            31  => 1,
            34  => 1,
            43  => 2,
            57  => 1,
            59  => 1,
            63  => 1,
            64  => 1,
            82  => 1,
            93  => 1,
            100 => 1,
            106 => 1,
            119 => 1,
            120 => 1,
            129 => 1,
            137 => 1,
            142 => 2,
            171 => 1,
            180 => 1,
            181 => 1,
            194 => 1,
            213 => 2,
            215 => 2,
            217 => 2,
            218 => 2,
            225 => 1,
            226 => 1,
            230 => 1,
            231 => 1,
            277 => 1,
            278 => 1,
            303 => 1,
            308 => 1,
            321 => 1,
            322 => 1,
            329 => 1,
            330 => 1,
            337 => 1,
            342 => 1,
            343 => 1,
            345 => 1,
            346 => 2,
            353 => 1,
            354 => 1,
            355 => 1,
            377 => 1,
            385 => 1,
            393 => 1,
            394 => 1,
            395 => 1,
            396 => 1,
            411 => 1,
            422 => 1,
            424 => 1,
            429 => 1,
            432 => 1,
            440 => 1,
            441 => 1,
            442 => 1,
            464 => 1,
            510 => 1,
            513 => 1,
            514 => 1,
            523 => 1,
            524 => 3,
            527 => 2,
            539 => 1,
            540 => 1,
            546 => 1,
            547 => 1,
            548 => 1,
            555 => 1,
            556 => 1,
            560 => 1,
            561 => 1,
            568 => 1,
            581 => 1,
            587 => 1,
            594 => 1,
            595 => 1,
            596 => 1,
            597 => 1,
            598 => 1,
            599 => 1,
            600 => 1,
            603 => 2,
            604 => 2,
            607 => 2,
            608 => 2,
            611 => 2,
            612 => 2,
            615 => 1,
            616 => 2,
            619 => 1,
            620 => 1,
            623 => 1,
            624 => 1,
            625 => 1,
            626 => 1,
            627 => 1,
            628 => 1,
            629 => 2,
            632 => 2,
            633 => 1,
            635 => 2,
            639 => 2,
            640 => 2,
            647 => 2,
            648 => 1,
        ];

    }//end getErrorList()


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

    }//end getWarningList()


}//end class
