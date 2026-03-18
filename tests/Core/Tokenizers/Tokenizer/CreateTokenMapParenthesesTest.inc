<?php

/* testDeclareParenthesesOwner */
declare(strict_types=1/* testDeclareParenthesesCloser */);

/* testIfParenthesesOwner */
if ($a /* testIfParenthesesCloser */) {
/* testElseIfParenthesesOwner */
} elseif ($b /* testElseIfParenthesesCloser */) {
}

/* testForParenthesesOwner */
for ($a = 1; $a < $b; $a++ /* testForParenthesesCloser */) {}

/* testForeachParenthesesOwnerPlain */
foreach ($array as $k => $v /* testForeachParenthesesCloserPlain */) {}

/* testForeachParenthesesOwnerWithNestedArray */
foreach /*comment*/ (
    /* testArrayParenthesesOwner */
    array('a', 'b'/* testArrayParenthesesCloser */ ) as $k => $v
/* testForeachParenthesesCloserWithNestedArray */
) {}

/* testForeachParenthesesOwnerWithNestedList */
foreach (
    /* testListParenthesesOwner */
    $array as list($a, $b/* testListParenthesesCloser */)
/* testForeachParenthesesCloserWithNestedList */
) {}

/* testSwitchParenthesesOwner */
switch ($foo/* testSwitchParenthesesCloser */) {
    case '1';
        break;
}

/* testWhileParenthesesOwner */
while( $bar /* testWhileParenthesesCloser */) {}

do {
    something();
/* testDoWhileParenthesesOwner */
} while   (true/* testDoWhileParenthesesCloser */);

try {
/* testCatchParenthesesOwner */
} catch (MyException | OtherException $e /* testCatchParenthesesCloser */) {
}

/* testMatchParenthesesOwner */
$m = match ($baz/* testMatchParenthesesCloser */) {
    default => 10,
};

/* testFunctionParenthesesOwner */
function name($a, $b/* testFunctionParenthesesCloser */) {}

/* testFunctionParenthesesOwnerReturnByRef */
function &returnByRef ($a, $b/* testFunctionParenthesesCloserReturnByRef */) {}

class ReservedKeyword {
    /* testFunctionParenthesesOwnerKeywordNameMatch */
    public function match($a, $b/* testFunctionParenthesesCloserKeywordNameMatch */) {}

    /* testFunctionParenthesesOwnerKeywordNameFn */
    public function fn($a, $b/* testFunctionParenthesesCloserKeywordNameFn */) {}

    /* testFunctionParenthesesOwnerKeywordNameFnReturnByRef */
    public function &fn($a, $b/* testFunctionParenthesesCloserKeywordNameFnReturnByRef */) {}
}

/* testClosureParenthesesOwner */
$cl = function($a, $b/* testClosureParenthesesCloser */) {};

/* testAnonClassParenthesesOwner */
$anon = new class($a, $b/* testAnonClassParenthesesCloser */) {};

/* testAnonClassNoParentheses */
$anon = new class {
    const FOO = 1;
};

// This snippet belongs with the testAnonClassNoParentheses case. Making sure these parentheses are not set for the anon class.
$a = ($b + 10);

/* testArbitraryParenthesesOpener */
$a = ($b + $c/* testArbitraryParenthesesCloser */);

/* testFunctionCallParenthesesOpener */
do_something($b + $c, $d, false /* testFunctionCallParenthesesCloser */);

/* testIssetParenthesesOwner */
$set = isset($b, $c/* testIssetParenthesesCloser */);

/* testEmptyParenthesesOwner */
$empty = empty($b /* testEmptyParenthesesCloser */);

/* testUnsetParenthesesOwner */
unset ($b, $c /* testUnsetParenthesesCloser */);

/* testEvalParenthesesOwner */
$eval = eval("\$str = \"$str\";"/* testEvalParenthesesCloser */);

/* testExitParenthesesOwner */
exit ( 101 /* testExitParenthesesCloser */);

/* testDieParenthesesOwner */
die ('oopsie' /* testDieParenthesesCloser */);

/* testFullyQualifiedExitParenthesesOwner */
\exit ( 101 /* testFullyQualifiedExitParenthesesCloser */);

/* testFullyQualifiedDieParenthesesOwner */
\die ('oopsie' /* testFullyQualifiedDieParenthesesCloser */);

/* testExitNoParentheses */
exit;

/* testDieNoParentheses */
die;

/*
 * All together now, let's make things a little more interesting....
 */

/* testNestedOuterIfParenthesesOwner */
if (
    /* testNestedFunctionCallAParenthesesOpener */
    array_map(
        /* testNestedClosureParenthesesOwner */
        function ($a, $b /* testNestedClosureParenthesesCloser */) /* testNestedClosureUseParenthesesOwner */
            use (&$c /* testNestedClosureUseParenthesesCloser */)
        {
            /* testNestedForeachParenthesesOwner */
            foreach (
                /* testNestedFunctionCallBParenthesesOpener */
                array_keys(
                    /* testNestedFunctionCallCParenthesesOpener */
                    function_call(
                        /* testNestedArrayAParenthesesOwner */
                        array(10, 20/* testNestedArrayAParenthesesCloser */)
                    /* testNestedFunctionCallCParenthesesCloser */
                    )
                /* testNestedFunctionCallBParenthesesCloser */
                )
                as
                $v
            /* testNestedForeachParenthesesCloser */
            ) {}
        },
        /* testNestedArrayBParenthesesOwner */
        array(
            /* testNestedListParenthesesOwner */
            'keyA' => list($a, $b/* testNestedListParenthesesCloser */) = $array,
            /* testNestedAnonClassParenthesesOwner */
            'keyB' => new class($foo/* testNestedAnonClassParenthesesCloser */) {},
        /* testNestedArrayBParenthesesCloser */
        )
    /* testNestedFunctionCallAParenthesesCloser */
    )
/* testNestedOuterIfParenthesesCloser */
) {}
