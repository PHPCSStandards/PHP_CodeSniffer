#!/usr/bin/env bash

function tear_down() {
  rm -f tests/EndToEnd/Fixtures/*.fixed
}

function test_phpcs_out_of_memory_error_handling() {
  OUTPUT="$(bin/phpcs -d memory_limit=4M --standard=tests/EndToEnd/Fixtures/endtoend.xml.dist tests/EndToEnd/Fixtures/)"
  # Exit code may be 255 or 139 depending on the PHP version, but the exact code is not our concern, just that it's non-zero.
  assert_unsuccessful_code

  assert_contains "The PHP_CodeSniffer \"phpcs\" command ran out of memory." "$OUTPUT"
  assert_contains "Either raise the \"memory_limit\" of PHP in the php.ini file or raise the memory limit at runtime" "$OUTPUT"
  assert_contains "using \"phpcs -d memory_limit=512M\" (replace 512M with the desired memory limit)." "$OUTPUT"
}

function test_phpcbf_out_of_memory_error_handling() {
  OUTPUT="$(bin/phpcbf -d memory_limit=4M --standard=tests/EndToEnd/Fixtures/endtoend.xml.dist tests/EndToEnd/Fixtures/ --suffix=.fixed)"
  # Exit code may be 255 or 139 depending on the PHP version, but the exact code is not our concern, just that it's non-zero.
  assert_unsuccessful_code

  assert_contains "The PHP_CodeSniffer \"phpcbf\" command ran out of memory." "$OUTPUT"
  assert_contains "Either raise the \"memory_limit\" of PHP in the php.ini file or raise the memory limit at runtime" "$OUTPUT"
  assert_contains "using \"phpcbf -d memory_limit=512M\" (replace 512M with the desired memory limit)." "$OUTPUT"
}

# The official fixes for the #php2shell vulnerability still allow the custom "out of memory" message to work/display.
# However, the unofficial backports of these fixes, will display the fatal error and then bow out without running
# any registered shutdown functions.
# The above tests are therefore no longer working for PHP versions with the unofficial backport of the fix.

# The question now is whether testing this is still useful in the first place.
# If it is, how do we determine on which versions to test ?
# It should work correctly on all PHP 8.2, 8.3, 8.4, 8.5 and 8.6 versions.
# For older PHP versions, it should *not* work anymore on the latest versions, but should still work on older patch releases....

function is_version_supported_for_custom_message() {
  OUTPUT="$( { php -r 'echo PHP_VERSION_ID;'; } 2>&1)"
  OUTPUT="$( { php -r \"echo (PHP_VERSION_ID >= 80200 ? 1 : 0);\"; } 2>&1)"
  [ "$(php -r 'echo PHP_VERSION_ID;')" -lt 80200 ]; echo $?
}

/*

PHP | Patched | Unpatched
--- | ------- | ---------
8.6 | custom  | custom
8.5 | custom  | custom 
8.4 | custom  | custom
8.3 | custom  | custom
8.2 | custom  | custom


8.1 | fatal   | custom
8.0 | fatal   | custom
7.4 | fatal   | custom


Versions below PHP 8.2 which should be considered patched:
5.4.45
5.5.38
5.6.40
7.0.33
7.1.33
7.2.34
7.3.33
7.4.33
8.0.30
8.1.34

Choices:
* Either skip the tests completely on PHP < 8.2
* Or skip only on PHP < 8.2 when on a patched version, but test the unpatched
* [Preferred] Or always test, but test for the fatal on PHP < 8.2 patched and for the custom message in all other cases

*/
