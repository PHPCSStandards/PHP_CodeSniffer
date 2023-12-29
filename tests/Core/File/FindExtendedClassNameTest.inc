<?php

namespace PHP_CodeSniffer\Tests\Core\File;

class testFECNClass {}

/* testExtendsUnqualifiedClass */
class testFECNExtendedClass extends testFECNClass {}

/* testExtendsFullyQualifiedClass */
class testFECNNamespacedClass extends \PHP_CodeSniffer\Tests\Core\File\testFECNClass {}

/* testNonExtendedClass */
class testFECNNonExtendedClass {}

/* testNonExtendedInterface */
interface testFECNInterface {}

/* testInterfaceExtendsUnqualifiedInterface */
interface testInterfaceThatExtendsInterface extends testFECNInterface{}

/* testInterfaceExtendsFullyQualifiedInterface */
interface testInterfaceThatExtendsFQCNInterface extends \PHP_CodeSniffer\Tests\Core\File\testFECNInterface{}

/* testNestedExtendedClass */
class testFECNNestedExtendedClass {
	public function someMethod() {
		/* testNestedExtendedAnonClass */
		$anon = new class extends testFECNAnonClass {};
	}
}

/* testClassThatExtendsAndImplements */
class testFECNClassThatExtendsAndImplements extends testFECNClass implements InterfaceA, InterfaceB {}

/* testClassThatImplementsAndExtends */
class testFECNClassThatImplementsAndExtends implements InterfaceA, InterfaceB extends testFECNClass {}
