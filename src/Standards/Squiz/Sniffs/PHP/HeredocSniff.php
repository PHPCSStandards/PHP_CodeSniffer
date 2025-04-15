<?php
/**
 * Bans the use of heredocs and nowdocs.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class HeredocSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array<int|string>
     */
    public function register()
    {
        return [
            T_START_HEREDOC,
            T_START_NOWDOC,
        ];

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $codePrefix = 'Heredoc';
        $data       = ['heredoc'];
        if ($tokens[$stackPtr]['code'] === T_START_NOWDOC) {
            $codePrefix = 'Nowdoc';
            $data       = ['nowdoc'];
        }

        $data[] = trim($tokens[$stackPtr]['content']);

        $error = 'Use of %s syntax (%s) is not allowed; use standard strings or inline HTML instead';
        $phpcsFile->addError($error, $stackPtr, $codePrefix.'NotAllowed', $data);

    }//end process()


}//end class
