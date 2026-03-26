<?php
/**
 * Tests for the \PHP_CodeSniffer\Util\Common::isCamelCaps method.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\Common;

use PHP_CodeSniffer\Util\Common;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the \PHP_CodeSniffer\Util\Common::isCamelCaps method.
 *
 * @covers \PHP_CodeSniffer\Util\Common::isCamelCaps
 */
final class IsCamelCapsTest extends TestCase
{


    /**
     * Test valid public function/method names.
     *
     * @param string $name   The tested name.
     * @param bool   $strict Value of the $strict flag.
     *
     * @dataProvider dataValidNotClassFormatPublic
     *
     * @return void
     */
    public function testValidNotClassFormatPublic($name, $strict)
    {
        $this->assertTrue(Common::isCamelCaps($name, false, true, $strict));
    }


    /**
     * Data provider.
     *
     * @see testValidNotClassFormatPublic()
     *
     * @return array<string, array<string, string|bool>>
     */
    public static function dataValidNotClassFormatPublic()
    {
        return [
            'lower camelCase string in strict mode'               => [
                'name'   => 'thisIsCamelCaps',
                'strict' => true,
            ],
            'lower camelCase string with acronym in relaxed mode' => [
                'name'   => 'thisISCamelCaps',
                'strict' => false,
            ],
            'lower camelCase string with initial acronym'         => [
                'name'   => 'ISThisCamelCaps',
                'strict' => false,
            ],
        ];
    }


    /**
     * Test invalid public function/method names.
     *
     * @param string $name The tested name.
     *
     * @dataProvider dataInvalidNotClassFormatPublic
     *
     * @return void
     */
    public function testInvalidNotClassFormatPublic($name)
    {
        $this->assertFalse(Common::isCamelCaps($name, false, true, true));
    }


    /**
     * Data provider.
     *
     * @see testInvalidNotClassFormatPublic()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataInvalidNotClassFormatPublic()
    {
        return [
            'string with initial underscore (invalid when $public is true)'              => [
                'name' => '_thisIsCamelCaps',
            ],
            'lower camelCase string with acronym (invalid when $strict is true)'         => [
                'name' => 'thisISCamelCaps',
            ],
            'lower camelCase string with initial acronym (invalid when $strict is true)' => [
                'name' => 'ISThisCamelCaps',
            ],
            'PascalCase string'                                                          => [
                'name' => 'ThisIsCamelCaps',
            ],
            'lower camelCase string with initial digit'                                  => [
                'name' => '3thisIsCamelCaps',
            ],
            'lower camelCase string with initial illegal character: *'                   => [
                'name' => '*thisIsCamelCaps',
            ],
            'lower camelCase string with initial illegal character: -'                   => [
                'name' => '-thisIsCamelCaps',
            ],
            'lower camelCase string with initial illegal character: é'                   => [
                'name' => 'éCamelCaps',
            ],
            'lower camelCase string with medial illegal character: *'                    => [
                'name' => 'this*IsCamelCaps',
            ],
            'lower camelCase string with medial illegal character: -'                    => [
                'name' => 'this-IsCamelCaps',
            ],
            'lower camelCase string with medial illegal character: é'                    => [
                // No camels were harmed in the cspell:disable-next-line.
                'name' => 'thisIsCamélCaps',
            ],
            'lower camelCase string with single medial underscore'                       => [
                'name' => 'this_IsCamelCaps',
            ],
            'snake_case string'                                                          => [
                'name' => 'this_is_camel_caps',
            ],
            'empty string'                                                               => [
                'name' => '',
            ],
        ];
    }


    /**
     * Test valid private method names.
     *
     * @param string $name   The tested name.
     * @param bool   $strict Value of the $strict flag.
     *
     * @dataProvider dataValidNotClassFormatPrivate
     *
     * @return void
     */
    public function testValidNotClassFormatPrivate($name, $strict)
    {
        $this->assertTrue(Common::isCamelCaps($name, false, false, $strict));
    }


    /**
     * Data provider.
     *
     * @see testValidNotClassFormatPrivate()
     *
     * @return array<string, array<string, string|bool>>
     */
    public static function dataValidNotClassFormatPrivate()
    {
        return [
            'lower camelCase string with initial underscore'                        => [
                'name'   => '_thisIsCamelCaps',
                'strict' => true,
            ],
            'lower camelCase string with acronym and initial underscore'            => [
                'name'   => '_thisISCamelCaps',
                'strict' => false,
            ],
            'lower camelCase string with acronym after initial underscore'          => [
                'name'   => '_ISThisCamelCaps',
                'strict' => false,
            ],
            'numeronym with initial underscore and capital after digit'             => [
                'name'   => '_i18N',
                'strict' => true,
            ],
            'numeronym with initial underscore and lowercase character after digit' => [
                'name'   => '_i18n',
                'strict' => true,
            ],
        ];
    }


    /**
     * Test invalid private method names.
     *
     * @param string $name   The tested name.
     * @param bool   $strict Value of the $strict flag.
     *
     * @dataProvider dataInvalidNotClassFormatPrivate
     *
     * @return void
     */
    public function testInvalidNotClassFormatPrivate($name, $strict)
    {
        $this->assertFalse(Common::isCamelCaps($name, false, false, $strict));
    }


    /**
     * Data provider.
     *
     * @see testInvalidNotClassFormatPrivate()
     *
     * @return array<string, array<string, string|bool>>
     */
    public static function dataInvalidNotClassFormatPrivate()
    {
        return [
            'lower camelCase string without initial underscore'                                   => [
                'name'   => 'thisIsCamelCaps',
                'strict' => true,
            ],
            'lower camelCase string with initial underscore, but with an acronym, in strict mode' => [
                'name'   => '_thisISCamelCaps',
                'strict' => true,
            ],
            'PascalCase string with initial underscore'                                           => [
                'name'   => '_ThisIsCamelCaps',
                'strict' => true,
            ],
            'lower camelCase string with two initial underscores'                                 => [
                'name'   => '__thisIsCamelCaps',
                'strict' => true,
            ],
            'lower camelCase string with two initial underscores and acronym in relaxed mode'     => [
                'name'   => '__thisISCamelCaps',
                'strict' => false,
            ],
            'lower camelCase string with initial digit'                                           => [
                'name'   => '3thisIsCamelCaps',
                'strict' => true,
            ],
            'lower camelCase string with initial illegal character: *'                            => [
                'name'   => '*thisIsCamelCaps',
                'strict' => true,
            ],
            'lower camelCase string with initial illegal character: -'                            => [
                'name'   => '-thisIsCamelCaps',
                'strict' => true,
            ],
            'lower camelCase string with initial illegal character: é'                            => [
                'name'   => 'éCamelCaps',
                'strict' => true,
            ],
            'snake_case string with initial underscore'                                           => [
                'name'   => '_this_is_camel_caps',
                'strict' => true,
            ],
            'single underscore'                                                                   => [
                'name'   => '_',
                'strict' => true,
            ],
            'empty string'                                                                        => [
                'name'   => '',
                'strict' => true,
            ],
        ];
    }


    /**
     * Test valid class names.
     *
     * @param string $name   The tested name.
     * @param bool   $strict Value of the $strict flag.
     *
     * @dataProvider dataValidClassFormatPublic
     *
     * @return void
     */
    public function testValidClassFormatPublic($name, $strict)
    {
        $this->assertTrue(Common::isCamelCaps($name, true, true, $strict));
    }


    /**
     * Data provider.
     *
     * @see testValidClassFormatPublic()
     *
     * @return array<string, array<string, string|bool>>
     */
    public static function dataValidClassFormatPublic()
    {
        return [
            'PascalCase string'                          => [
                'name'   => 'ThisIsCamelCaps',
                'strict' => true,
            ],
            'PascalCase string with acronym'             => [
                'name'   => 'ThisISCamelCaps',
                'strict' => false,
            ],
            'PascalCase string with digit between words' => [
                'name'   => 'This3IsCamelCaps',
                'strict' => false,
            ],
            'PascalCase string with digit inside word'   => [
                'name'   => 'Th1sIsCamelCaps',
                'strict' => false,
            ],
            'Single capital (strict)'                    => [
                'name'   => 'A',
                'strict' => true,
            ],
            'Single capital with digit (strict)'         => [
                'name'   => 'A1',
                'strict' => true,
            ],
            'Single capital (relaxed)'                   => [
                'name'   => 'A',
                'strict' => false,
            ],
            'Single capital with digit (relaxed)'        => [
                'name'   => 'A1',
                'strict' => false,
            ],
        ];
    }


    /**
     * Test invalid class names.
     *
     * @param string $name The tested name.
     *
     * @dataProvider dataInvalidClassFormat
     *
     * @return void
     */
    public function testInvalidClassFormat($name)
    {
        $this->assertFalse(Common::isCamelCaps($name, true));
    }


    /**
     * Data provider.
     *
     * @see testInvalidClassFormat()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataInvalidClassFormat()
    {
        return [
            'lower camelCase string'                             => [
                'name' => 'thisIsCamelCaps',
            ],
            'PascalCase string with medial illegal character: -' => [
                'name' => 'This-IsCamelCaps',
            ],
            'capitalised snake case'                             => [
                'name' => 'This_Is_Camel_Caps',
            ],
            'empty string'                                       => [
                'name' => '',
            ],
        ];
    }


    /**
     * Test invalid class names with the "visibilityPublic" flag set.
     *
     * Note that the visibilityPublic flag is ignored if the class format
     * flag is set, so these names are all invalid.
     *
     * @param string $name             The tested name.
     * @param bool   $visibilityPublic Value of the $visibilityPublic flag.
     *
     * @dataProvider dataInvalidClassFormatWithVisibilityPublicFlag
     *
     * @return void
     */
    public function testInvalidClassFormatWithVisibilityPublicFlag($name, $visibilityPublic)
    {
        $this->assertFalse(Common::isCamelCaps($name, true, $visibilityPublic));
    }


    /**
     * Data provider.
     *
     * @see testInvalidClassFormatWithVisibilityPublicFlag()
     *
     * @return array<string, array<string, string|bool>>
     */
    public static function dataInvalidClassFormatWithVisibilityPublicFlag()
    {
        return [
            'PascalCase string with initial underscore (public)'  => [
                'name'             => '_ThisIsCamelCaps',
                'visibilityPublic' => true,
            ],
            'PascalCase string with initial underscore (private)' => [
                'name'             => '_ThisIsCamelCaps',
                'visibilityPublic' => false,
            ],
            'empty string (public)'                               => [
                'name'             => '',
                'visibilityPublic' => true,
            ],
            'empty string (private)'                              => [
                'name'             => '',
                'visibilityPublic' => false,
            ],
        ];
    }


    /**
     * Test valid strings with default arguments.
     *
     * @param string $name The tested name.
     *
     * @dataProvider dataValidDefaultArguments
     *
     * @return void
     */
    public function testValidDefaultArguments($name)
    {
        $this->assertTrue(Common::isCamelCaps($name));
    }


    /**
     * Data provider.
     *
     * @see testValidDefaultArguments()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataValidDefaultArguments()
    {
        return [
            'lower camelCase string'                   => [
                'name' => 'thisIsCamelCaps',
            ],
            'lower camelCase string with medial digit' => [
                'name' => 'this3IsCamelCaps',
            ],
        ];
    }


    /**
     * Test invalid strings with default arguments.
     *
     * @param string $name The tested name.
     *
     * @dataProvider dataInvalidDefaultArguments
     *
     * @return void
     */
    public function testInvalidDefaultArguments($name)
    {
        $this->assertFalse(Common::isCamelCaps($name));
    }


    /**
     * Data provider.
     *
     * @see testInvalidDefaultArguments()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataInvalidDefaultArguments()
    {
        return [
            'PascalCase string'                              => [
                'name' => 'ThisIsCamelCaps',
            ],
            'PascalCase string with acronym'                 => [
                'name' => 'ThisISCamelCaps',
            ],
            'lower camelCase string with initial underscore' => [
                'name' => '_thisIsCamelCaps',
            ],
            'lower camelCase string with acronym'            => [
                'name' => 'thisISCamelCaps',
            ],
        ];
    }
}
