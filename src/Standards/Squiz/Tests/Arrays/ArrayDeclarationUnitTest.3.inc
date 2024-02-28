<?php

$closure = static function(): \Generator
{
    yield 'test case' => [
                          1, static fn (float $item): float => match ($item) {
        2.0 => 3.0,
        default => $item
        },
                         ];
};
