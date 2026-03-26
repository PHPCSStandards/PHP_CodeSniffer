<?php
/**
 * Tests the tokenization of goto declarations and statements.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2020-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Tests the tokenization of goto declarations and statements.
 *
 * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
 */
final class GotoLabelTest extends AbstractTokenizerTestCase
{


    /**
     * Verify that the label in a goto statement is tokenized as T_STRING.
     *
     * @param string $testMarker  The comment prefacing the target token.
     * @param string $testContent The token content to expect.
     *
     * @dataProvider dataGotoStatement
     *
     * @return void
     */
    public function testGotoStatement($testMarker, $testContent)
    {
        $tokens = $this->phpcsFile->getTokens();

        $label = $this->getTargetToken($testMarker, T_STRING);

        $this->assertIsInt($label);
        $this->assertSame($testContent, $tokens[$label]['content']);
    }


    /**
     * Data provider.
     *
     * @see testGotoStatement()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataGotoStatement()
    {
        return [
            'label for goto statement'                              => [
                'testMarker'  => '/* testGotoStatement */',
                'testContent' => 'marker',
            ],
            'label for goto statement in loop, keyword capitalized' => [
                'testMarker'  => '/* testGotoStatementInLoop */',
                'testContent' => 'end',
            ],
            'label for goto statement in switch'                    => [
                'testMarker'  => '/* testGotoStatementInSwitch */',
                'testContent' => 'def',
            ],
            'label for goto statement within function'              => [
                'testMarker'  => '/* testGotoStatementInFunction */',
                'testContent' => 'label',
            ],

            'goto parent'                                           => [
                'testMarker'  => '/* testParentAsGotoTargetShouldBeString */',
                'testContent' => 'parent',
            ],
            'goto self'                                             => [
                'testMarker'  => '/* testSelfAsGotoTargetShouldBeString */',
                'testContent' => 'self',
            ],
            'goto true'                                             => [
                'testMarker'  => '/* testTrueAsGotoTargetShouldBeString */',
                'testContent' => 'true',
            ],
            'goto false'                                            => [
                'testMarker'  => '/* testFalseAsGotoTargetShouldBeString */',
                'testContent' => 'false',
            ],
            'goto null'                                             => [
                'testMarker'  => '/* testNullAsGotoTargetShouldBeString */',
                'testContent' => 'null',
            ],
        ];
    }


    /**
     * Verify that the label in a goto declaration is tokenized as T_GOTO_LABEL
     * and that the next non-empty token is always T_GOTO_COLON.
     *
     * @param string $testMarker  The comment prefacing the target token.
     * @param string $testContent The token content to expect.
     *
     * @dataProvider dataGotoDeclaration
     *
     * @return void
     */
    public function testGotoDeclaration($testMarker, $testContent)
    {
        $tokens = $this->phpcsFile->getTokens();

        $label = $this->getTargetToken($testMarker, T_GOTO_LABEL);

        $this->assertIsInt($label);
        $this->assertSame($testContent, $tokens[$label]['content']);

        $next = $this->phpcsFile->findNext(Tokens::EMPTY_TOKENS, ($label + 1), null, true);

        $this->assertIsInt($next);
        $this->assertSame(T_GOTO_COLON, $tokens[$next]['code']);
        $this->assertSame('T_GOTO_COLON', $tokens[$next]['type']);
        $this->assertSame(':', $tokens[$next]['content']);
    }


    /**
     * Data provider.
     *
     * @see testGotoDeclaration()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataGotoDeclaration()
    {
        return [
            'label in goto declaration - marker' => [
                'testMarker'  => '/* testGotoDeclaration */',
                'testContent' => 'marker',
            ],
            'label in goto declaration - end'    => [
                'testMarker'  => '/* testGotoDeclarationOutsideLoop */',
                'testContent' => 'end',
            ],
            'label in goto declaration - def'    => [
                'testMarker'  => '/* testGotoDeclarationInSwitch */',
                'testContent' => 'def',
            ],
            'label in goto declaration - label'  => [
                'testMarker'  => '/* testGotoDeclarationInFunction */',
                'testContent' => 'label',
            ],

            'label in goto declaration - parent' => [
                'testMarker'  => '/* testParentAsGotoLabelShouldBeGotoLabel */',
                'testContent' => 'parent',
            ],
            'label in goto declaration - self'   => [
                'testMarker'  => '/* testSelfAsGotoLabelShouldBeGotoLabel */',
                'testContent' => 'self',
            ],
            'label in goto declaration - true'   => [
                'testMarker'  => '/* testTrueAsGotoLabelShouldBeGotoLabel */',
                'testContent' => 'true',
            ],
            'label in goto declaration - false'  => [
                'testMarker'  => '/* testFalseAsGotoLabelShouldBeGotoLabel */',
                'testContent' => 'false',
            ],
            'label in goto declaration - null'   => [
                'testMarker'  => '/* testNullAsGotoLabelShouldBeGotoLabel */',
                'testContent' => 'null',
            ],
        ];
    }


    /**
     * Verify that the constant used in a switch - case statement is not confused with a goto label.
     *
     * @param string $testMarker   The comment prefacing the target token.
     * @param string $testContent  The token content to expect.
     * @param string $expectedType Optional. The token type which is expected (not T_GOTO_LABEL).
     *                             Defaults to `T_STRING`.
     *
     * @dataProvider dataNotAGotoDeclaration
     *
     * @return void
     */
    public function testNotAGotoDeclaration($testMarker, $testContent, $expectedType = 'T_STRING')
    {
        $targetTypes  = Tokens::NAME_TOKENS;
        $targetTypes += [T_GOTO_LABEL => T_GOTO_LABEL];
        $expectedCode = T_STRING;

        if ($expectedType !== 'T_STRING') {
            $expectedCode = constant($expectedType);
            $targetTypes[$expectedCode] = $expectedCode;
        }

        $target = $this->getTargetToken($testMarker, $targetTypes, $testContent);

        $tokens     = $this->phpcsFile->getTokens();
        $tokenArray = $tokens[$target];

        $this->assertSame($expectedCode, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not ' . $expectedType . ' (code)');
        $this->assertSame($expectedType, $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not ' . $expectedType . ' (type)');
    }


    /**
     * Data provider.
     *
     * @see testNotAGotoDeclaration()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataNotAGotoDeclaration()
    {
        return [
            'not goto label - global constant followed by switch-case colon'     => [
                'testMarker'  => '/* testNotGotoDeclarationGlobalConstant */',
                'testContent' => 'CONSTANT',
            ],
            'not goto label - namespaced constant followed by switch-case colon' => [
                'testMarker'   => '/* testNotGotoDeclarationNamespacedConstant */',
                'testContent'  => 'MyNS\CONSTANT',
                'expectedType' => 'T_NAME_QUALIFIED',
            ],
            'not goto label - class constant followed by switch-case colon'      => [
                'testMarker'  => '/* testNotGotoDeclarationClassConstantInCase */',
                'testContent' => 'CONSTANT',
            ],
            'not goto label - spacey class constant in switch-case'              => [
                'testMarker'  => '/* testNotGotoDeclarationClassConstantWithSpace */',
                'testContent' => 'MY_CONST',
            ],
            'not goto label - class constant with comment in switch-case'        => [
                'testMarker'  => '/* testNotGotoDeclarationClassConstantWithComment */',
                'testContent' => 'OTHER_CONST',
            ],
            'not goto label - class property use followed by switch-case colon'  => [
                'testMarker'  => '/* testNotGotoDeclarationClassProperty */',
                'testContent' => 'property',
            ],
            'not goto label - true followed by switch-case colon'                => [
                'testMarker'   => '/* testNotGotoDeclarationTrueInCase */',
                'testContent'  => 'true',
                'expectedType' => 'T_TRUE',
            ],
            'not goto label - false followed by switch-case colon'               => [
                'testMarker'   => '/* testNotGotoDeclarationFalseInCase */',
                'testContent'  => '\false',
                'expectedType' => 'T_FALSE',
            ],
            'not goto label - null followed by switch-case colon'                => [
                'testMarker'   => '/* testNotGotoDeclarationNullInCase */',
                'testContent'  => 'null',
                'expectedType' => 'T_NULL',
            ],
            'not goto label - global constant followed by ternary else'          => [
                'testMarker'  => '/* testNotGotoDeclarationGlobalConstantInTernary */',
                'testContent' => 'CONST_A',
            ],
            'not goto label - global constant after ternary else'                => [
                'testMarker'  => '/* testNotGotoDeclarationGlobalConstantInTernary */',
                'testContent' => 'CONST_B',
            ],
            'not goto label - name of backed enum'                               => [
                'testMarker'  => '/* testNotGotoDeclarationEnumWithType */',
                'testContent' => 'Suit',
            ],
        ];
    }
}
