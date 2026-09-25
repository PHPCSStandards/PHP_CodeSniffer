<?php
/**
 * Tests the tokenization of BinaryPrefixTypecast tokens.
 *
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Tests the tokenization of the `b` prefix for text string tokens.
 *
 * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
 */
final class BinaryPrefixTypecastTest extends AbstractTokenizerTestCase
{


    /**
     * Verify the retokenization leaves text strings without the b prefix alone.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataNotBPrefix
     *
     * @return void
     */
    public function testNotBPrefix($testMarker)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, (Tokens::STRING_TOKENS + [T_BINARY_CAST]));
        $tokenArray = $tokens[$target];

        $this->assertNotSame(T_BINARY_CAST, $tokenArray['code'], 'Token tokenized as T_BINARY_CAST (code)');
        $this->assertNotSame('T_BINARY_CAST', $tokenArray['type'], 'Token tokenized as T_BINARY_CAST (type)');

        // Make sure the next token is a semi-colon to ensure the whole text string was captured.
        $this->assertSame('T_SEMICOLON', $tokens[($target + 1)]['type'], 'Next token is not a semi-colon');
    }


    /**
     * Data provider.
     *
     * @see testNotBPrefix()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataNotBPrefix()
    {
        return [
            'ordinary text string in single quotes'                    => [
                'testMarker' => '/* testNotBinaryStringCastSingleQuotes */',
            ],
            'ordinary text string in double quotes'                    => [
                'testMarker' => '/* testNotBinaryStringCastDoubleQuotes */',
            ],
            'ordinary text string in double quotes with interpolation' => [
                'testMarker' => '/* testNotBinaryStringCastDoubleQuotes */',
            ],
        ];
    }


    /**
     * Test that the b-prefix binary type cast is tokenized correctly in all supported cases.
     *
     * @param string $testMarker      The comment which prefaces the target token in the test file.
     * @param string $expectedContent Expected token content.
     * @param string $nextType        Expected token type for the text string token following the prefix.
     *
     * @dataProvider dataBPrefixTypeCast
     *
     * @return void
     */
    public function testBPrefixTypeCast($testMarker, $expectedContent = 'b', $nextType = 'T_CONSTANT_ENCAPSED_STRING')
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, T_BINARY_CAST);
        $tokenArray = $tokens[$target];

        $this->assertSame('T_BINARY_CAST', $tokenArray['type'], "Token tokenized as {$tokenArray['type']}, expected T_BINARY_CAST (type)");
        $this->assertSame($expectedContent, $tokenArray['content'], 'Token content does not match expectation');

        // Make sure the next token is still tokenized as a text string.
        $this->assertSame($nextType, $tokens[($target + 1)]['type'], 'Next token is not a text string');
    }


    /**
     * Data provider.
     *
     * @see testBPrefixTypeCast()
     *
     * @return array<string, array<string, string|int>>
     */
    public static function dataBPrefixTypeCast()
    {
        return [
            'b-prefix lowercase, text string in single quotes'                    => [
                'testMarker' => '/* testBinaryStringCastLowercaseSingleQuotes */',
            ],
            'b-prefix lowercase, text string in double quotes'                    => [
                'testMarker' => '/* testBinaryStringCastLowercaseDoubleQuotes */',
            ],
            'b-prefix lowercase, text string in double quotes with interpolation' => [
                'testMarker'      => '/* testBinaryStringCastLowercaseDoubleQuotesWithInterpolation */',
                'expectedContent' => 'b',
                'nextType'        => 'T_DOUBLE_QUOTED_STRING',
            ],
            'b-prefix uppercase, text string in single quotes'                    => [
                'testMarker'      => '/* testBinaryStringCastUppercaseSingleQuotes */',
                'expectedContent' => 'B',
            ],
            'b-prefix uppercase, text string in double quotes'                    => [
                'testMarker'      => '/* testBinaryStringCastUppercaseDoubleQuotes */',
                'expectedContent' => 'B',
            ],
            'b-prefix uppercase, text string in double quotes with interpolation' => [
                'testMarker'      => '/* testBinaryStringCastUppercaseDoubleQuotesWithInterpolation */',
                'expectedContent' => 'B',
                'nextType'        => 'T_DOUBLE_QUOTED_STRING',
            ],
        ];
    }


    /**
     * Verify the retokenization leaves a plain constant "b" before a text string alone (parse error, but not our concern).
     *
     * @return void
     */
    public function testWhiteSpaceNotAllowedBetweenBPrefixAndText()
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken(
            '/* testNotBinaryStringCastWithWhitespace */',
            (Tokens::STRING_TOKENS + [T_BINARY_CAST, T_STRING]),
            'b'
        );
        $tokenArray = $tokens[$target];

        $this->assertSame(T_STRING, $tokenArray['code'], 'Token tokenized as T_BINARY_CAST (code)');
        $this->assertSame('T_STRING', $tokenArray['type'], 'Token tokenized as T_BINARY_CAST (type)');

        // Make sure the next tokens have not been affected either.
        $this->assertSame('T_WHITESPACE', $tokens[($target + 1)]['type'], 'Next token is not a whitespace');
        $this->assertSame('T_CONSTANT_ENCAPSED_STRING', $tokens[($target + 2)]['type'], 'Next token is not a text string');
        $this->assertSame('T_SEMICOLON', $tokens[($target + 3)]['type'], 'Next token is not a semicolon');
    }
}
