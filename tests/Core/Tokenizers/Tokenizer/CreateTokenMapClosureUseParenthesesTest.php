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
final class CreateTokenMapClosureUseParenthesesTest extends AbstractTokenizerTestCase
{


    /**
     * Test that a non-closure use token does not get assigned the parenthesis_... indexes.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataUseNotClosure
     *
     * @return void
     */
    public function testUseNotClosure($testMarker)
    {
        $tokens = $this->phpcsFile->getTokens();

        $use = $this->getTargetToken($testMarker, T_USE);
        $this->assertArrayNotHasKey('parenthesis_owner', $tokens[$use], 'parenthesis_owner key is set');
        $this->assertArrayNotHasKey('parenthesis_opener', $tokens[$use], 'parenthesis_opener key is set');
        $this->assertArrayNotHasKey('parenthesis_closer', $tokens[$use], 'parenthesis_closer key is set');
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string>>
     */
    public static function dataUseNotClosure()
    {
        return [
            'Plain import use statement'                    => [
                'testMarker' => '/* testUseImportSimple */',
            ],
            'Import use statement with group'               => [
                'testMarker' => '/* testUseImportGroup */',
            ],
            'Trait use statement'                           => [
                'testMarker' => '/* testUseTrait */',
            ],
            'Trait use statement in nested anonymous class' => [
                'testMarker' => '/* testUseTraitInNestedAnonClass */',
            ],
        ];
    }


    /**
     * Test that the next open/close parenthesis after a non-closure use token
     * do not get assigned the use keyword as a parenthesis owner.
     *
     * @param string   $testMarker        The comment which prefaces the target token in the test file.
     * @param int|null $expectedOwnerCode Optional. If an owner is expected for the parentheses, the token
     *                                    constant which is expected as the 'code'.
     *                                    If left at the default (null), the parentheses will be tested to
     *                                    *not* have an owner.
     *
     * @dataProvider dataUseNotClosureNextOpenClose
     *
     * @return void
     */
    public function testUseNotClosureNextOpenClose($testMarker, $expectedOwnerCode = null)
    {
        $tokens = $this->phpcsFile->getTokens();
        $opener = $this->getTargetToken($testMarker, T_OPEN_PARENTHESIS);
        $closer = $this->getTargetToken($testMarker, T_CLOSE_PARENTHESIS);

        $this->assertArrayHasKey('parenthesis_opener', $tokens[$opener], 'Opener does not have "parenthesis_opener" key');
        $this->assertArrayHasKey('parenthesis_closer', $tokens[$opener], 'Opener does not have "parenthesis_closer" key');
        $this->assertSame($opener, $tokens[$opener]['parenthesis_opener'], 'Opener "parenthesis_opener" key set incorrectly');
        $this->assertSame($closer, $tokens[$opener]['parenthesis_closer'], 'Opener "parenthesis_closer" key set incorrectly');

        $this->assertArrayHasKey('parenthesis_opener', $tokens[$closer], 'Closer does not have "parenthesis_opener" key');
        $this->assertArrayHasKey('parenthesis_closer', $tokens[$closer], 'Closer does not have "parenthesis_closer" key');
        $this->assertSame($opener, $tokens[$closer]['parenthesis_opener'], 'Closer "parenthesis_opener" key set incorrectly');
        $this->assertSame($closer, $tokens[$closer]['parenthesis_closer'], 'Closer "parenthesis_closer" key set incorrectly');

        if ($expectedOwnerCode === null) {
            $this->assertArrayNotHasKey('parenthesis_owner', $tokens[$opener], 'Opener has unexpected "parenthesis_owner" key');
            $this->assertArrayNotHasKey('parenthesis_owner', $tokens[$closer], 'Closer has unexpected "parenthesis_owner" key');
        } else {
            $this->assertArrayHasKey('parenthesis_owner', $tokens[$opener], 'Opener does not have "parenthesis_owner" key');
            $this->assertArrayHasKey('parenthesis_owner', $tokens[$closer], 'Closer does not have "parenthesis_owner" key');

            $expectedOwner = $this->getTargetToken($testMarker, $expectedOwnerCode);

            $this->assertSame(
                $expectedOwner,
                $tokens[$opener]['parenthesis_owner'],
                'Opener "parenthesis_owner" key set to unexpected owner'
            );
            $this->assertSame(
                $expectedOwner,
                $tokens[$closer]['parenthesis_owner'],
                'Closer "parenthesis_owner" key set to unexpected owner'
            );
        }
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|int>>
     */
    public static function dataUseNotClosureNextOpenClose()
    {
        $data = self::dataUseNotClosure();

        // Enhance data set for one particular test case.
        $data['Trait use statement']['expectedOwnerCode'] = T_FUNCTION;

        return $data;
    }


    /**
     * Test that a closure use token gets assigned a parenthesis owner, opener and closer;
     * and that the opener/closer get the closure use token assigned as owner.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataClosureUse
     *
     * @return void
     */
    public function testClosureUse($testMarker)
    {
        $tokens = $this->phpcsFile->getTokens();
        $use    = $this->getTargetToken($testMarker, T_USE);
        $opener = $this->getTargetToken($testMarker, T_OPEN_PARENTHESIS);
        $closer = $this->getTargetToken($testMarker, T_CLOSE_PARENTHESIS);

        $this->assertArrayHasKey('parenthesis_owner', $tokens[$use], 'Use token does not have "parenthesis_owner" key');
        $this->assertArrayHasKey('parenthesis_opener', $tokens[$use], 'Use token does not have "parenthesis_opener" key');
        $this->assertArrayHasKey('parenthesis_closer', $tokens[$use], 'Use token does not have "parenthesis_closer" key');
        $this->assertSame($use, $tokens[$use]['parenthesis_owner'], 'Use token "parenthesis_owner" key set incorrectly');
        $this->assertSame($opener, $tokens[$use]['parenthesis_opener'], 'Use token "parenthesis_opener" key set incorrectly');
        $this->assertSame($closer, $tokens[$use]['parenthesis_closer'], 'Use token "parenthesis_closer" key set incorrectly');

        $this->assertArrayHasKey('parenthesis_owner', $tokens[$opener], 'Opener does not have "parenthesis_owner" key');
        $this->assertArrayHasKey('parenthesis_opener', $tokens[$opener], 'Opener does not have "parenthesis_opener" key');
        $this->assertArrayHasKey('parenthesis_closer', $tokens[$opener], 'Opener does not have "parenthesis_closer" key');
        $this->assertSame($use, $tokens[$opener]['parenthesis_owner'], 'Opener "parenthesis_owner" key set incorrectly');
        $this->assertSame($opener, $tokens[$opener]['parenthesis_opener'], 'Opener "parenthesis_opener" key set incorrectly');
        $this->assertSame($closer, $tokens[$opener]['parenthesis_closer'], 'Opener "parenthesis_closer" key set incorrectly');

        $this->assertArrayHasKey('parenthesis_owner', $tokens[$closer], 'Closer does not have "parenthesis_owner" key');
        $this->assertArrayHasKey('parenthesis_opener', $tokens[$closer], 'Closer does not have "parenthesis_opener" key');
        $this->assertArrayHasKey('parenthesis_closer', $tokens[$closer], 'Closer does not have "parenthesis_closer" key');
        $this->assertSame($use, $tokens[$closer]['parenthesis_owner'], 'Closer "parenthesis_owner" key set incorrectly');
        $this->assertSame($opener, $tokens[$closer]['parenthesis_opener'], 'Closer "parenthesis_opener" key set incorrectly');
        $this->assertSame($closer, $tokens[$closer]['parenthesis_closer'], 'Closer "parenthesis_closer" key set incorrectly');
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string>>
     */
    public static function dataClosureUse()
    {
        return [
            'Plain closure use'           => ['/* testClosureUse */'],
            'Closure use nested in class' => ['/* testClosureUseNestedInClass */'],
        ];
    }
}
