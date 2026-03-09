<?php

// Intentional parse error (missing closing brace for the first if).
// This should be the only test in this file.
// Testing that the sniff is *not* triggered.
// Test for https://github.com/squizlabs/PHP_CodeSniffer/pull/2989.

if ( true ) {

// This second if is here to ensure that the sniff completely bows out of this file after
// encountering the first one without a closing brace.
if ( true )
    echo 'foo';
