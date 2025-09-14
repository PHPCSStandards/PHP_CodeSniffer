<?php
/**
 * Base class for testing DocBlock comment tokenization.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\Comment;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Base class for testing DocBlock comment tokenization.
 *
 * @covers PHP_CodeSniffer\Tokenizers\Comment
 */
abstract class CommentTestCase extends AbstractTokenizerTestCase
{


    /**
     * Test whether the docblock tokens have the extra `comment_opener` and `comment_closer` keys,
     * and the docblock opener has the `comment_tags` key.
     *
     * @param string     $marker       The comment prefacing the target token.
     * @param int        $closerOffset The offset of the closer from the opener.
     * @param array<int> $expectedTags The expected tags offsets array.
     *
     * @dataProvider dataDocblockOpenerCloser
     *
     * @return void
     */
    public function testDocblockOpenerCloser($marker, $closerOffset, $expectedTags)
    {
        $tokens         = $this->phpcsFile->getTokens();
        $expectedOpener = $this->getTargetToken($marker, [T_DOC_COMMENT_OPEN_TAG]);
        $expectedCloser = ($expectedOpener + $closerOffset);

        $opener = $tokens[$expectedOpener];

        // Update the tags expectations.
        foreach ($expectedTags as $i => $ptr) {
            $expectedTags[$i] += $expectedOpener;
        }

        // Verify that the comment opener has the `comment_tags` key.
        $this->assertArrayHasKey('comment_tags', $opener, 'Comment opener: comment_tags index is not set');
        $this->assertSame($expectedTags, $opener['comment_tags'], 'Comment opener: recorded tags do not match expected tags');

        // Check that the comment_opener and comment_closer keys have been added to all docblock tokens.
        for ($i = $expectedOpener; $i <= $expectedCloser; $i++) {
            $token = $tokens[$i];
            $this->assertArrayHasKey('comment_opener', $token, 'Comment_opener index is not set (for stackPtr ' . $i . ')');
            $this->assertArrayHasKey('comment_closer', $token, 'Comment_closer index is not set (for stackPtr ' . $i . ')');

            $this->assertSame(
                $expectedOpener,
                $token['comment_opener'],
                'Comment_opener not set to the expected stack pointer (for stackPtr ' . $i . ')'
            );
            $this->assertSame(
                $expectedCloser,
                $token['comment_closer'],
                'Comment_closer not set to the expected stack pointer (for stackPtr ' . $i . ')'
            );
        }
    }


    /**
     * Data provider.
     *
     * @see testDocblockOpenerCloser()
     *
     * @return array<string, array<string, string|int|array<int>>>
     */
    abstract public static function dataDocblockOpenerCloser();


    /**
     * Test helper. Check a token sequence complies with an expected token sequence.
     *
     * @param int                              $startPtr         The position in the file to start checking from.
     * @param array<array<int|string, string>> $expectedSequence The consecutive token constants and their contents to expect.
     *
     * @return void
     */
    protected function checkTokenSequence($startPtr, array $expectedSequence)
    {
        $tokens = $this->phpcsFile->getTokens();

        $sequenceKey   = 0;
        $sequenceCount = count($expectedSequence);

        for ($i = $startPtr; $sequenceKey < $sequenceCount; $i++, $sequenceKey++) {
            $currentItem     = $expectedSequence[$sequenceKey];
            $expectedCode    = key($currentItem);
            $expectedType    = Tokens::tokenName($expectedCode);
            $expectedContent = current($currentItem);
            $errorMsgSuffix  = PHP_EOL . '(StackPtr: ' . $i . ' | Position in sequence: ' . $sequenceKey . ' | Expected: ' . $expectedType . ')';

            $this->assertSame(
                $expectedCode,
                $tokens[$i]['code'],
                'Token tokenized as ' . Tokens::tokenName($tokens[$i]['code']) . ', not ' . $expectedType . ' (code)' . $errorMsgSuffix
            );

            $this->assertSame(
                $expectedType,
                $tokens[$i]['type'],
                'Token tokenized as ' . $tokens[$i]['type'] . ', not ' . $expectedType . ' (type)' . $errorMsgSuffix
            );

            $this->assertSame(
                $expectedContent,
                $tokens[$i]['content'],
                'Token content did not match expectations' . $errorMsgSuffix
            );
        }
    }
}
