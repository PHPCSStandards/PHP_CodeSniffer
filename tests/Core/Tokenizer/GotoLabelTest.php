<?php
/**
 * Tests the tokenization of goto declarations and statements.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2020 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizer;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;

final class GotoLabelTest extends AbstractMethodUnitTest
{


    /**
     * Verify that the label in a goto statement is tokenized as T_STRING.
     *
     * @param string $testMarker  The comment prefacing the target token.
     * @param string $testContent The token content to expect.
     *
     * @dataProvider dataGotoStatement
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testGotoStatement($testMarker, $testContent)
    {
        $tokens = self::$phpcsFile->getTokens();

        $label = $this->getTargetToken($testMarker, T_STRING);

        $this->assertIsInt($label);
        $this->assertSame($testContent, $tokens[$label]['content']);

    }//end testGotoStatement()


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
        ];

    }//end dataGotoStatement()


    /**
     * Verify that the label in a goto declaration is tokenized as T_GOTO_LABEL.
     *
     * @param string $testMarker  The comment prefacing the target token.
     * @param string $testContent The token content to expect.
     *
     * @dataProvider dataGotoDeclaration
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testGotoDeclaration($testMarker, $testContent)
    {
        $tokens = self::$phpcsFile->getTokens();

        $label = $this->getTargetToken($testMarker, T_GOTO_LABEL);

        $this->assertIsInt($label);
        $this->assertSame($testContent, $tokens[$label]['content']);

    }//end testGotoDeclaration()


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
                'testContent' => 'marker:',
            ],
            'label in goto declaration - end'    => [
                'testMarker'  => '/* testGotoDeclarationOutsideLoop */',
                'testContent' => 'end:',
            ],
        ];

    }//end dataGotoDeclaration()


    /**
     * Verify that the constant used in a switch - case statement is not confused with a goto label.
     *
     * @param string $testMarker  The comment prefacing the target token.
     * @param string $testContent The token content to expect.
     *
     * @dataProvider dataNotAGotoDeclaration
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testNotAGotoDeclaration($testMarker, $testContent)
    {
        $tokens     = self::$phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, [T_GOTO_LABEL, T_STRING, T_NAME_QUALIFIED], $testContent);
        $tokenArray = $tokens[$target];

        $this->assertNotSame(T_GOTO_LABEL, $tokenArray['code'], 'Token tokenized as T_GOTO_LABEL, not T_STRING or T_NAME_QUALIFIED (code)');
        $this->assertNotSame('T_GOTO_LABEL', $tokenArray['type'], 'Token tokenized as T_GOTO_LABEL, not T_STRING or T_NAME_QUALIFIED (type)');

    }//end testNotAGotoDeclaration()


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
                'testMarker'  => '/* testNotGotoDeclarationNamespacedConstant */',
                'testContent' => 'MyNS\CONSTANT',
            ],
            'not goto label - class constant followed by switch-case colon'      => [
                'testMarker'  => '/* testNotGotoDeclarationClassConstant */',
                'testContent' => 'CONSTANT',
            ],
            'not goto label - class property use followed by switch-case colon'  => [
                'testMarker'  => '/* testNotGotoDeclarationClassProperty */',
                'testContent' => 'property',
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

    }//end dataNotAGotoDeclaration()


}//end class
