<?php

function foo($a, $_) {
    return $a * 2;
}

function baz($a, $_) {
    echo "baz({$a});";
}

class Foo implements Bar {
    function fooBar($_, $_) {
        return;
    }
}

print foo( 'PARAMETER' );
print "\n";

$foo = function ($a, $_) {
    return $a * 2;
};


/*
 * The function signature of methods in extended classes and implemented
 * interfaces has to mirror the parent class/interface.
 * The overloaded method may not use all params.
 */

class MyClass {
    public function something($a, $_) {
        return $a * 2;
    }
}

class MyExtendedClass extends SomeClass {
    public function something($a, $_) {
        return $a * 2;
    }
}

class MyExtendedClass implements SomeInterface {
    public function something($a, $_) {
        return $a * 2;
    }
}


/*
 * Functions may not use all params passed to them.
 * Report different violations for params *before* and *after* the last param used.
 */

function something($_) {
    return 'foobar';
}

function myCallback($a, $_, $c, $_) {
    return $a * $c;
}

fn ($_, $b) => $b;

// phpcs:set Generic.CodeAnalysis.UnusedFunctionParameter ignoreTypeHints[] Exception

function oneParam(Exception $_) {
    return 'foobar';
}

function moreParamFirst(Exception $_, LogicException $bar) {
    return 'foobar' . $bar;
}

function moreParamSecond(LogicException $bar, Exception $_) {
    return 'foobar' . $bar;
}
// phpcs:set Generic.CodeAnalysis.UnusedFunctionParameter ignoreTypeHints[]

class ConstructorPropertyPromotionNoContentInMethod {
    public function __construct(protected int $_) {}
}

class ConstructorPropertyPromotionWithContentInMethod {
    public function __construct(protected int $_, $toggle = true) {
        if ($toggle === true) {
            doSomething();
        }
    }
}

$found = in_array_cb($needle, $haystack, fn($_, $needle) => $needle === 5);


/*
 * Don't adjust the error code for closures and arrow functions in extended classes/classes implementing interfaces.
 */
class MyExtendedClass extends SomeClass {
    public function something($a, $b) {
        $c = $a + $b;
        $closure = function ($c, $_) {
            return $c * 2;
        };
    }
}


/**
 * Magic methods must match the function signature dictated by PHP.
 * Flagging unused parameters leads to notices which cannot be solved.
 */

class MagicMethodsWithParamsNotDictatedByPHP {
    public $foo;
    public function __construct($foo, $_) {
        $this->foo = $foo;
    }

    public function __invoke($foo, $_) {
        $this->foo = $foo;
    }
}

/**
 * Unused parameters in magic methods which have flexible function signatures
 * where the method potentially overloads a parent method should still be flagged,
 * but should use the `FoundInExtendedClassAfterLastUsed` error code.
 */
class MagicMethodsWithParamsNotDictatedByPHPInChildClass extends SomeParent{
    public $foo;
    public function __construct($foo, $_) {
        $this->foo = $foo;
    }

    public function __invoke($foo, $_) {
        $this->foo = $foo;
    }
}

/**
 * Should trigger the sniff as this method is not part of an interface.
 */
class MethodThrowsException {
    public function throwsException($_) {
        throw new Exception();
    }
}
