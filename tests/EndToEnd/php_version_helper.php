#!/usr/bin/env php
<?php

/**
 * Test helper to be called from BashUnit if a test needs to know whether or not the PHP version on which the test
 * is being run is a PHP version which has the full #php2shell patch or only a partial patch.
 *
 * Case in point: The official fixes for the #php2shell vulnerability still allow the custom "out of memory" message
 * to work/display.
 * However, the unofficial backports of these fixes, will display the fatal error and then bow out without running
 * any registered shutdown functions.
 *
 * PHP | Patched | Unpatched
 * --- | ------- | ---------
 * 8.6 | custom  | custom
 * 8.5 | custom  | custom
 * 8.4 | custom  | custom
 * 8.3 | custom  | custom
 * 8.2 | custom  | custom
 * 8.1 | fatal   | custom
 * 8.0 | fatal   | custom
 * 7.4 | fatal   | custom
 * etc.
 *
 * This helper will return an exit code, i.e. it will return `0` for a PHP version with the full patch/old functionality.
 * and it will return `1` when the PHP version only contains a partial (backported) patch which won't run shutdown functions.
 *
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */
switch (true) {
case (PHP_VERSION_ID >= 50400 && PHP_VERSION_ID < 50445):
case (PHP_VERSION_ID >= 50500 && PHP_VERSION_ID < 50538):
case (PHP_VERSION_ID >= 50600 && PHP_VERSION_ID < 50640):
case (PHP_VERSION_ID >= 70000 && PHP_VERSION_ID < 70033):
case (PHP_VERSION_ID >= 70100 && PHP_VERSION_ID < 70133):
case (PHP_VERSION_ID >= 70200 && PHP_VERSION_ID < 70234):
case (PHP_VERSION_ID >= 70300 && PHP_VERSION_ID < 70333):
case (PHP_VERSION_ID >= 70400 && PHP_VERSION_ID < 70433):
case (PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80030):
case (PHP_VERSION_ID >= 80100 && PHP_VERSION_ID < 80134):
case (PHP_VERSION_ID >= 80200):
    exit(0);

default:
    exit(1);
}
