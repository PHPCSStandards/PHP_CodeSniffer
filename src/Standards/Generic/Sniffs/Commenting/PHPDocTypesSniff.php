<?php
/**
 * Check PHPDoc Types.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

namespace PHP_CodeSniffer\Standards\Generic\Sniffs\Commenting;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;
use PHP_CodeSniffer\Util\PHPDocTypesUtil;

/**
 * Check PHPDoc Types.
 */
class PHPDocTypesSniff implements Sniff
{

    /**
     * Check named classes and functions, and class variables and constants have doc blocks.
     * Unless using this sniff standalone, probably disable this and use other sniffs for this.
     *
     * @var boolean
     */
    public $checkHasDocBlocks = false;

    /**
     * Check doc blocks, if present, contain appropriate type tags.
     *
     * @var boolean
     */
    public $checkHasTags = false;

    /**
     * Check there are no misplaced type tags--doesn't check for misplaced var tags.
     *
     * @var boolean
     */
    public $checkTagsNotMisplaced = true;

    /**
     * Check PHPDoc types and native types match--isn't aware of class heirarchies from other files, or global constants.
     *
     * @var boolean
     */
    public $checkTypeMatch = true;

    /**
     * Check built-in types are lower case, and short forms are used.
     *
     * @var boolean
     */
    public $checkTypeStyle = false;

    /**
     * Check the types used conform to the PHP-FIG PSR-5 PHPDoc standard.
     *
     * @var boolean
     */
    public $checkTypePhpFig = false;

    /**
     * Check pass by reference and splat usage matches for param tags.
     *
     * @var boolean
     */
    public $checkPassSplat = true;

    /**
     * Throw an error and stop if we can't parse the file.
     *
     * @var boolean
     */
    public $debugMode = false;

    /**
     * The current file.
     *
     * @var ?File
     */
    protected $file = null;

    /**
     * File tokens.
     *
     * @var array{
     *      'code': ?array-key, 'content': string, 'scope_opener'?: int, 'scope_closer'?: int,
     *      'parenthesis_opener'?: int, 'parenthesis_closer'?: int, 'attribute_closer'?: int,
     *      'bracket_opener'?: int, 'bracket_closer'?: int,
     *      'comment_tags'?: array<int>, 'comment_closer'?: int
     *  }[]
     */
    protected $tokens = [];

    /**
     * Classish things: classes, interfaces, traits, and enums.
     *
     * @var array<string, object{extends: ?string, implements: string[]}>
     */
    protected $artifacts = [];

    /**
     * For parsing and comparing types.
     *
     * @var ?PHPDocTypesUtil
     */
    protected $typesUtil = null;

    /**
     * Pass 1 for gathering artifact/classish info, 2 for checking.
     *
     * @var 1|2
     */
    protected $pass = 1;

    /**
     * Current token pointer in the file.
     *
     * @var integer
     */
    protected $filePtr = 0;

    /**
     * PHPDoc comment for upcoming declaration
     *
     * @var ?(
     *      \stdClass&object{
     *          ptr: int,
     *          tags: array<string, object{ptr: int, content: string, cStartPtr: ?int, cEndPtr: ?int}[]>
     *      }
     *  )
     */
    protected $commentPending = null;

    /**
     * The current token.
     *
     * @var array{
     *      'code': ?array-key, 'content': string, 'scope_opener'?: int, 'scope_closer'?: int,
     *      'parenthesis_opener'?: int, 'parenthesis_closer'?: int, 'attribute_closer'?: int,
     *      'bracket_opener'?: int, 'bracket_closer'?: int,
     *      'comment_tags'?: array<int>, 'comment_closer'?: int
     *  }
     */
    protected $token = [
        'code'    => null,
        'content' => '',
    ];

    /**
     * The previous token.
     *
     * @var array{
     *      'code': ?array-key, 'content': string, 'scope_opener'?: int, 'scope_closer'?: int,
     *      'parenthesis_opener'?: int, 'parenthesis_closer'?: int, 'attribute_closer'?: int,
     *      'bracket_opener'?: int, 'bracket_closer'?: int,
     *      'comment_tags'?: array<int>, 'comment_closer'?: int
     *  }
     */
    protected $tokenPrevious = [
        'code'    => null,
        'content' => '',
    ];


    /**
     * Register for open tag.
     *
     * @return array-key[]
     */
    public function register()
    {
        return [T_OPEN_TAG];

    }//end register()


    /**
     * Processes PHP files and perform PHPDoc type checks with file.
     *
     * @param File $phpcsFile The file being scanned.
     * @param int  $stackPtr  The position in the stack.
     *
     * @return int returns pointer to end of file to avoid being called further
     */
    public function process(File $phpcsFile, $stackPtr)
    {

        try {
            $this->file   = $phpcsFile;
            $this->tokens = $phpcsFile->getTokens();

            // Gather atifact info.
            $this->artifacts = [];
            if ($this->checkTypeMatch === true) {
                $this->pass      = 1;
                $this->typesUtil = null;
                $this->processPass($stackPtr);
            }

            // Check the PHPDoc types.
            $this->pass      = 2;
            $this->typesUtil = new PHPDocTypesUtil($this->artifacts);
            $this->processPass($stackPtr);
        } catch (\Exception $e) {
            // We should only end up here in debug mode.
            $this->file->addError(
                'The PHPDoc type sniff failed to parse the file.  PHPDoc type checks were not performed.  Error: '.$e->getMessage(),
                min($this->filePtr, (count($this->tokens) - 1)),
                'PHPDocParse'
            );
        }//end try

        return count($this->tokens);

    }//end process()


    /**
     * A pass over the file.
     *
     * @param int $stackPtr The position in the stack.
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processPass($stackPtr)
    {
        $scope         = (object) [
            'namespace'  => '',
            'uses'       => [],
            'templates'  => [],
            'closer'     => null,
            'className'  => null,
            'parentName' => null,
            'type'       => 'root',
        ];
        $this->filePtr = $stackPtr;
        $this->tokenPrevious = [
            'code'    => null,
            'content' => '',
        ];
        $this->fetchToken();
        $this->commentPending = null;

        $this->processBlock($scope, 0);

    }//end processPass()


    /**
     * Process the content of a file, class, function, or parameters
     *
     * @param \stdClass&object{namespace: string, uses: array<string, string>, templates: array<string, string>, className: ?string, parentName: ?string, type: string, closer: ?int} $scope Scope
     * @param 0|1|2                                                                                                                                                                   $type  0=file 1=block 2=parameters
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processBlock($scope, $type)
    {

        // Check we are at the start of a scope, and store scope closer.
        if ($type === 0) {
            // File.
            if ($this->debugMode === true && $this->token['code'] !== T_OPEN_TAG) {
                // We shouldn't ever end up here.
                throw new \Exception('Expected PHP open tag.');
            }

            $scope->closer = count($this->tokens);
        } else if ($type === 1) {
            // Block.
            if (isset($this->token['scope_opener']) === false
                || $this->token['scope_opener'] !== $this->filePtr
                || isset($this->token['scope_closer']) === false
            ) {
                throw new \Exception('Malformed block.');
            }

            $scope->closer = $this->token['scope_closer'];
        } else {
            // Parameters.
            if (isset($this->token['parenthesis_opener']) === false
                || $this->token['parenthesis_opener'] !== $this->filePtr
                || isset($this->token['parenthesis_closer']) === false
            ) {
                throw new \Exception('Malformed parameters.');
            }

            $scope->closer = $this->token['parenthesis_closer'];
        }//end if

        $this->advance();

        while (true) {
            // If parsing fails, we'll give up whatever we're doing, and try again.
            try {
                // Skip irrelevant tokens.
                while (in_array(
                    $this->token['code'],
                    array_merge(
                        [
                            T_NAMESPACE,
                            T_USE,
                        ],
                        Tokens::$methodPrefixes,
                        [
                            T_ATTRIBUTE,
                            T_READONLY,
                        ],
                        Tokens::$ooScopeTokens,
                        [
                            T_FUNCTION,
                            T_CLOSURE,
                            T_FN,
                            T_VAR,
                            T_CONST,
                            null,
                        ]
                    )
                ) === false
                    && ($this->filePtr < $scope->closer)
                ) {
                    $this->advance();
                }

                if ($this->filePtr >= $scope->closer) {
                    // End of the block.
                    break;
                } else if ($this->token['code'] === T_NAMESPACE && $scope->type === 'root') {
                    // Namespace.
                    $this->processNamespace($scope);
                } else if ($this->token['code'] === T_USE && ($scope->type === 'root' || $scope->type === 'namespace')) {
                    // Use.
                    $this->processUse($scope);
                } else if ($this->token['code'] === T_USE && $scope->type === 'classish') {
                    // Class trait use.
                    $this->processClassTraitUse();
                } else if (in_array(
                    $this->token['code'],
                    array_merge(
                        Tokens::$methodPrefixes,
                        [
                            T_ATTRIBUTE,
                            T_READONLY,
                        ],
                        Tokens::$ooScopeTokens,
                        [
                            T_FUNCTION,
                            T_CLOSURE,
                            T_FN,
                            T_CONST,
                            T_VAR,
                        ]
                    )
                ) === true
                ) {
                    // Maybe declaration.
                    // Fetch comment, if any.
                    $comment = $this->commentPending;
                    $this->commentPending = null;
                    // Ignore attribute(s).
                    while ($this->token['code'] === T_ATTRIBUTE) {
                        while ($this->token['code'] !== T_ATTRIBUTE_END) {
                            $this->advance();
                        }

                        $this->advance(T_ATTRIBUTE_END);
                    }

                    // Check this still looks like a declaration.
                    if (in_array(
                        $this->token['code'],
                        array_merge(
                            Tokens::$methodPrefixes,
                            [T_READONLY],
                            Tokens::$ooScopeTokens,
                            [
                                T_FUNCTION,
                                T_CLOSURE,
                                T_FN,
                                T_CONST,
                                T_VAR,
                            ]
                        )
                    ) === false
                    ) {
                        // It's not a declaration, possibly an enum case.
                        $this->processPossVarComment($scope, $comment);
                        continue;
                    }

                    // Ignore other preceding stuff, and gather info to check for static late bindings.
                    $static = false;
                    $staticprecededbynew = ($this->tokenPrevious['code'] === T_NEW);
                    while (in_array(
                        $this->token['code'],
                        array_merge(Tokens::$methodPrefixes, [T_READONLY])
                    ) === true
                    ) {
                        $static = $static || ($this->token['code'] === T_STATIC);
                        $this->advance();
                    }

                    // What kind of declaration is this?
                    if ($static === true && ($this->token['code'] === T_DOUBLE_COLON || $staticprecededbynew === true)) {
                        // It's not a declaration, it's a static late binding.
                        $this->processPossVarComment($scope, $comment);
                        continue;
                    } else if (in_array($this->token['code'], Tokens::$ooScopeTokens) === true) {
                        // Classish thing.
                        $this->processClassish($scope, $comment);
                    } else if (in_array($this->token['code'], [T_FUNCTION, T_CLOSURE, T_FN]) === true) {
                        // Function.
                        $this->processFunction($scope, $comment);
                    } else {
                        // Variable.
                        $this->processVariable($scope, $comment);
                    }
                } else {
                    // We got something unrecognised.
                    $this->advance();
                    throw new \Exception('Unrecognised construct.');
                }//end if
            } catch (\Exception $e) {
                // Just give up on whatever we're doing and try again, unless in debug mode.
                if ($this->debugMode === true) {
                    throw $e;
                }
            }//end try
        }//end while

        // Check we are at the end of the scope.
        if (($type !== 0 || $this->debugMode === true) && $this->filePtr !== $scope->closer) {
            throw new \Exception('Malformed scope closer.');
        }

    }//end processBlock()


    /**
     * Fetch the current tokens.
     *
     * @return         void
     * @phpstan-impure
     */
    protected function fetchToken()
    {
        if ($this->filePtr < count($this->tokens)) {
            $this->token = $this->tokens[$this->filePtr];
        } else {
            $this->token = [
                'code'    => null,
                'content' => '',
            ];
        }

    }//end fetchToken()


    /**
     * Advance the token pointer when reading PHP code.
     *
     * @param array-key $expectedCode What we expect, or null if anything's OK
     *
     * @return         void
     * @phpstan-impure
     */
    protected function advance($expectedCode=null)
    {

        // Check we have something to fetch, and it's what's expected.
        if (($expectedCode !== null && $this->token['code'] !== $expectedCode) || $this->token['code'] === null) {
            throw new \Exception("Unexpected token, saw: \"{$this->token['content']}\".");
        }

        // Dispose of unused comment, if any.
        if ($this->commentPending !== null) {
            $this->processPossVarComment(null, $this->commentPending);
            $this->commentPending = null;
        }

        $this->tokenPrevious = $this->token;

        $this->filePtr++;
        $this->fetchToken();

        // Skip stuff that doesn't affect us, and process PHPDoc comments.
        while ($this->filePtr < count($this->tokens)
            && in_array($this->tokens[$this->filePtr]['code'], Tokens::$emptyTokens) === true
        ) {
            if (in_array($this->tokens[$this->filePtr]['code'], [T_DOC_COMMENT_OPEN_TAG, T_DOC_COMMENT]) === true) {
                // Dispose of unused comment, if any.
                if ($this->pass === 2 && $this->commentPending !== null) {
                    $this->processPossVarComment(null, $this->commentPending);
                    $this->commentPending = null;
                }

                // Fetch new comment.
                $this->processComment();
            } else {
                $this->filePtr++;
                $this->fetchToken();
            }
        }

        // If we're at the end of the file, dispose of unused comment, if any.
        if ($this->token['code'] === null && $this->pass === 2 && $this->commentPending !== null) {
            $this->processPossVarComment(null, $this->commentPending);
            $this->commentPending = null;
        }

    }//end advance()


    /**
     * Find following token
     *
     * @return array{
     *      'code': ?array-key, 'content': string, 'scope_opener'?: int, 'scope_closer'?: int,
     *      'parenthesis_opener'?: int, 'parenthesis_closer'?: int, 'attribute_closer'?: int,
     *      'bracket_opener'?: int, 'bracket_closer'?: int,
     *      'comment_tags'?: array<int>, 'comment_closer'?: int
     *  }
     */
    protected function lookAhead()
    {
        $filePtr = ($this->filePtr + 1);

        // Skip stuff that doesn't affect us.
        while ($filePtr < count($this->tokens)
            && in_array($this->tokens[$filePtr]['code'], Tokens::$emptyTokens) === true
        ) {
            $filePtr++;
        }

        if ($filePtr < count($this->tokens)) {
            return $this->tokens[$filePtr];
        } else {
            return [
                'code'    => null,
                'content' => '',
            ];
        }

    }//end lookAhead()


    /**
     * Advance the token pointer to a specific point.
     *
     * @param int $newPtr Where to advance to
     *
     * @return         void
     * @phpstan-impure
     */
    protected function advanceTo($newPtr)
    {
        while ($this->filePtr < $newPtr) {
            $this->advance();
        }

        if ($this->filePtr !== $newPtr) {
            throw new \Exception('Malformed code.');
        }

    }//end advanceTo()


    /**
     * Process a PHPDoc comment.
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processComment()
    {
        $commentPtr           = $this->filePtr;
        $this->commentPending = (object) [
            'ptr'  => $commentPtr,
            'tags' => [],
        ];
        $this->filePtr++;
        $this->fetchToken();

        if (isset($this->tokens[$commentPtr]['comment_tags']) === false) {
            throw new \Exception('Comment tags not found.');
        }

        // For each tag.
        foreach ($this->tokens[$commentPtr]['comment_tags'] as $tagPtr) {
            $this->filePtr = $tagPtr;
            $this->fetchToken();

            $tag = (object) [
                'ptr'       => $tagPtr,
                'content'   => '',
                'cStartPtr' => null,
                'cEndPtr'   => null,
            ];

            // Fetch the tag type.
            $tagType = $this->token['content'];
            $this->filePtr++;
            $this->fetchToken();

            // Skip line starting stuff.
            while ($this->token['code'] === T_DOC_COMMENT_WHITESPACE
                && in_array(substr($this->token['content'], -1), ["\n", "\r"]) === false
            ) {
                $this->filePtr++;
                $this->fetchToken();
            }

            // For each line, until we reach a new tag.
            // Note: the logic for fixing a comment tag must exactly match this.
            do {
                // Fetch line content.
                $newline = false;
                while ($this->token['code'] !== null && $this->token['code'] !== T_DOC_COMMENT_CLOSE_TAG && $newline === false) {
                    if ($tag->cStartPtr === null) {
                        $tag->cStartPtr = $this->filePtr;
                    }

                    $tag->cEndPtr = $this->filePtr;
                    $newline      = in_array(substr($this->token['content'], -1), ["\n", "\r"]) === true;
                    if ($newline === true) {
                        $tag->content .= "\n";
                    } else {
                        $tag->content .= $this->token['content'];
                    }

                    $this->filePtr++;
                    $this->fetchToken();
                }

                // Skip next line starting stuff.
                while ($this->token['code'] === T_DOC_COMMENT_STAR
                        || ($this->token['code'] === T_DOC_COMMENT_WHITESPACE
                            && in_array(substr($this->token['content'], -1), ["\n", "\r"]) === false)
                ) {
                    $this->filePtr++;
                    $this->fetchToken();
                }
            } while (in_array($this->token['code'], [T_DOC_COMMENT_TAG, T_DOC_COMMENT_CLOSE_TAG, null]) === false);

            // Store tag content.
            if (isset($this->commentPending->tags[$tagType]) === false) {
                $this->commentPending->tags[$tagType] = [];
            }

            $this->commentPending->tags[$tagType][] = $tag;
        }//end foreach

        if (isset($this->tokens[$commentPtr]['comment_closer']) === false) {
            throw new \Exception('End of PHPDoc comment not found.');
        }

        $this->filePtr = $this->tokens[$commentPtr]['comment_closer'];
        $this->fetchToken();
        if ($this->token['code'] !== T_DOC_COMMENT_CLOSE_TAG) {
            throw new \Exception('End of PHPDoc comment not found.');
        }

        $this->filePtr++;
        $this->fetchToken();

    }//end processComment()


    /**
     * Check for misplaced tags
     *
     * @param object{ptr: int, tags: array<string, object{ptr: int, content: string, cStartPtr: ?int, cEndPtr: ?int}[]>} $comment  PHPDoc block
     * @param string[]                                                                                                   $tagNames What we shouldn't have
     *
     * @return void
     */
    protected function checkNo($comment, $tagNames)
    {
        if ($this->checkTagsNotMisplaced === false) {
            return;
        }

        foreach ($tagNames as $tagName) {
            if (isset($comment->tags[$tagName]) === true) {
                $this->file->addError(
                    'PHPDoc misplaced tag',
                    $comment->tags[$tagName][0]->ptr,
                    'PHPDocTagMisplaced'
                );
            }
        }

    }//end checkNo()


    /**
     * Fix a PHPDoc comment tag.
     *
     * @param object{ptr: int, content: string, cStartPtr: ?int, cEndPtr: ?int} $tag         The PHPDoc tag to be fixed
     * @param string                                                            $replacement Replacement text
     *
     * @return         void
     * @phpstan-impure
     */
    protected function fixCommentTag($tag, $replacement)
    {
        $replacementArray = explode("\n", $replacement);
        // Place in the replacement array.
        $replacementCounter = 0;
        // Have we done the replacement at the current position in the array?
        $doneReplacement = false;
        $ptr = $tag->cStartPtr;

        $this->file->fixer->beginChangeset();

        // For each line, until we reach a new tag.
        // Note: the logic for this must exactly match that for processing a comment tag.
        do {
            // Change line content.
            $newline = false;
            while ($this->tokens[$ptr]['code'] !== null && $this->tokens[$ptr]['code'] !== T_DOC_COMMENT_CLOSE_TAG && $newline === false) {
                $newline = in_array(substr($this->tokens[$ptr]['content'], -1), ["\n", "\r"]);
                if ($newline === false) {
                    if ($doneReplacement === true || $replacementArray[$replacementCounter] === '') {
                        // We shouldn't ever end up here.
                        throw new \Exception('Error during replacement.');
                    }

                    $this->file->fixer->replaceToken($ptr, $replacementArray[$replacementCounter]);
                    $doneReplacement = true;
                } else {
                    if (($doneReplacement === true || $replacementArray[$replacementCounter] === '') === false) {
                        // We shouldn't ever end up here.
                        throw new \Exception('Error during replacement.');
                    }

                    $replacementCounter++;
                    $doneReplacement = false;
                }

                $ptr++;
            }//end while

            // Skip next line starting stuff.
            while ($this->tokens[$ptr]['code'] === T_DOC_COMMENT_STAR
                    || ($this->tokens[$ptr]['code'] === T_DOC_COMMENT_WHITESPACE
                        && in_array(substr($this->tokens[$ptr]['content'], -1), ["\n", "\r"]) === false)
            ) {
                $ptr++;
            }
        } while (in_array($this->tokens[$ptr]['code'], [T_DOC_COMMENT_TAG, T_DOC_COMMENT_CLOSE_TAG, null]) === false);

        // Check we're done all the expected replacements, otherwise something's gone seriously wrong.
        if (($replacementCounter === count($replacementArray) - 1
            && ($doneReplacement === true || $replacementArray[(count($replacementArray) - 1)] === '')) === false
        ) {
            // We shouldn't ever end up here.
            throw new \Exception('Error during replacement.');
        }

        $this->file->fixer->endChangeset();

    }//end fixCommentTag()


    /**
     * Process a namespace declaration.
     *
     * @param \stdClass&object{namespace: string, uses: array<string, string>, templates: array<string, string>, className: ?string, parentName: ?string, type: string, closer: ?int} $scope Scope
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processNamespace($scope)
    {

        $this->advance(T_NAMESPACE);

        // Fetch the namespace.
        $namespace = '';
        while (in_array(
            $this->token['code'],
            [
                T_NAME_FULLY_QUALIFIED,
                T_NAME_QUALIFIED,
                T_NAME_RELATIVE,
                T_NS_SEPARATOR,
                T_STRING,
            ]
        ) === true
        ) {
            $namespace .= $this->token['content'];
            $this->advance();
        }

        // Check it's right.
        if ($namespace !== '' && $namespace[(strlen($namespace) - 1)] === '\\') {
            throw new \Exception('Namespace trailing backslash.');
        }

        // Check it's fully qualified.
        if ($namespace !== '' && $namespace[0] !== '\\') {
            $namespace = '\\'.$namespace;
        }

        if (in_array($this->token['code'], [T_OPEN_CURLY_BRACKET, T_SEMICOLON]) === false) {
            throw new \Exception('Namespace malformed.');
        }

        // What kind of namespace is it?
        if ($this->token['code'] === T_OPEN_CURLY_BRACKET) {
            $scope            = clone($scope);
            $scope->type      = 'namespace';
            $scope->namespace = $namespace;
            $this->processBlock($scope, 1);
        } else {
            $scope->namespace = $namespace;
            $this->advance(T_SEMICOLON);
        }

    }//end processNamespace()


    /**
     * Process a use declaration.
     *
     * @param \stdClass&object{namespace: string, uses: array<string, string>, templates: array<string, string>, className: ?string, parentName: ?string, type: string, closer: ?int} $scope Scope
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processUse($scope)
    {

        $this->advance(T_USE);

        // Loop until we've fetched all imports.
        $more = false;
        do {
            // Get the type.
            $type = 'class';
            if ($this->token['code'] === T_FUNCTION) {
                $type = 'function';
                $this->advance(T_FUNCTION);
            } else if ($this->token['code'] === T_CONST) {
                $type = 'const';
                $this->advance(T_CONST);
            }

            // Get what's being imported.
            $namespace = '';
            while (in_array(
                $this->token['code'],
                [
                    T_NAME_FULLY_QUALIFIED,
                    T_NAME_QUALIFIED,
                    T_NAME_RELATIVE,
                    T_NS_SEPARATOR,
                    T_STRING,
                ]
            ) === true
            ) {
                $namespace .= $this->token['content'];
                $this->advance();
            }

            // Check it's fully qualified.
            if ($namespace !== '' && $namespace[0] !== '\\') {
                $namespace = '\\'.$namespace;
            }

            if ($this->token['code'] === T_OPEN_USE_GROUP) {
                // It's a group.
                $namespaceStart = $namespace;
                if ($namespaceStart !== '' && strrpos($namespaceStart, '\\') !== (strlen($namespaceStart) - 1)) {
                    throw new \Exception("Namespace for use group doesn't have trailing back slash.");
                }

                $typeStart = $type;

                // Fetch everything in the group.
                $maybeMore = false;
                $this->advance(T_OPEN_USE_GROUP);
                do {
                    // Get the type.
                    $type = $typeStart;
                    if ($this->token['code'] === T_FUNCTION) {
                        $type = 'function';
                        $this->advance(T_FUNCTION);
                    } else if ($this->token['code'] === T_CONST) {
                        $type = 'const';
                        $this->advance(T_CONST);
                    }

                    // Get what's being imported.
                    $namespace = $namespaceStart;
                    while (in_array(
                        $this->token['code'],
                        [
                            T_NAME_FULLY_QUALIFIED,
                            T_NAME_QUALIFIED,
                            T_NAME_RELATIVE,
                            T_NS_SEPARATOR,
                            T_STRING,
                        ]
                    ) === true
                    ) {
                        $namespace .= $this->token['content'];
                        $this->advance();
                    }

                    // Figure out the alias.
                    $alias = substr($namespace, (strrpos($namespace, '\\') + 1));
                    if ($alias === false || $alias === '') {
                        throw new \Exception('Use item has trailing back slash.');
                    }

                    $asAlias = $this->processUseAsAlias();
                    if ($asAlias !== null) {
                        $alias = $asAlias;
                    }

                    // Store it.
                    if ($type === 'class') {
                        $scope->uses[$alias] = $namespace;
                    }

                    $maybeMore = ($this->token['code'] === T_COMMA);
                    if ($maybeMore === true) {
                        $this->advance(T_COMMA);
                    }
                } while ($maybeMore === true && $this->token['code'] !== T_CLOSE_USE_GROUP);
                $this->advance(T_CLOSE_USE_GROUP);
            } else {
                // It's a single import.
                // Figure out the alias.
                if (strrpos($namespace, '\\') !== false) {
                    $alias = substr($namespace, (strrpos($namespace, '\\') + 1));
                } else {
                    $alias = $namespace;
                }

                if ($alias === false || $alias === '') {
                    throw new \Exception('Use name has trailing back slash.');
                }

                $asAlias = $this->processUseAsAlias();
                if ($asAlias !== null) {
                    $alias = $asAlias;
                }

                // Store it.
                if ($type === 'class') {
                    $scope->uses[$alias] = $namespace;
                }
            }//end if

            $more = ($this->token['code'] === T_COMMA);
            if ($more === true) {
                $this->advance(T_COMMA);
            }
        } while ($more === true);

        $this->advance(T_SEMICOLON);

    }//end processUse()


    /**
     * Process a use as alias.
     *
     * @return         ?string
     * @phpstan-impure
     */
    protected function processUseAsAlias()
    {
        $alias = null;
        if ($this->token['code'] === T_AS) {
            $this->advance(T_AS);
            $alias = $this->token['content'];
            $this->advance(T_STRING);
        }

        return $alias;

    }//end processUseAsAlias()


    /**
     * Process a classish thing.
     *
     * @param \stdClass&object{namespace: string, uses: array<string, string>, templates: array<string, string>, className: ?string, parentName: ?string, type: string, closer: ?int} $scope   Scope
     * @param ?(\stdClass&object{ptr: int, tags: array<string, object{ptr: int, content: string, cStartPtr: ?int, cEndPtr: ?int}[]>})                                                 $comment PHPDoc block
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processClassish($scope, $comment)
    {

        $ptr   = $this->filePtr;
        $token = $this->token;
        $this->advance();

        // New scope.
        $scope         = clone($scope);
        $scope->type   = 'classish';
        $scope->closer = null;

        // Get details.
        $name = $this->file->getDeclarationName($ptr);
        if ($name !== null) {
            $name = $scope->namespace.'\\'.$name;
        }

        $parent = $this->file->findExtendedClassName($ptr);
        if ($parent === false) {
            $parent = null;
        } else if ($parent !== null && $parent[0] !== '\\') {
            if (isset($scope->uses[$parent]) === true) {
                $parent = $scope->uses[$parent];
            } else {
                $parent = $scope->namespace.'\\'.$parent;
            }
        }

        $interfaces = $this->file->findImplementedInterfaceNames($ptr);
        if ($interfaces === false) {
            $interfaces = [];
        }

        foreach ($interfaces as $index => $interface) {
            if ($interface !== '' && $interface[0] !== '\\') {
                if (isset($scope->uses[$interface]) === true) {
                    $interfaces[$index] = $scope->uses[$interface];
                } else {
                    $interfaces[$index] = $scope->namespace.'\\'.$interface;
                }
            }
        }

        $scope->className  = $name;
        $scope->parentName = $parent;

        if ($this->pass === 1 && $name !== null) {
            // Store details.
            $this->artifacts[$name] = (object) [
                'extends'    => $parent,
                'implements' => $interfaces,
            ];
        } else if ($this->pass === 2) {
            // Check for missing docs if not anonymous.
            if ($this->checkHasDocBlocks === true && $name !== null && $comment === null) {
                $this->file->addWarning(
                    'PHPDoc class is not documented',
                    $ptr,
                    'PHPDocClassDocMissing'
                );
            }

            // Check no misplaced tags.
            if ($comment !== null) {
                $this->checkNo($comment, ['@param', '@return', '@var']);
            }

            // Check and store templates.
            if ($comment !== null && isset($comment->tags['@template']) === true) {
                $this->processTemplates($scope, $comment);
            }

            // Check properties.
            if ($comment !== null) {
                // Check each property type.
                foreach (['@property', '@property-read', '@property-write'] as $tagName) {
                    if (isset($comment->tags[$tagName]) === false) {
                        $comment->tags[$tagName] = [];
                    }

                    // Check each individual property.
                    foreach ($comment->tags[$tagName] as $docProp) {
                        $docPropParsed = $this->typesUtil->parseTypeAndName(
                            $scope,
                            $docProp->content,
                            1,
                            false
                        );
                        if ($docPropParsed->type === null) {
                            $this->file->addError(
                                'PHPDoc class property type error: '.$docPropParsed->err,
                                $docProp->ptr,
                                'PHPDocClassPropType'
                            );
                        } else if ($docPropParsed->name === null) {
                            $this->file->addError(
                                'PHPDoc class property name missing or malformed',
                                $docProp->ptr,
                                'PHPDocClassPropName'
                            );
                        } else {
                            if ($this->checkTypePhpFig === true && $docPropParsed->phpFig === false) {
                                $this->file->addError(
                                    "PHPDoc class property type doesn't conform to PHP-FIG PSR-5",
                                    $docProp->ptr,
                                    'PHPDocClassPropTypePHPFIG'
                                );
                            }

                            if ($this->checkTypeStyle === true && $docPropParsed->fixed !== null) {
                                $fix = $this->file->addFixableError(
                                    "PHPDoc class property type doesn't conform to recommended style",
                                    $docProp->ptr,
                                    'PHPDocClassPropTypeStyle'
                                );
                                if ($fix === true) {
                                    $this->fixCommentTag(
                                        $docProp,
                                        $docPropParsed->fixed
                                    );
                                }
                            }
                        }//end if
                    }//end foreach
                }//end foreach
            }//end if
        }//end if

        if (isset($token['parenthesis_opener']) === true) {
            $parametersPtr = $token['parenthesis_opener'];
        } else {
            $parametersPtr = null;
        }

        if (isset($token['scope_opener']) === true) {
            $blockPtr = $token['scope_opener'];
        } else {
            $blockPtr = null;
        }

        // If it's an anonymous class, it could have parameters.
        // And those parameters could have other anonymous classes or functions in them.
        if ($parametersPtr !== null) {
            $this->advanceTo($parametersPtr);
            $this->processBlock($scope, 2);
        }

        // Process the content.
        if ($blockPtr !== null) {
            $this->advanceTo($blockPtr);
            $this->processBlock($scope, 1);
        };

    }//end processClassish()


    /**
     * Skip over a class trait usage.
     * We need to ignore these, because if it's got public, protected, or private in it,
     * it could be confused for a declaration.
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processClassTraitUse()
    {
        $this->advance(T_USE);

        $more = false;
        do {
            while (in_array(
                $this->token['code'],
                [
                    T_NAME_FULLY_QUALIFIED,
                    T_NAME_QUALIFIED,
                    T_NAME_RELATIVE,
                    T_NS_SEPARATOR,
                    T_STRING,
                ]
            ) === true
            ) {
                $this->advance();
            }

            if ($this->token['code'] === T_OPEN_CURLY_BRACKET) {
                if (isset($this->token['bracket_opener']) === false || isset($this->token['bracket_closer']) === false) {
                    throw new \Exception('Malformed class trait use group.');
                }

                $this->advanceTo($this->token['bracket_closer']);
                $this->advance(T_CLOSE_CURLY_BRACKET);
            }

            $more = ($this->token['code'] === T_COMMA);
            if ($more === true) {
                $this->advance(T_COMMA);
            }
        } while ($more === true);

    }//end processClassTraitUse()


    /**
     * Process a function.
     *
     * @param \stdClass&object{namespace: string, uses: array<string, string>, templates: array<string, string>, className: ?string, parentName: ?string, type: string, closer: ?int} $scope   Scope
     * @param ?(\stdClass&object{ptr: int, tags: array<string, object{ptr: int, content: string, cStartPtr: ?int, cEndPtr: ?int}[]>})                                                 $comment PHPDoc block
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processFunction($scope, $comment)
    {

        $ptr   = $this->filePtr;
        $token = $this->token;
        $this->advance();

        // New scope.
        $scope         = clone($scope);
        $scope->type   = 'function';
        $scope->closer = null;

        // Get details.
        if ($token['code'] !== T_FN) {
            $name = $this->file->getDeclarationName($ptr);
        } else {
            $name = null;
        }

        if (isset($token['parenthesis_opener']) === true) {
            $parametersPtr = $token['parenthesis_opener'];
        } else {
            $parametersPtr = null;
        }

        if (isset($token['scope_opener']) === true) {
            $blockPtr = $token['scope_opener'];
        } else {
            $blockPtr = null;
        }

        if ($parametersPtr === null
            || isset($this->tokens[$parametersPtr]['parenthesis_opener']) === false
            || isset($this->tokens[$parametersPtr]['parenthesis_closer']) === false
        ) {
            throw new \Exception('Malformed function parameters.');
        }

        $parameters = $this->file->getMethodParameters($ptr);
        $properties = $this->file->getMethodProperties($ptr);

        // Checks.
        if ($this->pass === 2) {
            // Check for missing docs if not anonymous.
            if ($this->checkHasDocBlocks === true && $name !== null && $comment === null) {
                $this->file->addWarning(
                    'PHPDoc function is not documented',
                    $ptr,
                    'PHPDocFunDocMissing'
                );
            }

            // Check for misplaced tags.
            if ($comment !== null) {
                $this->checkNo($comment, ['@property', '@property-read', '@property-write', '@var']);
            }

            // Check and store templates.
            if ($comment !== null && isset($comment->tags['@template']) === true) {
                $this->processTemplates($scope, $comment);
            }

            // Check parameter types.
            if ($comment !== null) {
                // Gather parameter data.
                $paramParsedArray = [];
                foreach ($parameters as $parameter) {
                    $paramText = trim($parameter['content']);
                    while (($spacePos = strpos($paramText, ' ')) !== false
                        && in_array(
                            strtolower(substr($paramText, 0, $spacePos)),
                            [
                                'public',
                                'private',
                                'protected',
                                'readonly',
                            ]
                        ) === true
                    ) {
                        $paramText = trim(substr($paramText, (strpos($paramText, ' ') + 1)));
                    }

                    $paramParsed = $this->typesUtil->parseTypeAndName(
                        $scope,
                        $paramText,
                        3,
                        true
                    );
                    if ($paramParsed->name !== null && isset($paramParsedArray[$paramParsed->name]) === false) {
                        $paramParsedArray[$paramParsed->name] = $paramParsed;
                    }
                }//end foreach

                if (isset($comment->tags['@param']) === false) {
                    $comment->tags['@param'] = [];
                }

                // Check each individual doc parameter.
                $docParamsMatched = [];
                foreach ($comment->tags['@param'] as $docParam) {
                    $docParamParsed = $this->typesUtil->parseTypeAndName(
                        $scope,
                        $docParam->content,
                        2,
                        false
                    );
                    if ($docParamParsed->type === null) {
                        $this->file->addError(
                            'PHPDoc function parameter type error: '.$docParamParsed->err,
                            $docParam->ptr,
                            'PHPDocFunParamType'
                        );
                    } else if ($docParamParsed->name === null) {
                        $this->file->addError(
                            'PHPDoc function parameter name missing or malformed',
                            $docParam->ptr,
                            'PHPDocFunParamName'
                        );
                    } else if (isset($paramParsedArray[$docParamParsed->name]) === false) {
                        // Function parameter doesn't exist.
                        $this->file->addError(
                            "PHPDoc function parameter doesn't exist",
                            $docParam->ptr,
                            'PHPDocFunParamNameWrong'
                        );
                    } else {
                        // Compare docs against actual parameter.
                        $paramParsed = $paramParsedArray[$docParamParsed->name];

                        if (isset($docParamsMatched[$docParamParsed->name]) === true) {
                            $this->file->addError(
                                'PHPDoc function parameter repeated',
                                $docParam->ptr,
                                'PHPDocFunParamNameMultiple'
                            );
                        }

                        $docParamsMatched[$docParamParsed->name] = true;

                        if ($this->checkTypeMatch === true
                            && $this->typesUtil->comparetypes($paramParsed->type, $docParamParsed->type) === false
                        ) {
                            $this->file->addError(
                                'PHPDoc function parameter type mismatch',
                                $docParam->ptr,
                                'PHPDocFunParamTypeMismatch'
                            );
                        }

                        if ($this->checkTypePhpFig === true && $docParamParsed->phpFig === false) {
                            $this->file->addError(
                                "PHPDoc function parameter type doesn't conform to PHP-FIG PSR-5",
                                $docParam->ptr,
                                'PHPDocFunParamTypePHPFIG'
                            );
                        }

                        if ($this->checkTypeStyle === true && $docParamParsed->fixed !== null) {
                            $fix = $this->file->addFixableError(
                                "PHPDoc function parameter type doesn't conform to recommended style",
                                $docParam->ptr,
                                'PHPDocFunParamTypeStyle'
                            );
                            if ($fix === true) {
                                $this->fixCommentTag(
                                    $docParam,
                                    $docParamParsed->fixed
                                );
                            }
                        }

                        if ($this->checkPassSplat === true && $paramParsed->passSplat !== $docParamParsed->passSplat) {
                            $this->file->addError(
                                'PHPDoc function parameter pass by reference or splat mismatch',
                                $docParam->ptr,
                                'PHPDocFunParamPassSplatMismatch'
                            );
                        }
                    }//end if
                }//end foreach

                // Check all parameters are documented (if all documented parameters were recognised).
                if ($this->checkHasTags === true && count($docParamsMatched) === count($comment->tags['@param'])) {
                    foreach ($paramParsedArray as $paramname => $paramParsed) {
                        if (isset($docParamsMatched[$paramname]) === false) {
                            $this->file->addWarning(
                                'PHPDoc function parameter %s not documented',
                                $comment->ptr,
                                'PHPDocFunParamTagMissing',
                                [$paramname]
                            );
                        }
                    }
                }

                // Check parameters are in the correct order.
                reset($paramParsedArray);
                reset($docParamsMatched);
                while (key($paramParsedArray) !== null || key($docParamsMatched) !== null) {
                    if (key($docParamsMatched) === key($paramParsedArray)) {
                        next($paramParsedArray);
                        next($docParamsMatched);
                    } else if (key($paramParsedArray) !== null && isset($docParamsMatched[key($paramParsedArray)]) === false) {
                        next($paramParsedArray);
                    } else {
                        $this->file->addWarning(
                            'PHPDoc function parameter order wrong',
                            $comment->ptr,
                            'PHPDocFunParamTagOrder'
                        );
                        break;
                    }
                }
            }//end if

            // Check return type.
            if ($comment !== null) {
                if ($properties['return_type'] !== '') {
                    $retParsed = $this->typesUtil->parseTypeAndName(
                        $scope,
                        $properties['return_type'],
                        0,
                        true
                    );
                } else {
                    $retParsed = (object) ['type' => 'mixed'];
                }

                if (isset($comment->tags['@return']) === false) {
                    $comment->tags['@return'] = [];
                }

                if ($this->checkHasTags === true && count($comment->tags['@return']) < 1
                    && $name !== '__construct' && $retParsed->type !== 'void'
                ) {
                    $this->file->addWarning(
                        'PHPDoc missing function @return tag',
                        $comment->ptr,
                        'PHPDocFunRetTagMissing'
                    );
                } else if (count($comment->tags['@return']) > 1) {
                    $this->file->addError(
                        'PHPDoc multiple function @return tags--Put in one tag, seperated by vertical bars |',
                        $comment->tags['@return'][1]->ptr,
                        'PHPDocFunRetTagMultiple'
                    );
                }

                // Check each individual return tag, in case there's more than one.
                foreach ($comment->tags['@return'] as $docRet) {
                    $docRetParsed = $this->typesUtil->parseTypeAndName(
                        $scope,
                        $docRet->content,
                        0,
                        false
                    );

                    if ($docRetParsed->type === null) {
                        $this->file->addError(
                            'PHPDoc function return type error: '.$docRetParsed->err,
                            $docRet->ptr,
                            'PHPDocFunRetType'
                        );
                    } else {
                        if ($this->checkTypeMatch === true
                            && $this->typesUtil->comparetypes($retParsed->type, $docRetParsed->type) === false
                        ) {
                            $this->file->addError(
                                'PHPDoc function return type mismatch',
                                $docRet->ptr,
                                'PHPDocFunRetTypeMismatch'
                            );
                        }

                        if ($this->checkTypePhpFig === true && $docRetParsed->phpFig === false) {
                            $this->file->addError(
                                "PHPDoc function return type doesn't conform to PHP-FIG PSR-5",
                                $docRet->ptr,
                                'PHPDocFunRetTypePHPFIG'
                            );
                        }

                        if ($this->checkTypeStyle === true && $docRetParsed->fixed !== null) {
                            $fix = $this->file->addFixableError(
                                "PHPDoc function return type doesn't conform to recommended style",
                                $docRet->ptr,
                                'PHPDocFunRetTypeStyle'
                            );
                            if ($fix === true) {
                                $this->fixCommentTag(
                                    $docRet,
                                    $docRetParsed->fixed
                                );
                            }
                        }
                    }//end if
                }//end foreach
            }//end if
        }//end if

        // Parameters could contain anonymous classes or functions.
        $this->advanceTo($parametersPtr);
        $this->processBlock($scope, 2);

        // Content.
        if ($blockPtr !== null) {
            $this->advanceTo($blockPtr);
            $this->processBlock($scope, 1);
        };

    }//end processFunction()


    /**
     * Process templates.
     *
     * @param \stdClass&object{namespace: string, uses: array<string, string>, templates: array<string, string>, className: ?string, parentName: ?string, type: string, closer: ?int} $scope   Scope
     * @param ?(\stdClass&object{ptr: int, tags: array<string, object{ptr: int, content: string, cStartPtr: ?int, cEndPtr: ?int}[]>})                                                 $comment PHPDoc block
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processTemplates($scope, $comment)
    {
        foreach ($comment->tags['@template'] as $docTemplate) {
            $docTemplateParsed = $this->typesUtil->parseTemplate($scope, $docTemplate->content);
            if ($docTemplateParsed->name === null) {
                $this->file->addError(
                    'PHPDoc template name missing or malformed',
                    $docTemplate->ptr,
                    'PHPDocTemplateName'
                );
            } else if ($docTemplateParsed->type === null) {
                $this->file->addError(
                    'PHPDoc template type error: '.$docTemplateParsed->err,
                    $docTemplate->ptr,
                    'PHPDocTemplateType'
                );
                $scope->templates[$docTemplateParsed->name] = 'never';
            } else {
                $scope->templates[$docTemplateParsed->name] = $docTemplateParsed->type;

                if ($this->checkTypePhpFig === true && $docTemplateParsed->phpFig === false) {
                    $this->file->addError(
                        "PHPDoc template type doesn't conform to PHP-FIG PSR-5",
                        $docTemplate->ptr,
                        'PHPDocTemplateTypePHPFIG'
                    );
                }

                if ($this->checkTypeStyle === true && $docTemplateParsed->fixed !== null) {
                    $fix = $this->file->addFixableError(
                        "PHPDoc tempate type doesn't conform to recommended style",
                        $docTemplate->ptr,
                        'PHPDocTemplateTypeStyle'
                    );
                    if ($fix === true) {
                        $this->fixCommentTag(
                            $docTemplate,
                            $docTemplateParsed->fixed
                        );
                    }
                }
            }//end if
        }//end foreach

    }//end processTemplates()


    /**
     * Process a variable.
     *
     * @param \stdClass&object{namespace: string, uses: array<string, string>, templates: array<string, string>, className: ?string, parentName: ?string, type: string, closer: ?int} $scope   Scope
     * @param ?(\stdClass&object{ptr: int, tags: array<string, object{ptr: int, content: string, cStartPtr: ?int, cEndPtr: ?int}[]>})                                                 $comment PHPDoc block
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processVariable($scope, $comment)
    {

        // Parse var/const token.
        $const = ($this->token['code'] === T_CONST);
        if ($const === true) {
            $this->advance(T_CONST);
        } else if ($this->token['code'] === T_VAR) {
            $this->advance(T_VAR);
        }

        // Parse type.
        $varType = '';
        while (in_array(
            $this->token['code'],
            [
                T_TYPE_UNION,
                T_TYPE_INTERSECTION,
                T_NULLABLE,
                T_OPEN_PARENTHESIS,
                T_CLOSE_PARENTHESIS,
                T_NAME_FULLY_QUALIFIED,
                T_NAME_QUALIFIED,
                T_NAME_RELATIVE,
                T_NS_SEPARATOR,
                T_STRING,
                T_NULL,
                T_ARRAY,
                T_OBJECT,
                T_SELF,
                T_PARENT,
                T_FALSE,
                T_TRUE,
                T_CALLABLE,
                T_STATIC,
            ]
        ) === true
            && ($const === false || $this->lookAhead()['code'] !== T_EQUAL)
        ) {
            $varType .= $this->token['content'];
            $this->advance();
        }

        // Check name.
        if (($const === true && $this->token['code'] !== T_STRING)
            || ($const === false && $this->token['code'] !== T_VARIABLE)
        ) {
            throw new \Exception('Expected variable or constant name.');
        }

        // Checking.
        if ($this->pass === 2) {
            if ($this->checkHasDocBlocks === true && $comment === null && $scope->type === 'classish') {
                // Require comments for class variables and constants.
                $this->file->addWarning(
                    'PHPDoc variable or constant is not documented',
                    $this->filePtr,
                    'PHPDocVarDocMissing'
                );
            } else if ($comment !== null) {
                // Check for misplaced tags.
                $this->checkNo(
                    $comment,
                    [
                        '@template',
                        '@property',
                        '@property-read',
                        '@property-write',
                        '@param',
                        '@return',
                    ]
                );

                if (isset($comment->tags['@var']) === false) {
                    $comment->tags['@var'] = [];
                }

                // Missing var tag.
                if ($this->checkHasTags === true && count($comment->tags['@var']) < 1) {
                    $this->file->addWarning(
                        'PHPDoc variable missing @var tag',
                        $comment->ptr,
                        'PHPDocVarTagMissing'
                    );
                }

                // Var type check and match.
                $varParsed = $this->typesUtil->parseTypeAndName(
                    $scope,
                    $varType,
                    0,
                    true
                );

                foreach ($comment->tags['@var'] as $docVar) {
                    $docVarParsed = $this->typesUtil->parseTypeAndName(
                        $scope,
                        $docVar->content,
                        0,
                        false
                    );

                    if ($docVarParsed->type === null) {
                        $this->file->addError(
                            'PHPDoc var type error: '.$docVarParsed->err,
                            $docVar->ptr,
                            'PHPDocVarType'
                        );
                    } else {
                        if ($this->checkTypeMatch === true
                            && $this->typesUtil->comparetypes($varParsed->type, $docVarParsed->type) === false
                        ) {
                            $this->file->addError(
                                'PHPDoc var type mismatch',
                                $docVar->ptr,
                                'PHPDocVarTypeMismatch'
                            );
                        }

                        if ($this->checkTypePhpFig === true && $docVarParsed->phpFig === false) {
                            $this->file->addError(
                                "PHPDoc var type doesn't conform to PHP-FIG PSR-5",
                                $docVar->ptr,
                                'PHPDocVarTypePHPFIG'
                            );
                        }

                        if ($this->checkTypeStyle === true && $docVarParsed->fixed !== null) {
                            $fix = $this->file->addFixableError(
                                "PHPDoc var type doesn't conform to recommended style",
                                $docVar->ptr,
                                'PHPDocVarTypeStyle'
                            );
                            if ($fix === true) {
                                $this->fixCommentTag(
                                    $docVar,
                                    $docVarParsed->fixed
                                );
                            }
                        }
                    }//end if
                }//end foreach
            }//end if
        }//end if

        $this->advance();

        if (in_array($this->token['code'], [T_EQUAL, T_COMMA, T_SEMICOLON, T_CLOSE_PARENTHESIS]) === false) {
            throw new \Exception('Malformed variable or function declaration.');
        }

    }//end processVariable()


    /**
     * Process a possible variable comment.
     *
     * Variable comments can be used for variables defined in a variety of ways.
     * If we find a PHPDoc var comment that's not attached to something we're looking for,
     * we'll just check the type is well formed, and assume it's otherwise OK.
     *
     * @param ?(\stdClass&object{namespace: string, uses: array<string, string>, templates: array<string, string>, className: ?string, parentName: ?string, type: string, closer: ?int}) $scope   We don't actually need the scope, because we're not doing a type comparison.
     * @param ?(\stdClass&object{ptr: int, tags: array<string, object{ptr: int, content: string, cStartPtr: ?int, cEndPtr: ?int}[]>})                                                    $comment PHPDoc block
     *
     * @return         void
     * @phpstan-impure
     */
    protected function processPossVarComment($scope, $comment)
    {
        if ($this->pass === 2 && $comment !== null) {
            $this->checkNo(
                $comment,
                [
                    '@template',
                    '@property',
                    '@property-read',
                    '@property-write',
                    '@param',
                    '@return',
                ]
            );

            // Check @var tags if any.
            if (isset($comment->tags['@var']) === true) {
                foreach ($comment->tags['@var'] as $docVar) {
                    $docVarParsed = $this->typesUtil->parseTypeAndName(
                        $scope,
                        $docVar->content,
                        0,
                        false
                    );

                    if ($docVarParsed->type === null) {
                        $this->file->addError(
                            'PHPDoc var type error: '.$docVarParsed->err,
                            $docVar->ptr,
                            'PHPDocVarType'
                        );
                    } else {
                        if ($this->checkTypePhpFig === true && $docVarParsed->phpFig === false) {
                            $this->file->addError(
                                "PHPDoc var type doesn't conform to PHP-FIG PSR-5",
                                $docVar->ptr,
                                'PHPDocVarTypePHPFIG'
                            );
                        }

                        if ($this->checkTypeStyle === true && $docVarParsed->fixed !== null) {
                            $fix = $this->file->addFixableError(
                                "PHPDoc var type doesn't conform to recommended style",
                                $docVar->ptr,
                                'PHPDocVarTypeStyle'
                            );
                            if ($fix === true) {
                                $this->fixCommentTag(
                                    $docVar,
                                    $docVarParsed->fixed
                                );
                            }
                        }
                    }//end if
                }//end foreach
            }//end if
        }//end if

    }//end processPossVarComment()


}//end class
