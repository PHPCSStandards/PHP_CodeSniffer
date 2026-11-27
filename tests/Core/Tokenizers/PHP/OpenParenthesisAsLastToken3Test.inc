<?php

// Testing that the tokenizer doesn't cause an "Undefined array key" warning.
// Intentional parse error. This should be the only test in the file.
// Mind: the file must not end with a new line.
// Ref: https://github.com/PHPCSStandards/PHP_CodeSniffer/issues/1543

/* testOpenParenthesisAndVoidAsLastTokens */
foo(void