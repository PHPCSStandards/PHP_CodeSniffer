<?php
/**
 * Verifies that operators have valid spacing surrounding them.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PSR12\Sniffs\Operators;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\OperatorSpacingSniff as SquizOperatorSpacingSniff;
use PHP_CodeSniffer\Util\Tokens;

class OperatorSpacingSniff extends SquizOperatorSpacingSniff
{

    /**
     * The PER version to be compatible with. For backwards compatibility this is set to 1.0 by default.
     *
     * @var string
     */
    public $perCompatible = '1.0';


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array<int|string>
     */
    public function register()
    {
        parent::register();

        $targets   = Tokens::COMPARISON_TOKENS;
        $targets  += Tokens::OPERATORS;
        $targets  += Tokens::ASSIGNMENT_TOKENS;
        $targets  += Tokens::BOOLEAN_OPERATORS;
        $targets[] = T_INLINE_THEN;
        $targets[] = T_INLINE_ELSE;
        $targets[] = T_STRING_CONCAT;
        $targets[] = T_INSTANCEOF;

        // Also register the contexts we want to specifically skip over.
        $targets[] = T_DECLARE;

        return $targets;
    }


    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The current file being checked.
     * @param int                         $stackPtr  The position of the current token in
     *                                               the stack passed in $tokens.
     *
     * @return void|int Optionally returns a stack pointer. The sniff will not be
     *                  called again on the current file until the returned stack
     *                  pointer is reached. Return `$phpcsFile->numTokens` to skip
     *                  the rest of the file.
     */
    public function process(File $phpcsFile, int $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // Skip over declare statements as those should be handled by different sniffs.
        if ($tokens[$stackPtr]['code'] === T_DECLARE) {
            if (isset($tokens[$stackPtr]['parenthesis_closer']) === false) {
                // Parse error / live coding.
                return $phpcsFile->numTokens;
            }

            return $tokens[$stackPtr]['parenthesis_closer'];
        }

        if ($this->isOperator($phpcsFile, $stackPtr) === false) {
            return;
        }

        $operator = $tokens[$stackPtr]['content'];

        // PER-CS 3.0: Exception to the rule for pipe operators in multi-catch blocks where no space is required.
        // As union types didn't exist when PSR-12 was created, the pipe in catch statements
        // was originally treated as a bitwise operator. This check changes the spacing requirement
        // for that specific case when opting in to PER-CS 3.0 or higher.
        if ($tokens[$stackPtr]['code'] === T_BITWISE_OR
            && isset($tokens[$stackPtr]['nested_parenthesis']) === true
            && version_compare($this->perCompatible, '3.0', '>=') === true
        ) {
            $parenthesis = array_keys($tokens[$stackPtr]['nested_parenthesis']);
            $bracket     = array_pop($parenthesis);
            if (isset($tokens[$bracket]['parenthesis_owner']) === true
                && $tokens[$tokens[$bracket]['parenthesis_owner']]['code'] === T_CATCH
            ) {
                if ($tokens[($stackPtr - 1)]['code'] === T_WHITESPACE
                    && strpos($tokens[($stackPtr - 1)]['content'], $phpcsFile->eolChar) === false
                    && $tokens[($stackPtr - 1)]['column'] !== 1
                ) {
                    $error = 'Expected 0 spaces before "%s"; %s found';
                    $data  = [
                        $operator,
                        $tokens[($stackPtr - 1)]['length'],
                    ];

                    $fix = $phpcsFile->addFixableError($error, $stackPtr, 'SpaceBefore', $data);
                    if ($fix === true) {
                        $phpcsFile->fixer->replaceToken(($stackPtr - 1), '');
                    }
                }

                if ($tokens[($stackPtr + 1)]['code'] === T_WHITESPACE
                    && strpos($tokens[($stackPtr + 1)]['content'], $phpcsFile->eolChar) === false
                ) {
                    $error = 'Expected 0 spaces after "%s"; %s found';
                    $data  = [
                        $operator,
                        $tokens[($stackPtr + 1)]['length'],
                    ];

                    $fix = $phpcsFile->addFixableError($error, $stackPtr, 'SpaceAfter', $data);
                    if ($fix === true) {
                        $phpcsFile->fixer->replaceToken(($stackPtr + 1), '');
                    }
                }

                // Now that this special case is handled, we can return early as we don't need to do
                // further checks.
                return;
            }
        }

        $checkBefore = true;
        $checkAfter  = true;

        // Skip short ternary.
        if ($tokens[($stackPtr)]['code'] === T_INLINE_ELSE
            && $tokens[($stackPtr - 1)]['code'] === T_INLINE_THEN
        ) {
            $checkBefore = false;
        }

        // Skip operator with comment on previous line.
        if ($tokens[($stackPtr - 1)]['code'] === T_COMMENT
            && $tokens[($stackPtr - 1)]['line'] < $tokens[$stackPtr]['line']
        ) {
            $checkBefore = false;
        }

        if (isset($tokens[($stackPtr + 1)]) === true) {
            // Skip short ternary.
            if ($tokens[$stackPtr]['code'] === T_INLINE_THEN
                && $tokens[($stackPtr + 1)]['code'] === T_INLINE_ELSE
            ) {
                $checkAfter = false;
            }
        } else {
            // Skip partial files.
            $checkAfter = false;
        }

        if ($checkBefore === true && $tokens[($stackPtr - 1)]['code'] !== T_WHITESPACE) {
            $error = 'Expected at least 1 space before "%s"; 0 found';
            $data  = [$operator];
            $fix   = $phpcsFile->addFixableError($error, $stackPtr, 'NoSpaceBefore', $data);
            if ($fix === true) {
                $phpcsFile->fixer->addContentBefore($stackPtr, ' ');
            }
        }

        if ($checkAfter === true && $tokens[($stackPtr + 1)]['code'] !== T_WHITESPACE) {
            $error = 'Expected at least 1 space after "%s"; 0 found';
            $data  = [$operator];
            $fix   = $phpcsFile->addFixableError($error, $stackPtr, 'NoSpaceAfter', $data);
            if ($fix === true) {
                $phpcsFile->fixer->addContent($stackPtr, ' ');
            }
        }
    }
}
