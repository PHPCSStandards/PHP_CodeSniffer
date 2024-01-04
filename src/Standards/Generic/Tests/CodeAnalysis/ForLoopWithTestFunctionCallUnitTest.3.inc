<?php

// Intentional parse error (missing open parenthesis). Testing that the sniff is *not* triggered
// in this case and that no PHP 8.3+ deprecation notice is thrown.
for
