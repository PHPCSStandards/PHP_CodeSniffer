--TEST--
Value collision with a non-tokenizer constant should not cause an error.
--SKIPIF--
<?php
if (version_compare(PHP_VERSION, "8.4", ">=")) {
    echo "skip because tokens used in this test already exist in PHP 8.4 so we cannot test polyfilling them", PHP_EOL;
}
--FILE--
<?php
// Using T_STRING as a value because that would be a collision (and throw) if the constant name looked like a tokenizer constant.
define('T_', T_STRING); // Too short
define('ONE', T_STRING); // First character is not 'T'
define('TWO', T_STRING); // Second character is not '_'
require('src/Util/Tokens.php');
echo 'No conflicts', PHP_EOL;
--EXPECT--
No conflicts
