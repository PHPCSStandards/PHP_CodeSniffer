<?php
/**
 * Tests the support of PHP 8.4 property hooks.
 *
 * @author    PHPCSStandards contributors <phpcs@phpcodesniffer.com>
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Tests the support of PHP 8.4 property hooks.
 *
 * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
 */
final class BackfillPropertyHookTest extends AbstractTokenizerTestCase
{


    /**
     * Test that long-form get/set hooks are tokenized as scope openers.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     * @param string $tokenType  The expected token type.
     * @param string $openerType The expected scope opener token type.
     * @param string $closerType The expected scope closer token type.
     *
     * @dataProvider    dataPropertyHooks
     * @outputBuffering disabled
     *
     * @return void
     */
    public function testPropertyHookHasScope($testMarker, $tokenType, $openerType, $closerType)
    {
        $tokens = $this->phpcsFile->getTokens();
        $hook   = $this->getTargetToken($testMarker, constant($tokenType));

        $this->assertSame($tokenType, $tokens[$hook]['type']);
        $this->assertArrayHasKey('scope_opener', $tokens[$hook]);
        $this->assertArrayHasKey('scope_closer', $tokens[$hook]);

        $opener = $tokens[$hook]['scope_opener'];
        $closer = $tokens[$hook]['scope_closer'];

        $this->assertSame(constant($openerType), $tokens[$opener]['code']);
        $this->assertSame(constant($closerType), $tokens[$closer]['code']);
        $this->assertSame($hook, $tokens[$opener]['scope_condition']);
        $this->assertSame($hook, $tokens[$closer]['scope_condition']);
    }


    /**
     * Test that a property with hooks remains a normal T_VARIABLE for existing APIs.
     *
     * @return void
     */
    public function testHookedPropertyRemainsVariable()
    {
        $tokens   = $this->phpcsFile->getTokens();
        $property = $this->getTargetToken('/* testHookedProperty */', T_VARIABLE);
        $promoted = $this->getTargetToken('/* testPromotedHookedProperty */', T_VARIABLE);

        $this->assertSame(T_VARIABLE, $tokens[$property]['code']);
        $this->assertSame('T_VARIABLE', $tokens[$property]['type']);
        $this->assertSame(T_VARIABLE, $tokens[$promoted]['code']);
        $this->assertSame('T_VARIABLE', $tokens[$promoted]['type']);
    }


    /**
     * Data provider.
     *
     * @see testPropertyHookHasScope()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataPropertyHooks()
    {
        return [
            'get hook'                        => [
                'testMarker' => '/* testGetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_GET',
                'openerType' => 'T_OPEN_CURLY_BRACKET',
                'closerType' => 'T_CLOSE_CURLY_BRACKET',
            ],
            'set hook'                        => [
                'testMarker' => '/* testSetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_SET',
                'openerType' => 'T_OPEN_CURLY_BRACKET',
                'closerType' => 'T_CLOSE_CURLY_BRACKET',
            ],
            'set hook with default parameter' => [
                'testMarker' => '/* testSetHookDefaultParam */',
                'tokenType'  => 'T_PROPERTY_HOOK_SET',
                'openerType' => 'T_OPEN_CURLY_BRACKET',
                'closerType' => 'T_CLOSE_CURLY_BRACKET',
            ],
            'short get hook'                  => [
                'testMarker' => '/* testShortGetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_GET',
                'openerType' => 'T_DOUBLE_ARROW',
                'closerType' => 'T_SEMICOLON',
            ],
            'short set hook'                  => [
                'testMarker' => '/* testShortSetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_SET',
                'openerType' => 'T_DOUBLE_ARROW',
                'closerType' => 'T_SEMICOLON',
            ],
            'reference get hook'              => [
                'testMarker' => '/* testReferenceGetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_GET',
                'openerType' => 'T_OPEN_CURLY_BRACKET',
                'closerType' => 'T_CLOSE_CURLY_BRACKET',
            ],
            'short reference get hook'        => [
                'testMarker' => '/* testShortReferenceGetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_GET',
                'openerType' => 'T_DOUBLE_ARROW',
                'closerType' => 'T_SEMICOLON',
            ],
            'promoted short get hook'         => [
                'testMarker' => '/* testPromotedShortGetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_GET',
                'openerType' => 'T_DOUBLE_ARROW',
                'closerType' => 'T_SEMICOLON',
            ],
            'promoted set hook'               => [
                'testMarker' => '/* testPromotedSetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_SET',
                'openerType' => 'T_OPEN_CURLY_BRACKET',
                'closerType' => 'T_CLOSE_CURLY_BRACKET',
            ],
            'promoted reference get hook'     => [
                'testMarker' => '/* testPromotedReferenceGetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_GET',
                'openerType' => 'T_DOUBLE_ARROW',
                'closerType' => 'T_SEMICOLON',
            ],
        ];
    }


    /**
     * Test that abstract/interface property hooks without bodies are tokenized without scope.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     * @param string $tokenType  The expected token type.
     *
     * @dataProvider dataBodylessPropertyHooks
     *
     * @return void
     */
    public function testBodylessPropertyHookHasNoScope($testMarker, $tokenType)
    {
        $tokens = $this->phpcsFile->getTokens();
        $hook   = $this->getTargetToken($testMarker, constant($tokenType));

        $this->assertSame($tokenType, $tokens[$hook]['type']);
        $this->assertArrayNotHasKey('scope_opener', $tokens[$hook]);
        $this->assertArrayNotHasKey('scope_closer', $tokens[$hook]);
    }


    /**
     * Data provider.
     *
     * @see testBodylessPropertyHookHasNoScope()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataBodylessPropertyHooks()
    {
        return [
            'interface get hook' => [
                'testMarker' => '/* testInterfaceGetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_GET',
            ],
            'interface set hook' => [
                'testMarker' => '/* testInterfaceSetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_SET',
            ],
            'abstract get hook'  => [
                'testMarker' => '/* testAbstractGetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_GET',
            ],
            'abstract set hook'  => [
                'testMarker' => '/* testAbstractSetHook */',
                'tokenType'  => 'T_PROPERTY_HOOK_SET',
            ],
        ];
    }


    /**
     * Test that a long-form set hook owns its parameter parentheses.
     *
     * @return void
     */
    public function testSetHookHasParentheses()
    {
        $tokens = $this->phpcsFile->getTokens();
        $set    = $this->getTargetToken('/* testSetHook */', T_PROPERTY_HOOK_SET);

        $this->assertArrayHasKey('parenthesis_opener', $tokens[$set]);
        $this->assertArrayHasKey('parenthesis_closer', $tokens[$set]);

        $opener = $tokens[$set]['parenthesis_opener'];
        $closer = $tokens[$set]['parenthesis_closer'];

        $this->assertSame(T_OPEN_PARENTHESIS, $tokens[$opener]['code']);
        $this->assertSame(T_CLOSE_PARENTHESIS, $tokens[$closer]['code']);
        $this->assertSame($set, $tokens[$opener]['parenthesis_owner']);
        $this->assertSame($set, $tokens[$closer]['parenthesis_owner']);
    }


    /**
     * Test that a by-reference get hook is preceded by the reference token.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataReferenceGetHooks
     *
     * @return void
     */
    public function testReferenceGetHook($testMarker)
    {
        $tokens = $this->phpcsFile->getTokens();
        $get    = $this->getTargetToken($testMarker, T_PROPERTY_HOOK_GET);

        $before = $this->phpcsFile->findPrevious(Tokens::EMPTY_TOKENS, ($get - 1), null, true);

        $this->assertSame(T_BITWISE_AND, $tokens[$before]['code']);
    }


    /**
     * Data provider.
     *
     * @see testReferenceGetHook()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataReferenceGetHooks()
    {
        return [
            'reference get hook'          => [
                'testMarker' => '/* testReferenceGetHook */',
            ],
            'short reference get hook'    => [
                'testMarker' => '/* testShortReferenceGetHook */',
            ],
            'promoted reference get hook' => [
                'testMarker' => '/* testPromotedReferenceGetHook */',
            ],
        ];
    }


    /**
     * Test that normal properties and function calls are not retokenized as property hooks.
     *
     * @return void
     */
    public function testNonHookSyntaxIsLeftAlone()
    {
        $tokens   = $this->phpcsFile->getTokens();
        $property = $this->getTargetToken('/* testPropertyWithoutHooks */', T_VARIABLE);
        $call     = $this->getTargetToken('/* testSetFunctionCall */', T_STRING, 'set');
        $matchArm = $this->getTargetToken('/* testMatchSetArm */', T_STRING, 'set');
        $hookGet  = $this->getTargetToken('/* testGetFunctionCallInsideHook */', T_STRING, 'get');
        $hookSet  = $this->getTargetToken('/* testSetFunctionCallInsideHook */', T_STRING, 'set');
        $hookArm  = $this->getTargetToken('/* testMatchSetArmInsideHook */', T_STRING, 'set');

        $this->assertSame(T_VARIABLE, $tokens[$property]['code']);
        $this->assertSame(T_STRING, $tokens[$call]['code']);
        $this->assertSame(T_STRING, $tokens[$matchArm]['code']);
        $this->assertSame(T_STRING, $tokens[$hookGet]['code']);
        $this->assertSame(T_STRING, $tokens[$hookSet]['code']);
        $this->assertSame(T_STRING, $tokens[$hookArm]['code']);
    }


    /**
     * Test that tokens inside property hooks are scoped to the hook.
     *
     * @return void
     */
    public function testTokensInsidePropertyHooksHaveHookCondition()
    {
        $tokens = $this->phpcsFile->getTokens();

        $getHook      = $this->getTargetToken('/* testGetHook */', T_PROPERTY_HOOK_GET);
        $getCall      = $this->getTargetToken('/* testGetFunctionCallInsideHook */', T_STRING, 'get');
        $setHook      = $this->getTargetToken('/* testSetHook */', T_PROPERTY_HOOK_SET);
        $setCall      = $this->getTargetToken('/* testSetFunctionCallInsideHook */', T_STRING, 'set');
        $shortSetHook = $this->getTargetToken('/* testShortSetHook */', T_PROPERTY_HOOK_SET);
        $matchArm     = $this->getTargetToken('/* testMatchSetArmInsideHook */', T_STRING, 'set');

        $this->assertSame(T_PROPERTY_HOOK_GET, $tokens[$getCall]['conditions'][$getHook]);
        $this->assertSame(T_PROPERTY_HOOK_SET, $tokens[$setCall]['conditions'][$setHook]);
        $this->assertSame(T_PROPERTY_HOOK_SET, $tokens[$matchArm]['conditions'][$shortSetHook]);
    }
}
