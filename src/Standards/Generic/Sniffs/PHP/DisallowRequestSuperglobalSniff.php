<?php
/**
 * Ensures the $_REQUEST superglobal is not used
 *
 * @author    Jeantwan Teuma <jeant.m24@gmail.com>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Sniffs\PHP;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DisallowRequestSuperglobalSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array<int|string>
     */
    public function register()
    {
        return [T_VARIABLE];
    }


    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in the stack
     *                                               passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, int $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $varName = $tokens[$stackPtr]['content'];
        if ($varName !== '$_REQUEST') {
            return;
        }

        $error = 'The $_REQUEST superglobal should not be used; use $_GET, $_POST, or $_COOKIE instead';
        $phpcsFile->addError($error, $stackPtr, 'Found');
    }
}
