<?php
/**
 * Tests the conversion of PHP native context sensitive keywords to T_STRING when used in a "goto" statement.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Tokenizers\PHP;

use PHP_CodeSniffer\Tests\Core\Tokenizers\AbstractTokenizerTestCase;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Tests the conversion of PHP native context sensitive keywords to T_STRING when used in a "goto" statement.
 *
 * @covers PHP_CodeSniffer\Tokenizers\PHP::tokenize
 */
final class ContextSensitiveKeywordsGotoTest extends AbstractTokenizerTestCase
{


    /**
     * Test that context sensitive keyword is tokenized as string when used in a "goto" statement.
     *
     * @param string $testMarker The comment which prefaces the target token in the test file.
     *
     * @dataProvider dataStrings
     *
     * @return void
     */
    public function testStrings($testMarker)
    {
        $tokens     = $this->phpcsFile->getTokens();
        $target     = $this->getTargetToken($testMarker, (Tokens::CONTEXT_SENSITIVE_KEYWORDS + [T_STRING]));
        $tokenArray = $tokens[$target];

        $this->assertSame(T_STRING, $tokenArray['code'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING (code)');
        $this->assertSame('T_STRING', $tokenArray['type'], 'Token tokenized as ' . $tokenArray['type'] . ', not T_STRING (type)');
    }


    /**
     * Data provider.
     *
     * @see testStrings()
     *
     * @return array<string, array<string>>
     */
    public static function dataStrings()
    {
        return [
            'abstract'     => ['/* testAbstract */'],
            'array'        => ['/* testArray */'],
            'as'           => ['/* testAs */'],
            'break'        => ['/* testBreak */'],
            'callable'     => ['/* testCallable */'],
            'case'         => ['/* testCase */'],
            'catch'        => ['/* testCatch */'],
            'class'        => ['/* testClass */'],
            'clone'        => ['/* testClone */'],
            'const'        => ['/* testConst */'],
            'continue'     => ['/* testContinue */'],
            'declare'      => ['/* testDeclare */'],
            'default'      => ['/* testDefault */'],
            'die'          => ['/* testDie */'],
            'do'           => ['/* testDo */'],
            'echo'         => ['/* testEcho */'],
            'else'         => ['/* testElse */'],
            'elseif'       => ['/* testElseIf */'],
            'empty'        => ['/* testEmpty */'],
            'enddeclare'   => ['/* testEndDeclare */'],
            'endfor'       => ['/* testEndFor */'],
            'endforeach'   => ['/* testEndForeach */'],
            'endif'        => ['/* testEndIf */'],
            'endswitch'    => ['/* testEndSwitch */'],
            'endwhile'     => ['/* testEndWhile */'],
            'enum'         => ['/* testEnum */'],
            'eval'         => ['/* testEval */'],
            'exit'         => ['/* testExit */'],
            'extends'      => ['/* testExtends */'],
            'final'        => ['/* testFinal */'],
            'finally'      => ['/* testFinally */'],
            'fn'           => ['/* testFn */'],
            'for'          => ['/* testFor */'],
            'foreach'      => ['/* testForeach */'],
            'function'     => ['/* testFunction */'],
            'global'       => ['/* testGlobal */'],
            'goto'         => ['/* testGoto */'],
            'if'           => ['/* testIf */'],
            'implements'   => ['/* testImplements */'],
            'include'      => ['/* testInclude */'],
            'include_once' => ['/* testIncludeOnce */'],
            'instanceof'   => ['/* testInstanceOf */'],
            'insteadof'    => ['/* testInsteadOf */'],
            'interface'    => ['/* testInterface */'],
            'isset'        => ['/* testIsset */'],
            'list'         => ['/* testList */'],
            'match'        => ['/* testMatch */'],
            'namespace'    => ['/* testNamespace */'],
            'new'          => ['/* testNew */'],
            'print'        => ['/* testPrint */'],
            'private'      => ['/* testPrivate */'],
            'protected'    => ['/* testProtected */'],
            'public'       => ['/* testPublic */'],
            'readonly'     => ['/* testReadonly */'],
            'require'      => ['/* testRequire */'],
            'require_once' => ['/* testRequireOnce */'],
            'return'       => ['/* testReturn */'],
            'static'       => ['/* testStatic */'],
            'switch'       => ['/* testSwitch */'],
            'throws'       => ['/* testThrows */'],
            'trait'        => ['/* testTrait */'],
            'try'          => ['/* testTry */'],
            'unset'        => ['/* testUnset */'],
            'use'          => ['/* testUse */'],
            'var'          => ['/* testVar */'],
            'while'        => ['/* testWhile */'],
            'yield'        => ['/* testYield */'],
            'yield_from'   => ['/* testYieldFrom */'],
            'and'          => ['/* testAnd */'],
            'or'           => ['/* testOr */'],
            'xor'          => ['/* testXor */'],
        ];
    }
}
