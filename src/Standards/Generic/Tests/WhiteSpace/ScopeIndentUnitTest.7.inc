<?php

// Flexible nowdoc (PHP 7.3+). This test needs to be in a separate file, as on PHP < 7.3 the nowdoc
// is not closed by the indented closing marker and the rest of the file would become part of it.
// This should be the only test in this file.
return [
    'lor' =>
        <<<'INTRO'
        lorem ipsum
        INTRO,
    'em' => [
        [
            '',
        ],
    ],
    'abc' => [
        'a' => 'wop wop',
        'b' => 'ola ola.',
    ],
];
