<?php

// This should be the only test in this file.
// There should be only empty tokens after the scope closer of the "if" token.

for ($i = 0; $i < 5; $i++)
    if ($i === 3) {
        echo $i;
    }