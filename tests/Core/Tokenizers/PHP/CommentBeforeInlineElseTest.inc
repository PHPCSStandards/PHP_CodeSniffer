<?php

/*
 * The colon in the ternaries below is deliberately placed on a line without any indentation.
 * On PHP 8+, this makes the tokenizer merge the new line after the `//`/`#` comment into the
 * comment token and set the original new line token to `null`. The backward-walking loops in
 * the colon retokenization need to skip over these `null` tokens.
 * See https://github.com/PHPCSStandards/PHP_CodeSniffer/issues/1418.
 */

/* testInlineElseAfterSlashComment */
echo (5 >= 10)
? "a"
//
: "b";

/* testInlineElseAfterHashComment */
$var = true
? "a"
#
: "b";

/*
 * The colon after the closure/arrow function below is a return type separator, not an inline else.
 * The comment between the `function`/`fn` keyword and the parameter parenthesis creates the same
 * `null` token, which the backward-walking loop looking for the function keyword must skip over so
 * the return type colon is not mistaken for an inline else.
 */

/* testColonReturnTypeAfterSlashComment */
$fn = (5 >= 10)
? fn//
($x): int => $x
: "b";

/* testColonReturnTypeAfterHashComment */
$fn = (5 >= 10)
? function#
($x): int { return $x; }
: "b";
