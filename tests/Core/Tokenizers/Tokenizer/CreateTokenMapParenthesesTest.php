<?php
/**
 * Tests that parenthesis owner, opener and closer indexes are set correctly.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\Tokenizer;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Tests that parenthesis owner, opener and closer indexes are set correctly.
 *
 * @covers PHP_CodeSniffer\Tokenizers\Tokenizer::createTokenMap
 */
final class CreateTokenMapParenthesesTest extends AbstractTokenizerTestCase
{


    /**
     * Test parentheses which have an owner get the correct "parenthesis_*" token indexes set.
     *
     * @param string     $testMarker The comment prefacing the target token.
     * @param int|string $tokenCode  The token code to look for.
     *
     * @dataProvider dataParenthesesWithOwner
     *
     * @return void
     */
    public function testParenthesesWithOwner($testMarker, $tokenCode)
    {
        $owner  = $this->getTargetToken($testMarker, $tokenCode);
        $opener = $this->getTargetToken($testMarker, T_OPEN_PARENTHESIS);
        $closer = $this->getTargetToken(str_replace('Owner', 'Closer', $testMarker), T_CLOSE_PARENTHESIS);

        $tokenType = Tokens::tokenName($tokenCode);

        $tokens      = $this->phpcsFile->getTokens();
        $ownerArray  = $tokens[$owner];
        $openerArray = $tokens[$opener];
        $closerArray = $tokens[$closer];

        $this->assertArrayHasKey('parenthesis_owner', $ownerArray, $tokenType . ' token does not have "parenthesis_owner" key');
        $this->assertArrayHasKey('parenthesis_opener', $ownerArray, $tokenType . ' token does not have "parenthesis_opener" key');
        $this->assertArrayHasKey('parenthesis_closer', $ownerArray, $tokenType . ' token does not have "parenthesis_closer" key');
        $this->assertSame($owner, $ownerArray['parenthesis_owner'], $tokenType . ' token "parenthesis_owner" key set incorrectly');
        $this->assertSame($opener, $ownerArray['parenthesis_opener'], $tokenType . ' token "parenthesis_opener" key set incorrectly');
        $this->assertSame($closer, $ownerArray['parenthesis_closer'], $tokenType . ' token "parenthesis_closer" key set incorrectly');

        $this->assertArrayHasKey('parenthesis_owner', $openerArray, $tokenType . ' opener does not have "parenthesis_owner" key');
        $this->assertArrayHasKey('parenthesis_opener', $openerArray, $tokenType . ' opener does not have "parenthesis_opener" key');
        $this->assertArrayHasKey('parenthesis_closer', $openerArray, $tokenType . ' opener does not have "parenthesis_closer" key');
        $this->assertSame($owner, $openerArray['parenthesis_owner'], $tokenType . ' opener "parenthesis_owner" key set incorrectly');
        $this->assertSame($opener, $openerArray['parenthesis_opener'], $tokenType . ' opener "parenthesis_opener" key set incorrectly');
        $this->assertSame($closer, $openerArray['parenthesis_closer'], $tokenType . ' opener "parenthesis_closer" key set incorrectly');

        $this->assertArrayHasKey('parenthesis_owner', $closerArray, $tokenType . ' closer does not have "parenthesis_owner" key');
        $this->assertArrayHasKey('parenthesis_opener', $closerArray, $tokenType . ' closer does not have "parenthesis_opener" key');
        $this->assertArrayHasKey('parenthesis_closer', $closerArray, $tokenType . ' closer does not have "parenthesis_closer" key');
        $this->assertSame($owner, $closerArray['parenthesis_owner'], $tokenType . ' closer "parenthesis_owner" key set incorrectly');
        $this->assertSame($opener, $closerArray['parenthesis_opener'], $tokenType . ' closer "parenthesis_opener" key set incorrectly');
        $this->assertSame($closer, $closerArray['parenthesis_closer'], $tokenType . ' closer "parenthesis_closer" key set incorrectly');
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|int>>
     */
    public static function dataParenthesesWithOwner()
    {
        return [
            'declare'                                        => [
                'testMarker' => '/* testDeclareParenthesesOwner */',
                'tokenCode'  => T_DECLARE,
            ],
            'if'                                             => [
                'testMarker' => '/* testIfParenthesesOwner */',
                'tokenCode'  => T_IF,
            ],
            'elseif'                                         => [
                'testMarker' => '/* testElseIfParenthesesOwner */',
                'tokenCode'  => T_ELSEIF,
            ],
            'for'                                            => [
                'testMarker' => '/* testForParenthesesOwner */',
                'tokenCode'  => T_FOR,
            ],
            'foreach'                                        => [
                'testMarker' => '/* testForeachParenthesesOwnerPlain */',
                'tokenCode'  => T_FOREACH,
            ],
            'foreach with nested array'                      => [
                'testMarker' => '/* testForeachParenthesesOwnerWithNestedArray */',
                'tokenCode'  => T_FOREACH,
            ],
            'array'                                          => [
                'testMarker' => '/* testArrayParenthesesOwner */',
                'tokenCode'  => T_ARRAY,
            ],
            'foreach with nested list'                       => [
                'testMarker' => '/* testForeachParenthesesOwnerWithNestedList */',
                'tokenCode'  => T_FOREACH,
            ],
            'list'                                           => [
                'testMarker' => '/* testListParenthesesOwner */',
                'tokenCode'  => T_LIST,
            ],
            'switch'                                         => [
                'testMarker' => '/* testSwitchParenthesesOwner */',
                'tokenCode'  => T_SWITCH,
            ],
            'while'                                          => [
                'testMarker' => '/* testWhileParenthesesOwner */',
                'tokenCode'  => T_WHILE,
            ],
            'do - while'                                     => [
                'testMarker' => '/* testDoWhileParenthesesOwner */',
                'tokenCode'  => T_WHILE,
            ],
            'catch'                                          => [
                'testMarker' => '/* testCatchParenthesesOwner */',
                'tokenCode'  => T_CATCH,
            ],
            'match'                                          => [
                'testMarker' => '/* testMatchParenthesesOwner */',
                'tokenCode'  => T_MATCH,
            ],
            'function declaration'                           => [
                'testMarker' => '/* testFunctionParenthesesOwner */',
                'tokenCode'  => T_FUNCTION,
            ],
            'function declaration return by ref'             => [
                'testMarker' => '/* testFunctionParenthesesOwnerReturnByRef */',
                'tokenCode'  => T_FUNCTION,
            ],
            'function declaration, "match" as function name' => [
                'testMarker' => '/* testFunctionParenthesesOwnerKeywordNameMatch */',
                'tokenCode'  => T_FUNCTION,
            ],
            'function declaration, "fn" as function name'    => [
                'testMarker' => '/* testFunctionParenthesesOwnerKeywordNameFn */',
                'tokenCode'  => T_FUNCTION,
            ],
            'function declaration, "&fn" as function name'   => [
                'testMarker' => '/* testFunctionParenthesesOwnerKeywordNameFnReturnByRef */',
                'tokenCode'  => T_FUNCTION,
            ],
            'closure declaration'                            => [
                'testMarker' => '/* testClosureParenthesesOwner */',
                'tokenCode'  => T_CLOSURE,
            ],
            'anonymous class'                                => [
                'testMarker' => '/* testAnonClassParenthesesOwner */',
                'tokenCode'  => T_ANON_CLASS,
            ],
            'isset'                                          => [
                'testMarker' => '/* testIssetParenthesesOwner */',
                'tokenCode'  => T_ISSET,
            ],
            'empty'                                          => [
                'testMarker' => '/* testEmptyParenthesesOwner */',
                'tokenCode'  => T_EMPTY,
            ],
            'unset'                                          => [
                'testMarker' => '/* testUnsetParenthesesOwner */',
                'tokenCode'  => T_UNSET,
            ],
            'eval'                                           => [
                'testMarker' => '/* testEvalParenthesesOwner */',
                'tokenCode'  => T_EVAL,
            ],
            'exit'                                           => [
                'testMarker' => '/* testExitParenthesesOwner */',
                'tokenCode'  => T_EXIT,
            ],
            'die'                                            => [
                'testMarker' => '/* testDieParenthesesOwner */',
                'tokenCode'  => T_EXIT,
            ],
            'exit (fully qualified)'                         => [
                'testMarker' => '/* testFullyQualifiedExitParenthesesOwner */',
                'tokenCode'  => T_EXIT,
            ],
            'die (fully qualified)'                          => [
                'testMarker' => '/* testFullyQualifiedDieParenthesesOwner */',
                'tokenCode'  => T_EXIT,
            ],

            'if - nested outer'                              => [
                'testMarker' => '/* testNestedOuterIfParenthesesOwner */',
                'tokenCode'  => T_IF,
            ],
            'closure - nested'                               => [
                'testMarker' => '/* testNestedClosureParenthesesOwner */',
                'tokenCode'  => T_CLOSURE,
            ],
            'closure use - nested'                           => [
                'testMarker' => '/* testNestedClosureUseParenthesesOwner */',
                'tokenCode'  => T_USE,
            ],
            'foreach - nested'                               => [
                'testMarker' => '/* testNestedForeachParenthesesOwner */',
                'tokenCode'  => T_FOREACH,
            ],
            'array - nested 1'                               => [
                'testMarker' => '/* testNestedArrayAParenthesesOwner */',
                'tokenCode'  => T_ARRAY,
            ],
            'array - nested 2'                               => [
                'testMarker' => '/* testNestedArrayBParenthesesOwner */',
                'tokenCode'  => T_ARRAY,
            ],
            'list - nested'                                  => [
                'testMarker' => '/* testNestedListParenthesesOwner */',
                'tokenCode'  => T_LIST,
            ],
            'anon class - nested'                            => [
                'testMarker' => '/* testNestedAnonClassParenthesesOwner */',
                'tokenCode'  => T_ANON_CLASS,
            ],
        ];
    }


    /**
     * Test parentheses which do *not* have an owner get the correct "parenthesis_*" token indexes set.
     *
     * @param string $testMarker The comment prefacing the target token.
     *
     * @dataProvider dataParenthesesWithoutOwner
     *
     * @return void
     */
    public function testParenthesesWithoutOwner($testMarker)
    {
        $opener = $this->getTargetToken($testMarker, T_OPEN_PARENTHESIS);
        $closer = $this->getTargetToken(str_replace('Opener', 'Closer', $testMarker), T_CLOSE_PARENTHESIS);

        $tokens      = $this->phpcsFile->getTokens();
        $openerArray = $tokens[$opener];
        $closerArray = $tokens[$closer];

        $this->assertArrayNotHasKey('parenthesis_owner', $openerArray, 'Opener has "parenthesis_owner" key');
        $this->assertArrayNotHasKey('parenthesis_owner', $closerArray, 'Closer has "parenthesis_owner" key');

        $this->assertArrayHasKey('parenthesis_opener', $openerArray, 'Opener does not have "parenthesis_opener" key');
        $this->assertArrayHasKey('parenthesis_closer', $openerArray, 'Opener does not have "parenthesis_closer" key');
        $this->assertSame($opener, $openerArray['parenthesis_opener'], 'Opener "parenthesis_opener" key set incorrectly');
        $this->assertSame($closer, $openerArray['parenthesis_closer'], 'Opener "parenthesis_closer" key set incorrectly');

        $this->assertArrayHasKey('parenthesis_opener', $closerArray, 'Closer does not have "parenthesis_opener" key');
        $this->assertArrayHasKey('parenthesis_closer', $closerArray, 'Closer does not have "parenthesis_closer" key');
        $this->assertSame($opener, $closerArray['parenthesis_opener'], 'Closer "parenthesis_opener" key set incorrectly');
        $this->assertSame($closer, $closerArray['parenthesis_closer'], 'Closer "parenthesis_closer" key set incorrectly');
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string>>
     */
    public static function dataParenthesesWithoutOwner()
    {
        return [
            'arbitrary parentheses, not nested' => [
                'testMarker' => '/* testArbitraryParenthesesOpener */',
            ],
            'function call'                     => [
                'testMarker' => '/* testFunctionCallParenthesesOpener */',
            ],
            'function call - nested 1'          => [
                'testMarker' => '/* testNestedFunctionCallAParenthesesOpener */',
            ],
            'function call - nested 2'          => [
                'testMarker' => '/* testNestedFunctionCallBParenthesesOpener */',
            ],
            'function call - nested 3'          => [
                'testMarker' => '/* testNestedFunctionCallCParenthesesOpener */',
            ],
        ];
    }


    /**
     * Test parentheses owner tokens when used without parentheses (where possible) do *not* have the "parenthesis_*" token indexes set.
     *
     * @param string     $testMarker The comment prefacing the target token.
     * @param int|string $tokenCode  The token code to look for.
     *
     * @dataProvider dataParenthesesOwnerWithoutParentheses
     *
     * @return void
     */
    public function testParenthesesOwnerWithoutParentheses($testMarker, $tokenCode)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, $tokenCode);
        $tokenArray = $tokens[$target];

        $tokenType = Tokens::tokenName($tokenCode);

        $this->assertArrayNotHasKey('parenthesis_owner', $tokenArray, $tokenType . ' token has "parenthesis_owner" key');
        $this->assertArrayNotHasKey('parenthesis_opener', $tokenArray, $tokenType . ' token has "parenthesis_opener" key');
        $this->assertArrayNotHasKey('parenthesis_closer', $tokenArray, $tokenType . ' token has "parenthesis_closer" key');
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|int>>
     */
    public static function dataParenthesesOwnerWithoutParentheses()
    {
        return [
            'anonymous class without parentheses' => [
                'testMarker' => '/* testAnonClassNoParentheses */',
                'tokenCode'  => T_ANON_CLASS,
            ],
            'exit without parentheses'            => [
                'testMarker' => '/* testExitNoParentheses */',
                'tokenCode'  => T_EXIT,
            ],
            'die without parentheses'             => [
                'testMarker' => '/* testDieNoParentheses */',
                'tokenCode'  => T_EXIT,
            ],
        ];
    }
}
