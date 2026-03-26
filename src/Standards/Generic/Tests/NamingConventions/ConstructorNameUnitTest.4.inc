<?php

// Intentional parse error (missing method name when gathering list).
// This should be the only test in this file.
// Testing that the sniff is *not* triggered.

class LiveCoding {
    public function __construct() {}
    public function {}
    public function myMethod() {}
}
