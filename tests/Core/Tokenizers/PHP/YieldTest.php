<?php
/**
 * Tests the tokenization of the `yield` and `yield from` keywords.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2021-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Tests the tokenization of the `yield` and `yield from` keywords.
 *
 * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
 */
final class YieldTest extends AbstractTokenizerTestCase
{


    /**
     * Test that the yield keyword is tokenized as such.
     *
     * @param string $testMarker      The comment which prefaces the target token in the test file.
     * @param string $expectedContent Expected token content.
     *
     * @dataProvider dataYieldKeyword
     *
     * @return void
     */
    public function testYieldKeyword($testMarker, $expectedContent)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, [T_YIELD, T_YIELD_FROM, T_STRING]);
        $tokenArray = $tokens[$target];

        $this->assertSame(T_YIELD, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_YIELD (code)');
        $this->assertSame('T_YIELD', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_YIELD (type)');

        $this->assertSame($expectedContent, $tokenArray['content'], 'Token content does not match expectation');
    }


    /**
     * Data provider.
     *
     * @see testYieldKeyword()
     *
     * @return array<string, array<string>>
     */
    public static function dataYieldKeyword()
    {
        return [
            'yield at end of file, live coding' => [
                'testMarker'      => '/* testYieldLiveCoding */',
                'expectedContent' => 'yield',
            ],
        ];
    }


    /**
     * Test that the yield from keyword is tokenized as a single token when it in on a single line
     * and only has whitespace between the words.
     *
     * @param string $testMarker      The comment which prefaces the target token in the test file.
     * @param string $expectedContent Expected token content.
     *
     * @dataProvider dataYieldFromKeywordSingleToken
     *
     * @return void
     */
    public function testYieldFromKeywordSingleToken($testMarker, $expectedContent)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, [T_YIELD, T_YIELD_FROM, T_STRING]);
        $tokenArray = $tokens[$target];

        $this->assertSame(T_YIELD_FROM, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_YIELD_FROM (code)');
        $this->assertSame('T_YIELD_FROM', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_YIELD_FROM (type)');

        if (isset($tokenArray['orig_content']) === true) {
            $this->assertSame($expectedContent, $tokenArray['orig_content'], 'Token (orig) content does not match expectation');
        } else {
            $this->assertSame($expectedContent, $tokenArray['content'], 'Token content does not match expectation');
        }
    }


    /**
     * Data provider.
     *
     * @see testYieldFromKeywordSingleToken()
     *
     * @return array<string, array<string>>
     */
    public static function dataYieldFromKeywordSingleToken()
    {
        return [
            'yield from'                          => [
                'testMarker'      => '/* testYieldFrom */',
                'expectedContent' => 'yield from',
            ],
            'yield from with extra space between' => [
                'testMarker'      => '/* testYieldFromWithExtraSpacesBetween */',
                'expectedContent' => 'Yield           From',
            ],
            'yield from with tab between'         => [
                'testMarker'      => '/* testYieldFromWithTabBetween */',
                'expectedContent' => 'yield	from',
            ],
        ];
    }


    /**
     * Test that the yield from keyword is tokenized as a single token when it in on a single line
     * and only has whitespace between the words.
     *
     * @param string                       $testMarker     The comment which prefaces the target token in the test file.
     * @param array<array<string, string>> $expectedTokens The tokenization expected.
     *
     * @dataProvider dataYieldFromKeywordMultiToken
     *
     * @return void
     */
    public function testYieldFromKeywordMultiToken($testMarker, $expectedTokens)
    {
        $tokens = $this->phpcsFile->getTokens();
        $target = $this->getTargetToken($testMarker, [T_YIELD, T_YIELD_FROM, T_STRING]);

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
     * @see testYieldFromKeywordMultiToken()
     *
     * @return array<string, array<string, string|array<array<string, string>>>>
     */
    public static function dataYieldFromKeywordMultiToken()
    {
        return [
            'yield from with new line'                => [
                'testMarker'     => '/* testYieldFromSplitByNewLines */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'yield',
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
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'FROM',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                ],
            ],
            'yield from with comment'                 => [
                'testMarker'     => '/* testYieldFromSplitByComment */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'yield',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_COMMENT',
                        'content' => '/* comment */',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'from',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'yield from with trailing comment'        => [
                'testMarker'     => '/* testYieldFromWithTrailingComment */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'yield',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_COMMENT',
                        'content' => '// comment
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'from',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'yield from with trailing annotation'     => [
                'testMarker'     => '/* testYieldFromWithTrailingAnnotation */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'yield',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                    [
                        'type'    => 'T_PHPCS_IGNORE',
                        'content' => '// phpcs:ignore Stnd.Cat.Sniff -- for reasons.
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'from',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => ' ',
                    ],
                ],
            ],
            'yield from with new line and comment'    => [
                'testMarker'     => '/* testYieldFromSplitByNewLineAndComments */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'yield',
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
                        'content' => '/* comment line 1
',
                    ],
                    [
                        'type'    => 'T_COMMENT',
                        'content' => '       line 2 */',
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
                        'content' => '// another comment
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'from',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                ],
            ],
            'yield from with new line and annotation' => [
                'testMarker'     => '/* testYieldFromSplitByNewLineAndAnnotation */',
                'expectedTokens' => [
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'YIELD',
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
                        'type'    => 'T_PHPCS_DISABLE',
                        'content' => '// @phpcs:disable Stnd.Cat.Sniff -- for reasons.
',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '    ',
                    ],
                    [
                        'type'    => 'T_YIELD_FROM',
                        'content' => 'From',
                    ],
                    [
                        'type'    => 'T_WHITESPACE',
                        'content' => '
',
                    ],
                ],
            ],
        ];
    }


    /**
     * Test that 'yield' or 'from' when not used as the reserved keyword are tokenized as `T_STRING`.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataYieldNonKeyword
     *
     * @return void
     */
    public function testYieldNonKeyword($testMarker)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, [T_YIELD, T_YIELD_FROM, T_STRING]);
        $tokenArray = $tokens[$target];

        $this->assertSame(T_STRING, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING (code)');
        $this->assertSame('T_STRING', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING (type)');
    }


    /**
     * Data provider.
     *
     * @see testYieldNonKeyword()
     *
     * @return array<string, array<string>>
     */
    public static function dataYieldNonKeyword()
    {
        return [
            'yield used as class name'            => ['/* testYieldUsedAsClassName */'],
            'yield used as class constant name'   => ['/* testYieldUsedAsClassConstantName */'],
            'yield used as method name'           => ['/* testYieldUsedAsMethodName */'],
            'yield used as property access 1'     => ['/* testYieldUsedAsPropertyName1 */'],
            'yield used as property access 2'     => ['/* testYieldUsedAsPropertyName2 */'],
            'yield used as class constant access' => ['/* testYieldUsedForClassConstantAccess1 */'],
            'from used as class constant access'  => ['/* testFromUsedForClassConstantAccess1 */'],
            'yield used as method name with ref'  => ['/* testYieldUsedAsMethodNameReturnByRef */'],
        ];
    }
}
