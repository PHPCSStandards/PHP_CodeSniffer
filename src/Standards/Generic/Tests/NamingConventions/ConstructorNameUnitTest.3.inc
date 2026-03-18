<?php

// Intentional parse error (missing method name).
// This should be the only test in this file.
// Testing that the sniff is *not* triggered.

$anon = class {
    public function {}
};
