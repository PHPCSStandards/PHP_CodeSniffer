<?php

// Intentional parse error (missing method name). This should be the only test in the file.

$anon = new class() {
    function {
        return;
    }
}
