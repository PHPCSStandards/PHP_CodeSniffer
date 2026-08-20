<?php
/**
 * Tests for the \PHP_CodeSniffer\Util\Common::prepareForOutput() method.
 *
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\Common;

use PHP_CodeSniffer\Util\Common;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the \PHP_CodeSniffer\Util\Common::prepareForOutput() method.
 *
 * @covers \PHP_CodeSniffer\Util\Common::prepareForOutput
 * @group  Windows
 */
final class PrepareForOutputTest extends TestCase
{


    /**
     * Test formatting whitespace characters, on anything other than Windows.
     *
     * @param string   $content     The content to prepare.
     * @param string[] $exclude     A list of characters to leave invisible.
     * @param string   $expected    Expected function output.
     * @param string   $expectedOld Expected function output on PHP<7.1 on Windows (unused in this test).
     *
     * @requires     OS ^(?!WIN).*
     * @dataProvider dataPrepareForOutput
     *
     * @return void
     */
    public function testPrepareForOutput($content, $exclude, $expected, $expectedOld)
    {
        $this->assertSame($expected, Common::prepareForOutput($content, $exclude));

    }//end testPrepareForOutput()


    /**
     * Test formatting whitespace characters, on modern PHP on Windows.
     *
     * @param string   $content     The content to prepare.
     * @param string[] $exclude     A list of characters to leave invisible.
     * @param string   $expected    Expected function output.
     * @param string   $expectedOld Expected function output on PHP<7.1 on Windows (unused in this test).
     *
     * @requires     OS ^WIN.*.
     * @requires     PHP 7.1
     * @dataProvider dataPrepareForOutput
     *
     * @return void
     */
    public function testPrepareForOutputWindows($content, $exclude, $expected, $expectedOld)
    {
        $this->assertSame($expected, Common::prepareForOutput($content, $exclude));

    }//end testPrepareForOutputWindows()


    /**
     * Test formatting whitespace characters, on PHP<7.1 on Windows.
     *
     * @param string   $content     The content to prepare.
     * @param string[] $exclude     A list of characters to leave invisible.
     * @param string   $expected    Expected function output (unused in this test).
     * @param string   $expectedOld Expected function output on PHP<7.1 on Windows.
     *
     * @requires     OS ^WIN.*.
     * @requires     PHP < 7.1
     * @dataProvider dataPrepareForOutput
     *
     * @return void
     */
    public function testPrepareForOutputOldPHPWindows($content, $exclude, $expected, $expectedOld)
    {
        // PHPUnit 4.8 (used on PHP 5.4) does not support the `@requires PHP < 7.1` syntax,
        // so double-check to avoid test failures.
        if (PHP_VERSION_ID >= 70100) {
            $this->markTestSkipped("Only for PHP < 7.1");
        }

        $this->assertSame($expectedOld, Common::prepareForOutput($content, $exclude));

    }//end testPrepareForOutputOldPHPWindows()


    /**
     * Data provider.
     *
     * @see testPrepareForOutput()
     * @see testPrepareForOutputWindows()
     * @see testPrepareForOutputOldPHPWindows()
     *
     * @return array<string, array<string, mixed>>
     */
    public static function dataPrepareForOutput()
    {
        return [
            'Special characters are replaced with their escapes' => [
                'content'     => "\r\n\t",
                'exclude'     => [],
                'expected'    => "\033[30;1m\\r\\n\\t\033[0m",
                'expectedOld' => "\033[30;1m\\r\\n\\t\033[0m",
            ],
            'Spaces are replaced with a unique mark'             => [
                'content'     => "    ",
                'exclude'     => [],
                'expected'    => "\033[30;1m····\033[0m",
                'expectedOld' => "    ",
            ],
            'Other characters are unaffected'                    => [
                'content'     => "{echo 1;}",
                'exclude'     => [],
                'expected'    => "{echo\033[30;1m·\033[0m1;}",
                'expectedOld' => "{echo 1;}",
            ],
            'No replacements'                                    => [
                'content'     => 'nothing-should-be-replaced',
                'exclude'     => [],
                'expected'    => 'nothing-should-be-replaced',
                'expectedOld' => 'nothing-should-be-replaced',
            ],
            'Excluded whitespace characters are unaffected'      => [
                'content'     => "\r\n\t ",
                'exclude'     => [
                    "\r",
                    "\n",
                ],
                'expected'    => "\r\n\033[30;1m\\t·\033[0m",
                'expectedOld' => "\r\n\033[30;1m\\t\033[0m ",
            ],
        ];

    }//end dataPrepareForOutput()


}//end class
