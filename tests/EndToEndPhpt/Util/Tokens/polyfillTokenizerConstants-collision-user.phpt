--TEST--
Detect when two or more polyfilled PHP tokens have the same value.
--SKIPIF--
<?php
if (version_compare(PHP_VERSION, '8.4', '>=') === true) {
    echo 'skip because tokens used in this test already exist in PHP 8.4 so we cannot test polyfilling them', PHP_EOL;
}
--FILE--
<?php
define('T_PRIVATE_SET', 10000);
define('T_PROTECTED_SET', 10000);
define('T_PUBLIC_SET', 10000);
require('src/Util/Tokens.php');
--EXPECTF--
Fatal error: Uncaught Exception: Externally polyfilled tokenizer constant value collision detected! T_PROTECTED_SET has the same value as T_PRIVATE_SET in %s:%d
Stack trace:
#0 %s(%d): PHP_CodeSniffer\Util\Tokens::polyfillTokenizerConstants()
#1 Standard input code(%d): require('...')
#2 {main}
  thrown in %s on line %d
