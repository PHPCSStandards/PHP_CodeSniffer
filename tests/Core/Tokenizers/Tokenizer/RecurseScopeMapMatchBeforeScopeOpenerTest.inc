<?php

/* testIfMatchInCondition */
if (match ($a) { 1 => true, default => false }) /* testIfMatchInConditionScopeOpener */ {
    echo 'if';
/* testIfMatchInConditionScopeCloser */
} /* testElseIfMatchInCondition */ elseif (match ($a) { 2 => true, default => false }) /* testElseIfMatchInConditionScopeOpener */ {
    echo 'elseif';
/* testElseIfMatchInConditionScopeCloser */
}

/* testIfMatchInConditionAlternativeSyntax */
if (match ($a) { 1 => true, default => false }) /* testIfMatchInConditionAlternativeSyntaxScopeOpener */ :
    echo 'if';
/* testIfMatchInConditionAlternativeSyntaxScopeCloser */
endif;

/* testWhileMatchInCondition */
while (match ($a) { 1 => true, default => false }) /* testWhileMatchInConditionScopeOpener */ {
    echo 'while';
/* testWhileMatchInConditionScopeCloser */
}

/* testForMatchInCondition */
for ($i = match ($a) { 1 => 0, default => 1 }; $i < 3; $i++) /* testForMatchInConditionScopeOpener */ {
    echo 'for';
/* testForMatchInConditionScopeCloser */
}

/* testForeachMatchInCondition */
foreach (match ($a) { 1 => [], default => [1] } as $v) /* testForeachMatchInConditionScopeOpener */ {
    echo 'foreach';
/* testForeachMatchInConditionScopeCloser */
}

/* testAnonClassMatchInArguments */
$obj = new class (match ($a) { 1 => 'a', default => 'b' }) /* testAnonClassMatchInArgumentsScopeOpener */ {
    public function __construct($p) {}
/* testAnonClassMatchInArgumentsScopeCloser */
};

// Test for https://github.com/PHPCSStandards/PHP_CodeSniffer/issues/1313
/* testIfMatchInConditionWithNestedIf */
if (match ($name[0]) {
    'g' => true,
    default => false,
} && !do_something($name[$i])) /* testIfMatchInConditionWithNestedIfScopeOpener */ {
    if ($obj->doSomething($name)) {
        return $foo;
    }
/* testIfMatchInConditionWithNestedIfScopeCloser */
}
