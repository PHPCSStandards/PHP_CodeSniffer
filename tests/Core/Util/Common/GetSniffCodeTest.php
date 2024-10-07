<?php
/**
 * Tests for the \PHP_CodeSniffer\Util\Common::getSniffCode() method.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\Common;

use PHP_CodeSniffer\Util\Common;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the \PHP_CodeSniffer\Util\Common::getSniffCode() method.
 *
 * @covers \PHP_CodeSniffer\Util\Common::getSniffCode
 */
final class GetSniffCodeTest extends TestCase
{


    /**
     * Test receiving an expected exception when the $sniffClass parameter is not passed a string value or is passed an empty string.
     *
     * @param string $input NOT a fully qualified sniff class name.
     *
     * @dataProvider dataGetSniffCodeThrowsExceptionOnInvalidInput
     *
     * @return void
     */
    public function testGetSniffCodeThrowsExceptionOnInvalidInput($input)
    {
        $exception = 'InvalidArgumentException';
        $message   = 'The $sniffClass parameter must be a non-empty string';

        if (method_exists($this, 'expectException') === true) {
            // PHPUnit 5+.
            $this->expectException($exception);
            $this->expectExceptionMessage($message);
        } else {
            // PHPUnit 4.
            $this->setExpectedException($exception, $message);
        }

        Common::getSniffCode($input);

    }//end testGetSniffCodeThrowsExceptionOnInvalidInput()


    /**
     * Data provider.
     *
     * @see testGetSniffCodeThrowsExceptionOnInvalidInput()
     *
     * @return array<string, array<string>>
     */
    public static function dataGetSniffCodeThrowsExceptionOnInvalidInput()
    {
        return [
            'Class name is not a string' => [true],
            'Class name is empty'        => [''],
        ];

    }//end dataGetSniffCodeThrowsExceptionOnInvalidInput()


    /**
     * Test receiving an expected exception when the $sniffClass parameter is not passed a value which
     * could be a fully qualified sniff(test) class name.
     *
     * @param string $input String input which can not be a fully qualified sniff(test) class name.
     *
     * @dataProvider dataGetSniffCodeThrowsExceptionOnInputWhichIsNotASniffTestClass
     *
     * @return void
     */
    public function testGetSniffCodeThrowsExceptionOnInputWhichIsNotASniffTestClass($input)
    {
        $exception = 'InvalidArgumentException';
        $message   = 'The $sniffClass parameter was not passed a fully qualified sniff(test) class name. Received:';

        if (method_exists($this, 'expectException') === true) {
            // PHPUnit 5+.
            $this->expectException($exception);
            $this->expectExceptionMessage($message);
        } else {
            // PHPUnit 4.
            $this->setExpectedException($exception, $message);
        }

        Common::getSniffCode($input);

    }//end testGetSniffCodeThrowsExceptionOnInputWhichIsNotASniffTestClass()


    /**
     * Data provider.
     *
     * @see testGetSniffCodeThrowsExceptionOnInputWhichIsNotASniffTestClass()
     *
     * @return array<string, array<string>>
     */
    public static function dataGetSniffCodeThrowsExceptionOnInputWhichIsNotASniffTestClass()
    {
        return [
            'Unqualified class name'                                        => ['ClassName'],
            'Fully qualified class name, not enough parts'                  => ['Fully\\Qualified\\ClassName'],
            'Fully qualified class name, doesn\'t end on Sniff or UnitTest' => ['Fully\\Sniffs\\Qualified\\ClassName'],
            'Fully qualified class name, ends on Sniff, but isn\'t'         => ['Fully\\Sniffs\\AbstractSomethingSniff'],
        ];

    }//end dataGetSniffCodeThrowsExceptionOnInputWhichIsNotASniffTestClass()


    /**
     * Test transforming a sniff class name to a sniff code.
     *
     * @param string $fqnClass A fully qualified sniff class name.
     * @param string $expected Expected function output.
     *
     * @dataProvider dataGetSniffCode
     *
     * @return void
     */
    public function testGetSniffCode($fqnClass, $expected)
    {
        $this->assertSame($expected, Common::getSniffCode($fqnClass));

    }//end testGetSniffCode()


    /**
     * Data provider.
     *
     * @see testGetSniffCode()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataGetSniffCode()
    {
        return [
            'PHPCS native sniff'                                  => [
                'fqnClass' => 'PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\Arrays\\ArrayIndentSniff',
                'expected' => 'Generic.Arrays.ArrayIndent',
            ],
            'Class is a PHPCS native test class'                  => [
                'fqnClass' => 'PHP_CodeSniffer\\Standards\\Generic\\Tests\\Arrays\\ArrayIndentUnitTest',
                'expected' => 'Generic.Arrays.ArrayIndent',
            ],
            'Sniff in external standard without namespace prefix' => [
                'fqnClass' => 'MyStandard\\Sniffs\\PHP\\MyNameSniff',
                'expected' => 'MyStandard.PHP.MyName',
            ],
            'Test in external standard without namespace prefix'  => [
                'fqnClass' => 'MyStandard\\Tests\\PHP\\MyNameSniff',
                'expected' => 'MyStandard.PHP.MyName',
            ],
            'Sniff in external standard with namespace prefix'    => [
                'fqnClass' => 'Vendor\\Package\\MyStandard\\Sniffs\\Category\\AnalyzeMeSniff',
                'expected' => 'MyStandard.Category.AnalyzeMe',
            ],
            'Test in external standard with namespace prefix'     => [
                'fqnClass' => 'Vendor\\Package\\MyStandard\\Tests\\Category\\AnalyzeMeUnitTest',
                'expected' => 'MyStandard.Category.AnalyzeMe',
            ],
        ];

    }//end dataGetSniffCode()


}//end class
