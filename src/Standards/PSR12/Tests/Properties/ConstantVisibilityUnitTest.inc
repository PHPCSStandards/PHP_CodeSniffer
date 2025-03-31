<?php
class Foo {
    public const BAR = 'bar';
    const BAZ = 'baz';
}

const APPLICATION_ENV = 'development';

// Issue 3526, PHP 8.1 final constants.
class SampleEnum
{
    final const FOO = 'SAMPLE';

    public final const BAR = 'SAMPLE';

    final private const BAZ = 'SAMPLE';
}

enum SomeEnum {
    public const BAR = 'bar';
    const BAZ = 'baz';
}

// Don't break on asymmetric visibility
class WithAsym {

    private(set) string $asym1;

    public private(set) string $asym2;

    protected(set) string $asym3;

    public protected(set) string $asym4;
}
