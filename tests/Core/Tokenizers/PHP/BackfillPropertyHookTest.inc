<?php

class PropertyHookDemo
{
    public string /* testHookedProperty */ $foo = 'default' {
        /* testGetHook */ get {
            /* testGetFunctionCallInsideHook */ get($this->foo);

            return $this->foo;
        }

        /* testSetHook */ set(string $value) {
            /* testSetFunctionCallInsideHook */ set($value);

            $this->foo = strtolower($value);
        }
    }

    public string /* testPropertyWithoutHooks */ $bar = 'default';

    public string $baz {
        /* testSetHookImplicitParam */ set {
            $this->baz = strtoupper($value);
        }
    }

    public string $short {
        /* testShortGetHook */ get => $this->short;
        /* testShortSetHook */ set => match ($value) {
            /* testMatchSetArmInsideHook */ set => strtolower($value),
            default => trim($value),
        };
    }

    public array $items {
        /* testReferenceGetHook */ &get {
            return $this->items;
        }
    }

    public array $shortItems {
        /* testShortReferenceGetHook */ &get => $this->shortItems;
    }

    public function set(string $value) {
        /* testSetFunctionCall */ set($value);
    }

    public function matchExpression(string $value): string
    {
        return match ($value) {
            /* testMatchSetArm */ set => 'setter',
            default => 'default',
        };
    }
}

interface PropertyHookInterfaceDemo
{
    public string $name {
        /* testInterfaceGetHook */ get;
        /* testInterfaceSetHook */ set;
    }
}

abstract class AbstractPropertyHookDemo
{
    abstract public string $name {
        /* testAbstractGetHook */ get;
        /* testAbstractSetHook */ set;
    }
}

class PromotedPropertyHookDemo
{
    public function __construct(
        public string /* testPromotedHookedProperty */ $name {
            /* testPromotedShortGetHook */ get => $this->name;
            /* testPromotedSetHook */ set {
                $this->name = trim($value);
            }
        },
        public array $items {
            /* testPromotedReferenceGetHook */ &get => $this->items;
        },
    ) {}
}
