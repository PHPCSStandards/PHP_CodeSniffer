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
