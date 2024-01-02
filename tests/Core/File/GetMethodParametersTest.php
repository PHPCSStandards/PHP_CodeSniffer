<?php
/**
 * Tests for the \PHP_CodeSniffer\Files\File::getMethodParameters method.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2019-2024 PHPCSStandards Contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\File;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;

/**
 * Tests for the \PHP_CodeSniffer\Files\File::getMethodParameters method.
 *
 * @covers \PHP_CodeSniffer\Files\File::getMethodParameters
 */
class GetMethodParametersTest extends AbstractMethodUnitTest
{


    /**
     * Verify pass-by-reference parsing.
     *
     * @return void
     */
    public function testPassByReference()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 5,
            'name'                => '$var',
            'content'             => '&$var',
            'has_attributes'      => false,
            'pass_by_reference'   => true,
            'reference_token'     => 4,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPassByReference()


    /**
     * Verify array hint parsing.
     *
     * @return void
     */
    public function testArrayHint()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 6,
            'name'                => '$var',
            'content'             => 'array $var',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'array',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 4,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testArrayHint()


    /**
     * Verify variable.
     *
     * @return void
     */
    public function testVariable()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 4,
            'name'                => '$var',
            'content'             => '$var',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testVariable()


    /**
     * Verify default value parsing with a single function param.
     *
     * @return void
     */
    public function testSingleDefaultValue()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 4,
            'name'                => '$var1',
            'content'             => '$var1=self::CONSTANT',
            'default'             => 'self::CONSTANT',
            'default_token'       => 6,
            'default_equal_token' => 5,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testSingleDefaultValue()


    /**
     * Verify default value parsing.
     *
     * @return void
     */
    public function testDefaultValues()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 4,
            'name'                => '$var1',
            'content'             => '$var1=1',
            'default'             => '1',
            'default_token'       => 6,
            'default_equal_token' => 5,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'comma_token'         => 7,
        ];
        $expected[1] = [
            'token'               => 9,
            'name'                => '$var2',
            'content'             => "\$var2='value'",
            'default'             => "'value'",
            'default_token'       => 11,
            'default_equal_token' => 10,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testDefaultValues()


    /**
     * Verify type hint parsing.
     *
     * @return void
     */
    public function testTypeHint()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 6,
            'name'                => '$var1',
            'content'             => 'foo $var1',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'foo',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 4,
            'nullable_type'       => false,
            'comma_token'         => 7,
        ];

        $expected[1] = [
            'token'               => 11,
            'name'                => '$var2',
            'content'             => 'bar $var2',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'bar',
            'type_hint_token'     => 9,
            'type_hint_end_token' => 9,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testTypeHint()


    /**
     * Verify self type hint parsing.
     *
     * @return void
     */
    public function testSelfTypeHint()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 6,
            'name'                => '$var',
            'content'             => 'self $var',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'self',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 4,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testSelfTypeHint()


    /**
     * Verify nullable type hint parsing.
     *
     * @return void
     */
    public function testNullableTypeHint()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 7,
            'name'                => '$var1',
            'content'             => '?int $var1',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?int',
            'type_hint_token'     => 5,
            'type_hint_end_token' => 5,
            'nullable_type'       => true,
            'comma_token'         => 8,
        ];

        $expected[1] = [
            'token'               => 13,
            'name'                => '$var2',
            'content'             => '?\bar $var2',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?\bar',
            'type_hint_token'     => 11,
            'type_hint_end_token' => 11,
            'nullable_type'       => true,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testNullableTypeHint()


    /**
     * Verify "bitwise and" in default value !== pass-by-reference.
     *
     * @return void
     */
    public function testBitwiseAndConstantExpressionDefaultValue()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 4,
            'name'                => '$a',
            'content'             => '$a = 10 & 20',
            'default'             => '10 & 20',
            'default_token'       => 8,
            'default_equal_token' => 6,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testBitwiseAndConstantExpressionDefaultValue()


    /**
     * Verify that arrow functions are supported.
     *
     * @return void
     */
    public function testArrowFunction()
    {
        // Offsets are relative to the T_FN token.
        $expected    = [];
        $expected[0] = [
            'token'               => 4,
            'name'                => '$a',
            'content'             => 'int $a',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'int',
            'type_hint_token'     => 2,
            'type_hint_end_token' => 2,
            'nullable_type'       => false,
            'comma_token'         => 5,
        ];

        $expected[1] = [
            'token'               => 8,
            'name'                => '$b',
            'content'             => '...$b',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => true,
            'variadic_token'      => 7,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testArrowFunction()


    /**
     * Verify recognition of PHP8 mixed type declaration.
     *
     * @return void
     */
    public function testPHP8MixedTypeHint()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$var1',
            'content'             => 'mixed &...$var1',
            'has_attributes'      => false,
            'pass_by_reference'   => true,
            'reference_token'     => 6,
            'variable_length'     => true,
            'variadic_token'      => 7,
            'type_hint'           => 'mixed',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 4,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8MixedTypeHint()


    /**
     * Verify recognition of PHP8 mixed type declaration with nullability.
     *
     * @return void
     */
    public function testPHP8MixedTypeHintNullable()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 7,
            'name'                => '$var1',
            'content'             => '?Mixed $var1',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?Mixed',
            'type_hint_token'     => 5,
            'type_hint_end_token' => 5,
            'nullable_type'       => true,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8MixedTypeHintNullable()


    /**
     * Verify recognition of type declarations using the namespace operator.
     *
     * @return void
     */
    public function testNamespaceOperatorTypeHint()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 7,
            'name'                => '$var1',
            'content'             => '?namespace\Name $var1',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?namespace\Name',
            'type_hint_token'     => 5,
            'type_hint_end_token' => 5,
            'nullable_type'       => true,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testNamespaceOperatorTypeHint()


    /**
     * Verify handling of a variadic parameter with a class name based type declaration.
     *
     * @return void
     */
    public function testVariadicFunctionClassType()
    {
        $expected    = [];
        $expected[0] = [
            'token'               => 4,
            'name'                => '$unit',
            'content'             => '$unit',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'comma_token'         => 5,
        ];
        $expected[1] = [
            'token'               => 10,
            'name'                => '$intervals',
            'content'             => 'DateInterval ...$intervals',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => true,
            'variadic_token'      => 9,
            'type_hint'           => 'DateInterval',
            'type_hint_token'     => 7,
            'type_hint_end_token' => 7,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testVariadicFunctionClassType()


    /**
     * Verify recognition of various namespaced class name type declarations.
     *
     * @return void
     */
    public function testNameSpacedTypeDeclaration()
    {
        $expected    = [];
        $expected[0] = [
            'token'               => 7,
            'name'                => '$a',
            'content'             => '\Package\Sub\ClassName $a',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '\Package\Sub\ClassName',
            'type_hint_token'     => 5,
            'type_hint_end_token' => 5,
            'nullable_type'       => false,
            'comma_token'         => 8,
        ];
        $expected[1] = [
            'token'               => 13,
            'name'                => '$b',
            'content'             => '?Sub\AnotherClass $b',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?Sub\AnotherClass',
            'type_hint_token'     => 11,
            'type_hint_end_token' => 11,
            'nullable_type'       => true,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testNameSpacedTypeDeclaration()


    /**
     * Verify recognition of PHP8 union type declaration.
     *
     * @return void
     */
    public function testPHP8UnionTypesSimple()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$number',
            'content'             => 'int|float $number',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'int|float',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 6,
            'nullable_type'       => false,
            'comma_token'         => 9,
        ];
        $expected[1] = [
            'token'               => 17,
            'name'                => '$obj',
            'content'             => 'self|parent &...$obj',
            'has_attributes'      => false,
            'pass_by_reference'   => true,
            'reference_token'     => 15,
            'variable_length'     => true,
            'variadic_token'      => 16,
            'type_hint'           => 'self|parent',
            'type_hint_token'     => 11,
            'type_hint_end_token' => 13,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8UnionTypesSimple()


    /**
     * Verify recognition of PHP8 union type declaration when the variable has either a spread operator or a reference.
     *
     * @return void
     */
    public function testPHP8UnionTypesWithSpreadOperatorAndReference()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 9,
            'name'                => '$paramA',
            'content'             => 'float|null &$paramA',
            'has_attributes'      => false,
            'pass_by_reference'   => true,
            'reference_token'     => 8,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'float|null',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 6,
            'nullable_type'       => false,
            'comma_token'         => 10,
        ];
        $expected[1] = [
            'token'               => 17,
            'name'                => '$paramB',
            'content'             => 'string|int ...$paramB',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => true,
            'variadic_token'      => 16,
            'type_hint'           => 'string|int',
            'type_hint_token'     => 12,
            'type_hint_end_token' => 14,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8UnionTypesWithSpreadOperatorAndReference()


    /**
     * Verify recognition of PHP8 union type declaration with a bitwise or in the default value.
     *
     * @return void
     */
    public function testPHP8UnionTypesSimpleWithBitwiseOrInDefault()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 6,
            'name'                => '$var',
            'content'             => 'int|float $var = CONSTANT_A | CONSTANT_B',
            'default'             => 'CONSTANT_A | CONSTANT_B',
            'default_token'       => 10,
            'default_equal_token' => 8,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'int|float',
            'type_hint_token'     => 2,
            'type_hint_end_token' => 4,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8UnionTypesSimpleWithBitwiseOrInDefault()


    /**
     * Verify recognition of PHP8 union type declaration with two classes.
     *
     * @return void
     */
    public function testPHP8UnionTypesTwoClasses()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$var',
            'content'             => 'MyClassA|\Package\MyClassB $var',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'MyClassA|\Package\MyClassB',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 6,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8UnionTypesTwoClasses()


    /**
     * Verify recognition of PHP8 union type declaration with all base types.
     *
     * @return void
     */
    public function testPHP8UnionTypesAllBaseTypes()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 20,
            'name'                => '$var',
            'content'             => 'array|bool|callable|int|float|null|object|string $var',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'array|bool|callable|int|float|null|object|string',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 18,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8UnionTypesAllBaseTypes()


    /**
     * Verify recognition of PHP8 union type declaration with all pseudo types.
     *
     * Note: "Resource" is not a type, but seen as a class name.
     *
     * @return void
     */
    public function testPHP8UnionTypesAllPseudoTypes()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 16,
            'name'                => '$var',
            'content'             => 'false|mixed|self|parent|iterable|Resource $var',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'false|mixed|self|parent|iterable|Resource',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 14,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8UnionTypesAllPseudoTypes()


    /**
     * Verify recognition of PHP8 union type declaration with (illegal) nullability.
     *
     * @return void
     */
    public function testPHP8UnionTypesNullable()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$number',
            'content'             => '?int|float $number',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?int|float',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 6,
            'nullable_type'       => true,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8UnionTypesNullable()


    /**
     * Verify recognition of PHP8 type declaration with (illegal) single type null.
     *
     * @return void
     */
    public function testPHP8PseudoTypeNull()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 6,
            'name'                => '$var',
            'content'             => 'null $var = null',
            'default'             => 'null',
            'default_token'       => 10,
            'default_equal_token' => 8,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'null',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 4,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8PseudoTypeNull()


    /**
     * Verify recognition of PHP8 type declaration with (illegal) single type false.
     *
     * @return void
     */
    public function testPHP8PseudoTypeFalse()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 6,
            'name'                => '$var',
            'content'             => 'false $var = false',
            'default'             => 'false',
            'default_token'       => 10,
            'default_equal_token' => 8,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'false',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 4,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8PseudoTypeFalse()


    /**
     * Verify recognition of PHP8 type declaration with (illegal) type false combined with type bool.
     *
     * @return void
     */
    public function testPHP8PseudoTypeFalseAndBool()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$var',
            'content'             => 'bool|false $var = false',
            'default'             => 'false',
            'default_token'       => 12,
            'default_equal_token' => 10,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'bool|false',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 6,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8PseudoTypeFalseAndBool()


    /**
     * Verify recognition of PHP8 type declaration with (illegal) type object combined with a class name.
     *
     * @return void
     */
    public function testPHP8ObjectAndClass()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$var',
            'content'             => 'object|ClassName $var',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'object|ClassName',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 6,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8ObjectAndClass()


    /**
     * Verify recognition of PHP8 type declaration with (illegal) type iterable combined with array/Traversable.
     *
     * @return void
     */
    public function testPHP8PseudoTypeIterableAndArray()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 10,
            'name'                => '$var',
            'content'             => 'iterable|array|Traversable $var',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'iterable|array|Traversable',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 8,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8PseudoTypeIterableAndArray()


    /**
     * Verify recognition of PHP8 type declaration with (illegal) duplicate types.
     *
     * @return void
     */
    public function testPHP8DuplicateTypeInUnionWhitespaceAndComment()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 17,
            'name'                => '$var',
            'content'             => 'int | string /*comment*/ | INT $var',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'int|string|INT',
            'type_hint_token'     => 5,
            'type_hint_end_token' => 15,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8DuplicateTypeInUnionWhitespaceAndComment()


    /**
     * Verify recognition of PHP8 constructor property promotion without type declaration, with defaults.
     *
     * @return void
     */
    public function testPHP8ConstructorPropertyPromotionNoTypes()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$x',
            'content'             => 'public $x = 0.0',
            'default'             => '0.0',
            'default_token'       => 12,
            'default_equal_token' => 10,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'property_visibility' => 'public',
            'visibility_token'    => 6,
            'property_readonly'   => false,
            'comma_token'         => 13,
        ];
        $expected[1] = [
            'token'               => 18,
            'name'                => '$y',
            'content'             => 'protected $y = \'\'',
            'default'             => "''",
            'default_token'       => 22,
            'default_equal_token' => 20,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'property_visibility' => 'protected',
            'visibility_token'    => 16,
            'property_readonly'   => false,
            'comma_token'         => 23,
        ];
        $expected[2] = [
            'token'               => 28,
            'name'                => '$z',
            'content'             => 'private $z = null',
            'default'             => 'null',
            'default_token'       => 32,
            'default_equal_token' => 30,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'property_visibility' => 'private',
            'visibility_token'    => 26,
            'property_readonly'   => false,
            'comma_token'         => 33,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8ConstructorPropertyPromotionNoTypes()


    /**
     * Verify recognition of PHP8 constructor property promotion with type declarations.
     *
     * @return void
     */
    public function testPHP8ConstructorPropertyPromotionWithTypes()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 10,
            'name'                => '$x',
            'content'             => 'protected float|int $x',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'float|int',
            'type_hint_token'     => 6,
            'type_hint_end_token' => 8,
            'nullable_type'       => false,
            'property_visibility' => 'protected',
            'visibility_token'    => 4,
            'property_readonly'   => false,
            'comma_token'         => 11,
        ];
        $expected[1] = [
            'token'               => 19,
            'name'                => '$y',
            'content'             => 'public ?string &$y = \'test\'',
            'default'             => "'test'",
            'default_token'       => 23,
            'default_equal_token' => 21,
            'has_attributes'      => false,
            'pass_by_reference'   => true,
            'reference_token'     => 18,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?string',
            'type_hint_token'     => 16,
            'type_hint_end_token' => 16,
            'nullable_type'       => true,
            'property_visibility' => 'public',
            'visibility_token'    => 13,
            'property_readonly'   => false,
            'comma_token'         => 24,
        ];
        $expected[2] = [
            'token'               => 30,
            'name'                => '$z',
            'content'             => 'private mixed $z',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'mixed',
            'type_hint_token'     => 28,
            'type_hint_end_token' => 28,
            'nullable_type'       => false,
            'property_visibility' => 'private',
            'visibility_token'    => 26,
            'property_readonly'   => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8ConstructorPropertyPromotionWithTypes()


    /**
     * Verify recognition of PHP8 constructor with both property promotion as well as normal parameters.
     *
     * @return void
     */
    public function testPHP8ConstructorPropertyPromotionAndNormalParam()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$promotedProp',
            'content'             => 'public int $promotedProp',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'int',
            'type_hint_token'     => 6,
            'type_hint_end_token' => 6,
            'nullable_type'       => false,
            'property_visibility' => 'public',
            'visibility_token'    => 4,
            'property_readonly'   => false,
            'comma_token'         => 9,
        ];
        $expected[1] = [
            'token'               => 14,
            'name'                => '$normalArg',
            'content'             => '?int $normalArg',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?int',
            'type_hint_token'     => 12,
            'type_hint_end_token' => 12,
            'nullable_type'       => true,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8ConstructorPropertyPromotionAndNormalParam()


    /**
     * Verify recognition of PHP8 constructor with property promotion using PHP 8.1 readonly keyword.
     *
     * @return void
     */
    public function testPHP81ConstructorPropertyPromotionWithReadOnly()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 11,
            'name'                => '$promotedProp',
            'content'             => 'public readonly ?int $promotedProp',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?int',
            'type_hint_token'     => 9,
            'type_hint_end_token' => 9,
            'nullable_type'       => true,
            'property_visibility' => 'public',
            'visibility_token'    => 4,
            'property_readonly'   => true,
            'readonly_token'      => 6,
            'comma_token'         => 12,
        ];
        $expected[1] = [
            'token'               => 23,
            'name'                => '$promotedToo',
            'content'             => 'readonly private string|bool &$promotedToo',
            'has_attributes'      => false,
            'pass_by_reference'   => true,
            'reference_token'     => 22,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'string|bool',
            'type_hint_token'     => 18,
            'type_hint_end_token' => 20,
            'nullable_type'       => false,
            'property_visibility' => 'private',
            'visibility_token'    => 16,
            'property_readonly'   => true,
            'readonly_token'      => 14,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP81ConstructorPropertyPromotionWithReadOnly()


    /**
     * Verify recognition of PHP8 constructor with property promotion using PHP 8.1 readonly
     * keyword without explicit visibility.
     *
     * @return void
     */
    public function testPHP81ConstructorPropertyPromotionWithOnlyReadOnly()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 10,
            'name'                => '$promotedProp',
            'content'             => 'readonly Foo&Bar $promotedProp',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'Foo&Bar',
            'type_hint_token'     => 6,
            'type_hint_end_token' => 8,
            'nullable_type'       => false,
            'property_visibility' => 'public',
            'visibility_token'    => false,
            'property_readonly'   => true,
            'readonly_token'      => 4,
            'comma_token'         => 11,
        ];
        $expected[1] = [
            'token'               => 18,
            'name'                => '$promotedToo',
            'content'             => 'readonly ?bool $promotedToo',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?bool',
            'type_hint_token'     => 16,
            'type_hint_end_token' => 16,
            'nullable_type'       => true,
            'property_visibility' => 'public',
            'visibility_token'    => false,
            'property_readonly'   => true,
            'readonly_token'      => 13,
            'comma_token'         => 19,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP81ConstructorPropertyPromotionWithOnlyReadOnly()


    /**
     * Verify behaviour when a non-constructor function uses PHP 8 property promotion syntax.
     *
     * @return void
     */
    public function testPHP8ConstructorPropertyPromotionGlobalFunction()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 6,
            'name'                => '$x',
            'content'             => 'private $x',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'property_visibility' => 'private',
            'visibility_token'    => 4,
            'property_readonly'   => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8ConstructorPropertyPromotionGlobalFunction()


    /**
     * Verify behaviour when an abstract constructor uses PHP 8 property promotion syntax.
     *
     * @return void
     */
    public function testPHP8ConstructorPropertyPromotionAbstractMethod()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$y',
            'content'             => 'public callable $y',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'callable',
            'type_hint_token'     => 6,
            'type_hint_end_token' => 6,
            'nullable_type'       => false,
            'property_visibility' => 'public',
            'visibility_token'    => 4,
            'property_readonly'   => false,
            'comma_token'         => 9,
        ];
        $expected[1] = [
            'token'               => 14,
            'name'                => '$x',
            'content'             => 'private ...$x',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => true,
            'variadic_token'      => 13,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'property_visibility' => 'private',
            'visibility_token'    => 11,
            'property_readonly'   => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8ConstructorPropertyPromotionAbstractMethod()


    /**
     * Verify and document behaviour when there are comments within a parameter declaration.
     *
     * @return void
     */
    public function testCommentsInParameter()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 19,
            'name'                => '$param',
            'content'             => '// Leading comment.
    ?MyClass /*-*/ & /*-*/.../*-*/ $param /*-*/ = /*-*/ \'default value\' . /*-*/ \'second part\' // Trailing comment.',
            'default'             => '\'default value\' . /*-*/ \'second part\' // Trailing comment.',
            'default_token'       => 27,
            'default_equal_token' => 23,
            'has_attributes'      => false,
            'pass_by_reference'   => true,
            'reference_token'     => 13,
            'variable_length'     => true,
            'variadic_token'      => 16,
            'type_hint'           => '?MyClass',
            'type_hint_token'     => 9,
            'type_hint_end_token' => 9,
            'nullable_type'       => true,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testCommentsInParameter()


    /**
     * Verify behaviour when parameters have attributes attached.
     *
     * @return void
     */
    public function testParameterAttributesInFunctionDeclaration()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 14,
            'name'                => '$constructorPropPromTypedParamSingleAttribute',
            'content'             => '#[\MyExample\MyAttribute] private string $constructorPropPromTypedParamSingleAttribute',
            'has_attributes'      => true,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'string',
            'type_hint_token'     => 12,
            'type_hint_end_token' => 12,
            'nullable_type'       => false,
            'property_visibility' => 'private',
            'visibility_token'    => 10,
            'property_readonly'   => false,
            'comma_token'         => 15,
        ];
        $expected[1] = [
            'token'               => 36,
            'name'                => '$typedParamSingleAttribute',
            'content'             => '#[MyAttr([1, 2])]
        Type|false
        $typedParamSingleAttribute',
            'has_attributes'      => true,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'Type|false',
            'type_hint_token'     => 31,
            'type_hint_end_token' => 33,
            'nullable_type'       => false,
            'comma_token'         => 37,
        ];
        $expected[2] = [
            'token'               => 56,
            'name'                => '$nullableTypedParamMultiAttribute',
            'content'             => '#[MyAttribute(1234), MyAttribute(5678)] ?int $nullableTypedParamMultiAttribute',
            'has_attributes'      => true,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?int',
            'type_hint_token'     => 54,
            'type_hint_end_token' => 54,
            'nullable_type'       => true,
            'comma_token'         => 57,
        ];
        $expected[3] = [
            'token'               => 71,
            'name'                => '$nonTypedParamTwoAttributes',
            'content'             => '#[WithoutArgument] #[SingleArgument(0)] $nonTypedParamTwoAttributes',
            'has_attributes'      => true,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'comma_token'         => 72,
        ];
        $expected[4] = [
            'token'               => 92,
            'name'                => '$otherParam',
            'content'             => '#[MyAttribute(array("key" => "value"))]
        &...$otherParam',
            'has_attributes'      => true,
            'pass_by_reference'   => true,
            'reference_token'     => 90,
            'variable_length'     => true,
            'variadic_token'      => 91,
            'type_hint'           => '',
            'type_hint_token'     => false,
            'type_hint_end_token' => false,
            'nullable_type'       => false,
            'comma_token'         => 93,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testParameterAttributesInFunctionDeclaration()


    /**
     * Verify recognition of PHP8.1 intersection type declaration.
     *
     * @return void
     */
    public function testPHP8IntersectionTypes()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$obj1',
            'content'             => 'Foo&Bar $obj1',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'Foo&Bar',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 6,
            'nullable_type'       => false,
            'comma_token'         => 9,
        ];
        $expected[1] = [
            'token'               => 15,
            'name'                => '$obj2',
            'content'             => 'Boo&Bar $obj2',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'Boo&Bar',
            'type_hint_token'     => 11,
            'type_hint_end_token' => 13,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP8IntersectionTypes()


    /**
     * Verify recognition of PHP8 intersection type declaration when the variable
     * has either a spread operator or a reference.
     *
     * @return void
     */
    public function testPHP81IntersectionTypesWithSpreadOperatorAndReference()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 9,
            'name'                => '$paramA',
            'content'             => 'Boo&Bar &$paramA',
            'has_attributes'      => false,
            'pass_by_reference'   => true,
            'reference_token'     => 8,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'Boo&Bar',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 6,
            'nullable_type'       => false,
            'comma_token'         => 10,
        ];
        $expected[1] = [
            'token'               => 17,
            'name'                => '$paramB',
            'content'             => 'Foo&Bar ...$paramB',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => true,
            'variadic_token'      => 16,
            'type_hint'           => 'Foo&Bar',
            'type_hint_token'     => 12,
            'type_hint_end_token' => 14,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP81IntersectionTypesWithSpreadOperatorAndReference()


    /**
     * Verify recognition of PHP8.1 intersection type declaration with more types.
     *
     * @return void
     */
    public function testPHP81MoreIntersectionTypes()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 10,
            'name'                => '$var',
            'content'             => 'MyClassA&\Package\MyClassB&\Package\MyClassC $var',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'MyClassA&\Package\MyClassB&\Package\MyClassC',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 8,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP81MoreIntersectionTypes()


    /**
     * Verify recognition of PHP8.1 intersection type declaration with illegal simple types.
     *
     * @return void
     */
    public function testPHP81IllegalIntersectionTypes()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 7,
            'name'                => '$numeric_string',
            'content'             => 'string&int $numeric_string',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'string&int',
            'type_hint_token'     => 3,
            'type_hint_end_token' => 5,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP81IllegalIntersectionTypes()


    /**
     * Verify recognition of PHP8.1 intersection type declaration with (illegal) nullability.
     *
     * @return void
     */
    public function testPHP81NullableIntersectionTypes()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$object',
            'content'             => '?Foo&Bar $object',
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?Foo&Bar',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 6,
            'nullable_type'       => true,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP81NullableIntersectionTypes()


    /**
     * Verify recognition of PHP 8.2 stand-alone `true` type.
     *
     * @return void
     */
    public function testPHP82PseudoTypeTrue()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 7,
            'name'                => '$var',
            'content'             => '?true $var = true',
            'default'             => 'true',
            'default_token'       => 11,
            'default_equal_token' => 9,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => '?true',
            'type_hint_token'     => 5,
            'type_hint_end_token' => 5,
            'nullable_type'       => true,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP82PseudoTypeTrue()


    /**
     * Verify recognition of PHP 8.2 type declaration with (illegal) type false combined with type true.
     *
     * @return void
     */
    public function testPHP82PseudoTypeFalseAndTrue()
    {
        // Offsets are relative to the T_FUNCTION token.
        $expected    = [];
        $expected[0] = [
            'token'               => 8,
            'name'                => '$var',
            'content'             => 'true|false $var = true',
            'default'             => 'true',
            'default_token'       => 12,
            'default_equal_token' => 10,
            'has_attributes'      => false,
            'pass_by_reference'   => false,
            'reference_token'     => false,
            'variable_length'     => false,
            'variadic_token'      => false,
            'type_hint'           => 'true|false',
            'type_hint_token'     => 4,
            'type_hint_end_token' => 6,
            'nullable_type'       => false,
            'comma_token'         => false,
        ];

        $this->getMethodParametersTestHelper('/* '.__FUNCTION__.' */', $expected);

    }//end testPHP82PseudoTypeFalseAndTrue()


    /**
     * Test helper.
     *
     * @param string                                     $commentString The comment which preceeds the test.
     * @param array<int, array<string, int|string|bool>> $expected      The expected function output.
     *
     * @return void
     */
    private function getMethodParametersTestHelper($commentString, $expected)
    {
        $target = $this->getTargetToken($commentString, [T_FUNCTION, T_CLOSURE, T_FN]);
        $found  = self::$phpcsFile->getMethodParameters($target);

        // Convert offsets to absolute positions in the token stream.
        foreach ($expected as $key => $param) {
            $expected[$key]['token'] += $target;

            if (is_int($param['reference_token']) === true) {
                $expected[$key]['reference_token'] += $target;
            }

            if (is_int($param['variadic_token']) === true) {
                $expected[$key]['variadic_token'] += $target;
            }

            if (is_int($param['type_hint_token']) === true) {
                $expected[$key]['type_hint_token'] += $target;
            }

            if (is_int($param['type_hint_end_token']) === true) {
                $expected[$key]['type_hint_end_token'] += $target;
            }

            if (is_int($param['comma_token']) === true) {
                $expected[$key]['comma_token'] += $target;
            }

            if (isset($param['default_token']) === true) {
                $expected[$key]['default_token'] += $target;
            }

            if (isset($param['default_equal_token']) === true) {
                $expected[$key]['default_equal_token'] += $target;
            }

            if (isset($param['visibility_token']) === true && is_int($param['visibility_token']) === true) {
                $expected[$key]['visibility_token'] += $target;
            }

            if (isset($param['readonly_token']) === true) {
                $expected[$key]['readonly_token'] += $target;
            }
        }//end foreach

        $this->assertEquals($expected, $found);

    }//end getMethodParametersTestHelper()


}//end class
