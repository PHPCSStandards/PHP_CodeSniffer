<?php

// Intentional parse error (missing method name). This should be the only test in the file.

namespace Vendor\Package;

class LiveCoding {
    /**
     * This test needs to hit the processReturn() method.
     */
    function {
        return;
    }
}
