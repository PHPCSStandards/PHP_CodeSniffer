<?php
/**
 * Tests for the \PHP_CodeSniffer\Util\Tokens::tokenName() method.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\Tokens;

use PHP_CodeSniffer\Util\Tokens;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the \PHP_CodeSniffer\Util\Tokens::tokenName() method.
 *
 * @covers \PHP_CodeSniffer\Util\Tokens::tokenName
 */
final class TokenNameTest extends TestCase
{


    /**
     * Test the method.
     *
     * @param int|string $tokenCode The PHP/PHPCS token code to get the name for.
     * @param string     $expected  The expected token name.
     *
     * @dataProvider dataTokenName
     * @dataProvider dataPolyfilledPHPNativeTokens
     *
     * @return void
     */
    public function testTokenName($tokenCode, $expected)
    {
        $this->assertSame($expected, Tokens::tokenName($tokenCode));
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, int|string>>
     */
    public static function dataTokenName()
    {
        return [
            'PHP native token: T_ECHO'            => [
                'tokenCode' => T_ECHO,
                'expected'  => 'T_ECHO',
            ],
            'PHP native token: T_FUNCTION'        => [
                'tokenCode' => T_FUNCTION,
                'expected'  => 'T_FUNCTION',
            ],
            'PHPCS native token: T_CLOSURE'       => [
                'tokenCode' => T_CLOSURE,
                'expected'  => 'T_CLOSURE',
            ],
            'PHPCS native token: T_STRING_CONCAT' => [
                'tokenCode' => T_STRING_CONCAT,
                'expected'  => 'T_STRING_CONCAT',
            ],

            // Document the current behaviour for invalid input.
            // This behaviour is subject to change.
            'Non-token integer passed'            => [
                'tokenCode' => 100000,
                'expected'  => 'UNKNOWN',
            ],
            'Non-token string passed'             => [
                'tokenCode' => 'something',
                'expected'  => 'ing',
            ],
        ];
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, int|string>>
     */
    public static function dataPolyfilledPHPNativeTokens()
    {
        return [
            'PHP 7.4 native token, polyfilled: T_COALESCE_EQUAL'                          => [
                'tokenCode' => T_COALESCE_EQUAL,
                'expected'  => 'T_COALESCE_EQUAL',
            ],
            'PHP 7.4 native token, polyfilled: T_BAD_CHARACTER'                           => [
                'tokenCode' => T_BAD_CHARACTER,
                'expected'  => 'T_BAD_CHARACTER',
            ],
            'PHP 7.4 native token, polyfilled: T_FN'                                      => [
                'tokenCode' => T_FN,
                'expected'  => 'T_FN',
            ],

            'PHP 8.0 native token, polyfilled: T_NULLSAFE_OBJECT_OPERATOR'                => [
                'tokenCode' => T_NULLSAFE_OBJECT_OPERATOR,
                'expected'  => 'T_NULLSAFE_OBJECT_OPERATOR',
            ],
            'PHP 8.0 native token, polyfilled: T_NAME_QUALIFIED'                          => [
                'tokenCode' => T_NAME_QUALIFIED,
                'expected'  => 'T_NAME_QUALIFIED',
            ],
            'PHP 8.0 native token, polyfilled: T_NAME_FULLY_QUALIFIED'                    => [
                'tokenCode' => T_NAME_FULLY_QUALIFIED,
                'expected'  => 'T_NAME_FULLY_QUALIFIED',
            ],
            'PHP 8.0 native token, polyfilled: T_NAME_RELATIVE'                           => [
                'tokenCode' => T_NAME_RELATIVE,
                'expected'  => 'T_NAME_RELATIVE',
            ],
            'PHP 8.0 native token, polyfilled: T_MATCH'                                   => [
                'tokenCode' => T_MATCH,
                'expected'  => 'T_MATCH',
            ],
            'PHP 8.0 native token, polyfilled: T_ATTRIBUTE'                               => [
                'tokenCode' => T_ATTRIBUTE,
                'expected'  => 'T_ATTRIBUTE',
            ],

            'PHP 8.1 native token, polyfilled: T_AMPERSAND_FOLLOWED_BY_VAR_OR_VARARG'     => [
                'tokenCode' => T_AMPERSAND_FOLLOWED_BY_VAR_OR_VARARG,
                'expected'  => 'T_AMPERSAND_FOLLOWED_BY_VAR_OR_VARARG',
            ],
            'PHP 8.1 native token, polyfilled: T_AMPERSAND_NOT_FOLLOWED_BY_VAR_OR_VARARG' => [
                'tokenCode' => T_AMPERSAND_NOT_FOLLOWED_BY_VAR_OR_VARARG,
                'expected'  => 'T_AMPERSAND_NOT_FOLLOWED_BY_VAR_OR_VARARG',
            ],
            'PHP 8.1 native token, polyfilled: T_READONLY'                                => [
                'tokenCode' => T_READONLY,
                'expected'  => 'T_READONLY',
            ],
            'PHP 8.1 native token, polyfilled: T_ENUM'                                    => [
                'tokenCode' => T_ENUM,
                'expected'  => 'T_ENUM',
            ],

            'PHP 8.4 native token, polyfilled: T_PUBLIC_SET'                              => [
                'tokenCode' => T_PUBLIC_SET,
                'expected'  => 'T_PUBLIC_SET',
            ],
            'PHP 8.4 native token, polyfilled: T_PROTECTED_SET'                           => [
                'tokenCode' => T_PROTECTED_SET,
                'expected'  => 'T_PROTECTED_SET',
            ],
            'PHP 8.4 native token, polyfilled: T_PRIVATE_SET'                             => [
                'tokenCode' => T_PRIVATE_SET,
                'expected'  => 'T_PRIVATE_SET',
            ],
        ];
    }
}
