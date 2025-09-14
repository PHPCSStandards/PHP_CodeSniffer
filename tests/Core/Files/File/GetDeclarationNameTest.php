<?php
/**
 * Tests for the \PHP_CodeSniffer\Files\File::getDeclarationName method.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2022 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Files\File;

use PHP_CodeSniffer\Tests\Core\AbstractMethodTestCase;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Tests for the \PHP_CodeSniffer\Files\File:getDeclarationName method.
 *
 * @covers \PHP_CodeSniffer\Files\File::getDeclarationName
 */
final class GetDeclarationNameTest extends AbstractMethodTestCase
{


    /**
     * Test receiving an expected exception when a non-supported token is passed.
     *
     * @param string     $testMarker The comment which prefaces the target token in the test file.
     * @param int|string $targetType Token type of the token to get as stackPtr.
     *
     * @dataProvider dataInvalidTokenPassed
     *
     * @return void
     */
    public function testInvalidTokenPassed($testMarker, $targetType)
    {
        $tokenName = Tokens::tokenName($targetType);
        $this->expectRunTimeException('Token type "' . $tokenName . '" is not T_FUNCTION, T_CLASS, T_INTERFACE, T_TRAIT or T_ENUM');

        $target = $this->getTargetToken($testMarker, $targetType);
        self::$phpcsFile->getDeclarationName($target);
    }


    /**
     * Data provider.
     *
     * @see testGetInvalidTokenPassed() For the array format.
     *
     * @return array<string, array<string, int|string>>
     */
    public static function dataInvalidTokenPassed()
    {
        return [
            'unsupported token T_STRING'             => [
                'testMarker' => '/* testInvalidTokenPassed */',
                'targetType' => T_STRING,
            ],
            'closure'                                => [
                'testMarker' => '/* testClosure */',
                'targetType' => T_CLOSURE,
            ],
            'anon-class-with-parentheses'            => [
                'testMarker' => '/* testAnonClassWithParens */',
                'targetType' => T_ANON_CLASS,
            ],
            'anon-class-with-parentheses-2'          => [
                'testMarker' => '/* testAnonClassWithParens2 */',
                'targetType' => T_ANON_CLASS,
            ],
            'anon-class-without-parentheses'         => [
                'testMarker' => '/* testAnonClassWithoutParens */',
                'targetType' => T_ANON_CLASS,
            ],
            'anon-class-extends-without-parentheses' => [
                'testMarker' => '/* testAnonClassExtendsWithoutParens */',
                'targetType' => T_ANON_CLASS,
            ],
        ];
    }


    /**
     * Test retrieving the name of a function or OO structure.
     *
     * @param string          $testMarker The comment which prefaces the target token in the test file.
     * @param string          $expected   Expected function output.
     * @param int|string|null $targetType Token type of the token to get as stackPtr.
     *
     * @dataProvider dataGetDeclarationName
     *
     * @return void
     */
    public function testGetDeclarationName($testMarker, $expected, $targetType = null)
    {
        if (isset($targetType) === false) {
            $targetType = [
                T_CLASS,
                T_INTERFACE,
                T_TRAIT,
                T_ENUM,
                T_FUNCTION,
            ];
        }

        $target = $this->getTargetToken($testMarker, $targetType);
        $result = self::$phpcsFile->getDeclarationName($target);
        $this->assertSame($expected, $result);
    }


    /**
     * Data provider.
     *
     * @see testGetDeclarationName() For the array format.
     *
     * @return array<string, array<string, string>>
     */
    public static function dataGetDeclarationName()
    {
        return [
            'function'                                                  => [
                'testMarker' => '/* testFunction */',
                'expected'   => 'functionName',
            ],
            'function-return-by-reference'                              => [
                'testMarker' => '/* testFunctionReturnByRef */',
                'expected'   => 'functionNameByRef',
            ],
            'class'                                                     => [
                'testMarker' => '/* testClass */',
                'expected'   => 'ClassName',
            ],
            'method'                                                    => [
                'testMarker' => '/* testMethod */',
                'expected'   => 'methodName',
            ],
            'abstract-method'                                           => [
                'testMarker' => '/* testAbstractMethod */',
                'expected'   => 'abstractMethodName',
            ],
            'method-return-by-reference'                                => [
                'testMarker' => '/* testMethodReturnByRef */',
                'expected'   => 'MethodNameByRef',
            ],
            'extended-class'                                            => [
                'testMarker' => '/* testExtendedClass */',
                'expected'   => 'ExtendedClass',
            ],
            'interface'                                                 => [
                'testMarker' => '/* testInterface */',
                'expected'   => 'InterfaceName',
            ],
            'trait'                                                     => [
                'testMarker' => '/* testTrait */',
                'expected'   => 'TraitName',
            ],
            'function-name-ends-with-number'                            => [
                'testMarker' => '/* testFunctionEndingWithNumber */',
                'expected'   => 'ValidNameEndingWithNumber5',
            ],
            'class-with-numbers-in-name'                                => [
                'testMarker' => '/* testClassWithNumber */',
                'expected'   => 'ClassWith1Number',
            ],
            'interface-with-numbers-in-name'                            => [
                'testMarker' => '/* testInterfaceWithNumbers */',
                'expected'   => 'InterfaceWith12345Numbers',
            ],
            'class-with-comments-and-new-lines'                         => [
                'testMarker' => '/* testClassWithCommentsAndNewLines */',
                'expected'   => 'ClassWithCommentsAndNewLines',
            ],
            'function-named-fn'                                         => [
                'testMarker' => '/* testFunctionFn */',
                'expected'   => 'fn',
            ],
            'enum-pure'                                                 => [
                'testMarker' => '/* testPureEnum */',
                'expected'   => 'Foo',
            ],
            'enum-backed-space-between-name-and-colon'                  => [
                'testMarker' => '/* testBackedEnumSpaceBetweenNameAndColon */',
                'expected'   => 'Hoo',
            ],
            'enum-backed-no-space-between-name-and-colon'               => [
                'testMarker' => '/* testBackedEnumNoSpaceBetweenNameAndColon */',
                'expected'   => 'Suit',
            ],
            'function-return-by-reference-with-reserved-keyword-each'   => [
                'testMarker' => '/* testFunctionReturnByRefWithReservedKeywordEach */',
                'expected'   => 'each',
            ],
            'function-return-by-reference-with-reserved-keyword-parent' => [
                'testMarker' => '/* testFunctionReturnByRefWithReservedKeywordParent */',
                'expected'   => 'parent',
            ],
            'function-return-by-reference-with-reserved-keyword-self'   => [
                'testMarker' => '/* testFunctionReturnByRefWithReservedKeywordSelf */',
                'expected'   => 'self',
            ],
            'function-return-by-reference-with-reserved-keyword-static' => [
                'testMarker' => '/* testFunctionReturnByRefWithReservedKeywordStatic */',
                'expected'   => 'static',
            ],
        ];
    }
}
