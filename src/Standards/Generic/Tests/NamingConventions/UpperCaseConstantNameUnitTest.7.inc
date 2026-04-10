<?php

namespace Foo;

use function Bar\define;
use function Bar\{otherFunc, define as renamedDefine};

// This is a call to the imported namespaced function, not the global one.
define('name', 'value');

// Lowercase here SHOULD be flagged: the leading backslash forces global resolution.
\define('lowercase_global', 'value');
