<?php
/**
 * Tests the support of PHP 8.1 "readonly" keyword.
 *
 * @author    Jaroslav Hanslík <kukulich@kukulich.cz>
 * @copyright 2021 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizer;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;

final class BackfillReadonlyTest extends AbstractMethodUnitTest
{


    /**
     * Test that the "readonly" keyword is tokenized as such.
     *
     * @param string $testMarker  The comment which prefaces the target token in the test file.
     * @param string $testContent Optional. The token content to look for.
     *                            Defaults to lowercase "readonly".
     *
     * @dataProvider dataReadonly
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::processAdditional
     *
     * @return void
     */
    public function testReadonly($testMarker, $testContent='readonly')
    {
        $tokens = self::$phpcsFile->getTokens();

        $target = $this->getTargetToken($testMarker, [T_READONLY, T_STRING], $testContent);
        $this->assertSame(T_READONLY, $tokens[$target]['code']);
        $this->assertSame('T_READONLY', $tokens[$target]['type']);

    }//end testReadonly()


    /**
     * Data provider.
     *
     * @see testReadonly()
     *
     * @return array
     */
    public static function dataReadonly()
    {
        return [
            [
                '/* testReadonlyProperty */',
            ],
            [
                '/* testVarReadonlyProperty */',
            ],
            [
                '/* testReadonlyVarProperty */',
            ],
            [
                '/* testStaticReadonlyProperty */',
            ],
            [
                '/* testReadonlyStaticProperty */',
            ],
            [
                '/* testConstReadonlyProperty */',
            ],
            [
                '/* testReadonlyPropertyWithoutType */',
            ],
            [
                '/* testPublicReadonlyProperty */',
            ],
            [
                '/* testProtectedReadonlyProperty */',
            ],
            [
                '/* testPrivateReadonlyProperty */',
            ],
            [
                '/* testPublicReadonlyPropertyWithReadonlyFirst */',
            ],
            [
                '/* testProtectedReadonlyPropertyWithReadonlyFirst */',
            ],
            [
                '/* testPrivateReadonlyPropertyWithReadonlyFirst */',
            ],
            [
                '/* testReadonlyWithCommentsInDeclaration */',
            ],
            [
                '/* testReadonlyWithNullableProperty */',
            ],
            [
                '/* testReadonlyNullablePropertyWithUnionTypeHintAndNullFirst */',
            ],
            [
                '/* testReadonlyNullablePropertyWithUnionTypeHintAndNullLast */',
            ],
            [
                '/* testReadonlyPropertyWithArrayTypeHint */',
            ],
            [
                '/* testReadonlyPropertyWithSelfTypeHint */',
            ],
            [
                '/* testReadonlyPropertyWithParentTypeHint */',
            ],
            [
                '/* testReadonlyPropertyWithFullyQualifiedTypeHint */',
            ],
            [
                '/* testReadonlyIsCaseInsensitive */',
                'ReAdOnLy',
            ],
            [
                '/* testReadonlyConstructorPropertyPromotion */',
            ],
            [
                '/* testReadonlyConstructorPropertyPromotionWithReference */',
                'ReadOnly',
            ],
            [
                '/* testReadonlyPropertyInAnonymousClass */',
            ],
            [
                '/* testReadonlyPropertyDNFTypeUnqualified */',
            ],
            [
                '/* testReadonlyPropertyDNFTypeFullyQualified */',
            ],
            [
                '/* testReadonlyPropertyDNFTypePartiallyQualified */',
            ],
            [
                '/* testReadonlyPropertyDNFTypeRelativeName */',
            ],
            [
                '/* testReadonlyPropertyDNFTypeMultipleSets */',
            ],
            [
                '/* testReadonlyPropertyDNFTypeWithArray */',
            ],
            [
                '/* testReadonlyPropertyDNFTypeWithSpacesAndComments */',
            ],
            [
                '/* testReadonlyConstructorPropertyPromotionWithDNF */',
            ],
            [
                '/* testReadonlyConstructorPropertyPromotionWithDNFAndReference */',
            ],
            [
                '/* testParseErrorLiveCoding */',
            ],
        ];

    }//end dataReadonly()


    /**
     * Test that "readonly" when not used as the keyword is still tokenized as `T_STRING`.
     *
     * @param string $testMarker  The comment which prefaces the target token in the test file.
     * @param string $testContent Optional. The token content to look for.
     *                            Defaults to lowercase "readonly".
     *
     * @dataProvider dataNotReadonly
     * @covers       PHP_CodeSniffer\Tokenizers\PHP::processAdditional
     *
     * @return void
     */
    public function testNotReadonly($testMarker, $testContent='readonly')
    {
        $tokens = self::$phpcsFile->getTokens();

        $target = $this->getTargetToken($testMarker, [T_READONLY, T_STRING, T_NAME_QUALIFIED], $testContent);
        if ($tokens[$target]['code'] !== T_NAME_QUALIFIED) {
            $this->assertSame(T_STRING, $tokens[$target]['code']);
            $this->assertSame('T_STRING', $tokens[$target]['type']);
        }

    }//end testNotReadonly()


    /**
     * Data provider.
     *
     * @see testNotReadonly()
     *
     * @return array
     */
    public static function dataNotReadonly()
    {
        return [
            [
                '/* testReadonlyUsedAsClassConstantName */',
                'READONLY',
            ],
            [
                '/* testReadonlyUsedAsMethodName */',
            ],
            [
                '/* testReadonlyUsedAsPropertyName */',
            ],
            [
                '/* testReadonlyPropertyInTernaryOperator */',
            ],
            [
                '/* testReadonlyUsedAsFunctionName */',
            ],
            [
                '/* testReadonlyUsedAsFunctionNameWithReturnByRef */',
            ],
            [
                '/* testReadonlyUsedAsNamespaceName */',
                'Readonly',
            ],
            [
                '/* testReadonlyUsedAsPartOfNamespaceName */',
                'My\Readonly\Collection',
            ],
            [
                '/* testReadonlyAsFunctionCall */',
            ],
            [
                '/* testReadonlyAsNamespacedFunctionCall */',
                'My\NS\readonly',
            ],
            [
                '/* testReadonlyAsMethodCall */',
            ],
            [
                '/* testReadonlyAsNullsafeMethodCall */',
                'readOnly',
            ],
            [
                '/* testReadonlyAsStaticMethodCallWithSpace */',
            ],
            [
                '/* testClassConstantFetchWithReadonlyAsConstantName */',
                'READONLY',
            ],
            [
                '/* testReadonlyUsedAsFunctionCallWithSpaceBetweenKeywordAndParens */',
            ],
            [
                '/* testReadonlyUsedAsMethodNameWithDNFParam */',
            ],
        ];

    }//end dataNotReadonly()


}//end class
