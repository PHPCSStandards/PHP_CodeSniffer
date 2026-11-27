<?php

// This is just within the limit
namespace This\Name\Space\IsGoingToBeJustWithinLimits\LongLongLongLongLongLoong;

// This is just within the absolute limit and should throw a NamespacedNameTooLong warning
namespace This\Name\Space\IsGoingToBeJustWithinLimits\LongLongLongLongLongLongLongLongLongLongLongLongLongLongLoooooong;

// This is too long and should throw a NamespacedNameMaxExceeded error
namespace This\Name\Space\IsGoingToBeTooLong\LongLongLongLongLongLongLongLongLongLongLongLongLongLongLongLongLongLoooong;

// These are just within the limits
use ThisReallyLong\Looooooooooooooong\UseStatement\ShouldBeNotTooLong\ClassName;
use function ThisReallyLong\Looong\UseStatement\ShouldBeNotTooLong\functionCall;
use const ThisReallyLong\Loooooooooong\UseStatement\ShouldBeNotTooLong\CONSTANT;

// These are just a bit too long and should throw a NamespacedNameTooLong warning
use ThisReallyLong\Long\Looooong\Looooooooooooooong\UseStatement\ThatShouldThrowAWarning\BecauseItsNotTooLong\ClassName;
use function ThisReallyLong\Long\Looooooong\Long\UseStatement\ThatShouldThrowAWarning\BecauseItsNotTooLong\functionCall;
use const ThisReallyLong\Long\Looooong\Loooooooooong\UseStatement\ThatShouldThrowAWarning\BecauseItsNotTooLong\CONSTANT;

// These are just a bit too long and should throw a NamespacedNameMaxExceeded error
use ThisReallyLong\Long\Loooooong\Looooong\UseStatement\ThatShouldNotBeAllowed\AndThrowErrorsBecauseItsTooLong\ClassName;
use function ThisReallyLong\Long\Looong\UseStatement\ThatShouldNotBeAllowed\AndThrowErrorsBecauseItsTooLong\functionCall;
use const ThisReallyLong\Long\Loooooooooong\UseStatement\ThatShouldNotBeAllowed\AndThrowErrorsBecauseItsTooLong\CONSTANT;

// These are just within the limits
echo \This\Name\Space\IsGoingToBeJustWithinLimits\LongLongLooong\functionCall();
new \This\Name\Space\IsGoingToBeJustWithinLimits\LongLongLongLooong\ClassName();

// These are just a bit too long and should throw a NamespacedNameTooLong warning
echo \ThisReallyLong\Long\Looooong\Loooooooong\UseStatement\ThatShouldThrowAWarning\BecauseItsNotTooLong\functionCall();
new \ThisReallyLong\Long\Looooong\Loooooooooooong\UseStatement\ThatShouldThrowAWarning\BecauseItsNotTooLong\ClassName();

// These are just a bit too long and should throw a NamespacedNameMaxExceeded error
echo \ThisReallyLong\Long\Long\Looooong\UseStatement\ThatShouldNotBeAllowed\AndThrowErrorsBecauseItsTooLong\functionCall();
new \ThisReallyLong\Long\Long\Looooooooong\UseStatement\ThatShouldNotBeAllowed\AndThrowErrorsBecauseItsTooLong\ClassName();

// These are a bit too long but can be shortened and should throw a TooLong warning
echo \This\Name\Space\IsGoingToBeJustWithinLimits\LongLongLooong\functionCall('foo', 'bar', 'baz');
new \This\Name\Space\IsGoingToBeJustWithinLimits\LongLongLongLooong\ClassName('foo', 'bar', 'baz');

// These are just a bit too long but can be shortened and should throw a MaxExceeded error
echo \ThisReallyLong\Long\Long\Looong\UseStatement\ThatShouldNotBeAllowed\AndThrowErrorsBecauseItsTooLong\functionCall('foo', 'bar', 'baz');
new \ThisReallyLong\Long\Long\Looooooong\UseStatement\ThatShouldNotBeAllowed\AndThrowErrorsBecauseItsTooLong\ClassName('foo', 'bar', 'baz');
