<?php

namespace PHP_CodeSniffer\Tests\Core\File;

interface testFIINInterface2 {}

/* testPlainInterface */
interface testFIINInterface {}

/* testClassImplementsSingle */
class testFIINImplementedClass implements testFIINInterface {}

/* testClassImplementsMultiple */
class testFIINMultiImplementedClass implements testFIINInterface, testFIINInterface2 {}

/* testImplementsFullyQualified */
class testFIINNamespacedClass implements \PHP_CodeSniffer\Tests\Core\File\testFIINInterface {}

/* testNonImplementedClass */
class testFIINNonImplementedClass {}

/* testClassThatExtendsAndImplements */
class testFECNClassThatExtendsAndImplements extends testFECNClass implements InterfaceA, \NameSpaced\Cat\InterfaceB {}

/* testClassThatImplementsAndExtends */
class testFECNClassThatImplementsAndExtends implements \InterfaceA, InterfaceB extends testFECNClass {}

/* testBackedEnumWithoutImplements */
enum Suit:string {}

/* testEnumImplementsSingle */
enum Suit implements Colorful {}

/* testBackedEnumImplementsMulti */
enum Suit: string implements Colorful, \Deck {}
