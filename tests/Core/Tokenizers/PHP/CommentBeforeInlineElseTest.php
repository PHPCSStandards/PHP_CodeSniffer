<?php
/**
 * Tests the retokenization of the ternary colon to T_INLINE_ELSE when preceded by a comment.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;

/**
 * Tests the retokenization of the ternary colon to T_INLINE_ELSE when preceded by a comment.
 *
 * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
 */
final class CommentBeforeInlineElseTest extends AbstractTokenizerTestCase
{


    /**
     * Test that the colon of a ternary expression is tokenized as T_INLINE_ELSE when it is
     * preceded by a slash or hash comment which is not followed by indentation.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataInlineElseAfterComment
     *
     * @return void
     */
    public function testInlineElseAfterComment($testMarker)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, [T_INLINE_ELSE, T_COLON]);
        $tokenArray = $tokens[$target];

        $this->assertSame(T_INLINE_ELSE, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_INLINE_ELSE (code)');
        $this->assertSame('T_INLINE_ELSE', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_INLINE_ELSE (type)');
    }


    /**
     * Data provider.
     *
     * @see testInlineElseAfterComment()
     *
     * @return array<string, array<string>>
     */
    public static function dataInlineElseAfterComment()
    {
        return [
            'colon after slash comment' => ['/* testInlineElseAfterSlashComment */'],
            'colon after hash comment'  => ['/* testInlineElseAfterHashComment */'],
        ];
    }


    /**
     * Test that the return type colon of a closure or arrow function is not mistaken for an inline
     * else when a slash or hash comment sits between the function keyword and the parameter
     * parenthesis and is not followed by indentation.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataColonReturnTypeAfterComment
     *
     * @return void
     */
    public function testColonReturnTypeAfterComment($testMarker)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, [T_INLINE_ELSE, T_COLON]);
        $tokenArray = $tokens[$target];

        $this->assertSame(T_COLON, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_COLON (code)');
        $this->assertSame('T_COLON', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_COLON (type)');
    }


    /**
     * Data provider.
     *
     * @see testColonReturnTypeAfterComment()
     *
     * @return array<string, array<string>>
     */
    public static function dataColonReturnTypeAfterComment()
    {
        return [
            'return type colon after slash comment' => ['/* testColonReturnTypeAfterSlashComment */'],
            'return type colon after hash comment'  => ['/* testColonReturnTypeAfterHashComment */'],
        ];
    }
}
