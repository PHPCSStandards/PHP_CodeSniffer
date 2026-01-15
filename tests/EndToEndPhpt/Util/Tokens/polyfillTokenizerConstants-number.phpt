--TEST--
Detect when an external party defines a PHP token polyfill with a number that we would have used.
--SKIPIF--
<?php
if (version_compare(PHP_VERSION, '8.4', '>=') === true) {
    echo 'skip because tokens used in this test already exist in PHP 8.4 so we cannot test polyfilling them', PHP_EOL;
}
--FILE--
<?php
define('T_PUBLIC_SET', 135000);
require 'src/Util/Tokens.php';
// ..00 is used, so this becomes ..01 (PHP 8.x) or ..14 (PHP 7.x)
if (T_PRIVATE_SET > 135000) {
    echo 'Success.', PHP_EOL;
} else {
    echo 'Failure - ', T_PRIVATE_SET, PHP_EOL;
}
--EXPECT--
Success.
