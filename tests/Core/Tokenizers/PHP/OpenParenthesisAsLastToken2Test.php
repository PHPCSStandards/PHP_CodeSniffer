<?php
/**
 * Tests that the tokenizer doesn't throw an error when an open parenthesis followed by whitespace are the last tokens in the file.
 *
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;

/**
 * Tests that the tokenizer doesn't throw an error when an open parenthesis followed by whitespace are the last tokens in the file.
 *
 * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
 */
final class OpenParenthesisAsLastToken2Test extends AbstractTokenizerTestCase
{


    /**
     * Test that an unfinished statement during live coding doesn't cause an "Undefined array key" error.
     *
     * @return void
     */
    public function testLiveCoding()
    {
        $tokens = $this->phpcsFile->getTokens();
        $target = $this->getTargetToken('/* testOpenParenthesisAndWhitespaceAsLastTokens */', T_OPEN_PARENTHESIS);

        $expectedTokenTypes = [
            'T_OPEN_PARENTHESIS',
            'T_WHITESPACE',
        ];
        $actualTokenTypes   = array_column(array_slice($tokens, $target), 'type');

        $this->assertSame($expectedTokenTypes, $actualTokenTypes);
    }
}
