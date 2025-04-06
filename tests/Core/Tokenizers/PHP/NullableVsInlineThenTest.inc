<?php

class Nullable
{
    /* testNullableReadonlyOnly */
    readonly ?int $prop;

    /* testNullablePrivateSetOnly */
    private(set) ?int $prop2;

    /* testNullablePublicPrivateSetOnly */
    public private(set) ?int $prop3;
}

class InlineThen
{
    /* testInlineThenInPropertyDefaultValue */
    public int $prop = self::SOMECONT ? PHP_CONST ? OTHER_CONST;
}
