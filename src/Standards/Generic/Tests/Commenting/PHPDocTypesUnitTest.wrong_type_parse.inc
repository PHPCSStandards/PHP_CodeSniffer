<?php
/**
 * A collection of invalid types for testing
 *
 * All type annotations should give an error in one of PHPStan or Psalm.
 * And all should give errors when checked with the PHPDoc types sniff, regardless of setting.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2023-2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

/**
 * A collection of invalid types for testing
 */
class TypesInvalid
{


    /**
     * Expecting variable name, saw end
     *
     * @param int
     *
     * @return void
     */
    public function expectingVarSawEnd(int $x): void
    {

    }//end expectingVarSawEnd()


    /**
     * Expecting variable name, saw other (passes Psalm)
     *
     * @param int int
     *
     * @return void
     */
    public function expectingVarSawOther(int $x): void
    {

    }//end expectingVarSawOther()


    /**
     * Expecting type, saw end
     *
     * @var
     */
    public $expectingTypeSawEnd;

    /**
     * Expecting type, saw other
     *
     * @var $varname
     */
    public $expectingTypeSawOther;

    /**
     * Unterminated string (passes Psalm)
     *
     * @var "
     */
    public $unterminatedString;

    /**
     * Unterminated string with escaped quote (passes Psalm)
     *
     * @var "\"
     */
    public $unterminatedStringWithEscapedQuote;

    /**
     * String has escape with no following character (passes Psalm)
     *
     * @var "\*/
    public $stringHasEscapeWithNoFollowingChar;

    /**
     * Non-DNF type (passes PHPStan)
     *
     * @var TypesInvalid&(a|b)
     */
    public $nonDnfType;

    /**
     * Invalid intersection
     *
     * @var integer&string
     */
    public $invalidIntersection;

    /**
     * Invalid int min
     *
     * @var int<0.0, 1>
     */
    public $invalidIntMin;

    /**
     * Invalid int max
     *
     * @var int<0, 1.0>
     */
    public $invalidIntMax;

    /**
     * Invalid int mask 1
     *
     * @var int-mask<1.0, 2.0>
     */
    public $invalidIntMask1;

    /**
     * Invalid int mask 2
     *
     * @var int-mask-of<string>
     */
    public $invalidIntMask2;

    /**
     * Expecting class for class-string, saw end
     *
     * @var class-string<
     */
    public $expectingClassForClassStringSawEnd;

    /**
     * Expecting class for class-string, saw other
     *
     * @var class-string<int>
     */
    public $expectingClassForClassStringSawOther;

    /**
     * List key
     *
     * @var list<int, string>
     */
    public $listKey;

    /**
     * Invalid array key (passes Psalm)
     *
     * @var array<object, object>
     */
    public $invalidArrayKey;

    /**
     * Non-empty-array shape
     *
     * @var non-empty-array{'a': int}
     */
    public $nonEmptyArrayShape;

    /**
     * Invalid object key (passes Psalm)
     *
     * @var object{0.0: int}
     */
    public $invalidObjectKey;

    /**
     * Can't get key of non-iterable
     *
     * @var key-of<int>
     */
    public $cantGetKeyOfNonIterable;

    /**
     * Can't get value of non-iterable
     *
     * @var value-of<int>
     */
    public $cantGetValueOfNonIterable;


    /**
     * Class name has trailing slash
     *
     * @param TypesInvalid\ $x
     *
     * @return void
     */
    public function classNameHasTrailingSlash(object $x): void
    {

    }//end classNameHasTrailingSlash()


    /**
     * Expecting closing bracket, saw end.
     *
     * @var (TypesInvalid
     */
    public $expectingClosingBracketSawEnd;

    /**
     * Expecting closing bracket, saw other
     *
     * @var (TypesInvalid int
     */
    public $expectingClosingBracketSawOther;

}//end class
