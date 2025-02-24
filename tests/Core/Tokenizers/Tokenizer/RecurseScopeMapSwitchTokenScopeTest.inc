<?php

/* testSwitchNormalSyntax */
switch ($value) /* testSwitchNormalSyntaxScopeOpener */ {
    case 1:
        echo 'one';
        break;
    default :
        echo 'other';
        break;
/* testSwitchNormalSyntaxScopeCloser */
}

// Test for https://github.com/squizlabs/PHP_CodeSniffer/issues/497
/* testSwitchAlternativeSyntax */
switch ($value) /* testSwitchAlternativeSyntaxScopeOpener */ :
    case 1:
        echo 'one';
        break;
    default:
        echo 'other';
        break;
/* testSwitchAlternativeSyntaxScopeCloser */
endswitch;

// Test for https://github.com/squizlabs/PHP_CodeSniffer/issues/543
/* testSwitchClosureWithinCondition */
switch((function () {
    return 'bar';
})()) /* testSwitchClosureWithinConditionScopeOpener */ {
    case 1:
        return 'test';
/* testSwitchClosureWithinConditionScopeCloser */
}

/* testSwitchClosureWithReturnTypeWithinCondition */
switch((function (): string {
    return 'bar';
})()) /* testSwitchClosureWithReturnTypeWithinConditionScopeOpener */ {
    case 1:
        return 'test';
/* testSwitchClosureWithReturnTypeWithinConditionScopeCloser */
}

/* testSwitchArrowFunctionWithinCondition */
switch((fn() => 'bar')()) /* testSwitchArrowFunctionWithinConditionScopeOpener */ {
    case 1:
        return 'test';
/* testSwitchArrowFunctionWithinConditionScopeCloser */
}

/* testSwitchArrowFunctionWithReturnTypeWithinCondition */
switch((fn(): string => 'bar')()) /* testSwitchArrowFunctionWithReturnTypeWithinConditionScopeOpener */ {
    case 1:
        return 'test';
/* testSwitchArrowFunctionWithReturnTypeWithinConditionScopeCloser */
}
