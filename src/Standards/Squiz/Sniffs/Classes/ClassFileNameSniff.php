<?php
/**
 * Tests that the file name and the name of the class contained within the file match.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

class ClassFileNameSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array<int|string>
     */
    public function register()
    {
        $targets = Tokens::$ooScopeTokens;
        unset($targets[T_ANON_CLASS]);

        return $targets;

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in
     *                                               the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $filename = $phpcsFile->getFilename();
        if ($filename === 'STDIN') {
            return $phpcsFile->numTokens;
        }

        $fullPath = basename($filename);
        $fileName = substr($fullPath, 0, strrpos($fullPath, '.'));

        $tokens = $phpcsFile->getTokens();
        $ooName = $phpcsFile->getDeclarationName($stackPtr);
        if ($ooName === null) {
            // Probably parse error/live coding.
            return;
        }

        if ($ooName !== $fileName) {
            $error = '%s name doesn\'t match filename; expected "%s %s"';
            $data  = [
                ucfirst($tokens[$stackPtr]['content']),
                $tokens[$stackPtr]['content'],
                $fileName,
            ];
            $phpcsFile->addError($error, $stackPtr, 'NoMatch', $data);
        }

    }//end process()


}//end class
