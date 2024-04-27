<?php
/**
 * A collection of valid types for testing
 *
 * This file should have no errors when checked with either PHPStan or Psalm, other than no value for iterable.
 * And no errors when checked with the PHPDoc types sniff, regardless of setting.
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
     * Basic type equivalence
     *
     * @param array      $array
     * @param bool       $bool
     * @param int        $int
     * @param float      $float
     * @param string     $string
     * @param object     $object
     * @param self       $self
     * @param iterable   $iterable
     * @param TypesValid $specificClass
     * @param callable   $callable
     *
     * @return void
     */
    public function basicTypeEquivalence(
        array $array,
        bool $bool,
        int $int,
        float $float,
        string $string,
        object $object,
        self $self,
        iterable $iterable,
        TypesValid $specificClass,
        callable $callable
    ): void {

    }//end basicTypeEquivalence()


    /**
     * Types not supported natively (as of PHP 7.2)
     *
     * @param resource $resource
     * @param static   $static
     * @param mixed    $mixed
     *
     * @return never
     */
    public function nonNativeTypes($resource, $static, $mixed)
    {
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
     * @param bool       $bool
     * @param true|false $literal
     *
     * @return void
     */
    public function booleanTypes(bool $bool, bool $literal): void
    {

    }//end booleanTypes()


    /**
     * Object types
     *
     * @param object            $object
     * @param TypesValid        $class
     * @param self|static|$this $relative
     * @param Traversable       $traversable
     * @param \Closure          $closure
     *
     * @return void
     */
    public function objectTypes(object $object, object $class,
        object $relative, object $traversable, object $closure
    ): void {

    }//end objectTypes()


    /**
     * Null type
     *
     * @param null     $standAloneNull
     * @param int|null $explicitNullable
     * @param int|null $implicitNullable
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
     * @param callable $callable
     * @param \Closure $closure
     *
     * @return void
     */
    public function callableTypes(callable $callable, callable $closure): void
    {

    }//end callableTypes()


    /**
     * Iterable types
     *
     * @param array       $array
     * @param iterable    $iterable
     * @param Traversable $traversable
     *
     * @return void
     */
    public function iterableTypes(iterable $array, iterable $iterable, iterable $traversable): void
    {

    }//end iterableTypes()


    /**
     * Basic structure
     *
     * @param int|string        $union
     * @param TypesValid&object $intersection
     * @param int[]             $arraySuffix
     *
     * @return void
     */
    public function basicStructure(
        $union,
        object $intersection,
        array $arraySuffix
    ): void {

    }//end basicStructure()


    /**
     * Structure combinations
     *
     * @param int|float|string               $multipleUnion
     * @param TypesValid&object&\Traversable $multipleIntersection
     * @param int[][]                        $multipleArray
     * @param int|int[]                      $unionArray
     * @param (int)[]                        $bracketArray
     * @param int|TypesValid&object          $dnf
     *
     * @return void
     */
    public function structureCombos(
        $multipleUnion,
        object $multipleIntersection,
        array $multipleArray,
        $unionArray,
        array $bracketArray,
        $dnf
    ): void {

    }//end structureCombos()


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
     * @param Traversable|Iterator|Generator|IteratorAggregate          $traversable
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
     * @param Iterator|SeekableIterator|ArrayIterator $iterator
     * @param SeekableIterator|ArrayIterator          $seekableIterator
     * @param Countable|ArrayIterator                 $countable
     *
     * @return void
     */
    public function splClasses(
        Iterator $iterator, SeekableIterator $seekableIterator, Countable $countable
    ): void {

    }//end splClasses()


}//end class
