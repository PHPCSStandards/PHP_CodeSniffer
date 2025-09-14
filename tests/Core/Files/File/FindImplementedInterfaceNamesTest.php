<?php
/**
 * Tests for the \PHP_CodeSniffer\Files\File::findImplementedInterfaceNames method.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Files\File;

use PHP_CodeSniffer\Tests\Core\AbstractMethodTestCase;

/**
 * Tests for the \PHP_CodeSniffer\Files\File::findImplementedInterfaceNames method.
 *
 * @covers \PHP_CodeSniffer\Files\File::findImplementedInterfaceNames
 */
final class FindImplementedInterfaceNamesTest extends AbstractMethodTestCase
{


    /**
     * Test getting a `false` result when a non-existent token is passed.
     *
     * @return void
     */
    public function testNonExistentToken()
    {
        $result = self::$phpcsFile->findImplementedInterfaceNames(100000);
        $this->assertFalse($result);
    }


    /**
     * Test getting a `false` result when a token other than one of the supported tokens is passed.
     *
     * @return void
     */
    public function testNotAClass()
    {
        $token  = $this->getTargetToken('/* testNotAClass */', [T_FUNCTION]);
        $result = self::$phpcsFile->findImplementedInterfaceNames($token);
        $this->assertFalse($result);
    }


    /**
     * Test retrieving the name(s) of the interfaces being implemented by a class.
     *
     * @param string              $identifier Comment which precedes the test case.
     * @param array<string>|false $expected   Expected function output.
     *
     * @dataProvider dataImplementedInterface
     *
     * @return void
     */
    public function testFindImplementedInterfaceNames($identifier, $expected)
    {
        $OOToken = $this->getTargetToken($identifier, [T_CLASS, T_ANON_CLASS, T_INTERFACE, T_ENUM]);
        $result  = self::$phpcsFile->findImplementedInterfaceNames($OOToken);
        $this->assertSame($expected, $result);
    }


    /**
     * Data provider for the FindImplementedInterfaceNames test.
     *
     * @see testFindImplementedInterfaceNames()
     *
     * @return array<string, array<string, string|array<string>|false>>
     */
    public static function dataImplementedInterface()
    {
        return [
            'interface declaration, no implements'                               => [
                'identifier' => '/* testPlainInterface */',
                'expected'   => false,
            ],
            'class does not implement'                                           => [
                'identifier' => '/* testNonImplementedClass */',
                'expected'   => false,
            ],
            'class implements single interface, unqualified'                     => [
                'identifier' => '/* testClassImplementsSingle */',
                'expected'   => [
                    'testFIINInterface',
                ],
            ],
            'class implements multiple interfaces'                               => [
                'identifier' => '/* testClassImplementsMultiple */',
                'expected'   => [
                    'testFIINInterface',
                    'testFIINInterface2',
                ],
            ],
            'class implements single interface, fully qualified'                 => [
                'identifier' => '/* testImplementsFullyQualified */',
                'expected'   => [
                    '\PHP_CodeSniffer\Tests\Core\File\testFIINInterface',
                ],
            ],
            'class implements single interface, partially qualified'             => [
                'identifier' => '/* testImplementsPartiallyQualified */',
                'expected'   => [
                    'Core\File\RelativeInterface',
                ],
            ],
            'class implements multiple interfaces, namespace relative'           => [
                'identifier' => '/* testImplementsMultipleNamespaceRelativeInterfaces */',
                'expected'   => [
                    'namespace\testInterfaceA',
                    'namespace\testInterfaceB',
                ],
            ],
            'class extends and implements'                                       => [
                'identifier' => '/* testClassThatExtendsAndImplements */',
                'expected'   => [
                    'InterfaceA',
                    '\NameSpaced\Cat\InterfaceB',
                ],
            ],
            'class implements and extends'                                       => [
                'identifier' => '/* testClassThatImplementsAndExtends */',
                'expected'   => [
                    '\InterfaceA',
                    'InterfaceB',
                ],
            ],
            'enum does not implement'                                            => [
                'identifier' => '/* testBackedEnumWithoutImplements */',
                'expected'   => false,
            ],
            'enum implements single interface, unqualified'                      => [
                'identifier' => '/* testEnumImplementsSingle */',
                'expected'   => [
                    'Colorful',
                ],
            ],
            'enum implements multiple interfaces, unqualified + fully qualified' => [
                'identifier' => '/* testBackedEnumImplementsMulti */',
                'expected'   => [
                    'Colorful',
                    '\Deck',
                ],
            ],
            'anon class implements single interface, unqualified'                => [
                'identifier' => '/* testAnonClassImplementsSingle */',
                'expected'   => [
                    'testFIINInterface',
                ],
            ],
            'parse error - implements keyword, but no interface name'            => [
                'identifier' => '/* testMissingImplementsName */',
                'expected'   => false,
            ],
            'parse error - live coding - no curly braces'                        => [
                'identifier' => '/* testParseError */',
                'expected'   => false,
            ],
        ];
    }
}
