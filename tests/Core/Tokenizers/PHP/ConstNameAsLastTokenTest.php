<?php
/**
 * Tests that a const declaration name which is the last non-empty token in a file is tokenized without an error.
 *
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;

/**
 * Tests that a const declaration name which is the last non-empty token in a file is tokenized without an error.
 *
 * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
 */
final class ConstNameAsLastTokenTest extends AbstractTokenizerTestCase
{


    /**
     * Test that an unfinished constant declaration during live coding doesn't cause an "Undefined array key" error.
     *
     * @return void
     */
    public function testLiveCoding()
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken('/* testLiveCoding */', [T_STRING]);
        $tokenArray = $tokens[$target];

        $this->assertSame(T_STRING, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING (code)');
        $this->assertSame('T_STRING', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING (type)');
    }
}
