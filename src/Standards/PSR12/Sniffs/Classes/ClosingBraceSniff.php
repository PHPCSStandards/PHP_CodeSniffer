<?php
/**
 * Verifies that closing braces are the last content on a line.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PSR12\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

class ClosingBraceSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array<int|string>
     */
    public function register()
    {
        return (Tokens::NAMED_OO_SCOPES + [T_FUNCTION => T_FUNCTION]);
    }


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, int $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if (isset($tokens[$stackPtr]['scope_closer']) === false) {
            return;
        }

        $closer = $tokens[$stackPtr]['scope_closer'];
        $next   = $phpcsFile->findNext(T_WHITESPACE, ($closer + 1), null, true);
        if ($next === false
            || $tokens[$next]['line'] !== $tokens[$closer]['line']
        ) {
            return;
        }

        $error = 'Closing brace must not be followed by any comment or statement on the same line';
        $phpcsFile->addError($error, $closer, 'StatementAfter');
    }
}
