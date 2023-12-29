<?php
/**
 * Tests for the \PHP_CodeSniffer\Files\File::findExtendedClassName method.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\File;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;

/**
 * Tests for the \PHP_CodeSniffer\Files\File::findExtendedClassName method.
 *
 * @covers \PHP_CodeSniffer\Files\File::findExtendedClassName
 */
class FindExtendedClassNameTest extends AbstractMethodUnitTest
{


    /**
     * Test retrieving the name of the class being extended by another class
     * (or interface).
     *
     * @param string $identifier Comment which precedes the test case.
     * @param bool   $expected   Expected function output.
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

    }//end testFindExtendedClassName()


    /**
     * Data provider for the FindExtendedClassName test.
     *
     * @see testFindExtendedClassName()
     *
     * @return array
     */
    public function dataExtendedClass()
    {
        return [
            [
                '/* testExtendsUnqualifiedClass */',
                'testFECNClass',
            ],
            [
                '/* testExtendsFullyQualifiedClass */',
                '\PHP_CodeSniffer\Tests\Core\File\testFECNClass',
            ],
            [
                '/* testNonExtendedClass */',
                false,
            ],
            [
                '/* testNonExtendedInterface */',
                false,
            ],
            [
                '/* testInterfaceExtendsUnqualifiedInterface */',
                'testFECNInterface',
            ],
            [
                '/* testInterfaceExtendsFullyQualifiedInterface */',
                '\PHP_CodeSniffer\Tests\Core\File\testFECNInterface',
            ],
            [
                '/* testNestedExtendedClass */',
                false,
            ],
            [
                '/* testNestedExtendedAnonClass */',
                'testFECNAnonClass',
            ],
            [
                '/* testExtendsPartiallyQualifiedClass */',
                'Core\File\RelativeClass',
            ],
            [
                '/* testExtendsNamespaceRelativeClass */',
                'namespace\Bar',
            ],
            [
                '/* testClassThatExtendsAndImplements */',
                'testFECNClass',
            ],
            [
                '/* testClassThatImplementsAndExtends */',
                'testFECNClass',
            ],
        ];

    }//end dataExtendedClass()


}//end class
