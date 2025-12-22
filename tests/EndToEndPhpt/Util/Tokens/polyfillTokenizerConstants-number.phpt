--TEST--
Detect when an external party defines a PHP token polyfill with a number that we would have used.
--SKIPIF--
<?php
if (version_compare(PHP_VERSION, "8.4", ">=")) {
    echo "skip because tokens used in this test already exist in PHP 8.4 so we cannot test polyfilling them", PHP_EOL;
}
--FILE--
<?php
define('T_PUBLIC_SET', 135000);
require('src/Util/Tokens.php');
echo T_PRIVATE_SET, PHP_EOL; // ..0 is used, so this becomes ..1
--EXPECT--
135001
