<?php

class OtherContextSensitiveKeywords
{
    const /* testParent */ PARENT = 'PARENT';
    const /* testSelf */ SELF = 'SELF';

    const /* testFalse */ FALSE = 'FALSE',
    const /* testTrue */ TRUE = 'TRUE',
    const /* testNull */ NULL = 'NULL',
}

abstract class SomeClass
{
    final function someFunction(
        /* testSelfIsKeyword */
        self $self,
        /* testParentIsKeyword */
        parent $parent
    ) {
        return $this;
    }
}

$instantiated1 = new /* testClassInstantiationParentIsKeyword */ parent();
$instantiated2 = new /* testClassInstantiationSelfIsKeyword */ SELF;

function /* testKeywordSelfAfterFunctionByRefShouldBeString */ &self() {}
function /* testKeywordParentAfterFunctionByRefShouldBeString */ &parent() {}
function /* testKeywordFalseAfterFunctionByRefShouldBeString */ &false() {}
function /* testKeywordTrueAfterFunctionByRefShouldBeString */ & true () {}
function /* testKeywordNullAfterFunctionByRefShouldBeString */ &NULL() {}

/* testKeywordAsFunctionCallNameShouldBeStringSelf */ self();
/* testKeywordAsFunctionCallNameShouldBeStringParent */ parent();
/* testKeywordAsFunctionCallNameShouldBeStringFalse */ false();
/* testKeywordAsFunctionCallNameShouldBeStringTrue */ True ();
/* testKeywordAsFunctionCallNameShouldBeStringNull */ null /*comment*/ ();

$instantiated4 = new /* testClassInstantiationFalseIsString */ False();
$instantiated5 = new /* testClassInstantiationTrueIsString */ true ();
$instantiated6 = new /* testClassInstantiationNullIsString */ null();

function standAloneFalseTrueNullTypesAndMore(
    /* testFalseIsKeywordAsParamType */ false $paramA,
    /* testTrueIsKeywordAsParamType */ true $paramB,
    /* testNullIsKeywordAsParamType */ null $paramC,
) /* testFalseIsKeywordAsReturnType */ false | /* testTrueIsKeywordAsReturnType */ true | /* testNullIsKeywordAsReturnType */ null {
    if ($a === /* testFalseIsKeywordInComparison */ false
    || $a === /* testTrueIsKeywordInComparison */ true
    || $a === /* testNullIsKeywordInComparison */ null
    ) {}
}
