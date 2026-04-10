<?php

namespace Foo {
    function define($name, $value) {
        // Do something.
    }

    define('name', 'value');
}

namespace Bar {
    // This must still be flagged: Foo's custom define() is not in scope here.
    define('lowercase_global', 'value');
}
