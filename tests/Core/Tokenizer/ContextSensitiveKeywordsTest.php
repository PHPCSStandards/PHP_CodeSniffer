<?php
/**
 * Tests the conversion of context sensitive keywords to T_STRING.
 *
 * @author    Jaroslav Hanslík <kukulich@kukulich.cz>
 * @copyright 2020 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizer;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;
use PHP_CodeSniffer\Util\Tokens;

final class ContextSensitiveKeywordsTest extends AbstractMethodUnitTest
{


    /**
     * Test that context sensitive keyword is tokenized as string when it should be string.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataStrings
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testStrings($testMarker)
    {
        $tokens = self::$phpcsFile->getTokens();

        $token = $this->getTargetToken($testMarker, (Tokens::$contextSensitiveKeywords + [T_STRING, T_NULL, T_FALSE, T_TRUE, T_PARENT, T_SELF]));

        $this->assertSame(T_STRING, $tokens[$token]['code']);
        $this->assertSame('T_STRING', $tokens[$token]['type']);

    }//end testStrings()


    /**
     * Data provider.
     *
     * @see testStrings()
     *
     * @return array<string, array<string>>
     */
    public static function dataStrings()
    {
        return [
            'constant declaration: abstract'                                    => ['/* testAbstract */'],
            'constant declaration: array'                                       => ['/* testArray */'],
            'constant declaration: as'                                          => ['/* testAs */'],
            'constant declaration: break'                                       => ['/* testBreak */'],
            'constant declaration: callable'                                    => ['/* testCallable */'],
            'constant declaration: case'                                        => ['/* testCase */'],
            'constant declaration: catch'                                       => ['/* testCatch */'],
            'constant declaration: class'                                       => ['/* testClass */'],
            'constant declaration: clone'                                       => ['/* testClone */'],
            'constant declaration: const'                                       => ['/* testConst */'],
            'constant declaration: continue'                                    => ['/* testContinue */'],
            'constant declaration: declare'                                     => ['/* testDeclare */'],
            'constant declaration: default'                                     => ['/* testDefault */'],
            'constant declaration: do'                                          => ['/* testDo */'],
            'constant declaration: echo'                                        => ['/* testEcho */'],
            'constant declaration: else'                                        => ['/* testElse */'],
            'constant declaration: elseif'                                      => ['/* testElseIf */'],
            'constant declaration: empty'                                       => ['/* testEmpty */'],
            'constant declaration: enddeclare'                                  => ['/* testEndDeclare */'],
            'constant declaration: endfor'                                      => ['/* testEndFor */'],
            'constant declaration: endforeach'                                  => ['/* testEndForeach */'],
            'constant declaration: endif'                                       => ['/* testEndIf */'],
            'constant declaration: endswitch'                                   => ['/* testEndSwitch */'],
            'constant declaration: endwhile'                                    => ['/* testEndWhile */'],
            'constant declaration: enum'                                        => ['/* testEnum */'],
            'constant declaration: eval'                                        => ['/* testEval */'],
            'constant declaration: exit'                                        => ['/* testExit */'],
            'constant declaration: extends'                                     => ['/* testExtends */'],
            'constant declaration: final'                                       => ['/* testFinal */'],
            'constant declaration: finally'                                     => ['/* testFinally */'],
            'constant declaration: fn'                                          => ['/* testFn */'],
            'constant declaration: for'                                         => ['/* testFor */'],
            'constant declaration: foreach'                                     => ['/* testForeach */'],
            'constant declaration: function'                                    => ['/* testFunction */'],
            'constant declaration: global'                                      => ['/* testGlobal */'],
            'constant declaration: goto'                                        => ['/* testGoto */'],
            'constant declaration: if'                                          => ['/* testIf */'],
            'constant declaration: implements'                                  => ['/* testImplements */'],
            'constant declaration: include'                                     => ['/* testInclude */'],
            'constant declaration: include_once'                                => ['/* testIncludeOnce */'],
            'constant declaration: instanceof'                                  => ['/* testInstanceOf */'],
            'constant declaration: insteadof'                                   => ['/* testInsteadOf */'],
            'constant declaration: interface'                                   => ['/* testInterface */'],
            'constant declaration: isset'                                       => ['/* testIsset */'],
            'constant declaration: list'                                        => ['/* testList */'],
            'constant declaration: match'                                       => ['/* testMatch */'],
            'constant declaration: namespace'                                   => ['/* testNamespace */'],
            'constant declaration: new'                                         => ['/* testNew */'],
            'constant declaration: parent'                                      => ['/* testParent */'],
            'constant declaration: print'                                       => ['/* testPrint */'],
            'constant declaration: private'                                     => ['/* testPrivate */'],
            'constant declaration: protected'                                   => ['/* testProtected */'],
            'constant declaration: public'                                      => ['/* testPublic */'],
            'constant declaration: readonly'                                    => ['/* testReadonly */'],
            'constant declaration: require'                                     => ['/* testRequire */'],
            'constant declaration: require_once'                                => ['/* testRequireOnce */'],
            'constant declaration: return'                                      => ['/* testReturn */'],
            'constant declaration: self'                                        => ['/* testSelf */'],
            'constant declaration: static'                                      => ['/* testStatic */'],
            'constant declaration: switch'                                      => ['/* testSwitch */'],
            'constant declaration: throws'                                      => ['/* testThrows */'],
            'constant declaration: trait'                                       => ['/* testTrait */'],
            'constant declaration: try'                                         => ['/* testTry */'],
            'constant declaration: unset'                                       => ['/* testUnset */'],
            'constant declaration: use'                                         => ['/* testUse */'],
            'constant declaration: var'                                         => ['/* testVar */'],
            'constant declaration: while'                                       => ['/* testWhile */'],
            'constant declaration: yield'                                       => ['/* testYield */'],
            'constant declaration: yield_from'                                  => ['/* testYieldFrom */'],
            'constant declaration: and'                                         => ['/* testAnd */'],
            'constant declaration: or'                                          => ['/* testOr */'],
            'constant declaration: xor'                                         => ['/* testXor */'],
            'constant declaration: false'                                       => ['/* testFalse */'],
            'constant declaration: true'                                        => ['/* testTrue */'],
            'constant declaration: null'                                        => ['/* testNull */'],

            'namespace declaration: class'                                      => ['/* testKeywordAfterNamespaceShouldBeString */'],
            'namespace declaration (partial): my'                               => ['/* testNamespaceNameIsString1 */'],
            'namespace declaration (partial): class'                            => ['/* testNamespaceNameIsString2 */'],
            'namespace declaration (partial): foreach'                          => ['/* testNamespaceNameIsString3 */'],

            'function declaration: eval'                                        => ['/* testKeywordAfterFunctionShouldBeString */'],
            'function declaration with return by ref: switch'                   => ['/* testKeywordAfterFunctionByRefShouldBeString */'],
            'function declaration with return by ref: self'                     => ['/* testKeywordSelfAfterFunctionByRefShouldBeString */'],
            'function declaration with return by ref: static'                   => ['/* testKeywordStaticAfterFunctionByRefShouldBeString */'],
            'function declaration with return by ref: parent'                   => ['/* testKeywordParentAfterFunctionByRefShouldBeString */'],
            'function declaration with return by ref: false'                    => ['/* testKeywordFalseAfterFunctionByRefShouldBeString */'],
            'function declaration with return by ref: true'                     => ['/* testKeywordTrueAfterFunctionByRefShouldBeString */'],
            'function declaration with return by ref: null'                     => ['/* testKeywordNullAfterFunctionByRefShouldBeString */'],

            'function call: self'                                               => ['/* testKeywordAsFunctionCallNameShouldBeStringSelf */'],
            'function call: static'                                             => ['/* testKeywordAsFunctionCallNameShouldBeStringStatic */'],
            'method call: static'                                               => ['/* testKeywordAsMethodCallNameShouldBeStringStatic */'],
            'function call: parent'                                             => ['/* testKeywordAsFunctionCallNameShouldBeStringParent */'],
            'function call: false'                                              => ['/* testKeywordAsFunctionCallNameShouldBeStringFalse */'],
            'function call: true'                                               => ['/* testKeywordAsFunctionCallNameShouldBeStringTrue */'],
            'function call: null; with comment between keyword and parentheses' => ['/* testKeywordAsFunctionCallNameShouldBeStringNull */'],

            'class instantiation: false'                                        => ['/* testClassInstantiationFalseIsString */'],
            'class instantiation: true'                                         => ['/* testClassInstantiationTrueIsString */'],
            'class instantiation: null'                                         => ['/* testClassInstantiationNullIsString */'],
        ];

    }//end dataStrings()


    /**
     * Test that context sensitive keyword is tokenized as keyword when it should be keyword.
     *
     * @param string $testMarker        The comment which prefaces the target token in the test file.
     * @param string $expectedTokenType The expected token type.
     *
     * @dataProvider dataKeywords
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testKeywords($testMarker, $expectedTokenType)
    {
        $tokens = self::$phpcsFile->getTokens();

        $token = $this->getTargetToken(
            $testMarker,
            (Tokens::$contextSensitiveKeywords + [T_ANON_CLASS, T_MATCH_DEFAULT, T_PARENT, T_SELF, T_STRING, T_NULL, T_FALSE, T_TRUE])
        );

        $this->assertSame(constant($expectedTokenType), $tokens[$token]['code']);
        $this->assertSame($expectedTokenType, $tokens[$token]['type']);

    }//end testKeywords()


    /**
     * Data provider.
     *
     * @see testKeywords()
     *
     * @return array
     */
    public static function dataKeywords()
    {
        return [
            'namespace: declaration'                  => [
                'testMarker'        => '/* testNamespaceIsKeyword */',
                'expectedTokenType' => 'T_NAMESPACE',
            ],
            'abstract: class declaration'             => [
                'testMarker'        => '/* testAbstractIsKeyword */',
                'expectedTokenType' => 'T_ABSTRACT',
            ],
            'class: declaration'                      => [
                'testMarker'        => '/* testClassIsKeyword */',
                'expectedTokenType' => 'T_CLASS',
            ],
            'extends: in class declaration'           => [
                'testMarker'        => '/* testExtendsIsKeyword */',
                'expectedTokenType' => 'T_EXTENDS',
            ],
            'implements: in class declaration'        => [
                'testMarker'        => '/* testImplementsIsKeyword */',
                'expectedTokenType' => 'T_IMPLEMENTS',
            ],
            'use: in trait import'                    => [
                'testMarker'        => '/* testUseIsKeyword */',
                'expectedTokenType' => 'T_USE',
            ],
            'insteadof: in trait import'              => [
                'testMarker'        => '/* testInsteadOfIsKeyword */',
                'expectedTokenType' => 'T_INSTEADOF',
            ],
            'as: in trait import'                     => [
                'testMarker'        => '/* testAsIsKeyword */',
                'expectedTokenType' => 'T_AS',
            ],
            'const: declaration'                      => [
                'testMarker'        => '/* testConstIsKeyword */',
                'expectedTokenType' => 'T_CONST',
            ],
            'private: property declaration'           => [
                'testMarker'        => '/* testPrivateIsKeyword */',
                'expectedTokenType' => 'T_PRIVATE',
            ],
            'protected: property declaration'         => [
                'testMarker'        => '/* testProtectedIsKeyword */',
                'expectedTokenType' => 'T_PROTECTED',
            ],
            'public: property declaration'            => [
                'testMarker'        => '/* testPublicIsKeyword */',
                'expectedTokenType' => 'T_PUBLIC',
            ],
            'var: property declaration'               => [
                'testMarker'        => '/* testVarIsKeyword */',
                'expectedTokenType' => 'T_VAR',
            ],
            'static: property declaration'            => [
                'testMarker'        => '/* testStaticIsKeyword */',
                'expectedTokenType' => 'T_STATIC',
            ],
            'readonly: property declaration'          => [
                'testMarker'        => '/* testReadonlyIsKeyword */',
                'expectedTokenType' => 'T_READONLY',
            ],
            'final: function declaration'             => [
                'testMarker'        => '/* testFinalIsKeyword */',
                'expectedTokenType' => 'T_FINAL',
            ],
            'function: declaration'                   => [
                'testMarker'        => '/* testFunctionIsKeyword */',
                'expectedTokenType' => 'T_FUNCTION',
            ],
            'callable: param type declaration'        => [
                'testMarker'        => '/* testCallableIsKeyword */',
                'expectedTokenType' => 'T_CALLABLE',
            ],
            'self: param type declaration'            => [
                'testMarker'        => '/* testSelfIsKeyword */',
                'expectedTokenType' => 'T_SELF',
            ],
            'parent: param type declaration'          => [
                'testMarker'        => '/* testParentIsKeyword */',
                'expectedTokenType' => 'T_PARENT',
            ],
            'return: statement'                       => [
                'testMarker'        => '/* testReturnIsKeyword */',
                'expectedTokenType' => 'T_RETURN',
            ],

            'interface: declaration'                  => [
                'testMarker'        => '/* testInterfaceIsKeyword */',
                'expectedTokenType' => 'T_INTERFACE',
            ],
            'trait: declaration'                      => [
                'testMarker'        => '/* testTraitIsKeyword */',
                'expectedTokenType' => 'T_TRAIT',
            ],
            'enum: declaration'                       => [
                'testMarker'        => '/* testEnumIsKeyword */',
                'expectedTokenType' => 'T_ENUM',
            ],

            'new: named instantiation'                => [
                'testMarker'        => '/* testNewIsKeyword */',
                'expectedTokenType' => 'T_NEW',
            ],
            'instanceof: comparison'                  => [
                'testMarker'        => '/* testInstanceOfIsKeyword */',
                'expectedTokenType' => 'T_INSTANCEOF',
            ],
            'clone'                                   => [
                'testMarker'        => '/* testCloneIsKeyword */',
                'expectedTokenType' => 'T_CLONE',
            ],

            'if'                                      => [
                'testMarker'        => '/* testIfIsKeyword */',
                'expectedTokenType' => 'T_IF',
            ],
            'empty'                                   => [
                'testMarker'        => '/* testEmptyIsKeyword */',
                'expectedTokenType' => 'T_EMPTY',
            ],
            'elseif'                                  => [
                'testMarker'        => '/* testElseIfIsKeyword */',
                'expectedTokenType' => 'T_ELSEIF',
            ],
            'else'                                    => [
                'testMarker'        => '/* testElseIsKeyword */',
                'expectedTokenType' => 'T_ELSE',
            ],
            'endif'                                   => [
                'testMarker'        => '/* testEndIfIsKeyword */',
                'expectedTokenType' => 'T_ENDIF',
            ],

            'for'                                     => [
                'testMarker'        => '/* testForIsKeyword */',
                'expectedTokenType' => 'T_FOR',
            ],
            'endfor'                                  => [
                'testMarker'        => '/* testEndForIsKeyword */',
                'expectedTokenType' => 'T_ENDFOR',
            ],

            'foreach'                                 => [
                'testMarker'        => '/* testForeachIsKeyword */',
                'expectedTokenType' => 'T_FOREACH',
            ],
            'endforeach'                              => [
                'testMarker'        => '/* testEndForeachIsKeyword */',
                'expectedTokenType' => 'T_ENDFOREACH',
            ],

            'switch'                                  => [
                'testMarker'        => '/* testSwitchIsKeyword */',
                'expectedTokenType' => 'T_SWITCH',
            ],
            'case: in switch'                         => [
                'testMarker'        => '/* testCaseIsKeyword */',
                'expectedTokenType' => 'T_CASE',
            ],
            'default: in switch'                      => [
                'testMarker'        => '/* testDefaultIsKeyword */',
                'expectedTokenType' => 'T_DEFAULT',
            ],
            'endswitch'                               => [
                'testMarker'        => '/* testEndSwitchIsKeyword */',
                'expectedTokenType' => 'T_ENDSWITCH',
            ],
            'break: in switch'                        => [
                'testMarker'        => '/* testBreakIsKeyword */',
                'expectedTokenType' => 'T_BREAK',
            ],
            'continue: in switch'                     => [
                'testMarker'        => '/* testContinueIsKeyword */',
                'expectedTokenType' => 'T_CONTINUE',
            ],

            'do'                                      => [
                'testMarker'        => '/* testDoIsKeyword */',
                'expectedTokenType' => 'T_DO',
            ],
            'while'                                   => [
                'testMarker'        => '/* testWhileIsKeyword */',
                'expectedTokenType' => 'T_WHILE',
            ],
            'endwhile'                                => [
                'testMarker'        => '/* testEndWhileIsKeyword */',
                'expectedTokenType' => 'T_ENDWHILE',
            ],

            'try'                                     => [
                'testMarker'        => '/* testTryIsKeyword */',
                'expectedTokenType' => 'T_TRY',
            ],
            'throw: statement'                        => [
                'testMarker'        => '/* testThrowIsKeyword */',
                'expectedTokenType' => 'T_THROW',
            ],
            'catch'                                   => [
                'testMarker'        => '/* testCatchIsKeyword */',
                'expectedTokenType' => 'T_CATCH',
            ],
            'finally'                                 => [
                'testMarker'        => '/* testFinallyIsKeyword */',
                'expectedTokenType' => 'T_FINALLY',
            ],

            'global'                                  => [
                'testMarker'        => '/* testGlobalIsKeyword */',
                'expectedTokenType' => 'T_GLOBAL',
            ],
            'echo'                                    => [
                'testMarker'        => '/* testEchoIsKeyword */',
                'expectedTokenType' => 'T_ECHO',
            ],
            'print: statement'                        => [
                'testMarker'        => '/* testPrintIsKeyword */',
                'expectedTokenType' => 'T_PRINT',
            ],
            'die: statement'                          => [
                'testMarker'        => '/* testDieIsKeyword */',
                'expectedTokenType' => 'T_EXIT',
            ],
            'eval'                                    => [
                'testMarker'        => '/* testEvalIsKeyword */',
                'expectedTokenType' => 'T_EVAL',
            ],
            'exit: statement'                         => [
                'testMarker'        => '/* testExitIsKeyword */',
                'expectedTokenType' => 'T_EXIT',
            ],
            'isset'                                   => [
                'testMarker'        => '/* testIssetIsKeyword */',
                'expectedTokenType' => 'T_ISSET',
            ],
            'unset'                                   => [
                'testMarker'        => '/* testUnsetIsKeyword */',
                'expectedTokenType' => 'T_UNSET',
            ],

            'include'                                 => [
                'testMarker'        => '/* testIncludeIsKeyword */',
                'expectedTokenType' => 'T_INCLUDE',
            ],
            'include_once'                            => [
                'testMarker'        => '/* testIncludeOnceIsKeyword */',
                'expectedTokenType' => 'T_INCLUDE_ONCE',
            ],
            'require'                                 => [
                'testMarker'        => '/* testRequireIsKeyword */',
                'expectedTokenType' => 'T_REQUIRE',
            ],
            'require_once'                            => [
                'testMarker'        => '/* testRequireOnceIsKeyword */',
                'expectedTokenType' => 'T_REQUIRE_ONCE',
            ],

            'list'                                    => [
                'testMarker'        => '/* testListIsKeyword */',
                'expectedTokenType' => 'T_LIST',
            ],
            'goto'                                    => [
                'testMarker'        => '/* testGotoIsKeyword */',
                'expectedTokenType' => 'T_GOTO',
            ],
            'match'                                   => [
                'testMarker'        => '/* testMatchIsKeyword */',
                'expectedTokenType' => 'T_MATCH',
            ],
            'default: in match expression'            => [
                'testMarker'        => '/* testMatchDefaultIsKeyword */',
                'expectedTokenType' => 'T_MATCH_DEFAULT',
            ],
            'fn'                                      => [
                'testMarker'        => '/* testFnIsKeyword */',
                'expectedTokenType' => 'T_FN',
            ],

            'yield'                                   => [
                'testMarker'        => '/* testYieldIsKeyword */',
                'expectedTokenType' => 'T_YIELD',
            ],
            'yield from'                              => [
                'testMarker'        => '/* testYieldFromIsKeyword */',
                'expectedTokenType' => 'T_YIELD_FROM',
            ],

            'declare'                                 => [
                'testMarker'        => '/* testDeclareIsKeyword */',
                'expectedTokenType' => 'T_DECLARE',
            ],
            'enddeclare'                              => [
                'testMarker'        => '/* testEndDeclareIsKeyword */',
                'expectedTokenType' => 'T_ENDDECLARE',
            ],

            'and: in if'                              => [
                'testMarker'        => '/* testAndIsKeyword */',
                'expectedTokenType' => 'T_LOGICAL_AND',
            ],
            'or: in if'                               => [
                'testMarker'        => '/* testOrIsKeyword */',
                'expectedTokenType' => 'T_LOGICAL_OR',
            ],
            'xor: in if'                              => [
                'testMarker'        => '/* testXorIsKeyword */',
                'expectedTokenType' => 'T_LOGICAL_XOR',
            ],

            'class: anon class declaration'           => [
                'testMarker'        => '/* testAnonymousClassIsKeyword */',
                'expectedTokenType' => 'T_ANON_CLASS',
            ],
            'extends: anon class declaration'         => [
                'testMarker'        => '/* testExtendsInAnonymousClassIsKeyword */',
                'expectedTokenType' => 'T_EXTENDS',
            ],
            'implements: anon class declaration'      => [
                'testMarker'        => '/* testImplementsInAnonymousClassIsKeyword */',
                'expectedTokenType' => 'T_IMPLEMENTS',
            ],
            'parent: class instantiation'             => [
                'testMarker'        => '/* testClassInstantiationParentIsKeyword */',
                'expectedTokenType' => 'T_PARENT',
            ],
            'self: class instantiation'               => [
                'testMarker'        => '/* testClassInstantiationSelfIsKeyword */',
                'expectedTokenType' => 'T_SELF',
            ],
            'static: class instantiation'             => [
                'testMarker'        => '/* testClassInstantiationStaticIsKeyword */',
                'expectedTokenType' => 'T_STATIC',
            ],
            'namespace: operator'                     => [
                'testMarker'        => '/* testNamespaceInNameIsKeyword */',
                'expectedTokenType' => 'T_NAMESPACE',
            ],

            'static: closure declaration'             => [
                'testMarker'        => '/* testStaticIsKeywordBeforeClosure */',
                'expectedTokenType' => 'T_STATIC',
            ],
            'static: parameter type (illegal)'        => [
                'testMarker'        => '/* testStaticIsKeywordWhenParamType */',
                'expectedTokenType' => 'T_STATIC',
            ],
            'static: arrow function declaration'      => [
                'testMarker'        => '/* testStaticIsKeywordBeforeArrow */',
                'expectedTokenType' => 'T_STATIC',
            ],
            'static: return type for arrow function'  => [
                'testMarker'        => '/* testStaticIsKeywordWhenReturnType */',
                'expectedTokenType' => 'T_STATIC',
            ],

            'false: param type declaration'           => [
                'testMarker'        => '/* testFalseIsKeywordAsParamType */',
                'expectedTokenType' => 'T_FALSE',
            ],
            'true: param type declaration'            => [
                'testMarker'        => '/* testTrueIsKeywordAsParamType */',
                'expectedTokenType' => 'T_TRUE',
            ],
            'null: param type declaration'            => [
                'testMarker'        => '/* testNullIsKeywordAsParamType */',
                'expectedTokenType' => 'T_NULL',
            ],
            'false: return type declaration in union' => [
                'testMarker'        => '/* testFalseIsKeywordAsReturnType */',
                'expectedTokenType' => 'T_FALSE',
            ],
            'true: return type declaration in union'  => [
                'testMarker'        => '/* testTrueIsKeywordAsReturnType */',
                'expectedTokenType' => 'T_TRUE',
            ],
            'null: return type declaration in union'  => [
                'testMarker'        => '/* testNullIsKeywordAsReturnType */',
                'expectedTokenType' => 'T_NULL',
            ],
            'false: in comparison'                    => [
                'testMarker'        => '/* testFalseIsKeywordInComparison */',
                'expectedTokenType' => 'T_FALSE',
            ],
            'true: in comparison'                     => [
                'testMarker'        => '/* testTrueIsKeywordInComparison */',
                'expectedTokenType' => 'T_TRUE',
            ],
            'null: in comparison'                     => [
                'testMarker'        => '/* testNullIsKeywordInComparison */',
                'expectedTokenType' => 'T_NULL',
            ],
        ];

    }//end dataKeywords()


}//end class
