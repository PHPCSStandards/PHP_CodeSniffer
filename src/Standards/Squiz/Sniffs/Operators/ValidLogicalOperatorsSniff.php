<?php
/**
 * Ensures logical operators 'and' and 'or' are not used.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Sniffs\Operators;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ValidLogicalOperatorsSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array<int|string>
     */
    public function register()
    {
        return [
            T_LOGICAL_AND,
            T_LOGICAL_OR,
        ];

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The current file being scanned.
     * @param int                         $stackPtr  The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $replacements = [
            'and' => '&&',
            'or'  => '||',
        ];

        $operator = strtolower($tokens[$stackPtr]['content']);
        if (isset($replacements[$operator]) === false) {
            return;
        }

        $error = 'Logical operator "%s" is prohibited; use "%s" instead';
        $data  = [
            $operator,
            $replacements[$operator],
        ];

        // Based on https://www.php.net/manual/en/language.operators.precedence.php
        // It contains the tokens that can result in different code behaviour when replacing "AND / OR" with "&& / ||".
        // So we need to check for them to decide whether it's a fixable or non-fixable error.
        $blockList = [
            T_EQUAL,
            T_PLUS_EQUAL,
            T_MINUS_EQUAL,
            T_MUL_EQUAL,
            T_POW_EQUAL,
            T_DIV_EQUAL,
            T_CONCAT_EQUAL,
            T_MOD_EQUAL,
            T_AND_EQUAL,
            T_OR_EQUAL,
            T_XOR_EQUAL,
            T_SL_EQUAL,
            T_SR_EQUAL,
            T_COALESCE,
            T_COALESCE_EQUAL,
            T_INLINE_THEN,
            T_INLINE_ELSE,
            T_YIELD,
            T_YIELD_FROM,
            T_PRINT,
        ];

        // Extend blocklist depending on which operator is being processed.
        if ($tokens[$stackPtr]['code'] === T_LOGICAL_OR) {
            $blockList[] = T_LOGICAL_XOR;
        } else if ($tokens[$stackPtr]['code'] === T_LOGICAL_AND) {
            $blockList[] = T_BOOLEAN_OR;
        }

        $start = $phpcsFile->findStartOfStatement($stackPtr);
        $end   = $phpcsFile->findEndOfStatement($stackPtr);

        for ($index = $start; $index <= $end; ++$index) {
            // Skip checking contents of grouped statements.
            if ($tokens[$index]['code'] === T_OPEN_PARENTHESIS) {
                $index = ($phpcsFile->findEndOfStatement($index + 1) + 1);
            }

            if (in_array($tokens[$index]['code'], $blockList, true) === true) {
                $phpcsFile->addError($error, $stackPtr, 'NotAllowed', $data);
                return;
            }
        }

        $fix = $phpcsFile->addFixableError($error, $stackPtr, 'NotAllowed', $data);
        if ($fix === true) {
            $phpcsFile->fixer->replaceToken($stackPtr, $replacements[$operator]);
        }

    }//end process()


}//end class
