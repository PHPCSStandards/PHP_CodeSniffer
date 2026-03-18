<?php
/**
 * Tests the tokenization of identifier names.
 *
 * As of PHP 8, identifier names are tokenized differently, depending on them being
 * either fully qualified, partially qualified or relative to the current namespace.
 *
 * This test file safeguards that in PHPCS 4.x this new form of tokenization is correctly
 * backfilled and that the tokenization of these identifier names is the same in all
 * PHP versions based on how these names are tokenized in PHP 8.
 *
 * {@link https://wiki.php.net/rfc/namespaced_names_as_token}
 * {@link https://github.com/squizlabs/PHP_CodeSniffer/issues/3041}
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2020-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;

final class NamespacedNameSingleTokenTest extends AbstractTokenizerTestCase
{


    /**
     * Test that identifier names are tokenized the same across PHP versions, based on the PHP 8 tokenization.
     *
     * @param string                       $testMarker     The comment prefacing the test.
     * @param array<array<string, string>> $expectedTokens The tokenization expected.
     *
     * @dataProvider dataIdentifierTokenization
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testIdentifierTokenization($testMarker, $expectedTokens)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $identifier = $this->getTargetToken($testMarker, constant($expectedTokens[0]['type']));

        foreach ($expectedTokens as $tokenInfo) {
            $this->assertSame(
                constant($tokenInfo['type']),
                $tokens[$identifier]['code'],
                'Token tokenized as ' . $tokens[$identifier]['type'] . ', not ' . $tokenInfo['type'] . ' (code)'
            );
            $this->assertSame(
                $tokenInfo['type'],
                $tokens[$identifier]['type'],
                'Token tokenized as ' . $tokens[$identifier]['type'] . ', not ' . $tokenInfo['type'] . ' (type)'
            );
            $this->assertSame($tokenInfo['content'], $tokens[$identifier]['content']);

            ++$identifier;
        }
    }


    /**
     * Data provider.
     *
     * @see testIdentifierTokenization()
     *
     * @return array<string, array<string, string|array<array<string, string>>>>
     */
    public static function dataIdentifierTokenization()
    {
        return [
            'namespace declaration'                                                                       => [
                'testMarker'     => '/* testNamespaceDeclaration */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAMESPACE',
                        'content' => 'namespace',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'Package',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'namespace declaration, multi-level'                                                          => [
                'testMarker'     => '/* testNamespaceDeclarationWithLevels */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAMESPACE',
                        'content' => 'namespace',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Vendor\SubLevel\Domain',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'namespace declaration, uses reserved keywords in name'                                       => [
                'testMarker'     => '/* testNamespaceDeclarationWithReservedKeywords */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAMESPACE',
                        'content' => 'namespace',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'For\Include\Fn',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'import use statement, class'                                                                 => [
                'testMarker'     => '/* testUseStatement */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'ClassName',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'import use statement, class, multi-level'                                                    => [
                'testMarker'     => '/* testUseStatementWithLevels */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Vendor\Level\Domain',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'import use statement, function'                                                              => [
                'testMarker'     => '/* testFunctionUseStatement */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'function',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'function_name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'import use statement, function, multi-level'                                                 => [
                'testMarker'     => '/* testFunctionUseStatementWithLevels */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'function',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Vendor\Level\function_in_ns',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'import use statement, constant'                                                              => [
                'testMarker'     => '/* testConstantUseStatement */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'const',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'CONSTANT_NAME',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'import use statement, constant, multi-level'                                                 => [
                'testMarker'     => '/* testConstantUseStatementWithLevels */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'const',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Vendor\Level\OTHER_CONSTANT',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'import use statement, multi-statement, unqualified class'                                    => [
                'testMarker'     => '/* testMultiUseUnqualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'UnqualifiedClassName',
                    ],
                    [
                        'type'    => 'T_COMMA',
                        'content' => ',',
                    ],
                ],
            ],
            'import use statement, multi-statement, partially qualified class'                            => [
                'testMarker'     => '/* testMultiUsePartiallyQualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Sublevel\PartiallyClassName',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'group use statement, multi-level prefix, mix inside group'                                   => [
                'testMarker'     => '/* testGroupUseStatement */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Vendor\Level',
                    ],
                    [
                        'type'    => 'T_NS_SEPARATOR',
                        'content' => '\\',
                    ],
                    [
                        'type'    => 'T_OPEN_USE_GROUP',
                        'content' => '{',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'AnotherDomain',
                    ],
                    [
                        'type'    => 'T_COMMA',
                        'content' => ',',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'function',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'function_grouped',
                    ],
                    [
                        'type'    => 'T_COMMA',
                        'content' => ',',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'const',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'CONSTANT_GROUPED',
                    ],
                    [
                        'type'    => 'T_COMMA',
                        'content' => ',',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Sub\YetAnotherDomain',
                    ],
                    [
                        'type'    => 'T_COMMA',
                        'content' => ',',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'function',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'SubLevelA\function_grouped_too',
                    ],
                    [
                        'type'    => 'T_COMMA',
                        'content' => ',',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'const',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'SubLevelB\CONSTANT_GROUPED_TOO',
                    ],
                    [
                        'type'    => 'T_COMMA',
                        'content' => ',',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_CLOSE_USE_GROUP',
                        'content' => '}',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'class declaration'                                                                           => [
                'testMarker'     => '/* testClassName */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'MyClass',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                ],
            ],
            'class declaration, extends fully qualified name'                                             => [
                'testMarker'     => '/* testExtendedFQN */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Vendor\Level\FQN',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                ],
            ],
            'class declaration, implements namespace relative name'                                       => [
                'testMarker'     => '/* testImplementsRelative */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_RELATIVE',
                        'content' => 'namespace\Name',
                    ],
                    [
                        'type'    => 'T_COMMA',
                        'content' => ',',
                    ],
                ],
            ],
            'class declaration, implements fully qualified name'                                          => [
                'testMarker'     => '/* testImplementsFQN */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Fully\Qualified',
                    ],
                    [
                        'type'    => 'T_COMMA',
                        'content' => ',',
                    ],
                ],
            ],
            'class declaration, implements unqualified name'                                              => [
                'testMarker'     => '/* testImplementsUnqualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'Unqualified',
                    ],
                    [
                        'type'    => 'T_COMMA',
                        'content' => ',',
                    ],
                ],
            ],
            'class declaration, implements partially qualified name (with reserved keyword)'              => [
                'testMarker'     => '/* testImplementsPartiallyQualifiedWithReservedKeyword */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Exit\Level\Name',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                ],
            ],
            'method declaration'                                                                          => [
                'testMarker'     => '/* testFunctionName */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'function_name',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
            'param type declaration, namespace relative name'                                             => [
                'testMarker'     => '/* testTypeDeclarationRelative */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_RELATIVE',
                        'content' => 'namespace\Name',
                    ],
                    [
                        'type'    => 'T_TYPE_UNION',
                        'content' => '|',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'object',
                    ],
                ],
            ],
            'param type declaration, fully qualified name'                                                => [
                'testMarker'     => '/* testTypeDeclarationFQN */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Fully\Qualified\Name',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'param type declaration, unqualified name'                                                    => [
                'testMarker'     => '/* testTypeDeclarationUnqualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'Unqualified',
                    ],
                    [
                        'type'    => 'T_TYPE_UNION',
                        'content' => '|',
                    ],
                    [
                        'type'    => 'T_FALSE',
                        'content' => 'false',
                    ],
                ],
            ],
            'param type declaration, partially qualified name'                                            => [
                'testMarker'     => '/* testTypeDeclarationPartiallyQualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NULLABLE',
                        'content' => '?',
                    ],
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Sublevel\Name',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'return type declaration, fully qualified name'                                               => [
                'testMarker'     => '/* testReturnTypeFQN */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NULLABLE',
                        'content' => '?',
                    ],
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Name',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'function call, namespace relative name'                                                      => [
                'testMarker'     => '/* testFunctionCallRelative */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_RELATIVE',
                        'content' => 'NameSpace\function_name',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
            'function call, fully qualified name (with reserved keyword)'                                 => [
                'testMarker'     => '/* testFunctionCallFQNWithReservedKeyword */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Vendor\Foreach\function_name',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
            'function call, unqualified name'                                                             => [
                'testMarker'     => '/* testFunctionCallUnqualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'function_name',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
            'function call, partially qualified name'                                                     => [
                'testMarker'     => '/* testFunctionCallPartiallyQualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Level\function_name',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
            'catch, namespace relative name'                                                              => [
                'testMarker'     => '/* testCatchRelative */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_RELATIVE',
                        'content' => 'namespace\SubLevel\Exception',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'catch, fully qualified name'                                                                 => [
                'testMarker'     => '/* testCatchFQN */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Exception',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'catch, unqualified name'                                                                     => [
                'testMarker'     => '/* testCatchUnqualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'Exception',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'catch, partially qualified name'                                                             => [
                'testMarker'     => '/* testCatchPartiallyQualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Level\Exception',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'class instantiation, namespace relative name'                                                => [
                'testMarker'     => '/* testNewRelative */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_RELATIVE',
                        'content' => 'namespace\ClassName',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
            'class instantiation, fully qualified name'                                                   => [
                'testMarker'     => '/* testNewFQN */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Vendor\ClassName',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
            'class instantiation, unqualified name'                                                       => [
                'testMarker'     => '/* testNewUnqualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'ClassName',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'class instantiation, partially qualified name'                                               => [
                'testMarker'     => '/* testNewPartiallyQualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Level\ClassName',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'double colon class access, namespace relative name'                                          => [
                'testMarker'     => '/* testDoubleColonRelative */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_RELATIVE',
                        'content' => 'namespace\ClassName',
                    ],
                    [
                        'type'    => 'T_DOUBLE_COLON',
                        'content' => '::',
                    ],
                ],
            ],
            'double colon class access, fully qualified name'                                             => [
                'testMarker'     => '/* testDoubleColonFQN */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\ClassName',
                    ],
                    [
                        'type'    => 'T_DOUBLE_COLON',
                        'content' => '::',
                    ],
                ],
            ],
            'double colon class access, unqualified name'                                                 => [
                'testMarker'     => '/* testDoubleColonUnqualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'ClassName',
                    ],
                    [
                        'type'    => 'T_DOUBLE_COLON',
                        'content' => '::',
                    ],
                ],
            ],
            'double colon class access, partially qualified name'                                         => [
                'testMarker'     => '/* testDoubleColonPartiallyQualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Level\ClassName',
                    ],
                    [
                        'type'    => 'T_DOUBLE_COLON',
                        'content' => '::',
                    ],
                ],
            ],
            'instanceof, namespace relative name'                                                         => [
                'testMarker'     => '/* testInstanceOfRelative */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_RELATIVE',
                        'content' => 'namespace\ClassName',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'instanceof, fully qualified name'                                                            => [
                'testMarker'     => '/* testInstanceOfFQN */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Full\ClassName',
                    ],
                    [
                        'type'    => 'T_CLOSE_PARENTHESIS',
                        'content' => ')',
                    ],
                ],
            ],
            'instanceof, unqualified name'                                                                => [
                'testMarker'     => '/* testInstanceOfUnqualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_STRING',
                        'content' => 'ClassName',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'instanceof, partially qualified name'                                                        => [
                'testMarker'     => '/* testInstanceOfPartiallyQualified */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Partially\ClassName',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'exit in partially qualified name (start)'                                                    => [
                'testMarker'     => '/* testExitInNamespacedNameStart */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Exit\Name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'exit in fully qualified name (middle)'                                                       => [
                'testMarker'     => '/* testExitInNamespacedNameMiddle */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Not\exit\Name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'exit in fully qualified name (end)'                                                          => [
                'testMarker'     => '/* testExitInNamespacedNameEnd */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Not\Exit',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'PHP 8.4 exit as function call, fully qualified'                                              => [
                'testMarker'     => '/* testFullyQualifiedExitFunctionCall */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_EXIT',
                        'content' => '\\Exit',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
            'exit as constant, fully qualified (illegal)'                                                 => [
                'testMarker'     => '/* testFullyQualifiedExitConstant */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_EXIT',
                        'content' => '\\exit',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'die in partially qualified name (start)'                                                     => [
                'testMarker'     => '/* testDieInNamespacedNameStart */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Die\Name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'die in fully qualified name (middle)'                                                        => [
                'testMarker'     => '/* testDieInNamespacedNameMiddle */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Not\die\Name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'die in fully qualified name (end)'                                                           => [
                'testMarker'     => '/* testDieInNamespacedNameEnd */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Not\DIE',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'PHP 8.4 die as function call, fully qualified'                                               => [
                'testMarker'     => '/* testFullyQualifiedDieFunctionCall */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_EXIT',
                        'content' => '\\die',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
            'die as constant, fully qualified (illegal)'                                                  => [
                'testMarker'     => '/* testFullyQualifiedDieConstant */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_EXIT',
                        'content' => '\\DIE',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'false in partially qualified name (start)'                                                   => [
                'testMarker'     => '/* testFalseInNamespacedNameStart */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'False\Name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'false in fully qualified name (middle)'                                                      => [
                'testMarker'     => '/* testFalseInNamespacedNameMiddle */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Not\false\Name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'false in fully qualified name (end)'                                                         => [
                'testMarker'     => '/* testFalseInNamespacedNameEnd */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Not\FALSE',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'false, fully qualified'                                                                      => [
                'testMarker'     => '/* testFullyQualifiedFalse */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_FALSE',
                        'content' => '\\false',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'true in partially qualified name (start)'                                                    => [
                'testMarker'     => '/* testTrueInNamespacedNameStart */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\True\Name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'true in fully qualified name (middle)'                                                       => [
                'testMarker'     => '/* testTrueInNamespacedNameMiddle */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Not\true\Name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'true in fully qualified name (end)'                                                          => [
                'testMarker'     => '/* testTrueInNamespacedNameEnd */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Not\True',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'true, fully qualified'                                                                       => [
                'testMarker'     => '/* testFullyQualifiedTrue */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_TRUE',
                        'content' => '\\TRUE',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'null in partially qualified name (start)'                                                    => [
                'testMarker'     => '/* testNullInNamespacedNameStart */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_QUALIFIED',
                        'content' => 'Null\Name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'null in fully qualified name (middle)'                                                       => [
                'testMarker'     => '/* testNullInNamespacedNameMiddle */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Not\Null\Name',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'null in fully qualified name (end)'                                                          => [
                'testMarker'     => '/* testNullInNamespacedNameEnd */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Not\null',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],
            'null, fully qualified'                                                                       => [
                'testMarker'     => '/* testFullyQualifiedNull */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NULL',
                        'content' => '\\Null',
                    ],
                    [
                        'type'    => 'T_SEMICOLON',
                        'content' => ';',
                    ],
                ],
            ],

            'function call, namespace relative, with whitespace (invalid in PHP 8)'                       => [
                'testMarker'     => '/* testInvalidInPHP8Whitespace */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAMESPACE',
                        'content' => 'namespace',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_NS_SEPARATOR',
                        'content' => '\\',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'Sublevel',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '          ',
                    ],
                    [
                        'type'    => 'T_NS_SEPARATOR',
                        'content' => '\\',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'function_name',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
            'double colon class access, fully qualified, with whitespace and comments (invalid in PHP 8)' => [
                'testMarker'     => '/* testInvalidInPHP8Comments */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Fully',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_PHPCS_IGNORE',
                        'content' => '// phpcs:ignore Stnd.Cat.Sniff -- for reasons
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Qualified',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_COMMENT',
                        'content' => '/* comment */',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\Name',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                ],
            ],
            'invalid name, double backslash'                                                              => [
                'testMarker'     => '/* testInvalidDoubleBackslash */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_NS_SEPARATOR',
                        'content' => '\\',
                    ],
                    [
                        'type'    => 'T_NAME_FULLY_QUALIFIED',
                        'content' => '\SomeClass',
                    ],
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                ],
            ],
        ];
    }
}
