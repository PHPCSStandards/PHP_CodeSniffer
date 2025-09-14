<?php
/**
 * Tests for the \PHP_CodeSniffer\Util\Common::getSniffCode() method.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\Common;

use InvalidArgumentException;
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
     * @param mixed $input NOT a fully qualified sniff class name.
     *
     * @dataProvider dataGetSniffCodeThrowsExceptionOnInvalidInput
     *
     * @return void
     */
    public function testGetSniffCodeThrowsExceptionOnInvalidInput($input)
    {
        $message = 'The $sniffClass parameter must be a non-empty string';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        Common::getSniffCode($input);
    }


    /**
     * Data provider.
     *
     * @see testGetSniffCodeThrowsExceptionOnInvalidInput()
     *
     * @return array<string, array<mixed>>
     */
    public static function dataGetSniffCodeThrowsExceptionOnInvalidInput()
    {
        return [
            'Class name is not a string' => [true],
            'Class name is empty'        => [''],
        ];
    }


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
        $message = 'The $sniffClass parameter was not passed a fully qualified sniff(test) class name. Received:';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        Common::getSniffCode($input);
    }


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
            'Unqualified class name'                                        => ['ClassNameSniff'],
            'Fully qualified sniff class name, not enough parts [1]'        => ['Fully\\Qualified\\ClassNameSniff'],
            'Fully qualified sniff class name, not enough parts [2]'        => ['CompanyName\\CheckMeSniff'],
            'Fully qualified test class name, not enough parts'             => ['Fully\\Qualified\\ClassNameUnitTest'],
            'Fully qualified class name, doesn\'t end on Sniff or UnitTest' => ['Fully\\Sniffs\\Qualified\\ClassName'],
            'Fully qualified class name, ends on Sniff, but isn\'t'         => ['Fully\\Sniffs\\AbstractSomethingSniff'],
            'Fully qualified class name, last part *is* Sniff'              => ['CompanyName\\Sniffs\\Category\\Sniff'],
            'Fully qualified class name, last part *is* UnitTest'           => ['CompanyName\\Tests\\Category\\UnitTest'],
            'Fully qualified class name, no Sniffs or Tests leaf'           => ['CompanyName\\CustomSniffs\\Whatever\\CheckMeSniff'],
            'Fully qualified class name, category called Sniffs'            => ['CompanyName\\Sniffs\\Sniffs\\InvalidCategorySniff'],
        ];
    }


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
    }


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
                'fqnClass' => 'MyStandard\\Tests\\PHP\\MyNameUnitTest',
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
    }
}
