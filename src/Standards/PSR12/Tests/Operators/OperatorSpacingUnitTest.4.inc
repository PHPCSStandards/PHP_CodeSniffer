<?php

// phpcs:set PSR12.Operators.OperatorSpacing perCompatible 3.0

// Valid.
try {
    // nothing
} catch (Exception|RuntimeException $e) {
}

// Valid because multiline formatting is undefined.
try {
    // nothing
} catch (
    Exception
    |RuntimeException
    |KlausiException
    |AnotherException
    |ItNeverEndsException $e
) {
}

// Valid because multiline formatting is undefined.
try {
    // nothing
} catch (
    Exception|
    RuntimeException|
    KlausiException|
    AnotherException|
    ItNeverEndsException $e
) {
}

// Invalid becasue of one space.
try {
    // nothing
} catch (Exception | RuntimeException $e) {
}

// Invalid because of multiple spaces.
try {
    // nothing
} catch (Exception  |   RuntimeException $e) {
}

// Testing that it works with future versions as well.
// phpcs:set PSR12.Operators.OperatorSpacing perCompatible 4.0

try {
    // nothing
} catch (Exception | RuntimeException $e) {
}

// phpcs:set PSR12.Operators.OperatorSpacing perCompatible 1.0

// Valid.
try {
    // nothing
} catch (Exception | RuntimeException $e) {
}

// Valid because multiline formatting is undefined.
try {
    // nothing
} catch (
    Exception
    | RuntimeException
    | KlausiException
    | AnotherException
    | ItNeverEndsException $e
) {
}

// Valid because multiline formatting is undefined.
try {
    // nothing
} catch (
    Exception |
    RuntimeException |
    KlausiException |
    AnotherException |
    ItNeverEndsException $e
) {
}

// Invalid becasue of no space.
try {
    // nothing
} catch (Exception|RuntimeException $e) {
}

// Invalid because of multiple spaces.
try {
    // nothing
} catch (Exception  |   RuntimeException $e) {
}
