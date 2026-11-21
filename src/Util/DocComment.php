<?php
/**
 * Utilities for doc comment types.
 *
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Util;

use PHP_CodeSniffer\Files\File;

class DocComment
{


    /**
     * Read a bracketed type spanning multiple comment strings.
     *
     * Stops at the next tag or comment closer. Single-line and incomplete types
     * return null so callers can retain their existing handling of those types.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The first comment string of the type.
     *
     * @return string|null
     */
    public static function getMultilineType(File $phpcsFile, int $stackPtr)
    {
        $tokens   = $phpcsFile->getTokens();
        $type     = '';
        $brackets = [];
        $pairs    = [
            '{' => '}',
            '(' => ')',
            '[' => ']',
            '<' => '>',
        ];
        $quote    = null;

        for ($i = $stackPtr; $i < $phpcsFile->numTokens; $i++) {
            if ($tokens[$i]['code'] === T_DOC_COMMENT_TAG
                || $tokens[$i]['code'] === T_DOC_COMMENT_CLOSE_TAG
            ) {
                break;
            }

            if ($tokens[$i]['code'] !== T_DOC_COMMENT_STRING) {
                continue;
            }

            if ($i !== $stackPtr) {
                $type .= ' ';
            }

            $content = $tokens[$i]['content'];
            $length  = strlen($content);
            for ($j = 0; $j < $length; $j++) {
                $char = $content[$j];
                if ($quote !== null) {
                    $type .= $char;
                    if ($char === '\\' && ($j + 1) < $length) {
                        $type .= $content[++$j];
                    } elseif ($char === $quote) {
                        $quote = null;
                    }

                    continue;
                }

                if ($char === '"' || $char === "'") {
                    $quote = $char;
                } elseif (isset($pairs[$char]) === true) {
                    $brackets[] = $pairs[$char];
                } elseif (strpos('})]>', $char) !== false) {
                    // The arrow in array(key => value) is not a closing bracket.
                    if ($char !== '>' || $j === 0 || $content[($j - 1)] !== '=') {
                        if (array_pop($brackets) !== $char) {
                            return null;
                        }
                    }
                } elseif (($char === ' ' || $char === "\t") && $brackets === []) {
                    if ($i !== $stackPtr) {
                        return $type;
                    }

                    return null;
                }

                $type .= $char;
            }

            if ($brackets === [] && $quote === null) {
                if ($i !== $stackPtr) {
                    return $type;
                }

                return null;
            }
        }

        return null;
    }
}
