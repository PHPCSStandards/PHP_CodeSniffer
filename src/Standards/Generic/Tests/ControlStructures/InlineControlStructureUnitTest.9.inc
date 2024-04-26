<?php

// Intentional parse error (nothing after while closing parenthesis).
// This should be the only test in this file.
// Testing that the sniff is *not* triggered.

while ($i < 5)
