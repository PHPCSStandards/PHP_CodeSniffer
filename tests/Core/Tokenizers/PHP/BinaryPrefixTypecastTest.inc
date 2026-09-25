<?php

/*
 * Safeguard that the b-prefix binary string type casts is tokenized correctly.
 *
 * Support for the b-prefix for text strings was added in PHP 5.2.1.
 */

/* testNotBinaryStringCastSingleQuotes */
$ordinary = 'b"something"';

/* testNotBinaryStringCastDoubleQuotes */
$ordinary = "b'something'";

/* testNotBinaryStringCastDoubleQuotesWithInterpolation */
$ordinary = "b'$something'";

/* testBinaryStringCastLowercaseSingleQuotes */
$binary = b'binary string';

/* testBinaryStringCastLowercaseDoubleQuotes */
$binary = b"binary string";

/* testBinaryStringCastLowercaseDoubleQuotesWithInterpolation */
$binary = b"binary $string";

/* testBinaryStringCastUppercaseSingleQuotes */
$binary = B'binary string';

/* testBinaryStringCastUppercaseDoubleQuotes */
$binary = B"binary string";

/* testBinaryStringCastUppercaseDoubleQuotesWithInterpolation */
$binary = B"binary $string";

// Intentional parse error.
// Whitespace between the text string and the b is not supported by PHP.
/* testNotBinaryStringCastWithWhitespace */
$binary = b 'binary string';
