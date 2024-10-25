phpcs:set Generic.Files.LineLength ignoreUseStatements true
<?php

/* This line is fine. */
use ThisShort\UseStatement\ThatShouldBeAllowed;

/* This line is too long but will be ignored. This line is too long but will be ignored. */
use ThisReallyLong\Long\Loooooooooooooooong\Loooooooooooooooong\UseStatement\ThatShouldBeAllowed\AndThrowNoWarningsOrErrors;
