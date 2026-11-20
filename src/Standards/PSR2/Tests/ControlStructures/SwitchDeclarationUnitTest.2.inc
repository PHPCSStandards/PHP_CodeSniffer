<?php

// Intentional parse error (missing colon).
// This should be the only test in this file.
// Testing that the sniff is *not* triggered.

switch($a) {
    case 1
}
