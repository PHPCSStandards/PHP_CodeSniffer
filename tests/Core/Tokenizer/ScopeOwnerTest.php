<?php
/**
 * Tests that scope owner (scope_condition, conditions) is set correctly
 *
 * @author  Dan Wallis <dan@wallis.nz>
 * @license https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizer;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;

final class ScopeOwnerTest extends AbstractMethodUnitTest
{


    /**
     * Test that a basic 'if' condition gets scope opener/closer set as expected.
     *
     * @param string $testMarker     The comment which prefaces the target token in the test file.
     * @param int    $conditionWidth How many tokens wide the 'if' condition should be.
     *
     * @dataProvider dataIfCondition
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testIfCondition($testMarker, $conditionWidth)
    {
        $tokens   = self::$phpcsFile->getTokens();
        $targetIf = $this->getTargetToken($testMarker, T_IF);

        $this->assertSame($targetIf, $tokens[$targetIf]['parenthesis_owner'], 'parenthesis owner is self for if');
        $this->assertSame(($targetIf + 2), $tokens[$targetIf]['parenthesis_opener'], 'expected parenthesis opener');
        $this->assertSame(($targetIf + 2 + $conditionWidth), $tokens[$targetIf]['parenthesis_closer'], 'expected parenthesis closer');
        $this->assertSame($targetIf, $tokens[$targetIf]['scope_condition']);

        $targetOpenCurly = self::$phpcsFile->findNext(T_OPEN_CURLY_BRACKET, $targetIf);
        $this->assertSame($targetIf, $tokens[$targetOpenCurly]['scope_condition'], 'scope_condition set on open curly');

        $targetCloseCurly = $tokens[$targetOpenCurly]['bracket_closer'];
        $this->assertSame($targetIf, $tokens[$targetCloseCurly]['scope_condition'], 'scope_condition set on close curly');

        $targetReturn = self::$phpcsFile->findNext(T_RETURN, $targetIf);
        $this->assertSame([$targetIf => T_IF], $tokens[$targetReturn]['conditions'], 'conditions set on if statement body');

    }//end testIfCondition()


    /**
     * Data provider.
     *
     * @see testIfCondition()
     *
     * @return array<string, array<string, int>>
     */
    public static function dataIfCondition()
    {
        return [
            'Basic if'                      => [
                'testMarker'     => '/* testNormalIfCondition */',
                'conditionWidth' => 2,
            ],
            'Function call in if condition' => [
                'testMarker'     => '/* testFunctionCallInIfCondition */',
                'conditionWidth' => 5,
            ],
            'Heredoc in if condition'       => [
                'testMarker'     => '/* testHeredocInIfCondition */',
                'conditionWidth' => 8,
            ],
        ];

    }//end dataIfCondition()


}//end class
