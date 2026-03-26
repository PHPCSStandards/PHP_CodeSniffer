<?php

// Intentional parse errors!
// Using a keyword as a "goto" label is a parse error, but should still be tokenized correctly as T_STRING to not confuse sniffs.

function gotoLabels() {
    goto /* testAbstract */ abstract;
    goto /* testArray */ array;
    goto /* testAs */ as;
    goto /* testBreak */ break;
    goto /* testCallable */ callable;
    goto /* testCase */ case;
    goto /* testCatch */ catch;
    goto /* testClass */ class;
    goto /* testClone */ clone;
    goto /* testConst */ const;
    goto /* testContinue */ continue;
    goto /* testDeclare */ declare;
    goto /* testDefault */ default;
    goto /* testDie */ die;
    goto /* testDo */ do;
    goto /* testEcho */ echo;
    goto /* testElse */ else;
    goto /* testElseIf */ elseif;
    goto /* testEmpty */ empty;
    goto /* testEndDeclare */ enddeclare;
    goto /* testEndFor */ endfor;
    goto /* testEndForeach */ endforeach;
    goto /* testEndIf */ endif;
    goto /* testEndSwitch */ endswitch;
    goto /* testEndWhile */ endwhile;
    goto /* testEnum */ enum;
    goto /* testEval */ eval;
    goto /* testExit */ exit;
    goto /* testExtends */ extends;
    goto /* testFinal */ final;
    goto /* testFinally */ finally;
    goto /* testFn */ fn;
    goto /* testFor */ for;
    goto /* testForeach */ ForEach;
    goto /* testFunction */ function;
    goto /* testGlobal */ global;
    goto /* testGoto */ goto;
    goto /* testIf */ if;
    goto /* testImplements */ implements;
    goto /* testInclude */ include;
    goto /* testIncludeOnce */ include_once;
    goto /* testInstanceOf */ instanceof;
    goto /* testInsteadOf */ insteadof;
    goto /* testInterface */ interface;
    goto /* testIsset */ isset;
    goto /* testList */ list;
    goto /* testMatch */ match;
    goto /* testNamespace */ namespace;
    goto /* testNew */ new;
    goto /* testPrint */ print;
    goto /* testPrivate */ private;
    goto /* testProtected */ protected;
    goto /* testPublic */ public;
    goto /* testReadonly */ readonly;
    goto /* testRequire */ require;
    goto /* testRequireOnce */ require_once;
    goto /* testReturn */ return;
    goto /* testStatic */ static;
    goto /* testSwitch */ switch;
    goto /* testThrows */ throw;
    goto /* testTrait */ trait;
    goto /* testTry */ try;
    goto /* testUnset */ unset;
    goto /* testUse */ use;
    goto /* testVar */ var;
    goto /* testWhile */ while;
    goto /* testYield */ yield;
    goto /* testYieldFrom */ yield_from;

    goto /* testAnd */ and;
    goto /* testOr */ or;
    goto /* testXor */ xor;
}
