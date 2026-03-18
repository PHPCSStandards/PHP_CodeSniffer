<?php
/**
 * Tests the adding of the "parenthesis" keys to closure use tokens.
 *
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\Tokenizer;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;

/**
 * Tests the adding of the "parenthesis" keys to closure use tokens.
 *
 * @covers PHP_CodeSniffer\Tokenizers\Tokenizer::createTokenMap
 */
final class CreateTokenMapClosureUseParenthesesParseErrorTest extends AbstractTokenizerTestCase
{


    /**
     * Test (and document) the behaviour of the parentheses setting during live coding, when a
     * `use` token is encountered at the very end of a file.
     *
     * @return void
     */
    public function testLiveCoding()
    {
        $tokens = $this->phpcsFile->getTokens();
        $use    = $this->getTargetToken('/* testLiveCoding */', T_USE);

        $this->assertArrayNotHasKey('parenthesis_owner', $tokens[$use], 'parenthesis_owner key is set');
        $this->assertArrayNotHasKey('parenthesis_opener', $tokens[$use], 'parenthesis_opener key is set');
        $this->assertArrayNotHasKey('parenthesis_closer', $tokens[$use], 'parenthesis_closer key is set');
    }
}
