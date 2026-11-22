<?php
/**
 * Tests converting enum "case" to T_ENUM_CASE.
 *
 * @author    Jaroslav Hanslík <kukulich@kukulich.cz>
 * @copyright 2021-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Util\Tokens;
use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;

final class EnumCaseTest extends AbstractTokenizerTestCase
{


    /**
     * Test that the enum "case" is converted to T_ENUM_CASE.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataEnumCases
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testEnumCases($testMarker)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $enumCase   = $this->getTargetToken($testMarker, [T_ENUM_CASE, T_CASE]);
        $tokenArray = $tokens[$enumCase];

        $this->assertSame(T_ENUM_CASE, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_ENUM_CASE (code)');
        $this->assertSame('T_ENUM_CASE', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_ENUM_CASE (type)');

        // Also make sure that the name for the enum case is always tokenized as T_STRING, even when it is a keyword.
        $nextNonEmpty = $this->phpcsFile->findNext(Tokens::EMPTY_TOKENS, ($enumCase + 1), null, true);
        $tokenArray   = $tokens[$nextNonEmpty];

        $this->assertSame(T_STRING, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING (code)');
        $this->assertSame('T_STRING', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING (type)');
    }


    /**
     * Data provider.
     *
     * @see testEnumCases()
     *
     * @return array<string, array<string>>
     */
    public static function dataEnumCases()
    {
        return [
            'enum case, no value'                                        => ['/* testPureEnumCase */'],
            'enum case, integer value'                                   => ['/* testBackingIntegerEnumCase */'],
            'enum case, string value'                                    => ['/* testBackingStringEnumCase */'],
            'enum case, integer value in more complex enum'              => ['/* testEnumCaseInComplexEnum */'],
            'enum case, keyword in mixed case'                           => ['/* testEnumCaseIsCaseInsensitive */'],
            'enum case, after switch statement'                          => ['/* testEnumCaseAfterSwitch */'],
            'enum case, after switch statement using alternative syntax' => ['/* testEnumCaseAfterSwitchWithEndSwitch */'],
            'enum case, nested in alt syntax switch 1'                   => ['/* testEnumCaseNestedInAltSyntaxSwitch1 */'],
            'enum case, nested in alt syntax switch 2'                   => ['/* testEnumCaseNestedInAltSyntaxSwitch2 */'],
            'enum case, nested in switch 1'                              => ['/* testEnumCaseNestedInSwitch1 */'],
            'enum case, nested in switch 2'                              => ['/* testEnumCaseNestedInSwitch2 */'],
            'enum case, "interface" as case name'                        => ['/* testKeywordAsEnumCaseNameShouldBeString1 */'],
            'enum case, "trait" as case name'                            => ['/* testKeywordAsEnumCaseNameShouldBeString2 */'],
            'enum case, "enum" as case name'                             => ['/* testKeywordAsEnumCaseNameShouldBeString3 */'],
            'enum case, "function" as case name'                         => ['/* testKeywordAsEnumCaseNameShouldBeString4 */'],
            'enum case, "false" as case name'                            => ['/* testKeywordAsEnumCaseNameShouldBeString5 */'],
            'enum case, "default" as case name'                          => ['/* testKeywordAsEnumCaseNameShouldBeString6 */'],
            'enum case, "array" as case name'                            => ['/* testKeywordAsEnumCaseNameShouldBeString7 */'],
            'enum case, "exit" as case name'                             => ['/* testKeywordAsEnumCaseNameShouldBeString8 */'],
        ];
    }


    /**
     * Test that "case" that is not enum case is still tokenized as `T_CASE`.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataNotEnumCases
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::tokenize
     *
     * @return void
     */
    public function testNotEnumCases($testMarker)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $case       = $this->getTargetToken($testMarker, [T_ENUM_CASE, T_CASE]);
        $tokenArray = $tokens[$case];

        $this->assertSame(T_CASE, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_CASE (code)');
        $this->assertSame('T_CASE', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_CASE (type)');
    }


    /**
     * Data provider.
     *
     * @see testNotEnumCases()
     *
     * @return array<string, array<string>>
     */
    public static function dataNotEnumCases()
    {
        return [
            'switch case with constant, semicolon condition end'      => ['/* testCaseWithSemicolonIsNotEnumCase */'],
            'alternative syntax switch case in enum method'           => ['/* testCaseInAlternativeSwitchInEnumIsNotEnumCase */'],
            'switch case with constant, colon condition end'          => ['/* testCaseWithConstantIsNotEnumCase */'],
            'switch case with constant, comparison'                   => ['/* testCaseWithConstantAndIdenticalIsNotEnumCase */'],
            'switch case, assignment'                                 => ['/* testCaseWithAssigmentIsNotEnumCase */'],
            'switch case with constant, keyword in mixed case'        => ['/* testIsNotEnumCaseIsCaseInsensitive */'],
            'switch case with constant, curlies condition end'        => ['/* testIsNotEnumCaseWithCurlies */'],
            'switch case with constant, semicolon + curlies'          => ['/* testIsNotEnumCaseWithSemicolonAndCurlies */'],
            'switch case with constant, php close tag condition end'  => ['/* testIsNotEnumCaseWithCloseTag */'],
            'alternative syntax switch case, colon condition end'     => ['/* testCaseInAlternativeSwitchIsNotEnumCase */'],
            'alternative syntax switch case, semicolon condition end' => ['/* testCaseInAlternativeSwitchWithSemicolonIsNotEnumCase */'],
            'switch case, body in curlies declares enum'              => ['/* testCaseInSwitchWhenCreatingEnumInSwitch1 */'],
            'switch case, body after semicolon declares enum'         => ['/* testCaseInSwitchWhenCreatingEnumInSwitch2 */'],
        ];
    }
}
