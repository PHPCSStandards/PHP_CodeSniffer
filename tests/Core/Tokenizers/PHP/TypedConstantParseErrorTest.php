<?php
/**
 * Tests that an unfinished constant declaration during live coding doesn't cause a fatal error.
 *
 * @author    Sai Asish Y <say.apm35@gmail.com>
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;

final class TypedConstantParseErrorTest extends AbstractTokenizerTestCase
{


    /**
     * Verify that an unfinished constant declaration during live coding doesn't cause an "Undefined array key" error.
     *
     * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testUnfinishedConstant()
    {
        $tokens = $this->phpcsFile->getTokens();

        $token      = $this->getTargetToken('/* testLiveCoding */', [T_STRING, T_CONST], 'A');
        $tokenArray = $tokens[$token];

        $this->assertSame('T_STRING', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING');
    }
}
