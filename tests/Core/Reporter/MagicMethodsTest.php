<?php
/**
 * Tests to safeguard that removed properties from the Reporter class are still accessible.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Reporter;

use PHP_CodeSniffer\Exceptions\RuntimeException;
use PHP_CodeSniffer\Reporter;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Tests to safeguard that a few removed properties from the Reporter class are still accessible for reading, but not writing.
 *
 * @covers \PHP_CodeSniffer\Reporter::__get
 * @covers \PHP_CodeSniffer\Reporter::__set
 * @covers \PHP_CodeSniffer\Reporter::__isset
 * @covers \PHP_CodeSniffer\Reporter::__unset
 */
final class MagicMethodsTest extends TestCase
{


    /**
     * Verify the magic __isset() method returns `false` for everything but the explicitly supported properties.
     *
     * @return void
     */
    public function testMagicIssetReturnsFalseForUnknownProperty()
    {
        $reporter = new Reporter(new ConfigDouble());

        $this->assertFalse(isset($reporter->unknown));
    }


    /**
     * Verify the magic __get() method rejects requests for anything but the explicitly supported properties.
     *
     * @return void
     */
    public function testMagicGetThrowsExceptionForUnsupportedProperty()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('ERROR: access requested to unknown property "Reporter::$invalid"');

        (new Reporter(new ConfigDouble()))->invalid;
    }


    /**
     * Test the magic __get() method handles supported properties.
     *
     * @param string $propertyName  The name of the property to request.
     * @param int    $set           Value to set for the properties comprising the virtual ones.
     * @param int    $expectedValue The expected value for the property.
     *
     * @dataProvider dataMagicGetReturnsValueForSupportedProperty
     *
     * @return void
     */
    public function testMagicGetReturnsValueForSupportedProperty($propertyName, $set, $expectedValue)
    {
        $reporter = new Reporter(new ConfigDouble());

        if ($set !== 0) {
            $reporter->totalFixableErrors   = $set;
            $reporter->totalFixableWarnings = $set;
            $reporter->totalFixedErrors     = $set;
            $reporter->totalFixedWarnings   = $set;
        }

        $this->assertTrue(isset($reporter->$propertyName));
        $this->assertSame($expectedValue, $reporter->$propertyName);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|int>>
     */
    public static function dataMagicGetReturnsValueForSupportedProperty()
    {
        return [
            'Property: totalFixable - 0' => [
                'propertyName'  => 'totalFixable',
                'set'           => 0,
                'expectedValue' => 0,
            ],
            'Property: totalFixed - 0'   => [
                'propertyName'  => 'totalFixed',
                'set'           => 0,
                'expectedValue' => 0,
            ],
            'Property: totalFixable - 2' => [
                'propertyName'  => 'totalFixable',
                'set'           => 1,
                'expectedValue' => 2,
            ],
            'Property: totalFixed - 4'   => [
                'propertyName'  => 'totalFixed',
                'set'           => 2,
                'expectedValue' => 4,
            ],
        ];
    }


    /**
     * Verify the magic __set() method rejects everything.
     *
     * @return void
     */
    public function testMagicSetThrowsException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('ERROR: setting property "Reporter::$totalFixable" is not allowed');

        $reporter = new Reporter(new ConfigDouble());
        $reporter->totalFixable = 10;
    }


    /**
     * Verify the magic __unset() method rejects everything.
     *
     * @return void
     */
    public function testMagicUnsetThrowsException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('ERROR: unsetting property "Reporter::$totalFixed" is not allowed');

        $reporter = new Reporter(new ConfigDouble());
        unset($reporter->totalFixed);
    }
}
