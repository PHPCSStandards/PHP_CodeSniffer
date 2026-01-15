--TEST--
Detect when the value of a polyfilled PHP token collides with a value already used by an existing internal PHP token.
--SKIPIF--
<?php
if (version_compare(PHP_VERSION, '8.4', '>=') === true) {
    echo 'skip because tokens used in this test already exist in PHP 8.4 so we cannot test polyfilling them', PHP_EOL;
}
--FILE--
<?php
define('T_PUBLIC_SET', T_STRING);
require 'src/Util/Tokens.php';
--EXPECTF--
Fatal error: Uncaught Exception: Externally polyfilled tokenizer constant value collision detected! T_PUBLIC_SET has the same value as T_STRING in %s:%d
Stack trace:
#0 %s(%d): PHP_CodeSniffer\Util\Tokens::polyfillTokenizerConstants()
#1 %s(%d): require('%s')
#2 {main}
  thrown in %s on line %d
