<?php
/**
 * Tests for the \PHP_CodeSniffer\Files\File::findExtendedClassName method.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Files\File;

use PHP_CodeSniffer\Tests\Core\AbstractMethodTestCase;

/**
 * Tests for the \PHP_CodeSniffer\Files\File::findExtendedClassName method.
 *
 * @covers \PHP_CodeSniffer\Files\File::findExtendedClassName
 */
final class FindExtendedClassNameTest extends AbstractMethodTestCase
{


    /**
     * Test getting a `false` result when a non-existent token is passed.
     *
     * @return void
     */
    public function testNonExistentToken()
    {
        $result = self::$phpcsFile->findExtendedClassName(100000);
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
        $result = self::$phpcsFile->findExtendedClassName($token);
        $this->assertFalse($result);
    }


    /**
     * Test retrieving the name of the class being extended by another class
     * (or interface).
     *
     * @param string       $identifier Comment which precedes the test case.
     * @param string|false $expected   Expected function output.
     *
     * @dataProvider dataExtendedClass
     *
     * @return void
     */
    public function testFindExtendedClassName($identifier, $expected)
    {
        $OOToken = $this->getTargetToken($identifier, [T_CLASS, T_ANON_CLASS, T_INTERFACE]);
        $result  = self::$phpcsFile->findExtendedClassName($OOToken);
        $this->assertSame($expected, $result);
    }


    /**
     * Data provider for the FindExtendedClassName test.
     *
     * @see testFindExtendedClassName()
     *
     * @return array<string, array<string, string|false>>
     */
    public static function dataExtendedClass()
    {
        return [
            'class does not extend'                                       => [
                'identifier' => '/* testNonExtendedClass */',
                'expected'   => false,
            ],
            'class extends unqualified class'                             => [
                'identifier' => '/* testExtendsUnqualifiedClass */',
                'expected'   => 'testFECNClass',
            ],
            'class extends fully qualified class'                         => [
                'identifier' => '/* testExtendsFullyQualifiedClass */',
                'expected'   => '\PHP_CodeSniffer\Tests\Core\File\testFECNClass',
            ],
            'class extends partially qualified class'                     => [
                'identifier' => '/* testExtendsPartiallyQualifiedClass */',
                'expected'   => 'Core\File\RelativeClass',
            ],
            'class extends namespace relative class'                      => [
                'identifier' => '/* testExtendsNamespaceRelativeClass */',
                'expected'   => 'namespace\Bar',
            ],
            'interface does not extend'                                   => [
                'identifier' => '/* testNonExtendedInterface */',
                'expected'   => false,
            ],
            'interface extends unqualified interface'                     => [
                'identifier' => '/* testInterfaceExtendsUnqualifiedInterface */',
                'expected'   => 'testFECNInterface',
            ],
            'interface extends fully qualified interface'                 => [
                'identifier' => '/* testInterfaceExtendsFullyQualifiedInterface */',
                'expected'   => '\PHP_CodeSniffer\Tests\Core\File\testFECNInterface',
            ],
            'anon class extends unqualified class'                        => [
                'identifier' => '/* testExtendedAnonClass */',
                'expected'   => 'testFECNExtendedAnonClass',
            ],
            'class does not extend but contains anon class which extends' => [
                'identifier' => '/* testNestedExtendedClass */',
                'expected'   => false,
            ],
            'anon class extends, nested in non-extended class'            => [
                'identifier' => '/* testNestedExtendedAnonClass */',
                'expected'   => 'testFECNAnonClass',
            ],
            'class extends and implements'                                => [
                'identifier' => '/* testClassThatExtendsAndImplements */',
                'expected'   => 'testFECNClass',
            ],
            'class implements and extends'                                => [
                'identifier' => '/* testClassThatImplementsAndExtends */',
                'expected'   => 'testFECNClass',
            ],
            'interface extends multiple interfaces (not supported)'       => [
                'identifier' => '/* testInterfaceMultiExtends */',
                'expected'   => '\Package\FooInterface',
            ],
            'readonly anon class extends fully qualified class'           => [
                'identifier' => '/* testExtendedReadonlyAnonClass */',
                'expected'   => '\Fully\Qualified\MyClass',
            ],
            'anon class with attribute extends partially qualified class' => [
                'identifier' => '/* testExtendedAnonClassWithAttributes */',
                'expected'   => 'Partially\Qualified\MyClass',
            ],
            'parse error - extends keyword, but no class name'            => [
                'identifier' => '/* testMissingExtendsName */',
                'expected'   => false,
            ],
            'parse error - live coding - no curly braces'                 => [
                'identifier' => '/* testParseError */',
                'expected'   => false,
            ],
        ];
    }
}
