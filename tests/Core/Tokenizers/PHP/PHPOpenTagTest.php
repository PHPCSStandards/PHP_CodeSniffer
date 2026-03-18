<?php
/**
 * Tests the tokenization of PHP open tags.
 *
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Tests the tokenization of PHP open tags.
 *
 * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
 */
final class PHPOpenTagTest extends AbstractTokenizerTestCase
{


    /**
     * Test that the tokenization of long PHP open tags does not include whitespace.
     *
     * @param string                           $testMarker     The comment prefacing the test.
     * @param array<array<string, string|int>> $expectedTokens The tokenization expected.
     *
     * @dataProvider dataLongOpenTag
     *
     * @return void
     */
    public function testLongOpenTag($testMarker, array $expectedTokens)
    {
        $this->checkTokenSequence($testMarker, $expectedTokens);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|array<array<string, string|int>>>>
     */
    public static function dataLongOpenTag()
    {
        $tokenType    = 'T_OPEN_TAG';
        $tokenContent = '<?php';
        $data         = self::getOpenTagTokenizationProvider('LongOpen', $tokenType, $tokenContent);

        // Remove the "no space" case as that's a parse error with long open tags.
        unset($data['open tag, no space']);

        // Add extra tests to verify the "join or don't join" whitespace logic is correct.
        $data['open tag + double new line'] = [
            'testMarker'     => '/* testLongOpenTagWithDoubleNewLine */',
            'expectedTokens' => [
                [
                    'type'       => $tokenType,
                    'content'    => $tokenContent,
                    'lineOffset' => 0,
                ],
                [
                    'type'       => 'T_WHITESPACE',
                    'content'    => "\n",
                    'lineOffset' => 0,
                ],
                [
                    'type'       => 'T_WHITESPACE',
                    'content'    => "\n",
                    'lineOffset' => 1,
                ],
                [
                    'type'       => 'T_ECHO',
                    'lineOffset' => 2,
                ],
            ],
        ];
        $data['open tag + triple new line'] = [
            'testMarker'     => '/* testLongOpenTagWithTripleNewLine */',
            'expectedTokens' => [
                [
                    'type'       => $tokenType,
                    'content'    => $tokenContent,
                    'lineOffset' => 0,
                ],
                [
                    'type'       => 'T_WHITESPACE',
                    'content'    => "\n",
                    'lineOffset' => 0,
                ],
                [
                    'type'       => 'T_WHITESPACE',
                    'content'    => "\n",
                    'lineOffset' => 1,
                ],
                [
                    'type'       => 'T_WHITESPACE',
                    'content'    => "\n",
                    'lineOffset' => 2,
                ],
                [
                    'type'       => 'T_ECHO',
                    'lineOffset' => 3,
                ],
            ],
        ];
        $data['open tag + new line + indent on next line'] = [
            'testMarker'     => '/* testLongOpenTagWithNewLineAndIndentOnNextLine */',
            'expectedTokens' => [
                [
                    'type'       => $tokenType,
                    'content'    => $tokenContent,
                    'lineOffset' => 0,
                ],
                [
                    'type'       => 'T_WHITESPACE',
                    'content'    => "\n",
                    'lineOffset' => 0,
                ],
                [
                    'type'       => 'T_WHITESPACE',
                    'content'    => '    ',
                    'lineOffset' => 1,
                ],
                [
                    'type'       => 'T_ECHO',
                    'lineOffset' => 1,
                ],
            ],
        ];

        return $data;
    }


    /**
     * Test that the tokenization of non-lowercase long PHP open tags does not include whitespace
     * and that the case of the tag is unchanged.
     *
     * @param string                           $testMarker     The comment prefacing the test.
     * @param array<array<string, string|int>> $expectedTokens The tokenization expected.
     *
     * @dataProvider dataCaseLongOpenTag
     *
     * @return void
     */
    public function testCaseLongOpenTag($testMarker, array $expectedTokens)
    {
        $this->checkTokenSequence($testMarker, $expectedTokens);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|array<array<string, string|int>>>>
     */
    public static function dataCaseLongOpenTag()
    {
        $data = self::getOpenTagTokenizationProvider('CaseLongOpen', 'T_OPEN_TAG', '<?php');

        // Remove the "no space" case as that's a parse error with long open tags.
        unset($data['open tag, no space']);

        // Update the expectations for the casing of the open tag.
        $data['open tag + new line']['expectedTokens'][0]['content'] = '<?PHP';
        $data['open tag + one space + new line']['expectedTokens'][0]['content']           = '<?phP';
        $data['open tag + trailing whitespace + new line']['expectedTokens'][0]['content'] = '<?Php';
        $data['open tag, one space']['expectedTokens'][0]['content']   = '<?pHp';
        $data['open tag, multi space']['expectedTokens'][0]['content'] = '<?phP';

        return $data;
    }


    /**
     * Test the tokenization of short PHP open echo tags (for consistency).
     *
     * @param string                           $testMarker     The comment prefacing the test.
     * @param array<array<string, string|int>> $expectedTokens The tokenization expected.
     *
     * @dataProvider dataShortOpenEchoTag
     *
     * @return void
     */
    public function testShortOpenEchoTag($testMarker, array $expectedTokens)
    {
        $this->checkTokenSequence($testMarker, $expectedTokens);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|array<array<string, string|int>>>>
     */
    public static function dataShortOpenEchoTag()
    {
        return self::getOpenTagTokenizationProvider('ShortOpenEcho', 'T_OPEN_TAG_WITH_ECHO', '<?=');
    }


    /**
     * Test the tokenization of short PHP open tags (for consistency).
     *
     * @param string                           $testMarker     The comment prefacing the test.
     * @param array<array<string, string|int>> $expectedTokens The tokenization expected.
     *
     * @dataProvider dataShortOpenTag
     *
     * @return void
     */
    public function testShortOpenTag($testMarker, array $expectedTokens)
    {
        if ((bool) ini_get('short_open_tag') === false) {
            $this->markTestSkipped('short_open_tag=on is required for this test');
        }

        $this->checkTokenSequence($testMarker, $expectedTokens);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|array<array<string, string|int>>>>
     */
    public static function dataShortOpenTag()
    {
        return self::getOpenTagTokenizationProvider('ShortOpen', 'T_OPEN_TAG', '<?');
    }


    /**
     * Test helper. Check a token sequence complies with an expected token sequence.
     *
     * @param string                           $testMarker     The comment prefacing the test.
     * @param array<array<string, string|int>> $expectedTokens The tokenization expected.
     *
     * @return void
     */
    private function checkTokenSequence($testMarker, array $expectedTokens)
    {
        $tokens   = $this->phpcsFile->getTokens();
        $target   = $this->getTargetToken($testMarker, [T_OPEN_TAG, T_OPEN_TAG_WITH_ECHO]);
        $stackPtr = $target;

        foreach ($expectedTokens as $tokenInfo) {
            $this->assertSame(
                constant($tokenInfo['type']),
                $tokens[$stackPtr]['code'],
                'Token tokenized as ' . Tokens::tokenName($tokens[$stackPtr]['code']) . ', not ' . $tokenInfo['type'] . ' (code)'
            );
            $this->assertSame(
                $tokenInfo['type'],
                $tokens[$stackPtr]['type'],
                'Token tokenized as ' . $tokens[$stackPtr]['type'] . ', not ' . $tokenInfo['type'] . ' (type)'
            );

            if (isset($tokenInfo['content']) === true) {
                $this->assertSame(
                    $tokenInfo['content'],
                    $tokens[$stackPtr]['content'],
                    'Token content does not match expected content'
                );
            }

            $this->assertSame(
                ($tokens[$target]['line'] + $tokenInfo['lineOffset']),
                $tokens[$stackPtr]['line'],
                'Line number does not match expected line number'
            );

            ++$stackPtr;
        }
    }


    /**
     * Data provider generator.
     *
     * @param string $tagtype      The type of tag being examined.
     * @param string $tokenType    The expected token type.
     * @param string $tokenContent The expected token contents.
     *
     * @return array<string, array<string, string|array<array<string, string|int>>>>
     */
    private static function getOpenTagTokenizationProvider($tagtype, $tokenType, $tokenContent)
    {
        $lastTokenType = 'T_ECHO';
        if ($tagtype === 'ShortOpenEcho') {
            $lastTokenType = 'T_CONSTANT_ENCAPSED_STRING';
        }

        return [
            'open tag + new line'                       => [
                'testMarker'     => '/* test' . $tagtype . 'TagWithNewLine */',
                'expectedTokens' => [
                    [
                        'type'       => $tokenType,
                        'content'    => $tokenContent,
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => 'T_WHITESPACE',
                        'content'    => "\n",
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => $lastTokenType,
                        'lineOffset' => 1,
                    ],
                ],
            ],
            'open tag + one space + new line'           => [
                'testMarker'     => '/* test' . $tagtype . 'TagWithOneSpaceAndNewLine */',
                'expectedTokens' => [
                    [
                        'type'       => $tokenType,
                        'content'    => $tokenContent,
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => 'T_WHITESPACE',
                        'content'    => ' ' . "\n",
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => $lastTokenType,
                        'lineOffset' => 1,
                    ],
                ],
            ],
            'open tag + trailing whitespace + new line' => [
                'testMarker'     => '/* test' . $tagtype . 'TagWithTrailingWhiteSpaceAndNewLine */',
                'expectedTokens' => [
                    [
                        'type'       => $tokenType,
                        'content'    => $tokenContent,
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => 'T_WHITESPACE',
                        'content'    => '    ' . "\n",
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => $lastTokenType,
                        'lineOffset' => 1,
                    ],
                ],
            ],
            'open tag, no space'                        => [
                'testMarker'     => '/* test' . $tagtype . 'TagNoSpace */',
                'expectedTokens' => [
                    [
                        'type'       => $tokenType,
                        'content'    => $tokenContent,
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => $lastTokenType,
                        'lineOffset' => 0,
                    ],
                ],
            ],
            'open tag, one space'                       => [
                'testMarker'     => '/* test' . $tagtype . 'TagOneSpace */',
                'expectedTokens' => [
                    [
                        'type'       => $tokenType,
                        'content'    => $tokenContent,
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => 'T_WHITESPACE',
                        'content'    => ' ',
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => $lastTokenType,
                        'lineOffset' => 0,
                    ],
                ],
            ],
            'open tag, multi space'                     => [
                'testMarker'     => '/* test' . $tagtype . 'TagMultiSpace */',
                'expectedTokens' => [
                    [
                        'type'       => $tokenType,
                        'content'    => $tokenContent,
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => 'T_WHITESPACE',
                        'content'    => '      ',
                        'lineOffset' => 0,
                    ],
                    [
                        'type'       => $lastTokenType,
                        'lineOffset' => 0,
                    ],
                ],
            ],
        ];
    }
}
