<?php
/**
 * Tests for the handling of properties being set via the ruleset.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Ruleset;

use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Test the handling of property value types for properties set via the ruleset and inline.
 *
 * @covers \PHP_CodeSniffer\Ruleset::processRule
 * @covers \PHP_CodeSniffer\Ruleset::setSniffProperty
 * @covers \PHP_CodeSniffer\Ruleset::getRealPropertyValue
 */
final class PropertyTypeHandlingTest extends TestCase
{

    /**
     * Sniff code for the sniff used in these tests.
     *
     * @var string
     */
    private const SNIFF_CODE = 'TestStandard.SetProperty.PropertyTypeHandling';

    /**
     * Class name of the sniff used in these tests.
     *
     * @var string
     */
    private const SNIFF_CLASS = 'Fixtures\\TestStandard\\Sniffs\\SetProperty\\PropertyTypeHandlingSniff';


    /**
     * Test the value type handling for properties set via a ruleset.
     *
     * @param string $propertyName Property name.
     * @param mixed  $expected     Expected property value.
     *
     * @dataProvider dataTypeHandling
     * @dataProvider dataArrayPropertyExtending
     *
     * @return void
     */
    public function testTypeHandlingWhenSetViaRuleset($propertyName, $expected)
    {
        $sniffObject = $this->getSniffObjectForRuleset();

        $this->assertSame($expected, $sniffObject->$propertyName);
    }


    /**
     * Test the value type handling for properties set inline in a test case file.
     *
     * @param string $propertyName Property name.
     * @param mixed  $expected     Expected property value.
     *
     * @dataProvider dataTypeHandling
     *
     * @return void
     */
    public function testTypeHandlingWhenSetInline($propertyName, $expected)
    {
        $sniffObject = $this->getSniffObjectAfterProcessingFile();

        $this->assertSame($expected, $sniffObject->$propertyName);
    }


    /**
     * Data provider.
     *
     * @see self::testTypeHandlingWhenSetViaRuleset()
     * @see self::testTypeHandlingWhenSetInline()
     *
     * @return array<string, array<string, mixed>>
     */
    public static function dataTypeHandling()
    {
        $expectedArrayOnlyValues    = [
            'string',
            '10',
            '1.5',
            null,
            null,
            true,
            false,
        ];
        $expectedArrayKeysAndValues = [
            'string' => 'string',
            10       => '10',
            'float'  => '1.5',
            ''       => null,
            'null'   => null,
            'true'   => true,
            'false'  => false,
        ];

        return [
            'String value (default)'                         => [
                'propertyName' => 'expectsString',
                'expected'     => 'arbitraryvalue',
            ],
            'String value with whitespace gets trimmed'      => [
                'propertyName' => 'expectsTrimmedString',
                'expected'     => 'some value',
            ],
            'String with whitespace only value becomes null' => [
                'propertyName' => 'emptyStringBecomesNull',
                'expected'     => null,
            ],
            'Integer value gets set as string'               => [
                'propertyName' => 'expectsIntButAcceptsString',
                'expected'     => '12345',
            ],
            'Float value gets set as string'                 => [
                'propertyName' => 'expectsFloatButAcceptsString',
                'expected'     => '12.345',
            ],
            'Null value gets set as null'                    => [
                'propertyName' => 'expectsNull',
                'expected'     => null,
            ],
            'Null (uppercase) value gets set as null'        => [
                'propertyName' => 'expectsNullCase',
                'expected'     => null,
            ],
            'Null (with spaces) value gets set as null'      => [
                'propertyName' => 'expectsNullTrimmed',
                'expected'     => null,
            ],
            'True value gets set as boolean'                 => [
                'propertyName' => 'expectsBooleanTrue',
                'expected'     => true,
            ],
            'True (mixed case) value gets set as string'     => [
                'propertyName' => 'expectsBooleanTrueCase',
                'expected'     => true,
            ],
            'True (with spaces) value gets set as boolean'   => [
                'propertyName' => 'expectsBooleanTrueTrimmed',
                'expected'     => true,
            ],
            'False value gets set as boolean'                => [
                'propertyName' => 'expectsBooleanFalse',
                'expected'     => false,
            ],
            'False (mixed case) value gets set as string'    => [
                'propertyName' => 'expectsBooleanFalseCase',
                'expected'     => false,
            ],
            'False (with spaces) value gets set as boolean'  => [
                'propertyName' => 'expectsBooleanFalseTrimmed',
                'expected'     => false,
            ],
            'Array with only values'                         => [
                'propertyName' => 'expectsArrayWithOnlyValues',
                'expected'     => $expectedArrayOnlyValues,
            ],
            'Array with keys and values'                     => [
                'propertyName' => 'expectsArrayWithKeysAndValues',
                'expected'     => $expectedArrayKeysAndValues,
            ],
            'Empty array'                                    => [
                'propertyName' => 'expectsEmptyArray',
                'expected'     => [],
            ],
            'Array with just the value "true"'               => [
                'propertyName' => 'expectsArrayWithJustValueTrue',
                'expected'     => [true],
            ],
            'Array with just the value "false"'              => [
                'propertyName' => 'expectsArrayWithJustValueFalse',
                'expected'     => [false],
            ],
            'Array with just the value "null"'               => [
                'propertyName' => 'expectsArrayWithJustValueNull',
                'expected'     => [null],
            ],
        ];
    }


    /**
     * Data provider.
     *
     * Array property extending is a feature which is only supported from a ruleset, not for inline property setting.
     *
     * @see self::testTypeHandlingWhenSetViaRuleset()
     *
     * @return array<string, array<string, mixed>>
     */
    public static function dataArrayPropertyExtending()
    {
        $expectedArrayOnlyValuesExtended    = [
            'string',
            '15',
            'another string',
        ];
        $expectedArrayKeysAndValuesExtended = [
            10               => '10',
            'string'         => 'string',
            15               => '15',
            'another string' => 'another string',
        ];

        return [
            'Array with only values extended'                                   => [
                'propertyName' => 'expectsArrayWithExtendedValues',
                'expected'     => $expectedArrayOnlyValuesExtended,
            ],
            'Array with keys and values extended'                               => [
                'propertyName' => 'expectsArrayWithExtendedKeysAndValues',
                'expected'     => $expectedArrayKeysAndValuesExtended,
            ],

            'Empty array in ruleset overrules existing value'                   => [
                'propertyName' => 'expectsNonEmptyArrayOverruledToEmpty',
                'expected'     => [],
            ],
            'Non empty array in ruleset overrules existing value'               => [
                'propertyName' => 'expectsNonEmptyArrayOverruledToNewValue',
                'expected'     => ['another key' => 'another value'],
            ],

            'Extending pre-existing value when there is no value'               => [
                'propertyName' => 'expectsExtendsWillJustSetToArrayWhenNoDefaultValuePresent',
                'expected'     => ['foo' => 'bar'],
            ],
            'Extending pre-existing non-array value will overrule'              => [
                'propertyName' => 'expectsExtendsWillOverruleNonArrayToNewArrayValue',
                'expected'     => ['phpcbf'],
            ],
            'Non empty array extended by non-empty array'                       => [
                'propertyName' => 'expectsNonEmptyArrayExtendedWithNonEmptyArray',
                'expected'     => [
                    'key'         => 'value',
                    'another key' => 'another value',
                ],
            ],
            'Non empty array keeps value when extended by empty array'          => [
                'propertyName' => 'expectsNonEmptyArrayKeepsValueWhenExtendedWithEmptyArray',
                'expected'     => ['key' => 'value'],
            ],

            'Non empty array double extended get both additions'                => [
                'propertyName' => 'expectsNonEmptyArrayDoubleExtendedWithNonEmptyArray',
                'expected'     => [
                    'key' => 'value',
                    'foo' => 'bar',
                    'bar' => 'baz',
                    'baz' => 'boo',
                ],
            ],

            'Values in non empty associative array can be redefined'            => [
                'propertyName' => 'expectsValuesInNonEmptyAssociativeArrayCanBeRedefined',
                'expected'     => [
                    'foo' => 'bar',
                    'bar' => 'foo',
                ],
            ],
            'Values in non empty numerically indexed array are not overwritten' => [
                'propertyName' => 'expectsValuesInNonEmptyNumericallyIndexedArrayAreNotOverwritten',
                'expected'     => [
                    'valueA',
                    'valueB',
                    'valueC',
                ],
            ],
            'Original values are untouched, while new values get cleaned'       => [
                'propertyName' => 'expectsPreexistingValuesStayTheSameWhileNewValuesGetCleaned',
                'expected'     => [
                    'predefinedA' => 'true',
                    'predefinedB' => '  null  ',
                    'newValueA'   => false,
                    'newValueB'   => null,
                    '1.5', // phpcs:ignore Squiz.Arrays.ArrayDeclaration.NoKeySpecified -- That is largely what we are testing...
                    true,
                ],
            ],
            'Invalid "extend" used on a non-array property'                     => [
                'propertyName' => 'expectsStringNotArray',
                'expected'     => 'some value',
            ],
        ];
    }


    /**
     * Test Helper.
     *
     * @see self::testTypeHandlingWhenSetViaRuleset()
     *
     * @return \PHP_CodeSniffer\Sniffs\Sniff
     */
    private function getSniffObjectForRuleset()
    {
        static $sniffObject;

        if (isset($sniffObject) === false) {
            // Set up the ruleset.
            $standard = __DIR__ . '/PropertyTypeHandlingTest.xml';
            $config   = new ConfigDouble(["--standard=$standard"]);
            $ruleset  = new Ruleset($config);

            // Verify that our target sniff has been registered.
            $this->assertArrayHasKey(self::SNIFF_CODE, $ruleset->sniffCodes, 'Target sniff not registered');
            $this->assertSame(self::SNIFF_CLASS, $ruleset->sniffCodes[self::SNIFF_CODE], 'Target sniff not registered with the correct class');
            $this->assertArrayHasKey(self::SNIFF_CLASS, $ruleset->sniffs, 'Sniff class not listed in registered sniffs');

            $sniffObject = $ruleset->sniffs[self::SNIFF_CLASS];
        }

        return $sniffObject;
    }


    /**
     * Test Helper
     *
     * @see self::testTypeHandlingWhenSetInline()
     *
     * @return \PHP_CodeSniffer\Sniffs\Sniff
     */
    private function getSniffObjectAfterProcessingFile()
    {
        static $sniffObject;

        if (isset($sniffObject) === false) {
            // Set up the ruleset.
            $standard = __DIR__ . '/PropertyTypeHandlingInlineTest.xml';
            $config   = new ConfigDouble(["--standard=$standard"]);
            $ruleset  = new Ruleset($config);

            // Verify that our target sniff has been registered.
            $this->assertArrayHasKey(self::SNIFF_CODE, $ruleset->sniffCodes, 'Target sniff not registered');
            $this->assertSame(self::SNIFF_CLASS, $ruleset->sniffCodes[self::SNIFF_CODE], 'Target sniff not registered with the correct class');
            $this->assertArrayHasKey(self::SNIFF_CLASS, $ruleset->sniffs, 'Sniff class not listed in registered sniffs');

            $sniffObject = $ruleset->sniffs[self::SNIFF_CLASS];

            // Process the file with inline phpcs:set annotations.
            $testFile = realpath(__DIR__ . '/Fixtures/PropertyTypeHandlingInline.inc');
            $this->assertNotFalse($testFile);

            $phpcsFile = new LocalFile($testFile, $ruleset, $config);
            $phpcsFile->process();
        }

        return $sniffObject;
    }
}
