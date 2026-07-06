<?php
/**
 * Tests that a const declaration name which is the last non-empty token in a file is tokenized without an error.
 *
 * @copyright 2025 PHPCSStandards and contributors
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
     * Test that the name of a const declaration which is the last non-empty token in a file is tokenized as T_STRING.
     *
     * @return void
     */
    public function testConstNameAsLastToken()
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken('/* testConstNameAsLastToken */', [T_STRING]);
        $tokenArray = $tokens[$target];

        $this->assertSame(T_STRING, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING (code)');
        $this->assertSame('T_STRING', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING (type)');
    }
}
