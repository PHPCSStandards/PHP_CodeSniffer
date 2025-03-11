<?php

// Intentional parse error, should be ignored by the sniff.
// This should be the only test in this test case file.

enum PropertiesNotAllowed {
    var $_notAllowed;
}
