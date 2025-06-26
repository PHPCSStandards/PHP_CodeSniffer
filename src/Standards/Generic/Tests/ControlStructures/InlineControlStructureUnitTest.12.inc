<?php

// Intentional parse error (nothing after else).
// This should be the only test in this file.
// Testing that the sniff is *not* triggered.

if ($bar) {
    doSomething();
} else
