<?php

namespace Foo;

// These are calls to the namespaced function `Foo\define()`,
// which is declared further down in the file.
define('name', 'value');
namespace\define('name', 'value');

// These are calls to other namespaced functions, never the global one.
Sub\define('name', 'value');
\My\Other\NS\define('name', 'value');

// Calls to the global function via the leading backslash MUST still be checked.
\define('VALID_NAME', true);

// Lowercase here SHOULD be flagged: the leading backslash forces global resolution.
\define('lowercase_global', 'value');

function define($name, $value) {
    // Do something.
}
