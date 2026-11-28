<?php

enum Foo
{
    /* testPureEnumCase */
    case SOME_CASE;
}

enum Boo: int {
    /* testBackingIntegerEnumCase */
    case ONE = 1;
}

enum Hoo: string
{
    /* testBackingStringEnumCase */
    case ONE = 'one';
}

enum ComplexEnum: int implements SomeInterface
{
    use SomeTrait {
        traitMethod as enumMethod;
    }

    const SOME_CONSTANT = true;

    /* testEnumCaseInComplexEnum */
    case ONE = 1;

    /* testEnumCaseIsCaseInsensitive */
    CaSe TWO = 2;

    public function someMethod(): bool
    {
        switch (true) {
            /* testCaseWithSemicolonIsNotEnumCase */
            case CONSTANT;
        }
    }

    /* testEnumCaseAfterSwitch */
    case THREE = 3;

    public function someOtherMethod(): bool
    {
        switch (true):
            /* testCaseInAlternativeSwitchInEnumIsNotEnumCase */
            case false:
        endswitch;
    }

    /* testEnumCaseAfterSwitchWithEndSwitch */
    case FOUR = 4;
}

switch (true) {
    /* testCaseWithConstantIsNotEnumCase */
    case CONSTANT:
    /* testCaseWithConstantAndIdenticalIsNotEnumCase */
    case CONSTANT === 1:
    /* testCaseWithAssigmentIsNotEnumCase */
    case $var = 1:
    /* testIsNotEnumCaseIsCaseInsensitive */
    cAsE CONSTANT:
    /* testIsNotEnumCaseWithCurlies */
    case CONSTANT: {
        break;
    }
    /* testIsNotEnumCaseWithSemicolonAndCurlies */
    case CONSTANT ; {
        break;
    }
    /* testIsNotEnumCaseWithCloseTag */
    case CONSTANT?>
        <div>something</div>
    <?php
}

switch ($s):
    /* testCaseInAlternativeSwitchIsNotEnumCase */
    case CONSTANT:
        enum Foo {
            /* testEnumCaseNestedInAltSyntaxSwitch1 */
            case NAME;
        }
        break;
    /* testCaseInAlternativeSwitchWithSemicolonIsNotEnumCase */
    case 'b';
        enum Bar: int {
            /* testEnumCaseNestedInAltSyntaxSwitch2 */
            case NAME = 1;
        }
        break;
endswitch;

switch ($x) {
    /* testCaseInSwitchWhenCreatingEnumInSwitch1 */
    case 'a': {
        enum Foo {
            /* testEnumCaseNestedInSwitch1 */
            case NAME;
        }
        break;
    }

    /* testCaseInSwitchWhenCreatingEnumInSwitch2 */
    case 'b';
        enum Bar:int {
            /* testEnumCaseNestedInSwitch2 */
            case NAME = 1;
        }
        break;
}

enum Foo: string {
    /* testKeywordAsEnumCaseNameShouldBeString1 */
    case INTERFACE = 'interface';
    /* testKeywordAsEnumCaseNameShouldBeString2 */
    case TRAIT = 'trait';
    /* testKeywordAsEnumCaseNameShouldBeString3 */
    case ENUM = 'enum';
    /* testKeywordAsEnumCaseNameShouldBeString4 */
    case FUNCTION = 'function';
    /* testKeywordAsEnumCaseNameShouldBeString5 */
    case FALSE = 'false';
    /* testKeywordAsEnumCaseNameShouldBeString6 */
    case DEFAULT = 'default';
    /* testKeywordAsEnumCaseNameShouldBeString7 */
    case ARRAY = 'array';
    /* testKeywordAsEnumCaseNameShouldBeString8 */
    case EXIT = 'exit';
}

// Related to https://github.com/PHPCSStandards/PHP_CodeSniffer/pull/1532#issuecomment-7073446480
enum NodeKind: string
{
    /* testEnumCaseNamedSwitch */
    case Switch = 'Switch';
    /* testNameAfterKeywordEnumCaseNameShouldBeString1 */
    case SwitchBody = 'SwitchBody';
    /* testNameAfterKeywordEnumCaseNameShouldBeString2 */
    case SwitchBraceDelimitedBody = 'SwitchBraceDelimitedBody';
    /* testEnumCaseNamedDeclare */
    case Declare = 'Declare';
}
