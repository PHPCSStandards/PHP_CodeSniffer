<?php
/**
 * Checks the format of the declare statements.
 *
 * @author    Sertan Danis <sdanis@squiz.net>
 * @copyright 2006-2019 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\PSR12\Sniffs\Files;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

class DeclareStatementSniff implements Sniff
{

    /**
     * Mapping from token code to human-readable name. Used to produce error messages.
     *
     * @var array<int|string, string>
     */
    private $NAMES = [
        T_DECLARE                  => 'declare keyword',
        T_OPEN_PARENTHESIS         => 'opening parenthesis',
        T_STRING                   => 'directive',
        T_EQUAL                    => 'equals sign',
        T_LNUMBER                  => 'directive value',
        T_CONSTANT_ENCAPSED_STRING => 'directive value',
        T_CLOSE_PARENTHESIS        => 'closing parenthesis',
        T_SEMICOLON                => 'semicolon',
        T_CLOSE_TAG                => 'closing PHP tag',
        T_OPEN_CURLY_BRACKET       => 'opening curly bracket',
        T_CLOSE_CURLY_BRACKET      => 'closing curly bracket',
    ];


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array<int|string>
     */
    public function register()
    {
        return [T_DECLARE];

    }//end register()


    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in
     *                                               the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $openParen = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $stackPtr);

        if ($openParen === false) {
            // Live coding / parse error.
            return;
        }

        $this->complainIfTokensNotAdjacent(
            $phpcsFile,
            $stackPtr,
            $openParen,
            'SpaceFoundAfterDeclare'
        );

        if (isset($tokens[$openParen]['parenthesis_closer']) === false) {
            // Live coding / parse error.
            return;
        }

        $closeParen = $tokens[$openParen]['parenthesis_closer'];

        $tokenBeforeDirective = $openParen;

        do {
            $directive = $phpcsFile->findNext(T_STRING, ($tokenBeforeDirective + 1), $closeParen);

            if ($directive === false) {
                // Live coding / parse error.
                return;
            }

            if ($tokens[$tokenBeforeDirective]['code'] === T_OPEN_PARENTHESIS) {
                // There should be no space between open parenthesis and the directive.
                $this->complainIfTokensNotAdjacent(
                    $phpcsFile,
                    $tokenBeforeDirective,
                    $directive,
                    'SpaceFoundBeforeDirective'
                );
                // There's no 'else' clause here, because PSR12 makes no mention of
                // formatting of the comma in a multi-directive statement.
            }

            // The directive must be in lowercase.
            if ($tokens[$directive]['content'] !== strtolower($tokens[$directive]['content'])) {
                $error = 'The directive of a declare statement must be in lowercase';
                $fix   = $phpcsFile->addFixableError($error, $directive, 'DirectiveNotLowercase');
                if ($fix === true) {
                    $phpcsFile->fixer->replaceToken($directive, strtolower($tokens[$directive]['content']));
                }
            }

            // When wishing to declare strict types in files containing markup outside PHP opening
            // and closing tags, the declaration MUST be on the first line of the file and include
            // an opening PHP tag, the strict types declaration and closing tag.
            if ($tokens[$stackPtr]['line'] !== 1 && strtolower($tokens[$directive]['content']) === 'strict_types') {
                $nonPHP = $phpcsFile->findNext(T_INLINE_HTML, 0);
                if ($nonPHP !== false) {
                    $error = 'When declaring strict_types in a file with markup outside PHP tags, the declare statement must be on the first line';
                    $phpcsFile->addError($error, $stackPtr, 'DeclareNotOnFirstLine');
                }
            }

            $equals = $phpcsFile->findNext(T_EQUAL, ($directive + 1), $closeParen);

            if ($equals === false) {
                // Live coding / parse error.
                return;
            }

            // There should be no space between directive and the equal sign.
            $this->complainIfTokensNotAdjacent(
                $phpcsFile,
                $directive,
                $equals,
                'SpaceFoundAfterDirective'
            );

            $value = $phpcsFile->findNext([T_LNUMBER, T_CONSTANT_ENCAPSED_STRING], ($equals + 1), $closeParen);

            if ($value === false) {
                // Live coding / parse error.
                return;
            }

            // There should be no space between equals sign and directive value.
            $this->complainIfTokensNotAdjacent(
                $phpcsFile,
                $equals,
                $value,
                'SpaceFoundBeforeDirectiveValue'
            );

            // Handle multi-directive statements.
            $tokenBeforeDirective = $phpcsFile->findNext(T_COMMA, ($value + 1), $closeParen);
        } while ($tokenBeforeDirective !== false);

        // $closeParen was defined earlier as $closeParen = $tokens[$openParen]['parenthesis_closer'];
        // There should be no space between directive value and closing parenthesis.
        $this->complainIfTokensNotAdjacent(
            $phpcsFile,
            $value,
            $closeParen,
            'SpaceFoundAfterDirectiveValue'
        );

        $nextThing = $phpcsFile->findNext(Tokens::$emptyTokens, ($closeParen + 1), null, true);

        if ($nextThing === false) {
            // Live coding / parse error.
            return;
        }

        // There should be no space between closing parenthesis and semicolon.
        if ($tokens[$nextThing]['code'] === T_SEMICOLON) {
            $this->complainIfTokensNotAdjacent(
                $phpcsFile,
                $closeParen,
                $nextThing,
                'SpaceFoundBeforeSemicolon'
            );

            if (isset($nonPHP) === true && $nonPHP !== false) {
                $PHPClosingTag = $phpcsFile->findNext(Tokens::$emptyTokens, ($nextThing + 1), null, true);
                if ($PHPClosingTag !== false) {
                    $this->complainIfNotExactlyOneSpaceBetween(
                        $phpcsFile,
                        $nextThing,
                        $PHPClosingTag,
                        'BeforeClosePHPTag'
                    );
                }
            }

            return;
        }//end if

        // There should be exactly one space between the close parenthesis and the closing PHP tag.
        if ($tokens[$nextThing]['code'] === T_CLOSE_TAG) {
            $this->complainIfNotExactlyOneSpaceBetween(
                $phpcsFile,
                $closeParen,
                $nextThing,
                'BeforeClosePHPTag'
            );

            return;
        }

        if ($tokens[$nextThing]['code'] === T_OPEN_CURLY_BRACKET) {
            // There should be exactly one space between the closing parenthesis and the opening bracket.
            $this->complainIfNotExactlyOneSpaceBetween(
                $phpcsFile,
                $closeParen,
                $nextThing,
                'BeforeCurlyBracket'
            );

            $openBracket = $nextThing;
            if (isset($tokens[$openBracket]['bracket_closer']) === false) {
                // Live coding / parse error.
                return;
            }

            $closeBracket = $tokens[$openBracket]['bracket_closer'];

            $openLine  = $tokens[$openBracket]['line'];
            $closeLine = $tokens[$closeBracket]['line'];

            $afterOpen   = $phpcsFile->findNext(Tokens::$emptyTokens, ($openBracket + 1), $closeBracket, true);
            $afterClose  = $phpcsFile->findNext(Tokens::$emptyTokens, ($closeBracket + 1), null, true);
            $beforeClose = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($closeBracket - 1), $openBracket, true);

            // The open curly bracket must be the last code on the line.
            if ($afterOpen !== false && $tokens[$afterOpen]['line'] === $openLine) {
                $error = 'The open curly bracket of a declare statement must be the last code on the line';

                $fix = $phpcsFile->addFixableError($error, $afterOpen, 'CodeFoundAfterOpenCurlyBracket');

                if ($fix === true) {
                    $phpcsFile->fixer->beginChangeset();
                    if ($tokens[($afterOpen - 1)]['code'] === T_WHITESPACE) {
                        $phpcsFile->fixer->replaceToken(($afterOpen - 1), '');
                    }

                    // 4 = indent size as defined by PSR12.
                    $indent = str_repeat(' ', (4 + $tokens[$stackPtr]['column'] - 1));
                    $phpcsFile->fixer->addContentBefore($afterOpen, PHP_EOL.$indent);
                    $phpcsFile->fixer->endChangeset();
                }
            }

            // The closing curly bracket must be on a new line.
            if ($afterClose !== false && $tokens[$afterClose]['line'] === $closeLine) {
                $error = 'The closing curly bracket of a declare statement must be the last code on the line';
                $fix   = $phpcsFile->addFixableError($error, $afterClose, 'CodeFoundAfterCloseCurlyBracket');
                if ($fix === true) {
                    $phpcsFile->fixer->addNewlineBefore($afterClose);
                }
            }

            if ($beforeClose !== false && $tokens[$beforeClose]['line'] === $closeLine) {
                $error = 'The closing curly bracket of a declare statement must be on a new line.';
                $fix   = $phpcsFile->addFixableError($error, $closeBracket, 'CurlyBracketNotOnNewLine');
                if ($fix === true) {
                    $phpcsFile->fixer->beginChangeset();
                    if ($tokens[($closeBracket - 1)]['code'] === T_WHITESPACE) {
                        $phpcsFile->fixer->replaceToken(($closeBracket - 1), '');
                    }

                    $phpcsFile->fixer->addNewlineBefore($closeBracket);
                    $phpcsFile->fixer->endChangeset();
                }
            }

            // Closing curly bracket must align with the declare keyword.
            if ($tokens[$stackPtr]['column'] !== $tokens[$closeBracket]['column']) {
                $error = 'The closing curly bracket of a declare statements must be aligned with the declare keyword';

                $expected = ($tokens[$stackPtr]['column'] - 1);
                $actual   = ($tokens[$closeBracket]['column'] - 1);
                $indent   = trim($tokens[($closeBracket - 1)]['content'], PHP_EOL);

                if ($expected > $actual) {
                    $fix = $phpcsFile->addFixableError($error, $closeBracket, 'CloseBracketNotAligned');
                    if ($fix === true) {
                        $phpcsFile->fixer->addContentBefore($closeBracket, str_repeat(' ', ($expected - $actual)));
                    }
                } else if ($tokens[($closeBracket - 1)]['code'] === T_WHITESPACE && strlen($indent) > $expected) {
                    $fix = $phpcsFile->addFixableError($error, $closeBracket, 'CloseBracketNotAligned');
                    if ($fix === true) {
                        $phpcsFile->fixer->replaceToken(($closeBracket - 1), str_repeat(' ', $expected));
                    }
                } else {
                    $phpcsFile->addError($error, $closeBracket, 'CloseBracketNotAligned');
                }
            }//end if
        }//end if

    }//end process()


    /**
     * Add an error if the token is not at the expected index. Fix if possible.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile     The file being scanned.
     * @param int                         $previousToken Index within $tokens[] of the first token.
     * @param int                         $nextToken     Index within $tokens[] of the second token.
     * @param string                      $errorCode     Error code to be used for this problem.
     *
     * @return void
     */
    private function complainIfTokensNotAdjacent($phpcsFile, $previousToken, $nextToken, $errorCode)
    {
        if (($previousToken + 1) === $nextToken) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $error  = 'Expected no space between the '.$this->NAMES[$tokens[$previousToken]['code']].' and the '.$this->NAMES[$tokens[$nextToken]['code']].' in a declare statement';

        $onlyWhitespace = true;
        for ($i = ($previousToken + 1); $i < $nextToken; $i++) {
            if ($tokens[$i]['code'] !== T_WHITESPACE) {
                $onlyWhitespace = false;
                break;
            }
        }

        if ($onlyWhitespace === true) {
            $fix = $phpcsFile->addFixableError($error, ($previousToken + 1), $errorCode);

            if ($fix === true) {
                $phpcsFile->fixer->beginChangeset();
                for ($i = ($previousToken + 1); $i < $nextToken; $i++) {
                    $phpcsFile->fixer->replaceToken($i, '');
                }

                $phpcsFile->fixer->endChangeset();
            }
        } else {
            $phpcsFile->addError($error, ($previousToken + 1), $errorCode);
        }

    }//end complainIfTokensNotAdjacent()


    /**
     * Add an error if there is not exactly one space between tokens. Fix if possible.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile     The file being scanned.
     * @param int                         $previousToken Index within $tokens[] of the first token.
     * @param int                         $nextToken     Index within $tokens[] of the second token.
     * @param string                      $errorCode     Error code suffix for this problem.
     *
     * @return void
     */
    private function complainIfNotExactlyOneSpaceBetween($phpcsFile, $previousToken, $nextToken, $errorCode)
    {
        $contentBetween = $phpcsFile->getTokensAsString(($previousToken + 1), ($nextToken - $previousToken - 1), true);

        if ($contentBetween === ' ') {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $error  = 'Expected one space between the '.$this->NAMES[$tokens[$previousToken]['code']].' and the '.$this->NAMES[$tokens[$nextToken]['code']].' in a declare statement';

        if ($contentBetween === '') {
            $fix = $phpcsFile->addFixableError($error, $nextToken, 'NoSpaceFound'.$errorCode);
            if ($fix === true) {
                $phpcsFile->fixer->addContentBefore($nextToken, ' ');
            }

            return;
        }

        if (trim($contentBetween) !== '') {
            $phpcsFile->addError($error, ($previousToken + 1), 'NonSpaceFound'.$errorCode);
            return;
        }

        $fix = $phpcsFile->addFixableError($error, ($nextToken - 1), 'ExtraSpaceFound'.$errorCode);

        if ($fix === true) {
            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->replaceToken(($previousToken + 1), ' ');
            for ($i = ($previousToken + 2); $i < $nextToken; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }

            $phpcsFile->fixer->endChangeset();
        }

    }//end complainIfNotExactlyOneSpaceBetween()


}//end class
