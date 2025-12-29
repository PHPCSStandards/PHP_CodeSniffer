<?php

// Intentional parse error. There should be a colon between the function 'use' and its return type.
$closure = function ($foo) use ($bar) string { return 'baz'; };
