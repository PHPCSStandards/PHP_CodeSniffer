<?php

function generator()
{
    /* testYield */
    yield 1;

    /* testYieldFollowedByComment */
    YIELD/*comment*/ 2;

    /* testYieldFrom */
    yield from gen2();

    /* testYieldFromWithExtraSpacesBetween */
    Yield           From gen2();

    /* testYieldFromWithTabBetween */
    yield	from gen2();

    /* testYieldFromSplitByNewLines */
    yield

    FROM
    gen2();
}

/* testYieldUsedAsClassName */
class Yield {
    /* testYieldUsedAsClassConstantName */
    const Type YIELD = 'foo';

    /* testYieldUsedAsMethodName */
    public function yield() {
        /* testYieldUsedAsPropertyName1 */
        echo $obj->yield;

        /* testYieldUsedAsPropertyName2 */
        echo $obj?->yield();

        /* testYieldUsedForClassConstantAccess1 */
        echo MyClass::YIELD;
        /* testFromUsedForClassConstantAccess1 */
        echo MyClass::FROM;
    }

    /* testYieldUsedAsMethodNameReturnByRef */
    public function &yield() {}
}

function myGen() {
    /* testYieldLiveCoding */
    yield
