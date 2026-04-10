<?php
/**
 * Ensures that constant names are all uppercase.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

class UpperCaseConstantNameSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array<int|string>
     */
    public function register()
    {
        return [
            T_STRING,
            T_NAME_FULLY_QUALIFIED,
            T_CONST,
        ];
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

        if ($tokens[$stackPtr]['code'] === T_CONST) {
            // This is a constant declared with the "const" keyword.
            // This may be an OO constant, in which case it could be typed, so we need to
            // jump over a potential type to get to the name.
            $assignmentOperator = $phpcsFile->findNext([T_EQUAL, T_SEMICOLON], ($stackPtr + 1));
            if ($assignmentOperator === false || $tokens[$assignmentOperator]['code'] !== T_EQUAL) {
                // Parse error/live coding. Nothing to do. Rest of loop is moot.
                return;
            }

            $constant = $phpcsFile->findPrevious(Tokens::EMPTY_TOKENS, ($assignmentOperator - 1), ($stackPtr + 1), true);
            if ($constant === false) {
                return;
            }

            $constName = $tokens[$constant]['content'];

            if (strtoupper($constName) !== $constName) {
                if (strtolower($constName) === $constName) {
                    $phpcsFile->recordMetric($constant, 'Constant name case', 'lower');
                } else {
                    $phpcsFile->recordMetric($constant, 'Constant name case', 'mixed');
                }

                $error = 'Class constants must be uppercase; expected %s but found %s';
                $data  = [
                    strtoupper($constName),
                    $constName,
                ];
                $phpcsFile->addError($error, $constant, 'ClassConstantNotUpperCase', $data);
            } else {
                $phpcsFile->recordMetric($constant, 'Constant name case', 'upper');
            }

            return;
        }

        // Only interested in define statements now.
        if (strtolower(ltrim($tokens[$stackPtr]['content'], '\\')) !== 'define') {
            return;
        }

        // Make sure this is not a method call or class instantiation.
        $prev = $phpcsFile->findPrevious(Tokens::EMPTY_TOKENS, ($stackPtr - 1), null, true);
        if ($tokens[$prev]['code'] === T_OBJECT_OPERATOR
            || $tokens[$prev]['code'] === T_DOUBLE_COLON
            || $tokens[$prev]['code'] === T_NULLSAFE_OBJECT_OPERATOR
            || $tokens[$prev]['code'] === T_NEW
        ) {
            return;
        }

        // Make sure this is not an attribute.
        if (empty($tokens[$stackPtr]['nested_attributes']) === false) {
            return;
        }

        // If the current namespace declares or imports a function named
        // "define", any unqualified `define()` call may resolve to that
        // function instead of the global one, so the sniff should bow out.
        // Fully qualified `\define(...)` calls are unaffected as they come
        // in as T_NAME_FULLY_QUALIFIED tokens and are handled below.
        if ($tokens[$stackPtr]['code'] === T_STRING
            && $this->namespaceHasCustomDefine($phpcsFile, $stackPtr) === true
        ) {
            return;
        }

        // If the next non-whitespace token after this token
        // is not an opening parenthesis then it is not a function call.
        $openBracket = $phpcsFile->findNext(Tokens::EMPTY_TOKENS, ($stackPtr + 1), null, true);
        if ($openBracket === false || $tokens[$openBracket]['code'] !== T_OPEN_PARENTHESIS) {
            return;
        }

        // Bow out if next non-empty token after the opening parenthesis is not a string (the
        // constant name). This could happen when live coding, if the constant is a variable or an
        // expression, or if handling a first-class callable or a function definition outside the
        // global scope.
        $constPtr = $phpcsFile->findNext(Tokens::EMPTY_TOKENS, ($openBracket + 1), null, true);
        if ($constPtr === false || $tokens[$constPtr]['code'] !== T_CONSTANT_ENCAPSED_STRING) {
            return;
        }

        $constName = $tokens[$constPtr]['content'];
        $prefix    = '';

        // Strip namespace from constant like \foo\bar\CONSTANT.
        $splitPos = strrpos($constName, '\\');
        if ($splitPos !== false) {
            $prefix    = substr($constName, 0, ($splitPos + 1));
            $constName = substr($constName, ($splitPos + 1));
        }

        if (strtoupper($constName) !== $constName) {
            if (strtolower($constName) === $constName) {
                $phpcsFile->recordMetric($constPtr, 'Constant name case', 'lower');
            } else {
                $phpcsFile->recordMetric($constPtr, 'Constant name case', 'mixed');
            }

            $error = 'Constants must be uppercase; expected %s but found %s';
            $data  = [
                $prefix . strtoupper($constName),
                $prefix . $constName,
            ];
            $phpcsFile->addError($error, $constPtr, 'ConstantNotUpperCase', $data);
        } else {
            $phpcsFile->recordMetric($constPtr, 'Constant name case', 'upper');
        }
    }


    /**
     * Determine whether the namespace containing a token declares or imports
     * a function named "define".
     *
     * Checks for namespace-level `function define(...)` declarations and
     * `use function ...\define;` (or aliased) imports. The result is cached
     * per file path and namespace scope to avoid rescanning on every token.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The token being checked.
     *
     * @return bool
     */
    private function namespaceHasCustomDefine(File $phpcsFile, int $stackPtr)
    {
        static $cache = [];

        $fileKey = $phpcsFile->getFilename();
        if (isset($cache[$fileKey]) === true) {
            $scopeKey = $this->getNamespaceScopeKey($phpcsFile, $stackPtr);
            return isset($cache[$fileKey][$scopeKey]);
        }

        $tokens          = $phpcsFile->getTokens();
        $cache[$fileKey] = [];

        for ($i = 0; $i < $phpcsFile->numTokens; $i++) {
            $code     = $tokens[$i]['code'];
            $scopeKey = $this->getNamespaceScopeKey($phpcsFile, $i);

            // Namespace-level `function define(...)` declaration.
            if ($code === T_FUNCTION && $this->isInGlobalOrNamespaceScope($tokens[$i]) === true) {
                $namePtr = $phpcsFile->findNext(Tokens::EMPTY_TOKENS, ($i + 1), null, true);
                if ($namePtr !== false
                    && $tokens[$namePtr]['code'] === T_STRING
                    && strtolower($tokens[$namePtr]['content']) === 'define'
                ) {
                    $cache[$fileKey][$scopeKey] = true;
                }

                continue;
            }

            // `use function ...define;` import at file or namespace scope only.
            if ($code === T_USE && $this->isInGlobalOrNamespaceScope($tokens[$i]) === true) {
                $next = $phpcsFile->findNext(Tokens::EMPTY_TOKENS, ($i + 1), null, true);
                if ($next === false || $tokens[$next]['code'] !== T_STRING
                    || strtolower($tokens[$next]['content']) !== 'function'
                ) {
                    continue;
                }

                $end = $phpcsFile->findNext([T_SEMICOLON, T_OPEN_USE_GROUP], ($next + 1));
                if ($end === false) {
                    continue;
                }

                if ($this->useListImportsDefine($phpcsFile, $next, $end) === true) {
                    $cache[$fileKey][$scopeKey] = true;
                    continue;
                }

                // Group use statement: walk the body looking for a `define` import.
                if ($tokens[$end]['code'] === T_OPEN_USE_GROUP) {
                    $groupEnd = $phpcsFile->findNext(T_CLOSE_USE_GROUP, ($end + 1));
                    if ($groupEnd !== false
                        && $this->useListImportsDefine($phpcsFile, $end, $groupEnd) === true
                    ) {
                        $cache[$fileKey][$scopeKey] = true;
                    }
                }
            }
        }

        $scopeKey = $this->getNamespaceScopeKey($phpcsFile, $stackPtr);
        return isset($cache[$fileKey][$scopeKey]);
    }


    /**
     * Get a stable cache key for the namespace containing a token.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The token being checked.
     *
     * @return string
     */
    private function getNamespaceScopeKey(File $phpcsFile, int $stackPtr)
    {
        $namespacePtr = $phpcsFile->getCondition($stackPtr, T_NAMESPACE);
        if ($namespacePtr === false) {
            return 'global';
        }

        return 'namespace:' . $namespacePtr;
    }


    /**
     * Determine whether a token is at file scope or directly within a namespace.
     *
     * @param array<string, mixed> $token Token data.
     *
     * @return bool
     */
    private function isInGlobalOrNamespaceScope(array $token)
    {
        if (empty($token['conditions']) === true) {
            return true;
        }

        if (count($token['conditions']) !== 1) {
            return false;
        }

        $conditions = $token['conditions'];
        reset($conditions);

        return current($conditions) === T_NAMESPACE;
    }


    /**
     * Inspect a `use function` import list for a `define` import.
     *
     * Handles plain imports (`use function Foo\define;`), aliases away from
     * `define` (`use function Foo\define as something;` — does NOT count) and
     * aliases to `define` (`use function Foo\bar as define;` — counts).
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $start     Position to start scanning after.
     * @param int                         $end       Position to stop scanning at.
     *
     * @return bool
     */
    private function useListImportsDefine(File $phpcsFile, int $start, int $end)
    {
        $tokens = $phpcsFile->getTokens();

        for ($j = ($start + 1); $j < $end; $j++) {
            $code = $tokens[$j]['code'];

            // Explicit alias: `... as define`.
            if ($code === T_AS) {
                $aliasPtr = $phpcsFile->findNext(Tokens::EMPTY_TOKENS, ($j + 1), $end, true);
                if ($aliasPtr !== false
                    && $tokens[$aliasPtr]['code'] === T_STRING
                    && strtolower($tokens[$aliasPtr]['content']) === 'define'
                ) {
                    return true;
                }

                continue;
            }

            if ($code !== T_STRING
                && $code !== T_NAME_QUALIFIED
                && $code !== T_NAME_FULLY_QUALIFIED
            ) {
                continue;
            }

            $segments = explode('\\', $tokens[$j]['content']);
            $last     = strtolower(end($segments));
            if ($last !== 'define') {
                continue;
            }

            // Skip if the next non-empty token is `as` — the import is renamed
            // and is therefore not in scope as `define`.
            $after = $phpcsFile->findNext(Tokens::EMPTY_TOKENS, ($j + 1), $end, true);
            if ($after !== false && $tokens[$after]['code'] === T_AS) {
                continue;
            }

            return true;
        }

        return false;
    }
}
