<?php

// Intentional parse error (nothing after for closing parenthesis).
// This should be the only test in this file.
// Testing that the sniff is *not* triggered.

for ($i = 0; $i < 5; $i++)
