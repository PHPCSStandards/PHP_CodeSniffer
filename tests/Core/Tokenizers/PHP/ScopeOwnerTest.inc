<?php

/* testNormalIfCondition */
if (true) {
    return;
}

/* testFunctionCallInIfCondition */
if (doThing(0)) {
    return;
}

/* testHeredocInIfCondition */
// Ref: https://github.com/PHPCSStandards/PHP_CodeSniffer/issues/149
if (foo(<<<EOD
foobar!
EOD
)) {
    return;
}
