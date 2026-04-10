<?php

namespace Foo;

// `define` is aliased AWAY: the local symbol is `something`, not `define`.
use function Bar\define as something;

define('name', 'value');
