<?php
/**
 * Tests the tokenization of typecast tokens.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Tests the tokenization of typecast tokens.
 *
 * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
 */
final class TypecastsTest extends AbstractTokenizerTestCase
{


    /**
     * Test that something between parentheses which may _look_ like a type cast, but isn't, tokenizes correctly.
     *
     * @param string                       $testMarker     The comment which prefaces the target tokens in the test file.
     * @param array<array<string, string>> $expectedTokens The tokenization expected.
     *
     * @dataProvider dataNotATypeCast
     *
     * @return void
     */
    public function testNotATypeCast($testMarker, $expectedTokens)
    {
        $tokens = $this->phpcsFile->getTokens();
        $target = $this->getTargetToken($testMarker, [T_OPEN_PARENTHESIS]);

        foreach ($expectedTokens as $nr => $tokenInfo) {
            $this->assertSame(
                constant($tokenInfo['type']),
                $tokens[$target]['code'],
                'Token tokenized as ' . Tokens::tokenName($tokens[$target]['code']) . ', not ' . $tokenInfo['type'] . ' (code)'
            );
            $this->assertSame(
                $tokenInfo['type'],
                $tokens[$target]['type'],
                'Token tokenized as ' . $tokens[$target]['type'] . ', not ' . $tokenInfo['type'] . ' (type)'
            );
            $this->assertSame(
                $tokenInfo['content'],
                $tokens[$target]['content'],
                'Content of token ' . ($nr + 1) . ' (' . $tokens[$target]['type'] . ') does not match expectations'
            );

            ++$target;
        }
    }


    /**
     * Data provider.
     *
     * @see testNotATypeCast()
     *
     * @return array<string, array<string, string|array<array<string, string>>>>
     */
    public static function dataNotATypeCast()
    {
        return [
            'constant within parentheses'                            => [
                'testMarker'     => '/* testNotATypeCast1 */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'NOT_A_TYPECAST',
                    ],
                    [
                        'type'    => 'T_CLOSE_PARENTHESIS',
                        'content' => ')',
                    ],
                ],
            ],
            'Invalid type cast void - new lines are not allowed [1]' => [
                'testMarker'     => '/* testNotATypeCast2 */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'void',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_CLOSE_PARENTHESIS',
                        'content' => ')',
                    ],
                ],
            ],
            'Invalid type cast void - new lines are not allowed [2]' => [
                'testMarker'     => '/* testNotATypeCast3 */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
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
                        'content' => 'void',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                    [
                        'type'    => 'T_CLOSE_PARENTHESIS',
                        'content' => ')',
                    ],
                ],
            ],
            'Invalid type cast void - comments are not allowed'      => [
                'testMarker'     => '/* testNotATypeCast4 */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_COMMENT',
                        'content' => '/*comment*/',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'void',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_COMMENT',
                        'content' => '/*comment */',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_CLOSE_PARENTHESIS',
                        'content' => ')',
                    ],
                ],
            ],
            'Live coding/parse error'                                => [
                'testMarker'     => '/* testNotATypeCast5 */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_OPEN_PARENTHESIS',
                        'content' => '(',
                    ],
                    [
                        'type'    => 'T_STRING',
                        'content' => 'void',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => "\n",
                    ],
                ],
            ],
        ];
    }


    /**
     * Test that valid type casts are tokenized as such.
     *
     * @param string $testMarker      The comment which prefaces the target token in the test file.
     * @param string $expectedType    Expected token type.
     * @param string $expectedContent Expected token content.
     *
     * @dataProvider dataTypeCast
     *
     * @return void
     */
    public function testTypeCast($testMarker, $expectedType, $expectedContent)
    {
        $tokens       = $this->phpcsFile->getTokens();
        $expectedCode = constant($expectedType);
        $target       = $this->getTargetToken($testMarker, $expectedCode);
        $tokenArray   = $tokens[$target];

        $this->assertSame($expectedCode, $tokenArray['code'], "Token tokenized as {$tokenArray['type']}, not $expectedType (code)");
        $this->assertSame($expectedType, $tokenArray['type'], "Token tokenized as {$tokenArray['type']}, not $expectedType (type)");

        if (isset($tokenArray['orig_content']) === true) {
            $this->assertSame($expectedContent, $tokenArray['orig_content'], 'Token (orig) content does not match expectation');
        } else {
            $this->assertSame($expectedContent, $tokenArray['content'], 'Token content does not match expectation');
        }

        // Make sure there are no stray tokens.
        // This assertion requires all type casts tested via this test to be followed whitespace + a variable.
        $this->assertSame(T_WHITESPACE, $tokens[($target + 1)]['code'], 'Stray tokens detected');
        $this->assertSame(T_VARIABLE, $tokens[($target + 2)]['code'], 'Stray tokens detected');
    }


    /**
     * Data provider.
     *
     * @see testTypeCast()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataTypeCast()
    {
        return [
            '(bool)'                => [
                'testMarker'      => '/* testBool */',
                'expectedType'    => 'T_BOOL_CAST',
                'expectedContent' => '(bool)',
            ],
            '( BOOL )'              => [
                'testMarker'      => '/* testSpacyUppercaseBool */',
                'expectedType'    => 'T_BOOL_CAST',
                'expectedContent' => '( BOOL)',
            ],
            '(boolean)'             => [
                'testMarker'      => '/* testBoolean */',
                'expectedType'    => 'T_BOOL_CAST',
                'expectedContent' => '(boolean)',
            ],
            '( BOOLEAN )'           => [
                'testMarker'      => '/* testSpacyUppercaseBoolean */',
                'expectedType'    => 'T_BOOL_CAST',
                'expectedContent' => '( BOOLEAN )',
            ],
            '(int)'                 => [
                'testMarker'      => '/* testInt */',
                'expectedType'    => 'T_INT_CAST',
                'expectedContent' => '(int)',
            ],
            '( INT )'               => [
                'testMarker'      => '/* testSpacyUppercaseInt */',
                'expectedType'    => 'T_INT_CAST',
                'expectedContent' => '( INT )',
            ],
            '(integer)'             => [
                'testMarker'      => '/* testInteger */',
                'expectedType'    => 'T_INT_CAST',
                'expectedContent' => '(integer)',
            ],
            '(   INTEGER )'         => [
                'testMarker'      => '/* testSpacyUppercaseInteger */',
                'expectedType'    => 'T_INT_CAST',
                'expectedContent' => '(   INTEGER )',
            ],
            '(float)'               => [
                'testMarker'      => '/* testFloat */',
                'expectedType'    => 'T_DOUBLE_CAST',
                'expectedContent' => '(float)',
            ],
            '( FLOAT )'             => [
                'testMarker'      => '/* testSpacyUppercaseFloat */',
                'expectedType'    => 'T_DOUBLE_CAST',
                'expectedContent' => '( FLOAT )',
            ],
            '(real)'                => [
                'testMarker'      => '/* testReal */',
                'expectedType'    => 'T_DOUBLE_CAST',
                'expectedContent' => '(real)',
            ],
            '( REAL )'              => [
                'testMarker'      => '/* testSpacyUppercaseReal */',
                'expectedType'    => 'T_DOUBLE_CAST',
                'expectedContent' => '( REAL )',
            ],
            '(double)'              => [
                'testMarker'      => '/* testDouble */',
                'expectedType'    => 'T_DOUBLE_CAST',
                'expectedContent' => '(double)',
            ],
            '( DOUBLE   )'          => [
                'testMarker'      => '/* testSpacyUppercaseDouble */',
                'expectedType'    => 'T_DOUBLE_CAST',
                'expectedContent' => '( DOUBLE   )',
            ],
            '(string)'              => [
                'testMarker'      => '/* testString */',
                'expectedType'    => 'T_STRING_CAST',
                'expectedContent' => '(string)',
            ],
            '( STRING )'            => [
                'testMarker'      => '/* testSpacyUppercaseString */',
                'expectedType'    => 'T_STRING_CAST',
                'expectedContent' => '(STRING )',
            ],
            '(binary)'              => [
                'testMarker'      => '/* testBinary */',
                'expectedType'    => 'T_BINARY_CAST',
                'expectedContent' => '(binary)',
            ],
            '( BINARY )'            => [
                'testMarker'      => '/* testSpacyUppercaseBinary */',
                'expectedType'    => 'T_BINARY_CAST',
                'expectedContent' => '( BINARY )',
            ],
            '(array)'               => [
                'testMarker'      => '/* testArray */',
                'expectedType'    => 'T_ARRAY_CAST',
                'expectedContent' => '(array)',
            ],
            '(   ARRAY   )'         => [
                'testMarker'      => '/* testSpacyUppercaseArray */',
                'expectedType'    => 'T_ARRAY_CAST',
                'expectedContent' => '(   ARRAY   )',
            ],
            '(object)'              => [
                'testMarker'      => '/* testObject */',
                'expectedType'    => 'T_OBJECT_CAST',
                'expectedContent' => '(object)',
            ],
            '( OBJECT )'            => [
                'testMarker'      => '/* testSpacyUppercaseObject */',
                'expectedType'    => 'T_OBJECT_CAST',
                'expectedContent' => '( OBJECT )',
            ],
            '(unset)'               => [
                'testMarker'      => '/* testUnset */',
                'expectedType'    => 'T_UNSET_CAST',
                'expectedContent' => '(unset)',
            ],
            '( UNSET )'             => [
                'testMarker'      => '/* testSpacyUppercaseUnset */',
                'expectedType'    => 'T_UNSET_CAST',
                'expectedContent' => '( UNSET )',
            ],

            // PHP 8.5: new (void) cast.
            '(void)'                => [
                'testMarker'      => '/* testVoid */',
                'expectedType'    => 'T_VOID_CAST',
                'expectedContent' => '(void)',
            ],
            'Nested (void)'         => [
                'testMarker'      => '/* testVoidNested */',
                'expectedType'    => 'T_VOID_CAST',
                'expectedContent' => '(void)',
            ],
            '(   void   ) (spaces)' => [
                'testMarker'      => '/* testSpacyVoid */',
                'expectedType'    => 'T_VOID_CAST',
                'expectedContent' => '(   void   )',
            ],
            '(\tvoid\t) (tabs)'     => [
                'testMarker'      => '/* testTabbyVoid */',
                'expectedType'    => 'T_VOID_CAST',
                'expectedContent' => "(\tvoid\t)",
            ],
            '(VOID)'                => [
                'testMarker'      => '/* testUppercaseVoid */',
                'expectedType'    => 'T_VOID_CAST',
                'expectedContent' => '(VOID)',
            ],
        ];
    }
}
