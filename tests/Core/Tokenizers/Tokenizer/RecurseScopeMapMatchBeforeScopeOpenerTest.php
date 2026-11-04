<?php
/**
 * Tests setting the scope for tokens which have a match expression before their scope opener.
 *
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\Tokenizer;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;

final class RecurseScopeMapMatchBeforeScopeOpenerTest extends AbstractTokenizerTestCase
{


    /**
     * Tests setting the scope for a token which has a match expression before its scope opener.
     *
     * @param string     $testMarker The comment which prefaces the target token in the test file.
     * @param int|string $tokenCode  The code of the target token.
     * @param int|string $openerCode The expected token code for the scope opener.
     * @param int|string $closerCode The expected token code for the scope closer.
     *
     * @dataProvider dataMatchBeforeScopeOpener
     * @covers       \PHP_CodeSniffer\Tokenizers\Tokenizer::recurseScopeMap
     *
     * @return void
     */
    public function testMatchBeforeScopeOpener($testMarker, $tokenCode, $openerCode, $closerCode)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, $tokenCode);
        $tokenArray = $tokens[$target];

        $expectedScopeOpener = $this->getTargetToken(substr($testMarker, 0, -3) . 'ScopeOpener */', $openerCode);
        $expectedScopeCloser = $this->getTargetToken(substr($testMarker, 0, -3) . 'ScopeCloser */', $closerCode);

        $this->assertArrayHasKey('scope_condition', $tokenArray, 'Scope condition not set');
        $this->assertSame($target, $tokenArray['scope_condition'], 'Scope condition not set correctly');

        $this->assertArrayHasKey('scope_opener', $tokenArray, 'Scope opener not set');
        $this->assertSame(
            $expectedScopeOpener,
            $tokenArray['scope_opener'],
            sprintf(
                'Scope opener not set correctly; expected %s, found %s',
                $tokens[$expectedScopeOpener]['type'],
                $tokens[$tokenArray['scope_opener']]['type']
            )
        );

        $this->assertArrayHasKey('scope_closer', $tokenArray, 'Scope closer not set');
        $this->assertSame(
            $expectedScopeCloser,
            $tokenArray['scope_closer'],
            sprintf(
                'Scope closer not set correctly; expected %s, found %s',
                $tokens[$expectedScopeCloser]['type'],
                $tokens[$tokenArray['scope_closer']]['type']
            )
        );
    }


    /**
     * Data provider.
     *
     * @see testMatchBeforeScopeOpener()
     *
     * @return array<string, array<string, int|string>>
     */
    public static function dataMatchBeforeScopeOpener()
    {
        return [
            'if with match expression in the condition'                     => [
                'testMarker' => '/* testIfMatchInCondition */',
                'tokenCode'  => T_IF,
                'openerCode' => T_OPEN_CURLY_BRACKET,
                'closerCode' => T_CLOSE_CURLY_BRACKET,
            ],
            'elseif with match expression in the condition'                 => [
                'testMarker' => '/* testElseIfMatchInCondition */',
                'tokenCode'  => T_ELSEIF,
                'openerCode' => T_OPEN_CURLY_BRACKET,
                'closerCode' => T_CLOSE_CURLY_BRACKET,
            ],
            'if with match expression in the condition, alternative syntax' => [
                'testMarker' => '/* testIfMatchInConditionAlternativeSyntax */',
                'tokenCode'  => T_IF,
                'openerCode' => T_COLON,
                'closerCode' => T_ENDIF,
            ],
            'while with match expression in the condition'                  => [
                'testMarker' => '/* testWhileMatchInCondition */',
                'tokenCode'  => T_WHILE,
                'openerCode' => T_OPEN_CURLY_BRACKET,
                'closerCode' => T_CLOSE_CURLY_BRACKET,
            ],
            'for with match expression in the condition'                    => [
                'testMarker' => '/* testForMatchInCondition */',
                'tokenCode'  => T_FOR,
                'openerCode' => T_OPEN_CURLY_BRACKET,
                'closerCode' => T_CLOSE_CURLY_BRACKET,
            ],
            'foreach with match expression in the condition'                => [
                'testMarker' => '/* testForeachMatchInCondition */',
                'tokenCode'  => T_FOREACH,
                'openerCode' => T_OPEN_CURLY_BRACKET,
                'closerCode' => T_CLOSE_CURLY_BRACKET,
            ],
            'anonymous class with match expression in the arguments'        => [
                'testMarker' => '/* testAnonClassMatchInArguments */',
                'tokenCode'  => T_ANON_CLASS,
                'openerCode' => T_OPEN_CURLY_BRACKET,
                'closerCode' => T_CLOSE_CURLY_BRACKET,
            ],
            'if with match expression in the condition and a nested if'     => [
                'testMarker' => '/* testIfMatchInConditionWithNestedIf */',
                'tokenCode'  => T_IF,
                'openerCode' => T_OPEN_CURLY_BRACKET,
                'closerCode' => T_CLOSE_CURLY_BRACKET,
            ],
        ];
    }
}
