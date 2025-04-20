<?php
/**
 * Stores weightings and groupings of tokens.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Util;

define('T_NONE', 'PHPCS_T_NONE');
define('T_OPEN_CURLY_BRACKET', 'PHPCS_T_OPEN_CURLY_BRACKET');
define('T_CLOSE_CURLY_BRACKET', 'PHPCS_T_CLOSE_CURLY_BRACKET');
define('T_OPEN_SQUARE_BRACKET', 'PHPCS_T_OPEN_SQUARE_BRACKET');
define('T_CLOSE_SQUARE_BRACKET', 'PHPCS_T_CLOSE_SQUARE_BRACKET');
define('T_OPEN_PARENTHESIS', 'PHPCS_T_OPEN_PARENTHESIS');
define('T_CLOSE_PARENTHESIS', 'PHPCS_T_CLOSE_PARENTHESIS');
define('T_COLON', 'PHPCS_T_COLON');
define('T_NULLABLE', 'PHPCS_T_NULLABLE');
define('T_STRING_CONCAT', 'PHPCS_T_STRING_CONCAT');
define('T_INLINE_THEN', 'PHPCS_T_INLINE_THEN');
define('T_INLINE_ELSE', 'PHPCS_T_INLINE_ELSE');
define('T_NULL', 'PHPCS_T_NULL');
define('T_FALSE', 'PHPCS_T_FALSE');
define('T_TRUE', 'PHPCS_T_TRUE');
define('T_SEMICOLON', 'PHPCS_T_SEMICOLON');
define('T_EQUAL', 'PHPCS_T_EQUAL');
define('T_MULTIPLY', 'PHPCS_T_MULTIPLY');
define('T_DIVIDE', 'PHPCS_T_DIVIDE');
define('T_PLUS', 'PHPCS_T_PLUS');
define('T_MINUS', 'PHPCS_T_MINUS');
define('T_MODULUS', 'PHPCS_T_MODULUS');
define('T_BITWISE_AND', 'PHPCS_T_BITWISE_AND');
define('T_BITWISE_OR', 'PHPCS_T_BITWISE_OR');
define('T_BITWISE_XOR', 'PHPCS_T_BITWISE_XOR');
define('T_BITWISE_NOT', 'PHPCS_T_BITWISE_NOT');
define('T_GREATER_THAN', 'PHPCS_T_GREATER_THAN');
define('T_LESS_THAN', 'PHPCS_T_LESS_THAN');
define('T_BOOLEAN_NOT', 'PHPCS_T_BOOLEAN_NOT');
define('T_SELF', 'PHPCS_T_SELF');
define('T_PARENT', 'PHPCS_T_PARENT');
define('T_DOUBLE_QUOTED_STRING', 'PHPCS_T_DOUBLE_QUOTED_STRING');
define('T_COMMA', 'PHPCS_T_COMMA');
define('T_HEREDOC', 'PHPCS_T_HEREDOC');
define('T_ASPERAND', 'PHPCS_T_ASPERAND');
define('T_DOLLAR', 'PHPCS_T_DOLLAR');
define('T_CLOSURE', 'PHPCS_T_CLOSURE');
define('T_ANON_CLASS', 'PHPCS_T_ANON_CLASS');
define('T_BACKTICK', 'PHPCS_T_BACKTICK');
define('T_START_NOWDOC', 'PHPCS_T_START_NOWDOC');
define('T_NOWDOC', 'PHPCS_T_NOWDOC');
define('T_END_NOWDOC', 'PHPCS_T_END_NOWDOC');
define('T_OPEN_SHORT_ARRAY', 'PHPCS_T_OPEN_SHORT_ARRAY');
define('T_CLOSE_SHORT_ARRAY', 'PHPCS_T_CLOSE_SHORT_ARRAY');
define('T_GOTO_LABEL', 'PHPCS_T_GOTO_LABEL');
define('T_GOTO_COLON', 'PHPCS_T_GOTO_COLON');
define('T_BINARY_CAST', 'PHPCS_T_BINARY_CAST');
define('T_OPEN_USE_GROUP', 'PHPCS_T_OPEN_USE_GROUP');
define('T_CLOSE_USE_GROUP', 'PHPCS_T_CLOSE_USE_GROUP');
define('T_FN_ARROW', 'PHPCS_T_FN_ARROW');
define('T_TYPE_UNION', 'PHPCS_T_TYPE_UNION');
define('T_PARAM_NAME', 'PHPCS_T_PARAM_NAME');
define('T_MATCH_ARROW', 'PHPCS_T_MATCH_ARROW');
define('T_MATCH_DEFAULT', 'PHPCS_T_MATCH_DEFAULT');
define('T_ATTRIBUTE_END', 'PHPCS_T_ATTRIBUTE_END');
define('T_ENUM_CASE', 'PHPCS_T_ENUM_CASE');
define('T_TYPE_INTERSECTION', 'PHPCS_T_TYPE_INTERSECTION');
define('T_TYPE_OPEN_PARENTHESIS', 'PHPCS_T_TYPE_OPEN_PARENTHESIS');
define('T_TYPE_CLOSE_PARENTHESIS', 'PHPCS_T_TYPE_CLOSE_PARENTHESIS');

/*
 * {@internal IMPORTANT: all PHP native polyfilled tokens MUST be added to the
 * `PHP_CodeSniffer\Tests\Core\Util\Tokens\TokenNameTest::dataPolyfilledPHPNativeTokens()` test method!}
 */

// Some PHP 7.4 tokens, replicated for lower versions.
if (defined('T_COALESCE_EQUAL') === false) {
    define('T_COALESCE_EQUAL', 'PHPCS_T_COALESCE_EQUAL');
}

if (defined('T_BAD_CHARACTER') === false) {
    define('T_BAD_CHARACTER', 'PHPCS_T_BAD_CHARACTER');
}

if (defined('T_FN') === false) {
    define('T_FN', 'PHPCS_T_FN');
}

// Some PHP 8.0 tokens, replicated for lower versions.
if (defined('T_NULLSAFE_OBJECT_OPERATOR') === false) {
    define('T_NULLSAFE_OBJECT_OPERATOR', 'PHPCS_T_NULLSAFE_OBJECT_OPERATOR');
}

if (defined('T_NAME_QUALIFIED') === false) {
    define('T_NAME_QUALIFIED', 'PHPCS_T_NAME_QUALIFIED');
}

if (defined('T_NAME_FULLY_QUALIFIED') === false) {
    define('T_NAME_FULLY_QUALIFIED', 'PHPCS_T_NAME_FULLY_QUALIFIED');
}

if (defined('T_NAME_RELATIVE') === false) {
    define('T_NAME_RELATIVE', 'PHPCS_T_NAME_RELATIVE');
}

if (defined('T_MATCH') === false) {
    define('T_MATCH', 'PHPCS_T_MATCH');
}

if (defined('T_ATTRIBUTE') === false) {
    define('T_ATTRIBUTE', 'PHPCS_T_ATTRIBUTE');
}

// Some PHP 8.1 tokens, replicated for lower versions.
if (defined('T_AMPERSAND_FOLLOWED_BY_VAR_OR_VARARG') === false) {
    define('T_AMPERSAND_FOLLOWED_BY_VAR_OR_VARARG', 'PHPCS_T_AMPERSAND_FOLLOWED_BY_VAR_OR_VARARG');
}

if (defined('T_AMPERSAND_NOT_FOLLOWED_BY_VAR_OR_VARARG') === false) {
    define('T_AMPERSAND_NOT_FOLLOWED_BY_VAR_OR_VARARG', 'PHPCS_T_AMPERSAND_NOT_FOLLOWED_BY_VAR_OR_VARARG');
}

if (defined('T_READONLY') === false) {
    define('T_READONLY', 'PHPCS_T_READONLY');
}

if (defined('T_ENUM') === false) {
    define('T_ENUM', 'PHPCS_T_ENUM');
}

// Tokens used for parsing doc blocks.
define('T_DOC_COMMENT_STAR', 'PHPCS_T_DOC_COMMENT_STAR');
define('T_DOC_COMMENT_WHITESPACE', 'PHPCS_T_DOC_COMMENT_WHITESPACE');
define('T_DOC_COMMENT_TAG', 'PHPCS_T_DOC_COMMENT_TAG');
define('T_DOC_COMMENT_OPEN_TAG', 'PHPCS_T_DOC_COMMENT_OPEN_TAG');
define('T_DOC_COMMENT_CLOSE_TAG', 'PHPCS_T_DOC_COMMENT_CLOSE_TAG');
define('T_DOC_COMMENT_STRING', 'PHPCS_T_DOC_COMMENT_STRING');

// Tokens used for PHPCS instruction comments.
define('T_PHPCS_ENABLE', 'PHPCS_T_PHPCS_ENABLE');
define('T_PHPCS_DISABLE', 'PHPCS_T_PHPCS_DISABLE');
define('T_PHPCS_SET', 'PHPCS_T_PHPCS_SET');
define('T_PHPCS_IGNORE', 'PHPCS_T_PHPCS_IGNORE');
define('T_PHPCS_IGNORE_FILE', 'PHPCS_T_PHPCS_IGNORE_FILE');

final class Tokens
{

    /**
     * Tokens that represent assignments.
     *
     * @var array<int|string, int|string>
     */
    public const ASSIGNMENT_TOKENS = [
        T_EQUAL          => T_EQUAL,
        T_AND_EQUAL      => T_AND_EQUAL,
        T_OR_EQUAL       => T_OR_EQUAL,
        T_CONCAT_EQUAL   => T_CONCAT_EQUAL,
        T_DIV_EQUAL      => T_DIV_EQUAL,
        T_MINUS_EQUAL    => T_MINUS_EQUAL,
        T_POW_EQUAL      => T_POW_EQUAL,
        T_MOD_EQUAL      => T_MOD_EQUAL,
        T_MUL_EQUAL      => T_MUL_EQUAL,
        T_PLUS_EQUAL     => T_PLUS_EQUAL,
        T_XOR_EQUAL      => T_XOR_EQUAL,
        T_DOUBLE_ARROW   => T_DOUBLE_ARROW,
        T_SL_EQUAL       => T_SL_EQUAL,
        T_SR_EQUAL       => T_SR_EQUAL,
        T_COALESCE_EQUAL => T_COALESCE_EQUAL,
    ];

    /**
     * Tokens that represent equality comparisons.
     *
     * @var array<int|string, int|string>
     */
    public const EQUALITY_TOKENS = [
        T_IS_EQUAL            => T_IS_EQUAL,
        T_IS_NOT_EQUAL        => T_IS_NOT_EQUAL,
        T_IS_IDENTICAL        => T_IS_IDENTICAL,
        T_IS_NOT_IDENTICAL    => T_IS_NOT_IDENTICAL,
        T_IS_SMALLER_OR_EQUAL => T_IS_SMALLER_OR_EQUAL,
        T_IS_GREATER_OR_EQUAL => T_IS_GREATER_OR_EQUAL,
    ];

    /**
     * Tokens that represent comparison operator.
     *
     * @var array<int|string, int|string>
     */
    public const COMPARISON_TOKENS = (self::EQUALITY_TOKENS + [
        T_LESS_THAN    => T_LESS_THAN,
        T_GREATER_THAN => T_GREATER_THAN,
        T_SPACESHIP    => T_SPACESHIP,
        T_COALESCE     => T_COALESCE,
    ]);

    /**
     * Tokens that represent arithmetic operators.
     *
     * @var array<int|string, int|string>
     */
    public const ARITHMETIC_TOKENS = [
        T_PLUS     => T_PLUS,
        T_MINUS    => T_MINUS,
        T_MULTIPLY => T_MULTIPLY,
        T_DIVIDE   => T_DIVIDE,
        T_MODULUS  => T_MODULUS,
        T_POW      => T_POW,
    ];

    /**
     * Tokens that perform operations.
     *
     * @var array<int|string, int|string>
     */
    public const OPERATORS = (self::ARITHMETIC_TOKENS + [
        T_SPACESHIP   => T_SPACESHIP,
        T_COALESCE    => T_COALESCE,
        T_BITWISE_AND => T_BITWISE_AND,
        T_BITWISE_OR  => T_BITWISE_OR,
        T_BITWISE_XOR => T_BITWISE_XOR,
        T_SL          => T_SL,
        T_SR          => T_SR,
    ]);

    /**
     * Tokens that perform boolean operations.
     *
     * @var array<int|string, int|string>
     */
    public const BOOLEAN_OPERATORS = [
        T_BOOLEAN_AND => T_BOOLEAN_AND,
        T_BOOLEAN_OR  => T_BOOLEAN_OR,
        T_LOGICAL_AND => T_LOGICAL_AND,
        T_LOGICAL_OR  => T_LOGICAL_OR,
        T_LOGICAL_XOR => T_LOGICAL_XOR,
    ];

    /**
     * Tokens that represent casting.
     *
     * @var array<int|string, int|string>
     */
    public const CAST_TOKENS = [
        T_INT_CAST    => T_INT_CAST,
        T_STRING_CAST => T_STRING_CAST,
        T_DOUBLE_CAST => T_DOUBLE_CAST,
        T_ARRAY_CAST  => T_ARRAY_CAST,
        T_BOOL_CAST   => T_BOOL_CAST,
        T_OBJECT_CAST => T_OBJECT_CAST,
        T_UNSET_CAST  => T_UNSET_CAST,
        T_BINARY_CAST => T_BINARY_CAST,
    ];

    /**
     * Token types that open parenthesis.
     *
     * @var array<int|string, int|string>
     */
    public const PARENTHESIS_OPENERS = [
        T_ARRAY      => T_ARRAY,
        T_LIST       => T_LIST,
        T_FUNCTION   => T_FUNCTION,
        T_CLOSURE    => T_CLOSURE,
        T_USE        => T_USE,
        T_ANON_CLASS => T_ANON_CLASS,
        T_WHILE      => T_WHILE,
        T_FOR        => T_FOR,
        T_FOREACH    => T_FOREACH,
        T_SWITCH     => T_SWITCH,
        T_IF         => T_IF,
        T_ELSEIF     => T_ELSEIF,
        T_CATCH      => T_CATCH,
        T_DECLARE    => T_DECLARE,
        T_MATCH      => T_MATCH,
        T_ISSET      => T_ISSET,
        T_EMPTY      => T_EMPTY,
        T_UNSET      => T_UNSET,
        T_EVAL       => T_EVAL,
        T_EXIT       => T_EXIT,
    ];

    /**
     * Tokens that are allowed to open scopes.
     *
     * @var array<int|string, int|string>
     */
    public const SCOPE_OPENERS = [
        T_CLASS      => T_CLASS,
        T_ANON_CLASS => T_ANON_CLASS,
        T_INTERFACE  => T_INTERFACE,
        T_TRAIT      => T_TRAIT,
        T_ENUM       => T_ENUM,
        T_NAMESPACE  => T_NAMESPACE,
        T_FUNCTION   => T_FUNCTION,
        T_CLOSURE    => T_CLOSURE,
        T_IF         => T_IF,
        T_SWITCH     => T_SWITCH,
        T_CASE       => T_CASE,
        T_DECLARE    => T_DECLARE,
        T_DEFAULT    => T_DEFAULT,
        T_WHILE      => T_WHILE,
        T_ELSE       => T_ELSE,
        T_ELSEIF     => T_ELSEIF,
        T_FOR        => T_FOR,
        T_FOREACH    => T_FOREACH,
        T_DO         => T_DO,
        T_TRY        => T_TRY,
        T_CATCH      => T_CATCH,
        T_FINALLY    => T_FINALLY,
        T_USE        => T_USE,
        T_MATCH      => T_MATCH,
    ];

    /**
     * Tokens that represent scope modifiers.
     *
     * @var array<int|string, int|string>
     */
    public const SCOPE_MODIFIERS = [
        T_PRIVATE   => T_PRIVATE,
        T_PUBLIC    => T_PUBLIC,
        T_PROTECTED => T_PROTECTED,
    ];

    /**
     * Tokens that can prefix a method name
     *
     * @var array<int|string, int|string>
     */
    public const METHOD_MODIFIERS = (self::SCOPE_MODIFIERS + [
        T_ABSTRACT => T_ABSTRACT,
        T_STATIC   => T_STATIC,
        T_FINAL    => T_FINAL,
    ]);

    /**
     * Tokens that open code blocks.
     *
     * @var array<int|string, int|string>
     */
    public const BLOCK_OPENERS = [
        T_OPEN_CURLY_BRACKET  => T_OPEN_CURLY_BRACKET,
        T_OPEN_SQUARE_BRACKET => T_OPEN_SQUARE_BRACKET,
        T_OPEN_PARENTHESIS    => T_OPEN_PARENTHESIS,
    ];

    /**
     * Tokens that represent brackets and parenthesis.
     *
     * @var array<int|string, int|string>
     */
    public const BRACKET_TOKENS = (self::BLOCK_OPENERS + [
        T_CLOSE_CURLY_BRACKET  => T_CLOSE_CURLY_BRACKET,
        T_CLOSE_SQUARE_BRACKET => T_CLOSE_SQUARE_BRACKET,
        T_CLOSE_PARENTHESIS    => T_CLOSE_PARENTHESIS,
    ]);

    /**
     * Tokens that don't represent code.
     *
     * @var array<int|string, int|string>
     */
    public const EMPTY_TOKENS = (self::COMMENT_TOKENS + [T_WHITESPACE => T_WHITESPACE]);

    /**
     * Tokens that are comments.
     *
     * @var array<int|string, int|string>
     */
    public const COMMENT_TOKENS = (self::PHPCS_ANNOTATION_TOKENS + [
        T_COMMENT                => T_COMMENT,
        T_DOC_COMMENT            => T_DOC_COMMENT,
        T_DOC_COMMENT_STAR       => T_DOC_COMMENT_STAR,
        T_DOC_COMMENT_WHITESPACE => T_DOC_COMMENT_WHITESPACE,
        T_DOC_COMMENT_TAG        => T_DOC_COMMENT_TAG,
        T_DOC_COMMENT_OPEN_TAG   => T_DOC_COMMENT_OPEN_TAG,
        T_DOC_COMMENT_CLOSE_TAG  => T_DOC_COMMENT_CLOSE_TAG,
        T_DOC_COMMENT_STRING     => T_DOC_COMMENT_STRING,
    ]);

    /**
     * Tokens that are comments containing PHPCS instructions.
     *
     * @var array<int|string, int|string>
     */
    public const PHPCS_ANNOTATION_TOKENS = [
        T_PHPCS_ENABLE      => T_PHPCS_ENABLE,
        T_PHPCS_DISABLE     => T_PHPCS_DISABLE,
        T_PHPCS_SET         => T_PHPCS_SET,
        T_PHPCS_IGNORE      => T_PHPCS_IGNORE,
        T_PHPCS_IGNORE_FILE => T_PHPCS_IGNORE_FILE,
    ];

    /**
     * Tokens that represent strings.
     *
     * Note that T_STRINGS are NOT represented in this list.
     *
     * @var array<int|string, int|string>
     */
    public const STRING_TOKENS = [
        T_CONSTANT_ENCAPSED_STRING => T_CONSTANT_ENCAPSED_STRING,
        T_DOUBLE_QUOTED_STRING     => T_DOUBLE_QUOTED_STRING,
    ];

    /**
     * Tokens that represent text strings.
     *
     * @var array<int|string, int|string>
     */
    public const TEXT_STRING_TOKENS = (self::STRING_TOKENS + [
        T_INLINE_HTML => T_INLINE_HTML,
        T_HEREDOC     => T_HEREDOC,
        T_NOWDOC      => T_NOWDOC,
    ]);

    /**
     * Tokens that make up a heredoc string.
     *
     * @var array<int|string, int|string>
     */
    public const HEREDOC_TOKENS = [
        T_START_HEREDOC => T_START_HEREDOC,
        T_END_HEREDOC   => T_END_HEREDOC,
        T_HEREDOC       => T_HEREDOC,
        T_START_NOWDOC  => T_START_NOWDOC,
        T_END_NOWDOC    => T_END_NOWDOC,
        T_NOWDOC        => T_NOWDOC,
    ];

    /**
     * Tokens that include files.
     *
     * @var array<int|string, int|string>
     */
    public const INCLUDE_TOKENS = [
        T_REQUIRE_ONCE => T_REQUIRE_ONCE,
        T_REQUIRE      => T_REQUIRE,
        T_INCLUDE_ONCE => T_INCLUDE_ONCE,
        T_INCLUDE      => T_INCLUDE,
    ];

    /**
     * Tokens used for "names", be it namespace, OO, function or constant names.
     *
     * @var array<int|string, int|string>
     */
    public const NAME_TOKENS = [
        T_STRING               => T_STRING,
        T_NAME_QUALIFIED       => T_NAME_QUALIFIED,
        T_NAME_FULLY_QUALIFIED => T_NAME_FULLY_QUALIFIED,
        T_NAME_RELATIVE        => T_NAME_RELATIVE,
    ];

    /**
     * Tokens that represent the names of called functions.
     *
     * Mostly, these are just strings. But PHP tokenizes some language
     * constructs and functions using their own tokens.
     *
     * @var array<int|string, int|string>
     */
    public const FUNCTION_NAME_TOKENS = (self::INCLUDE_TOKENS + self::NAME_TOKENS + [
        T_EVAL   => T_EVAL,
        T_EXIT   => T_EXIT,
        T_ISSET  => T_ISSET,
        T_UNSET  => T_UNSET,
        T_EMPTY  => T_EMPTY,
        T_SELF   => T_SELF,
        T_PARENT => T_PARENT,
        T_STATIC => T_STATIC,
    ]);

    /**
     * Tokens that open class and object scopes.
     *
     * @var array<int|string, int|string>
     */
    public const OO_SCOPE_TOKENS = [
        T_CLASS      => T_CLASS,
        T_ANON_CLASS => T_ANON_CLASS,
        T_INTERFACE  => T_INTERFACE,
        T_TRAIT      => T_TRAIT,
        T_ENUM       => T_ENUM,
    ];

    /**
     * Tokens representing PHP magic constants.
     *
     * @var array <int|string> => <int|string>
     *
     * @link https://www.php.net/language.constants.predefined PHP Manual on magic constants
     */
    public const MAGIC_CONSTANTS = [
        T_CLASS_C  => T_CLASS_C,
        T_DIR      => T_DIR,
        T_FILE     => T_FILE,
        T_FUNC_C   => T_FUNC_C,
        T_LINE     => T_LINE,
        T_METHOD_C => T_METHOD_C,
        T_NS_C     => T_NS_C,
        T_TRAIT_C  => T_TRAIT_C,
    ];

    /**
     * Tokens representing context sensitive keywords in PHP.
     *
     * @var array<int|string, int|string>
     *
     * https://wiki.php.net/rfc/context_sensitive_lexer
     */
    public const CONTEXT_SENSITIVE_KEYWORDS = [
        T_ABSTRACT     => T_ABSTRACT,
        T_ARRAY        => T_ARRAY,
        T_AS           => T_AS,
        T_BREAK        => T_BREAK,
        T_CALLABLE     => T_CALLABLE,
        T_CASE         => T_CASE,
        T_CATCH        => T_CATCH,
        T_CLASS        => T_CLASS,
        T_CLONE        => T_CLONE,
        T_CONST        => T_CONST,
        T_CONTINUE     => T_CONTINUE,
        T_DECLARE      => T_DECLARE,
        T_DEFAULT      => T_DEFAULT,
        T_DO           => T_DO,
        T_ECHO         => T_ECHO,
        T_ELSE         => T_ELSE,
        T_ELSEIF       => T_ELSEIF,
        T_EMPTY        => T_EMPTY,
        T_ENDDECLARE   => T_ENDDECLARE,
        T_ENDFOR       => T_ENDFOR,
        T_ENDFOREACH   => T_ENDFOREACH,
        T_ENDIF        => T_ENDIF,
        T_ENDSWITCH    => T_ENDSWITCH,
        T_ENDWHILE     => T_ENDWHILE,
        T_ENUM         => T_ENUM,
        T_EVAL         => T_EVAL,
        T_EXIT         => T_EXIT,
        T_EXTENDS      => T_EXTENDS,
        T_FINAL        => T_FINAL,
        T_FINALLY      => T_FINALLY,
        T_FN           => T_FN,
        T_FOR          => T_FOR,
        T_FOREACH      => T_FOREACH,
        T_FUNCTION     => T_FUNCTION,
        T_GLOBAL       => T_GLOBAL,
        T_GOTO         => T_GOTO,
        T_IF           => T_IF,
        T_IMPLEMENTS   => T_IMPLEMENTS,
        T_INCLUDE      => T_INCLUDE,
        T_INCLUDE_ONCE => T_INCLUDE_ONCE,
        T_INSTANCEOF   => T_INSTANCEOF,
        T_INSTEADOF    => T_INSTEADOF,
        T_INTERFACE    => T_INTERFACE,
        T_ISSET        => T_ISSET,
        T_LIST         => T_LIST,
        T_LOGICAL_AND  => T_LOGICAL_AND,
        T_LOGICAL_OR   => T_LOGICAL_OR,
        T_LOGICAL_XOR  => T_LOGICAL_XOR,
        T_MATCH        => T_MATCH,
        T_NAMESPACE    => T_NAMESPACE,
        T_NEW          => T_NEW,
        T_PRINT        => T_PRINT,
        T_PRIVATE      => T_PRIVATE,
        T_PROTECTED    => T_PROTECTED,
        T_PUBLIC       => T_PUBLIC,
        T_READONLY     => T_READONLY,
        T_REQUIRE      => T_REQUIRE,
        T_REQUIRE_ONCE => T_REQUIRE_ONCE,
        T_RETURN       => T_RETURN,
        T_STATIC       => T_STATIC,
        T_SWITCH       => T_SWITCH,
        T_THROW        => T_THROW,
        T_TRAIT        => T_TRAIT,
        T_TRY          => T_TRY,
        T_UNSET        => T_UNSET,
        T_USE          => T_USE,
        T_VAR          => T_VAR,
        T_WHILE        => T_WHILE,
        T_YIELD        => T_YIELD,
        T_YIELD_FROM   => T_YIELD_FROM,
    ];

    /**
     * The token weightings.
     *
     * @var array<int|string, int>
     */
    private const WEIGHTINGS = [
        T_CLASS               => 1000,
        T_INTERFACE           => 1000,
        T_TRAIT               => 1000,
        T_ENUM                => 1000,
        T_NAMESPACE           => 1000,
        T_FUNCTION            => 100,
        T_CLOSURE             => 100,

        /*
         * Conditions.
         */

        T_WHILE               => 50,
        T_FOR                 => 50,
        T_FOREACH             => 50,
        T_IF                  => 50,
        T_ELSE                => 50,
        T_ELSEIF              => 50,
        T_DO                  => 50,
        T_TRY                 => 50,
        T_CATCH               => 50,
        T_FINALLY             => 50,
        T_SWITCH              => 50,
        T_MATCH               => 50,

        T_SELF                => 25,
        T_PARENT              => 25,

        /*
         * Operators and arithmetic.
         */

        T_BITWISE_AND         => 8,
        T_BITWISE_OR          => 8,
        T_BITWISE_XOR         => 8,

        T_MULTIPLY            => 5,
        T_DIVIDE              => 5,
        T_PLUS                => 5,
        T_MINUS               => 5,
        T_MODULUS             => 5,
        T_POW                 => 5,
        T_SPACESHIP           => 5,
        T_COALESCE            => 5,
        T_COALESCE_EQUAL      => 5,

        T_SL                  => 5,
        T_SR                  => 5,
        T_SL_EQUAL            => 5,
        T_SR_EQUAL            => 5,

        T_EQUAL               => 5,
        T_AND_EQUAL           => 5,
        T_CONCAT_EQUAL        => 5,
        T_DIV_EQUAL           => 5,
        T_MINUS_EQUAL         => 5,
        T_MOD_EQUAL           => 5,
        T_MUL_EQUAL           => 5,
        T_OR_EQUAL            => 5,
        T_PLUS_EQUAL          => 5,
        T_XOR_EQUAL           => 5,

        T_BOOLEAN_AND         => 5,
        T_BOOLEAN_OR          => 5,

        /*
         * Equality.
         */

        T_IS_EQUAL            => 5,
        T_IS_NOT_EQUAL        => 5,
        T_IS_IDENTICAL        => 5,
        T_IS_NOT_IDENTICAL    => 5,
        T_IS_SMALLER_OR_EQUAL => 5,
        T_IS_GREATER_OR_EQUAL => 5,
    ];

    /**
     * The token weightings.
     *
     * @var array<int|string, int>
     *
     * @deprecated 4.0.0 Use the Tokens::getHighestWeightedToken() method instead.
     */
    public static $weightings = self::WEIGHTINGS;

    /**
     * Tokens that represent assignments.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::ASSIGNMENT_TOKENS constant instead.
     */
    public static $assignmentTokens = self::ASSIGNMENT_TOKENS;

    /**
     * Tokens that represent equality comparisons.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::EQUALITY_TOKENS constant instead.
     */
    public static $equalityTokens = self::EQUALITY_TOKENS;

    /**
     * Tokens that represent comparison operator.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::COMPARISON_TOKENS constant instead.
     */
    public static $comparisonTokens = self::COMPARISON_TOKENS;

    /**
     * Tokens that represent arithmetic operators.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::ARITHMETIC_TOKENS constant instead.
     */
    public static $arithmeticTokens = self::ARITHMETIC_TOKENS;

    /**
     * Tokens that perform operations.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::OPERATORS constant instead.
     */
    public static $operators = self::OPERATORS;

    /**
     * Tokens that perform boolean operations.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::BOOLEAN_OPERATORS constant instead.
     */
    public static $booleanOperators = self::BOOLEAN_OPERATORS;

    /**
     * Tokens that represent casting.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::CAST_TOKENS constant instead.
     */
    public static $castTokens = self::CAST_TOKENS;

    /**
     * Token types that open parenthesis.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::PARENTHESIS_OPENERS constant instead.
     */
    public static $parenthesisOpeners = self::PARENTHESIS_OPENERS;

    /**
     * Tokens that are allowed to open scopes.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::SCOPE_OPENERS constant instead.
     */
    public static $scopeOpeners = self::SCOPE_OPENERS;

    /**
     * Tokens that represent scope modifiers.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::SCOPE_MODIFIERS constant instead.
     */
    public static $scopeModifiers = self::SCOPE_MODIFIERS;

    /**
     * Tokens that can prefix a method name
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::METHOD_MODIFIERS constant instead.
     */
    public static $methodPrefixes = self::METHOD_MODIFIERS;

    /**
     * Tokens that open code blocks.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::BLOCK_OPENERS constant instead.
     */
    public static $blockOpeners = self::BLOCK_OPENERS;

    /**
     * Tokens that don't represent code.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::EMPTY_TOKENS constant instead.
     */
    public static $emptyTokens = self::EMPTY_TOKENS;

    /**
     * Tokens that are comments.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::COMMENT_TOKENS constant instead.
     */
    public static $commentTokens = self::COMMENT_TOKENS;

    /**
     * Tokens that are comments containing PHPCS instructions.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::PHPCS_ANNOTATION_TOKENS constant instead.
     */
    public static $phpcsCommentTokens = self::PHPCS_ANNOTATION_TOKENS;

    /**
     * Tokens that represent strings.
     *
     * Note that T_STRINGS are NOT represented in this list.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::STRING_TOKENS constant instead.
     */
    public static $stringTokens = self::STRING_TOKENS;

    /**
     * Tokens that represent text strings.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::TEXT_STRINGS constant instead.
     */
    public static $textStringTokens = self::TEXT_STRING_TOKENS;

    /**
     * Tokens that represent brackets and parenthesis.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::BRACKET_TOKENS constant instead.
     */
    public static $bracketTokens = self::BRACKET_TOKENS;

    /**
     * Tokens that include files.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::INCLUDE_TOKENS constant instead.
     */
    public static $includeTokens = self::INCLUDE_TOKENS;

    /**
     * Tokens that make up a heredoc string.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::HEREDOC_TOKENS constant instead.
     */
    public static $heredocTokens = self::HEREDOC_TOKENS;

    /**
     * Tokens that represent the names of called functions.
     *
     * Mostly, these are just strings. But PHP tokenizes some language
     * constructs and functions using their own tokens.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::FUNCTION_NAME_TOKENS constant instead.
     */
    public static $functionNameTokens = self::FUNCTION_NAME_TOKENS;

    /**
     * Tokens that open class and object scopes.
     *
     * @var array<int|string, int|string>
     *
     * @deprecated 4.0.0 Use the Tokens::OO_SCOPE_TOKENS constant instead.
     */
    public static $ooScopeTokens = self::OO_SCOPE_TOKENS;

    /**
     * Tokens representing PHP magic constants.
     *
     * @var array <int|string> => <int|string>
     *
     * @link https://www.php.net/language.constants.predefined PHP Manual on magic constants
     *
     * @deprecated 4.0.0 Use the Tokens::MAGIC_CONSTANTS constant instead.
     */
    public static $magicConstants = self::MAGIC_CONSTANTS;

    /**
     * Tokens representing context sensitive keywords in PHP.
     *
     * @var array<int|string, int|string>
     *
     * @link https://wiki.php.net/rfc/context_sensitive_lexer
     *
     * @deprecated 4.0.0 Use the Tokens::CONTEXT_SENSITIVE_KEYWORDS constant instead.
     */
    public static $contextSensitiveKeywords = self::CONTEXT_SENSITIVE_KEYWORDS;


    /**
     * Given a token constant, returns the name of the token.
     *
     * If passed an integer, the token name is sourced from PHP's token_name()
     * function. If passed a string, it is assumed to be a PHPCS-supplied token
     * that begins with PHPCS_T_, so the name is sourced from the token value itself.
     *
     * @param int|string $token The token constant to get the name for.
     *
     * @return string
     */
    public static function tokenName($token)
    {
        if (is_string($token) === false) {
            // PHP-supplied token name.
            return token_name($token);
        }

        return substr($token, 6);

    }//end tokenName()


    /**
     * Returns the highest weighted token type.
     *
     * Tokens are weighted by their approximate frequency of appearance in code
     * - the less frequently they appear in the code, the higher the weighting.
     * For example T_CLASS tokens appear very infrequently in a file, and
     * therefore have a high weighting.
     *
     * If there are no weightings for any of the specified tokens, the first token
     * seen in the passed array will be returned.
     *
     * @param array<int|string> $tokens The token types to get the highest weighted
     *                                  type for.
     *
     * @return int The highest weighted token.
     *             On equal "weight", returns the first token of that particular weight.
     */
    public static function getHighestWeightedToken(array $tokens)
    {
        $highest     = -1;
        $highestType = false;

        $weights = self::WEIGHTINGS;

        foreach ($tokens as $token) {
            if (isset($weights[$token]) === true) {
                $weight = $weights[$token];
            } else {
                $weight = 0;
            }

            if ($weight > $highest) {
                $highest     = $weight;
                $highestType = $token;
            }
        }

        return $highestType;

    }//end getHighestWeightedToken()


}//end class
