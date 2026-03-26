<?php
/**
 * Test fixture.
 *
 * @see \PHP_CodeSniffer\Tests\Core\Ruleset\PropertyTypeHandlingTest
 */

namespace Fixtures\TestStandard\Sniffs\SetProperty;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class PropertyTypeHandlingSniff implements Sniff
{

    /**
     * Used to verify that string properties are set as string.
     *
     * This is the default behaviour.
     *
     * @var string
     */
    public $expectsString;

    /**
     * Used to verify that string properties are set as string, with surrounding whitespace trimmed.
     *
     * This is the default behaviour.
     *
     * @var string
     */
    public $expectsTrimmedString;

    /**
     * Used to verify that a string value with only whitespace will end up being set as null.
     *
     * @var string|null
     */
    public $emptyStringBecomesNull;

    /**
     * Used to verify that integer properties do not have special handling and will be set as a string.
     *
     * @var int
     */
    public $expectsIntButAcceptsString;

    /**
     * Used to verify that floating point properties do not have special handling and will be set as a string.
     *
     * @var float
     */
    public $expectsFloatButAcceptsString;

    /**
     * Used to verify that null gets set as a proper null value.
     *
     * @var null
     */
    public $expectsNull;

    /**
     * Used to verify that null gets set as a proper null value.
     *
     * @var null
     */
    public $expectsNullCase;

    /**
     * Used to verify that null gets set as a proper null value.
     *
     * @var null
     */
    public $expectsNullTrimmed;

    /**
     * Used to verify that booleans get set as proper boolean values.
     *
     * @var bool
     */
    public $expectsBooleanTrue;

    /**
     * Used to verify that booleans get set as proper boolean values.
     *
     * @var bool
     */
    public $expectsBooleanTrueCase;

    /**
     * Used to verify that booleans get set as proper boolean values.
     *
     * @var bool
     */
    public $expectsBooleanTrueTrimmed;

    /**
     * Used to verify that booleans get set as proper boolean values.
     *
     * @var bool
     */
    public $expectsBooleanFalse;

    /**
     * Used to verify that booleans get set as proper boolean values.
     *
     * @var bool
     */
    public $expectsBooleanFalseCase;

    /**
     * Used to verify that booleans get set as proper boolean values.
     *
     * @var bool
     */
    public $expectsBooleanFalseTrimmed;

    /**
     * Used to verify that array properties get parsed to a proper array.
     *
     * @var array<mixed>
     */
    public $expectsArrayWithOnlyValues;

    /**
     * Used to verify that array properties with keys get parsed to a proper array.
     *
     * @var array<string, mixed>
     */
    public $expectsArrayWithKeysAndValues;

    /**
     * Used to verify that array properties can get extended.
     *
     * @var array<mixed>
     */
    public $expectsArrayWithExtendedValues;

    /**
     * Used to verify that array properties can get extended.
     *
     * @var array<mixed>
     */
    public $expectsArrayWithExtendedKeysAndValues;

    /**
     * Used to verify that array properties allow for setting a property to an empty array.
     *
     * @var array<mixed>
     */
    public $expectsEmptyArray;

    /**
     * Used to verify that array properties with a default value allow for (re-)setting the property to an empty array.
     *
     * @var array<string, string>
     */
    public $expectsNonEmptyArrayOverruledToEmpty = [
        'key' => 'value',
    ];

    /**
     * Used to verify that array properties with a default value allow for (re-)setting the property value.
     *
     * @var array<string, string>
     */
    public $expectsNonEmptyArrayOverruledToNewValue = [
        'key' => 'value',
    ];

    /**
     * Used to safeguard that if `extend=true` is used on a property without pre-existing value, this will not cause errors.
     *
     * @var array<mixed>
     */
    public $expectsExtendsWillJustSetToArrayWhenNoDefaultValuePresent;

    /**
     * Used to document that if `extend=true` is used on a property which doesn't have an array value, the value will be overruled.
     * (= original behaviour, no change)
     *
     * @var array<mixed>
     */
    public $expectsExtendsWillOverruleNonArrayToNewArrayValue = true;

    /**
     * Used to verify that array properties with a default value can get extended.
     *
     * @var array<string, mixed>
     */
    public $expectsNonEmptyArrayExtendedWithNonEmptyArray = [
        'key' => 'value',
    ];

    /**
     * Used to verify that array properties with a default value which are extended by an empty array do not get reset.
     *
     * @var array<string, mixed>
     */
    public $expectsNonEmptyArrayKeepsValueWhenExtendedWithEmptyArray = [
        'key' => 'value',
    ];

    /**
     * Used to verify that array properties with a default value can get extended multiple times.
     *
     * @var array<string, mixed>
     */
    public $expectsNonEmptyArrayDoubleExtendedWithNonEmptyArray = [
        'key' => 'value',
    ];

    /**
     * Used to verify the value for a specific array key can be overwritten from the ruleset.
     *
     * @var array<string, mixed>
     */
    public $expectsValuesInNonEmptyAssociativeArrayCanBeRedefined = [
        'foo' => 'foo',
        'bar' => 'bar',
    ];

    /**
     * Used to verify that non-keyed values are added to the array and do not overwrite existing values.
     *
     * @var array<mixed>
     */
    public $expectsValuesInNonEmptyNumericallyIndexedArrayAreNotOverwritten = [
        'valueA',
    ];

    /**
     * Used to verify that a default value for an array does not get the cleaning/type juggling treatment, while the ruleset added values do.
     *
     * @var array<string|int, mixed>
     */
    public $expectsPreexistingValuesStayTheSameWhileNewValuesGetCleaned = [
        'predefinedA' => 'true',
        'predefinedB' => '  null  ',
    ];

    /**
     * Used to verify that - in particular inline - array properties with only a "special" value get handled correctly.
     *
     * @var array<mixed>
     */
    public $expectsArrayWithJustValueTrue = [];

    /**
     * Used to verify that - in particular inline - array properties with only a "special" value get handled correctly.
     *
     * @var array<mixed>
     */
    public $expectsArrayWithJustValueFalse = [];

    /**
     * Used to verify that - in particular inline - array properties with only a "special" value get handled correctly.
     *
     * @var array<mixed>
     */
    public $expectsArrayWithJustValueNull = [];

    /**
     * Used to verify that if `extend` is used on a non-array property, the value still gets set, but not as an array.
     *
     * @var array<mixed>
     */
    public $expectsStringNotArray;

    public function register()
    {
        return [T_ECHO];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        // Do something.
    }
}
