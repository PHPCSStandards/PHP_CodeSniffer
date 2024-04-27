<?php
/**
 * A collection of valid types for testing
 *
 * This file should have no errors for PHP 8 when checked with either PHPStan or Psalm.
 * And no errors when checked with the PHPDoc types sniff when checkTypePhpFig and checkTypeStyle are disabled.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2023-2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

use stdClass as MyStdClass;

/**
 * A parent class
 */
class TypesValidParent
{
}//end class

/**
 * An interface
 */
interface TypesValidInterface
{
}//end interface

/**
 * A collection of valid types for testing
 */
class TypesValid extends TypesValidParent implements TypesValidInterface
{

    /**
     * @var array<int, string>
     */
    public const ARRAY_CONST = [
        1 => 'one',
        2 => 'two',
    ];

    /**
     * @var int
     */
    public const INT_ONE = 1;

    /**
     * @var int
     */
    public const INT_TWO = 2;

    /**
     * @var float
     */
    public const FLOAT_1_0 = 1.0;

    /**
     * @var float
     */
    public const FLOAT_2_0 = 2.0;

    /**
     * @var string
     */
    public const STRING_HELLO = 'Hello';

    /**
     * @var string
     */
    public const STRING_WORLD = 'World';

    /**
     * @var bool
     */
    public const BOOL_FALSE = false;

    /**
     * @var bool
     */
    public const BOOL_TRUE = true;


    /**
     * Basic type equivalence
     *
     * @param bool       $bool
     * @param int        $int
     * @param float      $float
     * @param string     $string
     * @param object     $object
     * @param self       $self
     * @param parent     $parent
     * @param TypesValid $specificClass
     * @param callable   $callable
     *
     * @return void
     */
    public function basicTypeEquivalence(
        bool $bool,
        int $int,
        float $float,
        string $string,
        object $object,
        self $self,
        parent $parent,
        TypesValid $specificClass,
        callable $callable
    ): void {

    }//end basicTypeEquivalence()


    /**
     * Types not supported natively (as of PHP 7.2)
     *
     * @param array<int>    $parameterisedArray
     * @param resource      $resource
     * @param static        $static
     * @param iterable<int> $parameterisedIterable
     * @param array-key     $arrayKey
     * @param scalar        $scalar
     * @param mixed         $mixed
     *
     * @return never
     */
    public function nonNativeTypes($parameterisedArray, $resource, $static, $parameterisedIterable,
        $arrayKey, $scalar, $mixed
    ) {
        throw new \Exception();

    }//end nonNativeTypes()


    /**
     * Parameter modifiers
     *
     * @param object &$reference
     * @param int    ...$splat
     *
     * @return void
     */
    public function parameterModifiers(
        object &$reference,
        int ...$splat
    ): void {

    }//end parameterModifiers()


    /**
     * Boolean types
     *
     * @param bool|boolean $bool
     * @param true|false   $literal
     *
     * @return void
     */
    public function booleanTypes(bool $bool, bool $literal): void
    {

    }//end booleanTypes()


    /**
     * Integer types
     *
     * @param int|integer                                                 $int
     * @param positive-int|negative-int|non-positive-int|non-negative-int $intRange1
     * @param int<0, 100>|int<min, 100>|int<50, max>|int<-100, max>       $intRange2
     * @param 234|-234                                                    $literal1
     * @param int-mask<1, 2, 4>                                           $intMask1
     *
     * @return void
     */
    public function integerTypes(int $int, int $intRange1, int $intRange2,
        int $literal1, int $intMask1
    ): void {

    }//end integerTypes()


    /**
     * Integer types complex
     *
     * @param 1_000|-1_000                                                                $literal2
     * @param int-mask<TypesValid::INT_ONE, TypesValid::INT_TWO>                          $intMask2
     * @param int-mask-of<TypesValid::INT_*>|int-mask-of<key-of<TypesValid::ARRAY_CONST>> $intMask3
     *
     * @return void
     */
    public function integerTypesComplex(int $literal2, int $intMask2, int $intMask3): void
    {

    }//end integerTypesComplex()


    /**
     * Float types
     *
     * @param float|double $float
     * @param 1.0|-1.0     $literal
     *
     * @return void
     */
    public function floatTypes(float $float, float $literal): void
    {

    }//end floatTypes()


    /**
     * String types
     *
     * @param string                                                                                        $string
     * @param class-string|class-string<TypesValid>                                                         $classString1
     * @param callable-string|numeric-string|non-empty-string|non-falsy-string|truthy-string|literal-string $other
     * @param 'foo'|'bar'                                                                                   $literal
     *
     * @return void
     */
    public function stringTypes(string $string, string $classString1, string $other, string $literal): void
    {

    }//end stringTypes()


    /**
     * String types complex
     *
     * @param '\'' $stringWithEscape
     *
     * @return void
     */
    public function stringTypesComplex(string $stringWithEscape): void
    {

    }//end stringTypesComplex()


    /**
     * Array types
     *
     * @param TypesValid[]|array<TypesValid>|array<int, string>                                  $genArray1
     * @param non-empty-array<TypesValid>|non-empty-array<int, TypesValid>                       $genArray2
     * @param list<TypesValid>|non-empty-list<TypesValid>                                        $list
     * @param array{'foo': int, "bar": string}|array{'foo': int, "bar"?: string}|array{int, int} $shapes1
     * @param array{0: int, 1?: int}|array{foo: int, bar: string}                                $shapes2
     *
     * @return void
     */
    public function arrayTypes(array $genArray1, array $genArray2, array $list,
        array $shapes1, array $shapes2
    ): void {

    }//end arrayTypes()


    /**
     * Array types complex
     *
     * @param array<array-key, string> $genArray3
     *
     * @return void
     */
    public function arrayTypesComplex(array $genArray3): void
    {

    }//end arrayTypesComplex()


    /**
     * Object types
     *
     * @param object                                                               $object
     * @param object{'foo': int, "bar": string}|object{'foo': int, "bar"?: string} $shapes1
     * @param object{foo: int, bar?: string}                                       $shapes2
     * @param TypesValid                                                           $class
     * @param self|parent|static|$this                                             $relative
     * @param Traversable<int>|Traversable<int, int>                               $traversable1
     * @param \Closure|\Closure(int, int): string                                  $closure
     *
     * @return void
     */
    public function objectTypes(object $object, object $shapes1, object $shapes2, object $class,
        object $relative, object $traversable1, object $closure
    ): void {

    }//end objectTypes()


    /**
     * Object types complex
     *
     * @param Traversable<1|2, TypesValid|TypesValidInterface>|Traversable<TypesValid::INT_*, string> $traversable2
     *
     * @return void
     */
    public function objectTypesComplex(object $traversable2): void
    {

    }//end objectTypesComplex()


    /**
     * Never type
     *
     * @return never|never-return|never-returns|no-return
     */
    public function neverType()
    {
        throw new \Exception();

    }//end neverType()


    /**
     * Null type
     *
     * @param null $standAloneNull
     * @param ?int $explicitNullable
     * @param ?int $implicitNullable
     *
     * @return void
     */
    public function nullType(
        $standAloneNull,
        ?int $explicitNullable,
        int $implicitNullable=null
    ): void {

    }//end nullType()


    /**
     * User-defined type
     *
     * @param TypesValid|\TypesValid $class
     *
     * @return void
     */
    public function userDefinedType(TypesValid $class): void
    {

    }//end userDefinedType()


    /**
     * Callable types
     *
     * @param callable|callable(int, int): string|callable(int, int=): string $callable1
     * @param callable(int $foo, string $bar): void                           $callable2
     * @param callable(float ...$floats): (int|null)|callable(object&): ?int  $callable3
     * @param \Closure|\Closure(int, int): string                             $closure
     * @param callable-string                                                 $callableString
     *
     * @return void
     */
    public function callableTypes(callable $callable1, callable $callable2, callable $callable3,
        callable $closure, callable $callableString
    ): void {

    }//end callableTypes()


    /**
     * Iterable types
     *
     * @param array<int>                                           $array
     * @param iterable<TypesValid>|iterable<int, TypesValid>       $iterable1
     * @param Traversable<TypesValid>|Traversable<int, TypesValid> $traversable1
     *
     * @return void
     */
    public function iterableTypes(iterable $array, iterable $iterable1, iterable $traversable1): void
    {

    }//end iterableTypes()


    /**
     * Iterable types complex
     *
     * @param iterable<1|2, TypesValid>|iterable<TypesValid::INT_*, string>       $iterable2
     * @param Traversable<1|2, TypesValid>|Traversable<TypesValid::INT_*, string> $traversable2
     *
     * @return void
     */
    public function iterableTypesComplex(iterable $iterable2, iterable $traversable2): void
    {

    }//end iterableTypesComplex()


    /**
     * Key and value of
     *
     * @param key-of<TypesValid::ARRAY_CONST>   $keyOf1
     * @param value-of<TypesValid::ARRAY_CONST> $valueOf1
     *
     * @return void
     */
    public function keyAndValueOf(int $keyOf1, string $valueOf1): void
    {

    }//end keyAndValueOf()


    /**
     * Key and value of complex
     *
     * @param key-of<TypesValid::ARRAY_CONST|array<int, string>>   $keyOf2
     * @param value-of<TypesValid::ARRAY_CONST|array<int, string>> $valueOf2
     *
     * @return void
     */
    public function keyAndValueOfComplex(int $keyOf2, string $valueOf2): void
    {

    }//end keyAndValueOfComplex()


    /**
     * Conditional return types
     *
     * @param int $size
     *
     * @return ($size is positive-int ? non-empty-array<string> : array<string>)
     */
    public function conditionalReturn(int $size): array
    {
        if ($size > 0) {
            return array_fill(0, $size, 'entry');
        } else {
            return [];
        }

    }//end conditionalReturn()


    /**
     * Conditional return types complex 1
     *
     * @param TypesValid::INT_*|TypesValid::STRING_* $x
     *
     * @return ($x is TypesValid::INT_* ? TypesValid::INT_* : TypesValid::STRING_*)
     */
    public function conditionalReturnComplex1($x)
    {
        return $x;

    }//end conditionalReturnComplex1()


    /**
     * Conditional return types complex 2
     *
     * @param 1|2|'Hello'|'World' $x
     *
     * @return ($x is 1|2 ? 1|2 : 'Hello'|'World')
     */
    public function conditionalReturnComplex2($x)
    {
        return $x;

    }//end conditionalReturnComplex2()


    /**
     * Constant enumerations
     *
     * @param TypesValid::BOOL_FALSE|TypesValid::BOOL_TRUE|TypesValid::BOOL_* $bool
     * @param TypesValid::INT_ONE                                             $int1
     * @param TypesValid::INT_ONE|TypesValid::INT_TWO                         $int2
     * @param self::INT_*                                                     $int3
     * @param TypesValid::*                                                   $mixed
     * @param TypesValid::FLOAT_1_0|TypesValid::FLOAT_2_0                     $float
     * @param TypesValid::STRING_HELLO                                        $string
     * @param TypesValid::ARRAY_CONST                                         $array
     *
     * @return void
     */
    public function constantEnumerations(bool $bool, int $int1, int $int2, int $int3, $mixed,
        float $float, string $string, array $array
    ): void {

    }//end constantEnumerations()


    /**
     * Basic structure
     *
     * @param ?int                                          $nullable
     * @param int|string                                    $union
     * @param TypesValid&object{additionalproperty: string} $intersection
     * @param (int)                                         $brackets
     * @param int[]                                         $arraySuffix
     *
     * @return void
     */
    public function basicStructure(
        ?int $nullable,
        $union,
        object $intersection,
        int $brackets,
        array $arraySuffix
    ): void {

    }//end basicStructure()


    /**
     * Structure combinations
     *
     * @param int|float|string                                                $multipleUnion
     * @param TypesValid&object{additionalproperty: string}&\Traversable<int> $multipleIntersection
     * @param ((int))                                                         $multipleBracket
     * @param int[][]                                                         $multipleArray
     * @param ?(int)                                                          $nullableBracket1
     * @param (?int)                                                          $nullableBracket2
     * @param ?int[]                                                          $nullableArray
     * @param (int|float)                                                     $unionBracket1
     * @param int|(float)                                                     $unionBracket2
     * @param int|int[]                                                       $unionArray
     * @param (TypesValid&object{additionalproperty: string})                 $intersectionBracket1
     * @param TypesValid&(object{additionalproperty: string})                 $intersectionBracket2
     * @param (int)[]                                                         $bracketArray1
     * @param (int[])                                                         $bracketArray2
     * @param int|(TypesValid&object{additionalproperty: string})             $dnf
     *
     * @return void
     */
    public function structureCombos(
        $multipleUnion,
        object $multipleIntersection,
        int $multipleBracket,
        array $multipleArray,
        ?int $nullableBracket1,
        ?int $nullableBracket2,
        ?array $nullableArray,
        $unionBracket1,
        $unionBracket2,
        $unionArray,
        object $intersectionBracket1,
        object $intersectionBracket2,
        array $bracketArray1,
        array $bracketArray2,
        $dnf
    ): void {

    }//end structureCombos()


    /**
     * DocType DNF vs Native DNF
     *
     * @param int|(TypesValidParent&TypesValidInterface) $p
     *
     * @return void
     */
    public function dnfVsDnf((TypesValidInterface&TypesValidParent)|int $p): void
    {

    }//end dnfVsDnf()


    /**
     * Inheritance
     *
     * @param TypesValid        $basic
     * @param self|static|$this $relative1
     * @param TypesValid        $relative2
     *
     * @return void
     */
    public function inheritance(
        TypesValidParent $basic,
        parent $relative1,
        parent $relative2
    ): void {

    }//end inheritance()


    /**
     * Template
     *
     * @param T $template
     *
     * @template T of int
     * @return   void
     */
    public function template(int $template): void
    {

    }//end template()


    /**
     * Use alias
     *
     * @param stdClass $use
     *
     * @return void
     */
    public function uses(MyStdClass $use): void
    {

    }//end uses()


    /**
     * Built-in classes with inheritance
     *
     * @param Traversable<string>|Iterator|Generator|IteratorAggregate  $traversable
     * @param Iterator|Generator                                        $iterator
     * @param Throwable|Exception|Error                                 $throwable
     * @param Exception|ErrorException                                  $exception
     * @param Error|ArithmeticError|AssertionError|ParseError|TypeError $error
     * @param ArithmeticError|DivisionByZeroError                       $arithmeticError
     *
     * @return void
     */
    public function builtinClasses(
        Traversable $traversable, Iterator $iterator,
        Throwable $throwable, Exception $exception, Error $error,
        ArithmeticError $arithmeticError
    ): void {

    }//end builtinClasses()


    /**
     * SPL classes with inheritance (a few examples only)
     *
     * @param Iterator|SeekableIterator<int, string>|ArrayIterator $iterator
     * @param SeekableIterator<int, string>|ArrayIterator          $seekableIterator
     * @param Countable|ArrayIterator                              $countable
     *
     * @return void
     */
    public function splClasses(
        Iterator $iterator, SeekableIterator $seekableIterator, Countable $countable
    ): void {

    }//end splClasses()


}//end class
