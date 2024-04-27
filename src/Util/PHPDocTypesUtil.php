<?php
/**
 * PHPDoc types utility
 *
 * Checks that PHPDoc types are well formed, and returns a simplified version if so, or null otherwise.
 * Global constants aren't supported.
 * Simplified types can then be compared.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2023-2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA v4 or later
 */

namespace PHP_CodeSniffer\Util;

/**
 * PHPDoc types utility
 */
class PHPDocTypesUtil
{

    /**
     * Predefined and SPL classes.
     *
     * @var array<string, string[]>
     */
    protected $library = [
        // Predefined general.
        '\\ArrayAccess'                     => [],
        '\\BackedEnum'                      => ['\\UnitEnum'],
        '\\Closure'                         => ['callable'],
        '\\Directory'                       => [],
        '\\Fiber'                           => [],
        '\\php_user_filter'                 => [],
        '\\SensitiveParameterValue'         => [],
        '\\Serializable'                    => [],
        '\\stdClass'                        => [],
        '\\Stringable'                      => [],
        '\\UnitEnum'                        => [],
        '\\WeakReference'                   => [],
        // Predefined iterables.
        '\\Generator'                       => ['\\Iterator'],
        '\\InternalIterator'                => ['\\Iterator'],
        '\\Iterator'                        => ['\\Traversable'],
        '\\IteratorAggregate'               => ['\\Traversable'],
        '\\Traversable'                     => ['iterable'],
        '\\WeakMap'                         => [
            '\\ArrayAccess',
            '\\Countable',
            '\\Iteratoraggregate',
        ],
        // Predefined throwables.
        '\\ArithmeticError'                 => ['\\Error'],
        '\\AssertionError'                  => ['\\Error'],
        '\\CompileError'                    => ['\\Error'],
        '\\DivisionByZeroError'             => ['\\ArithmeticError'],
        '\\Error'                           => ['\\Throwable'],
        '\\ErrorException'                  => ['\\Exception'],
        '\\Exception'                       => ['\\Throwable'],
        '\\ParseError'                      => ['\\CompileError'],
        '\\Throwable'                       => ['\\Stringable'],
        '\\TypeError'                       => ['\\Error'],
        // SPL Data structures.
        '\\SplDoublyLinkedList'             => [
            '\\Iterator',
            '\\Countable',
            '\\ArrayAccess',
            '\\Serializable',
        ],
        '\\SplStack'                        => ['\\SplDoublyLinkedList'],
        '\\SplQueue'                        => ['\\SplDoublyLinkedList'],
        '\\SplHeap'                         => [
            '\\Iterator',
            '\\Countable',
        ],
        '\\SplMaxHeap'                      => ['\\SplHeap'],
        '\\SplMinHeap'                      => ['\\SplHeap'],
        '\\SplPriorityQueue'                => [
            '\\Iterator',
            '\\Countable',
        ],
        '\\SplFixedArray'                   => [
            '\\IteratorAggregate',
            '\\ArrayAccess',
            '\\Countable',
            '\\JsonSerializable',
        ],
        '\\Splobjectstorage'                => [
            '\\Countable',
            '\\Iterator',
            '\\Serializable',
            '\\Arrayaccess',
        ],
        // SPL iterators.
        '\\AppendIterator'                  => ['\\IteratorIterator'],
        '\\ArrayIterator'                   => [
            '\\SeekableIterator',
            '\\ArrayAccess',
            '\\Serializable',
            '\\Countable',
        ],
        '\\CachingIterator'                 => [
            '\\IteratorIterator',
            '\\ArrayAccess',
            '\\Countable',
            '\\Stringable',
        ],
        '\\CallbackFilterIterator'          => ['\\FilterIterator'],
        '\\DirectoryIterator'               => [
            '\\SplFileInfo',
            '\\SeekableIterator',
        ],
        '\\EmptyIterator'                   => ['\\Iterator'],
        '\\FilesystemIterator'              => ['\\DirectoryIterator'],
        '\\FilterIterator'                  => ['\\IteratorIterator'],
        '\\GlobalIterator'                  => [
            '\\FilesystemIterator',
            '\\Countable',
        ],
        '\\InfiniteIterator'                => ['\\IteratorIterator'],
        '\\IteratorIterator'                => ['\\OuterIterator'],
        '\\LimitIterator'                   => ['\\IteratorIterator'],
        '\\MultipleIterator'                => ['\\Iterator'],
        '\\NoRewindIterator'                => ['\\IteratorIterator'],
        '\\ParentIterator'                  => ['\\RecursiveFilterIterator'],
        '\\RecursiveArrayIterator'          => [
            '\\ArrayIterator',
            '\\RecursiveIterator',
        ],
        '\\RecursiveCachingIterator'        => [
            '\\CachingIterator',
            '\\RecursiveIterator',
        ],
        '\\RecursiveCallbackFilterIterator' => [
            '\\CallbackFilterIterator',
            '\\RecursiveIterator',
        ],
        '\\RecursiveDirectoryIterator'      => [
            '\\FilesystemIterator',
            '\\RecursiveIterator',
        ],
        '\\RecursiveFilterIterator'         => [
            '\\FilterIterator',
            '\\RecursiveIterator',
        ],
        '\\RecursiveIteratorIterator'       => ['\\OuterIterator'],
        '\\RecursiveRegexIterator'          => [
            '\\RegexIterator',
            '\\RecursiveIterator',
        ],
        '\\RecursiveTreeIterator'           => ['\\RecursiveIteratorIterator'],
        '\\RegexIterator'                   => ['\\FilterIterator'],
        // SPL interfaces.
        '\\Countable'                       => [],
        '\\OuterIterator'                   => ['\\Iterator'],
        '\\RecursiveIterator'               => ['\\Iterator'],
        '\\SeekableIterator'                => ['\\Iterator'],
        // SPL exceptions.
        '\\BadFunctionCallException'        => ['\\LogicException'],
        '\\BadMethodCallException'          => ['\\BadFunctionCallException'],
        '\\DomainException'                 => ['\\LogicException'],
        '\\InvalidArgumentException'        => ['\\LogicException'],
        '\\LengthException'                 => ['\\LogicException'],
        '\\LogicException'                  => ['\\Exception'],
        '\\OutOfBoundsException'            => ['\\RuntimeException'],
        '\\OutOfRangeException'             => ['\\LogicException'],
        '\\OverflowException'               => ['\\RuntimeException'],
        '\\RangeException'                  => ['\\RuntimeException'],
        '\\RuntimeException'                => ['\\Exception'],
        '\\UnderflowException'              => ['\\RuntimeException'],
        '\\UnexpectedValueException'        => ['\\RuntimeException'],
        // SPL file handling.
        '\\SplFileInfo'                     => ['\\Stringable'],
        '\\SplFileObject'                   => [
            '\\SplFileInfo',
            '\\RecursiveIterator',
            '\\SeekableIterator',
        ],
        '\\SplTempFileObject'               => ['\\SplFileObject'],
        // SPL misc.
        '\\ArrayObject'                     => [
            '\\IteratorAggregate',
            '\\ArrayAccess',
            '\\Serializable',
            '\\Countable',
        ],
        '\\SplObserver'                     => [],
        '\\SplSubject'                      => [],
    ];

    /**
     * Inheritance heirarchy.
     *
     * @var array<string, object{extends: ?string, implements: string[]}>
     */
    protected $artifacts;

    /**
     * Scope.
     *
     * @var object{namespace: string, uses: string[], templates: string[], className: ?string, parentName: ?string}
     */
    protected $scope;

    /**
     * The text to be parsed.
     *
     * @var string
     */
    protected $text = '';

    /**
     * Replacements.
     *
     * @var array<object{pos: non-negative-int, len: non-negative-int, replacement: string}>
     */
    protected $replacements = [];

    /**
     * When we encounter an unknown type, what should we use?
     *
     * @var string
     */
    protected $unknown = 'never';

    /**
     * Whether the type complies with the PHP-FIG PHPDoc standard.
     *
     * @var boolean
     */
    protected $phpFig = true;

    /**
     * Next tokens.
     *
     * @var object{startPos: non-negative-int, endPos: non-negative-int, text: ?string}[]
     */
    protected $nexts = [];

    /**
     * The next token.
     *
     * @var ?string
     */
    protected $next = null;


    /**
     * Constructor
     *
     * @param array<string, object{extends: ?string, implements: string[]}> $artifacts Classish things
     */
    public function __construct($artifacts=[])
    {
        $this->artifacts = $artifacts;

    }//end __construct()


    /**
     * Parse a type and possibly variable name
     *
     * @param ?object{namespace: string, uses: string[], templates: string[], className: ?string, parentName: ?string} $scope   the scope
     * @param string                                                                                                   $text    the text to parse
     * @param 0|1|2|3                                                                                                  $getWhat what to get 0=type only 1=also name 2=also modifiers (& ...) 3=also default
     * @param bool                                                                                                     $goWide  if we can't determine the type, should we assume wide (for native type) or narrow (for PHPDoc)?
     *
     * @return object{
     *              type: ?string, passSplat: string, name: ?string, rem: string,
     *              err: ?string, fixed: ?string, phpFig: bool
     *          } the simplified type, pass by reference & splat, variable name, remaining text,
     *            error message, fixed text, and whether PHP-FIG
     */
    public function parseTypeAndName($scope, $text, $getWhat, $goWide)
    {

        // Initialise variables.
        if ($scope !== null) {
            $this->scope = $scope;
        } else {
            $this->scope = (object) [
                'namespace'  => '',
                'uses'       => [],
                'templates'  => [],
                'className'  => null,
                'parentName' => null,
            ];
        }

        $this->text         = $text;
        $this->replacements = [];
        if ($goWide === true) {
            $this->unknown = 'mixed';
        } else {
            $this->unknown = 'never';
        }

        $this->phpFig = true;
        $this->nexts  = [];
        $this->next   = $this->next();
        $err          = null;

        // Try to parse type.
        $savedNexts = $this->nexts;
        try {
            $type = $this->parseAnyType();
            if ($this->next !== null
                && ctype_space(substr($this->text, ($this->nexts[0]->startPos - 1), 1)) === false
                && in_array($this->next, [',', ';', ':', '.']) === false
            ) {
                // Code smell check.
                throw new \Exception('No space after type.');
            }
        } catch (\Exception $e) {
            $this->nexts = $savedNexts;
            $this->next  = $this->next();
            $type        = null;
            $err         = $e->getMessage();
        }

        // Try to parse pass by reference and splat.
        $passSplat = '';
        if ($getWhat >= 2) {
            if ($this->next === '&') {
                $passSplat .= $this->parseToken('&');
            }

            if ($this->next === '...') {
                $passSplat .= $this->parseToken('...');
            }
        }

        // Try to parse name and default value.
        if ($getWhat >= 1) {
            $savedNexts = $this->nexts;
            try {
                if ($this->next === null || $this->next[0] !== '$') {
                    throw new \Exception("Expected variable name, saw \"{$this->next}\".");
                }

                $name = $this->parseToken();
                if ($this->next !== null
                    && ($getWhat < 3 || $this->next !== '=')
                    && ctype_space(substr($this->text, ($this->nexts[0]->startPos - 1), 1)) === false
                    && in_array($this->next, [',', ';', ':', '.']) === false
                ) {
                    // Code smell check.
                    throw new \Exception('No space after variable name.');
                }

                // Implicit nullable.
                if ($getWhat >= 3) {
                    if ($this->next === '='
                        && strtolower(($this->next(1))) === 'null'
                        && strtolower(trim(substr($text, $this->nexts[1]->startPos))) === 'null'
                        && $type !== null && $type !== 'mixed'
                    ) {
                        $type = $type.'|null';
                    }
                }
            } catch (\Exception $e) {
                $this->nexts = $savedNexts;
                $this->next  = $this->next();
                $name        = null;
            }//end try
        } else {
            $name = null;
        }//end if

        if ($type !== null) {
            $fixed = $this->getFixed();
        } else {
            $fixed = null;
        }

        return (object) [
            'type'      => $type,
            'passSplat' => $passSplat,
            'name'      => $name,
            'rem'       => trim(substr($text, $this->nexts[0]->startPos)),
            'err'       => $err,
            'fixed'     => $fixed,
            'phpFig'    => $this->phpFig,
        ];

    }//end parseTypeAndName()


    /**
     * Parse a template
     *
     * @param ?object{namespace: string, uses: string[], templates: string[], className: ?string, parentName: ?string} $scope the scope
     * @param string                                                                                                   $text  the text to parse
     *
     * @return object{
     *              type: ?string, name: ?string, rem: string,
     *              err: ?string, fixed: ?string, phpFig: bool
     *          } the simplified type, template name, remaining text,
     *            error message, fixed text, and whether PHP-FIG
     */
    public function parseTemplate($scope, $text)
    {

        // Initialise variables.
        if ($scope !== null) {
            $this->scope = $scope;
        } else {
            $this->scope = (object) [
                'namespace'  => '',
                'uses'       => [],
                'templates'  => [],
                'className'  => null,
                'parentName' => null,
            ];
        }

        $this->text         = $text;
        $this->replacements = [];
        $this->unknown      = 'never';
        $this->phpFig       = true;
        $this->nexts        = [];
        $this->next         = $this->next();
        $err = null;

        // Try to parse template name.
        $savedNexts = $this->nexts;
        try {
            if ($this->next === null || (ctype_alpha($this->next[0]) === false && $this->next[0] !== '_')) {
                throw new \Exception("Expected template name, saw \"{$this->next}\".");
            }

            $name = $this->parseToken();
            if ($this->next !== null
                && ctype_space(substr($this->text, ($this->nexts[0]->startPos - 1), 1)) === false
                && in_array($this->next, [',', ';', ':', '.']) === false
            ) {
                // Code smell check.
                throw new \Exception('No space after template name.');
            }
        } catch (\Exception $e) {
            $this->nexts = $savedNexts;
            $this->next  = $this->next();
            $name        = null;
        }

        if ($this->next === 'of' || $this->next === 'as') {
            $this->parseToken();
            // Try to parse type.
            $savedNexts = $this->nexts;
            try {
                $type = $this->parseAnyType();
                if ($this->next !== null
                    && ctype_space(substr($this->text, ($this->nexts[0]->startPos - 1), 1)) === false
                    && in_array($this->next, [',', ';', ':', '.']) === false
                ) {
                    // Code smell check.
                    throw new \Exception('No space after type.');
                }
            } catch (\Exception $e) {
                $this->nexts = $savedNexts;
                $this->next  = $this->next();
                $type        = null;
                $err         = $e->getMessage();
            }
        } else {
            $type = 'mixed';
        }//end if

        if ($type !== null) {
            $fixed = $this->getFixed();
        } else {
            $fixed = null;
        }

        return (object) [
            'type'   => $type,
            'name'   => $name,
            'rem'    => trim(substr($text, $this->nexts[0]->startPos)),
            'err'    => $err,
            'fixed'  => $fixed,
            'phpFig' => $this->phpFig,
        ];

    }//end parseTemplate()


    /**
     * Compare types
     *
     * @param ?string $wideType   the type that should be wider, e.g. PHP type
     * @param ?string $narrowType the type that should be narrower, e.g. PHPDoc type
     *
     * @return bool whether $narrowType has the same or narrower scope as $wideType
     */
    public function compareTypes($wideType, $narrowType)
    {
        if ($narrowType === null) {
            return false;
        } else if ($wideType === null || $wideType === 'mixed' || $narrowType === 'never') {
            return true;
        }

        $wideIntersections   = explode('|', $wideType);
        $narrowIntersections = explode('|', $narrowType);

        // We have to match all narrow intersections.
        $haveAllIntersections = true;
        foreach ($narrowIntersections as $narrowIntersection) {
            $narrowSingles = explode('&', $narrowIntersection);

            // If the wide types are super types, that should match.
            $narrowAdditions = [];
            foreach ($narrowSingles as $narrowSingle) {
                assert($narrowSingle !== '');
                $superTypes      = $this->superTypes($narrowSingle);
                $narrowAdditions = array_merge($narrowAdditions, $superTypes);
            }

            $narrowSingles = array_merge($narrowSingles, $narrowAdditions);
            sort($narrowSingles);
            $narrowSingles = array_unique($narrowSingles);

            // We need to look in each wide intersection.
            $haveThisIntersection = false;
            foreach ($wideIntersections as $wideIntersection) {
                $wideSingles = explode('&', $wideIntersection);

                // And find all parts of one of them.
                $haveAllSingles = true;
                foreach ($wideSingles as $wideSingle) {
                    if (in_array($wideSingle, $narrowSingles) === false) {
                        $haveAllSingles = false;
                        break;
                    }
                }

                if ($haveAllSingles === true) {
                    $haveThisIntersection = true;
                    break;
                }
            }

            if ($haveThisIntersection === false) {
                $haveAllIntersections = false;
                break;
            }
        }//end foreach

        return $haveAllIntersections;

    }//end compareTypes()


    /**
     * Get super types
     *
     * @param string $baseType What type do we want the supers for?
     *
     * @return string[] super types
     */
    protected function superTypes($baseType)
    {
        if (in_array($baseType, ['int', 'string']) === true) {
            $superTypes = [
                'array-key',
                'scaler',
            ];
        } else if ($baseType === 'callable-string') {
            $superTypes = [
                'callable',
                'string',
                'array-key',
                'scalar',
            ];
        } else if (in_array($baseType, ['array-key', 'float', 'bool']) === true) {
            $superTypes = ['scalar'];
        } else if ($baseType === 'array') {
            $superTypes = ['iterable'];
        } else if ($baseType === 'static') {
            $superTypes = [
                'self',
                'parent',
                'object',
            ];
        } else if ($baseType === 'self') {
            $superTypes = [
                'parent',
                'object',
            ];
        } else if ($baseType === 'parent') {
            $superTypes = ['object'];
        } else if (strpos($baseType, 'static(') === 0 || $baseType[0] === '\\') {
            if (strpos($baseType, 'static(') === 0) {
                $superTypes     = [
                    'static',
                    'self',
                    'parent',
                    'object',
                ];
                $superTypeQueue = [substr($baseType, 7, -1)];
                $ignore         = false;
            } else {
                $superTypes     = ['object'];
                $superTypeQueue = [$baseType];
                $ignore         = true;
                // We don't want to include the class itself, just super types of it.
            }

            while (($superType = array_shift($superTypeQueue)) !== null) {
                if (in_array($superType, $superTypes) === true) {
                    $ignore = false;
                    continue;
                }

                if ($ignore === false) {
                    $superTypes[] = $superType;
                }

                if (isset($this->library[$superType]) === true) {
                    $librarySupers = $this->library[$superType];
                } else {
                    $librarySupers = null;
                }

                if (isset($this->artifacts[$superType]) === true) {
                    $superTypeObj = $this->artifacts[$superType];
                } else {
                    $superTypeObj = null;
                }

                if ($librarySupers !== null) {
                    $superTypeQueue = array_merge($superTypeQueue, $librarySupers);
                } else if ($superTypeObj !== null) {
                    if ($superTypeObj->extends !== null) {
                        $superTypeQueue[] = $superTypeObj->extends;
                    }

                    if (count($superTypeObj->implements) > 0) {
                        foreach ($superTypeObj->implements as $implements) {
                            $superTypeQueue[] = $implements;
                        }
                    }
                } else if ($ignore === false) {
                    $superTypes = array_merge($superTypes, $this->superTypes($superType));
                }

                $ignore = false;
            }//end while

            $superTypes = array_unique($superTypes);
        } else {
            $superTypes = [];
        }//end if

        return $superTypes;

    }//end superTypes()


    /**
     * Prefetch next token
     *
     * @param non-negative-int $lookAhead How far ahead is the token we want?
     *
     * @return         ?string
     * @phpstan-impure
     */
    protected function next($lookAhead=0)
    {

        // Fetch any more tokens we need.
        while (count($this->nexts) < ($lookAhead + 1)) {
            if (count($this->nexts) > 0) {
                $startPos = end($this->nexts)->endPos;
            } else {
                $startPos = 0;
            }

            $stringUnterminated = false;

            // Ignore whitespace.
            while ($startPos < strlen($this->text) && ctype_space($this->text[$startPos]) === true) {
                $startPos++;
            }

            if ($startPos < strlen($this->text)) {
                $firstChar = $this->text[$startPos];
            } else {
                $firstChar = null;
            }

            // Deal with different types of tokens.
            if ($firstChar === null) {
                // No more tokens.
                $endPos = $startPos;
            } else if (ctype_alpha($firstChar) === true || $firstChar === '_' || $firstChar === '$' || $firstChar === '\\'
                || ord($firstChar) >= 0x7F
            ) {
                // Identifier token.
                $endPos = $startPos;
                do {
                    $endPos = ($endPos + 1);
                    if ($endPos < strlen($this->text)) {
                        $nextChar = $this->text[$endPos];
                    } else {
                        $nextChar = null;
                    }
                } while ($nextChar !== null && (ctype_alnum($nextChar) === true || $nextChar === '_'
                                        || ord($nextChar) >= 0x7F
                                        || ($firstChar !== '$' && ($nextChar === '-' || $nextChar === '\\')))
                );
            } else if (ctype_digit($firstChar) === true
                || ($firstChar === '-' && strlen($this->text) >= ($startPos + 2) && ctype_digit($this->text[($startPos + 1)]) === true)
            ) {
                // Number token.
                $nextChar  = $firstChar;
                $havePoint = false;
                $endPos    = $startPos;
                do {
                    $havePoint = $havePoint || $nextChar === '.';
                    $endPos    = ($endPos + 1);
                    if ($endPos < strlen($this->text)) {
                        $nextChar = $this->text[$endPos];
                    } else {
                        $nextChar = null;
                    }
                } while ($nextChar !== null && (ctype_digit($nextChar) === true || ($nextChar === '.' && $havePoint === false) || $nextChar === '_'));
            } else if ($firstChar === '"' || $firstChar === "'") {
                // String token.
                $endPos = ($startPos + 1);
                if ($endPos < strlen($this->text)) {
                    $nextChar = $this->text[$endPos];
                } else {
                    $nextChar = null;
                }

                while ($nextChar !== $firstChar && $nextChar !== null) {
                    // There may be unterminated strings.
                    if ($nextChar === '\\' && strlen($this->text) >= ($endPos + 2)) {
                        $endPos = ($endPos + 2);
                    } else {
                        $endPos++;
                    }

                    if ($endPos < strlen($this->text)) {
                        $nextChar = $this->text[$endPos];
                    } else {
                        $nextChar = null;
                    }
                }

                if ($nextChar !== null) {
                    $endPos++;
                } else {
                    $stringUnterminated = true;
                }
            } else if (strlen($this->text) >= ($startPos + 3) && substr($this->text, $startPos, 3) === '...') {
                // Splat.
                $endPos = ($startPos + 3);
            } else if (strlen($this->text) >= ($startPos + 2) && substr($this->text, $startPos, 2) === '::') {
                // Scope resolution operator.
                $endPos = ($startPos + 2);
            } else {
                // Other symbol token.
                $endPos = ($startPos + 1);
            }//end if

            // Store token.
            $next = substr($this->text, $startPos, ($endPos - $startPos));
            if ($stringUnterminated === true) {
                $next = '[unterminated string]';
            } else if ($next === false || $next === '') {
                $next = null;
            }

            $this->nexts[] = (object) [
                'startPos' => $startPos,
                'endPos'   => $endPos,
                'text'     => $next,
            ];
        }//end while

        // Return the needed token.
        return $this->nexts[$lookAhead]->text;

    }//end next()


    /**
     * Fetch the next token
     *
     * @param ?string $expect the expected text, or null for any
     *
     * @return         string
     * @phpstan-impure
     */
    protected function parseToken($expect=null)
    {

        $next = $this->next;

        // Check we have the expected token.
        if ($next === null) {
            throw new \Exception('Unexpected end.');
        } else if ($expect !== null && strtolower($next) !== strtolower($expect)) {
            throw new \Exception("Expected \"{$expect}\", saw \"{$next}\".");
        }

        // Prefetch next token.
        $this->next(1);

        // Return consumed token.
        array_shift($this->nexts);
        $this->next = $this->next();
        return $next;

    }//end parseToken()


    /**
     * Correct the next token
     *
     * @param string $correct the corrected text
     *
     * @return         void
     * @phpstan-impure
     */
    protected function correctToken($correct)
    {
        if ($correct !== $this->nexts[0]->text) {
            $this->replacements[] = (object) [
                'pos'         => $this->nexts[0]->startPos,
                'len'         => strlen($this->nexts[0]->text),
                'replacement' => $correct,
            ];
        }

    }//end correctToken()


    /**
     * Get the corrected text, or null if no change
     *
     * @return ?string
     */
    protected function getFixed()
    {
        if (count($this->replacements) === 0) {
            return null;
        }

        $fixedText = $this->text;
        foreach (array_reverse($this->replacements) as $fix) {
            $fixedText = substr($fixedText, 0, $fix->pos).$fix->replacement.substr($fixedText, ($fix->pos + $fix->len));
        }

        return $fixedText;

    }//end getFixed()


    /**
     * Parse a list of types seperated by | and/or &, single nullable type, or conditional return type
     *
     * @param bool $inBrackets are we immediately inside brackets?
     *
     * @return         string the simplified type
     * @phpstan-impure
     */
    protected function parseAnyType($inBrackets=false)
    {

        if ($inBrackets === true && $this->next !== null && $this->next[0] === '$' && $this->next(1) === 'is') {
            // Conditional return type.
            $this->phpFig = false;
            $this->parseToken();
            $this->parseToken('is');
            $this->parseAnyType();
            $this->parseToken('?');
            $firstType = $this->parseAnyType();
            $this->parseToken(':');
            $secondType = $this->parseAnyType();
            $unionTypes = array_merge(explode('|', $firstType), explode('|', $secondType));
        } else if ($this->next === '?') {
            // Single nullable type.
            $this->phpFig = false;
            $this->parseToken('?');
            $unionTypes   = explode('|', $this->parseSingleType());
            $unionTypes[] = 'null';
        } else {
            // Union list.
            $unionTypes = [];
            do {
                // Intersection list.
                $unionInstead      = null;
                $intersectionTypes = [];
                do {
                    $singleType = $this->parseSingleType();
                    if (strpos($singleType, '|') !== false) {
                        $intersectionTypes[] = $this->unknown;
                        $unionInstead        = $singleType;
                    } else {
                        $intersectionTypes = array_merge($intersectionTypes, explode('&', $singleType));
                    }

                    // We have to figure out whether a & is for intersection or pass by reference.
                    $nextNext = $this->next(1);
                    $haveMoreIntersections = $this->next === '&'
                        && !(in_array($nextNext, ['...', '=', ',', ')', null])
                            || ($nextNext !== null && $nextNext[0] === '$'));
                    if ($haveMoreIntersections === true) {
                        $this->parseToken('&');
                    }
                } while ($haveMoreIntersections === true);
                if (count($intersectionTypes) > 1 && $unionInstead !== null) {
                    throw new \Exception('Non-DNF.');
                } else if (count($intersectionTypes) <= 1 && $unionInstead !== null) {
                    $unionTypes = array_merge($unionTypes, explode('|', $unionInstead));
                } else {
                    // Tidy and store intersection list.
                    if (count($intersectionTypes) > 1) {
                        foreach ($intersectionTypes as $intersectionType) {
                            assert($intersectionType !== '');
                            $superTypes = $this->superTypes($intersectionType);
                            if (in_array($intersectionType, ['object', 'iterable', 'callable']) === false
                                && in_array('object', $superTypes) === false
                            ) {
                                throw new \Exception('Intersection can only be used with objects.');
                            }

                            foreach ($superTypes as $superType) {
                                $superPos = array_search($superType, $intersectionTypes);
                                if ($superPos !== false) {
                                    unset($intersectionTypes[$superPos]);
                                }
                            }
                        }

                        sort($intersectionTypes);
                        $intersectionTypes = array_unique($intersectionTypes);
                        $neverPos          = array_search('never', $intersectionTypes);
                        if ($neverPos !== false) {
                            $intersectionTypes = ['never'];
                        }

                        $mixedPos = array_search('mixed', $intersectionTypes);
                        if ($mixedPos !== false && count($intersectionTypes) > 1) {
                            unset($intersectionTypes[$mixedPos]);
                        }
                    }//end if

                    array_push($unionTypes, implode('&', $intersectionTypes));
                }//end if
                // Check for more union items.
                $haveMoreUnions = $this->next === '|';
                if ($haveMoreUnions === true) {
                    $this->parseToken('|');
                }
            } while ($haveMoreUnions === true);
        }//end if

        // Tidy and return union list.
        if (count($unionTypes) > 1) {
            if (in_array('int', $unionTypes) === true && in_array('string', $unionTypes) === true) {
                $unionTypes[] = 'array-key';
            }

            if (in_array('bool', $unionTypes) === true && in_array('float', $unionTypes) === true && in_array('array-key', $unionTypes) === true) {
                $unionTypes[] = 'scalar';
            }

            if (in_array('\\Traversable', $unionTypes) === true && in_array('array', $unionTypes) === true) {
                $unionTypes[] = 'iterable';
            }

            sort($unionTypes);
            $unionTypes = array_unique($unionTypes);
            $mixedPos   = array_search('mixed', $unionTypes);
            if ($mixedPos !== false) {
                $unionTypes = ['mixed'];
            }

            $neverPos = array_search('never', $unionTypes);
            if ($neverPos !== false && count($unionTypes) > 1) {
                unset($unionTypes[$neverPos]);
            }

            foreach ($unionTypes as $key1 => $unionType1) {
                assert($unionType1 !== '');
                foreach ($unionTypes as $key2 => $unionType2) {
                    assert($unionType2 !== '');
                    if ($key2 !== $key1 && $this->compareTypes($unionType1, $unionType2) === true) {
                        unset($unionTypes[$key2]);
                    }
                }
            }
        }//end if

        $type = implode('|', $unionTypes);
        assert($type !== '');
        return $type;

    }//end parseAnyType()


    /**
     * Parse a single type, possibly array type
     *
     * @return         string the simplified type
     * @phpstan-impure
     */
    protected function parseSingleType()
    {
        $hasBrackets = false;
        if ($this->next === '(') {
            $hasBrackets = true;
            $this->parseToken('(');
            $type = $this->parseAnyType(true);
            $this->parseToken(')');
        } else {
            $type = $this->parseBasicType();
        }

        if ($hasBrackets === true && $this->next !== '[') {
            $this->phpFig = false;
        }

        while ($this->next === '[' && $this->next(1) === ']') {
            // Array suffix.
            $this->parseToken('[');
            $this->parseToken(']');
            $type = 'array';
        }

        return $type;

    }//end parseSingleType()


    /**
     * Parse a basic type
     *
     * @return         string the simplified type
     * @phpstan-impure
     */
    protected function parseBasicType()
    {

        $next = $this->next;
        if ($next === null) {
            throw new \Exception('Expected type, saw end.');
        }

        $lowerNext = strtolower($next);
        $nextChar  = $next[0];

        if (in_array($lowerNext, ['bool', 'boolean', 'true', 'false']) === true) {
            // Bool.
            if ($lowerNext === 'boolean') {
                $this->correctToken('bool');
            } else {
                $this->correctToken($lowerNext);
            }

            $this->parseToken();
            $type = 'bool';
        } else if (in_array(
            $lowerNext,
            [
                'int',
                'integer',
                'positive-int',
                'negative-int',
                'non-positive-int',
                'non-negative-int',
                'int-mask',
                'int-mask-of',
            ]
        ) === true
            || ((ctype_digit($nextChar) === true || $nextChar === '-') && strpos($next, '.') === false)
        ) {
            // Int.
            if (in_array($lowerNext, ['int', 'integer']) === false) {
                $this->phpFig = false;
            }

            if ($lowerNext === 'integer') {
                $this->correctToken('int');
            } else {
                $this->correctToken($lowerNext);
            }

            $intType = strtolower($this->parseToken());
            if ($intType === 'int' && $this->next === '<') {
                // Integer range.
                $this->phpFig = false;
                $this->parseToken('<');
                $next = $this->next;
                if ($next === null
                    || (strtolower($next) !== 'min'
                    && ((ctype_digit($next[0]) === false && $next[0] !== '-') || strpos($next, '.') !== false))
                ) {
                    throw new \Exception("Expected int min, saw \"{$next}\".");
                }

                $this->parseToken();
                $this->parseToken(',');
                $next = $this->next;
                if ($next === null
                    || (strtolower($next) !== 'max'
                    && ((ctype_digit($next[0]) === false && $next[0] !== '-') || strpos($next, '.') !== false))
                ) {
                    throw new \Exception("Expected int max, saw \"{$next}\".");
                }

                $this->parseToken();
                $this->parseToken('>');
            } else if ($intType === 'int-mask') {
                // Integer mask.
                $this->parseToken('<');
                do {
                    $mask = $this->parseBasicType();
                    if ($this->compareTypes('int', $mask) === false) {
                        throw new \Exception('Invalid int mask.');
                    }

                    $haveSeperator = $this->next === ',';
                    if ($haveSeperator === true) {
                        $this->parseToken(',');
                    }
                } while ($haveSeperator === true);
                $this->parseToken('>');
            } else if ($intType === 'int-mask-of') {
                // Integer mask of.
                $this->parseToken('<');
                $mask = $this->parseBasicType();
                if ($this->compareTypes('int', $mask) === false) {
                    throw new \Exception('Invalid int mask of.');
                }

                $this->parseToken('>');
            }//end if

            $type = 'int';
        } else if (in_array($lowerNext, ['float', 'double']) === true
            || ((ctype_digit($nextChar) === true || $nextChar === '-') && strpos($next, '.') !== false)
        ) {
            // Float.
            if (in_array($lowerNext, ['float', 'double']) === false) {
                $this->phpFig = false;
            }

            if ($lowerNext === 'double') {
                $this->correctToken('float');
            } else {
                $this->correctToken($lowerNext);
            }

            $this->parseToken();
            $type = 'float';
        } else if (in_array(
            $lowerNext,
            [
                'string',
                'class-string',
                'numeric-string',
                'literal-string',
                'non-empty-string',
                'non-falsy-string',
                'truthy-string',
            ]
        ) === true
            || $nextChar === '"' || $nextChar === "'"
        ) {
            // String.
            if ($lowerNext !== 'string') {
                $this->phpFig = false;
            }

            if ($nextChar !== '"' && $nextChar !== "'") {
                $this->correctToken($lowerNext);
            }

            $strType = strtolower($this->parseToken());
            if ($strType === 'class-string' && $this->next === '<') {
                $this->parseToken('<');
                $objectType = $this->parseBasicType();
                if ($this->compareTypes('object', $objectType) === false) {
                    throw new \Exception("Class-string type isn't class.");
                }

                $this->parseToken('>');
            }

            $type = 'string';
        } else if ($lowerNext === 'callable-string') {
            // Callable-string.
            $this->phpFig = false;
            $this->correctToken($lowerNext);
            $this->parseToken('callable-string');
            $type = 'callable-string';
        } else if (in_array($lowerNext, ['array', 'non-empty-array', 'list', 'non-empty-list']) === true) {
            // Array.
            if ($lowerNext !== 'array') {
                $this->phpFig = false;
            }

            $this->correctToken($lowerNext);
            $arrayType = strtolower($this->parseToken());
            if ($this->next === '<') {
                // Typed array.
                $this->phpFig = false;
                $this->parseToken('<');
                $firstType = $this->parseAnyType();
                if ($this->next === ',') {
                    if (in_array($arrayType, ['list', 'non-empty-list']) === true) {
                        throw new \Exception('Lists cannot have keys specified.');
                    }

                    $key = $firstType;
                    if ($this->compareTypes('array-key', $key) === false) {
                        throw new \Exception('Invalid array key.');
                    }

                    $this->parseToken(',');
                    $value = $this->parseAnyType();
                } else {
                    $key   = null;
                    $value = $firstType;
                }

                $this->parseToken('>');
            } else if ($this->next === '{') {
                // Array shape.
                $this->phpFig = false;
                if (in_array($arrayType, ['non-empty-array', 'non-empty-list']) === true) {
                    throw new \Exception('Non-empty-arrays cannot have shapes.');
                }

                $this->parseToken('{');
                do {
                    $next = $this->next;
                    if ($next !== null
                        && (ctype_alpha($next) === true || $next[0] === '_' || $next[0] === "'" || $next[0] === '"'
                        || ((ctype_digit($next[0]) === true || $next[0] === '-') && strpos($next, '.') === false))
                        && ($this->next(1) === ':' || ($this->next(1) === '?' && $this->next(2) === ':'))
                    ) {
                        $this->parseToken();
                        if ($this->next === '?') {
                            $this->parseToken('?');
                        }

                        $this->parseToken(':');
                    }

                    $this->parseAnyType();
                    $haveComma = $this->next === ',';
                    if ($haveComma === true) {
                        $this->parseToken(',');
                    }
                } while ($haveComma === true);
                $this->parseToken('}');
            }//end if

            $type = 'array';
        } else if ($lowerNext === 'object') {
            // Object.
            $this->correctToken($lowerNext);
            $this->parseToken('object');
            if ($this->next === '{') {
                // Object shape.
                $this->phpFig = false;
                $this->parseToken('{');
                do {
                    $next = $this->next;
                    if ($next === null
                        || (ctype_alpha($next) === false && $next[0] !== '_' && $next[0] !== "'" && $next[0] !== '"')
                    ) {
                        throw new \Exception('Invalid object key.');
                    }

                    $this->parseToken();
                    if ($this->next === '?') {
                        $this->parseToken('?');
                    }

                    $this->parseToken(':');
                    $this->parseAnyType();
                    $haveComma = $this->next === ',';
                    if ($haveComma === true) {
                        $this->parseToken(',');
                    }
                } while ($haveComma === true);
                $this->parseToken('}');
            }//end if

            $type = 'object';
        } else if ($lowerNext === 'resource') {
            // Resource.
            $this->correctToken($lowerNext);
            $this->parseToken('resource');
            $type = 'resource';
        } else if (in_array($lowerNext, ['never', 'never-return', 'never-returns', 'no-return']) === true) {
            // Never.
            $this->correctToken('never');
            $this->parseToken();
            $type = 'never';
        } else if ($lowerNext === 'null') {
            // Null.
            $this->correctToken($lowerNext);
            $this->parseToken('null');
            $type = 'null';
        } else if ($lowerNext === 'void') {
            // Void.
            $this->correctToken($lowerNext);
            $this->parseToken('void');
            $type = 'void';
        } else if ($lowerNext === 'self') {
            // Self.
            $this->correctToken($lowerNext);
            $this->parseToken('self');
            if ($this->scope->className !== null) {
                $type = $this->scope->className;
            } else {
                $type = 'self';
            }
        } else if ($lowerNext === 'parent') {
            // Parent.
            $this->phpFig = false;
            $this->correctToken($lowerNext);
            $this->parseToken('parent');
            if ($this->scope->parentName !== null) {
                $type = $this->scope->parentName;
            } else {
                $type = 'parent';
            }
        } else if (in_array($lowerNext, ['static', '$this']) === true) {
            // Static.
            $this->correctToken($lowerNext);
            $this->parseToken();
            if ($this->scope->className !== null) {
                $type = "static({$this->scope->className})";
            } else {
                $type = 'static';
            }
        } else if ($lowerNext === 'callable'
            || $next === '\\Closure' || ($next === 'Closure' && $this->scope->namespace === '')
        ) {
            // Callable.
            if ($lowerNext === 'callable') {
                $this->correctToken($lowerNext);
            }

            $callableType = $this->parseToken();
            if ($this->next === '(') {
                $this->phpFig = false;
                $this->parseToken('(');
                while ($this->next !== ')') {
                    $this->parseAnyType();
                    if ($this->next === '&') {
                        $this->parseToken('&');
                    }

                    if ($this->next === '...') {
                        $this->parseToken('...');
                    }

                    if ($this->next === '=') {
                        $this->parseToken('=');
                    }

                    if ($this->next !== null) {
                        $nextChar = $this->next[0];
                    } else {
                        $nextChar = null;
                    }

                    if ($nextChar === '$') {
                        $this->parseToken();
                    }

                    if ($this->next !== ')') {
                        $this->parseToken(',');
                    }
                }//end while

                $this->parseToken(')');
                $this->parseToken(':');
                if ($this->next === '?') {
                    $this->parseAnyType();
                } else {
                    $this->parseSingleType();
                }
            }//end if

            if (strtolower($callableType) === 'callable') {
                $type = 'callable';
            } else {
                $type = '\\Closure';
            }
        } else if ($lowerNext === 'mixed') {
            // Mixed.
            $this->correctToken($lowerNext);
            $this->parseToken('mixed');
            $type = 'mixed';
        } else if ($lowerNext === 'iterable') {
            // Iterable (Traversable|array).
            $this->correctToken($lowerNext);
            $this->parseToken('iterable');
            if ($this->next === '<') {
                $this->phpFig = false;
                $this->parseToken('<');
                $firstType = $this->parseAnyType();
                if ($this->next === ',') {
                    $key = $firstType;
                    $this->parseToken(',');
                    $value = $this->parseAnyType();
                } else {
                    $key   = null;
                    $value = $firstType;
                }

                $this->parseToken('>');
            }

            $type = 'iterable';
        } else if ($lowerNext === 'array-key') {
            // Array-key (int|string).
            $this->phpFig = false;
            $this->correctToken($lowerNext);
            $this->parseToken('array-key');
            $type = 'array-key';
        } else if ($lowerNext === 'scalar') {
            // Scalar can be (bool|int|float|string).
            $this->phpFig = false;
            $this->correctToken($lowerNext);
            $this->parseToken('scalar');
            $type = 'scalar';
        } else if ($lowerNext === 'key-of') {
            // Key-of.
            $this->phpFig = false;
            $this->correctToken($lowerNext);
            $this->parseToken('key-of');
            $this->parseToken('<');
            $iterable = $this->parseAnyType();
            if ($this->compareTypes('iterable', $iterable) === false && $this->compareTypes('object', $iterable) === false) {
                throw new \Exception("Can't get key of non-iterable.");
            }

            $this->parseToken('>');
            $type = $this->unknown;
        } else if ($lowerNext === 'value-of') {
            // Value-of.
            $this->phpFig = false;
            $this->correctToken($lowerNext);
            $this->parseToken('value-of');
            $this->parseToken('<');
            $iterable = $this->parseAnyType();
            if ($this->compareTypes('iterable', $iterable) === false && $this->compareTypes('object', $iterable) === false) {
                throw new \Exception("Can't get value of non-iterable.");
            }

            $this->parseToken('>');
            $type = $this->unknown;
        } else if ((ctype_alpha($next[0]) === true || $next[0] === '_' || $next[0] === '\\')
            && strpos($next, '-') === false && strpos($next, '\\\\') === false
        ) {
            // Class name.
            $type = $this->parseToken();
            if (strrpos($type, '\\') === (strlen($type) - 1)) {
                throw new \Exception('Class name has trailing back slash.');
            }

            if ($type[0] !== '\\') {
                if (array_key_exists($type, $this->scope->uses) === true) {
                    $type = $this->scope->uses[$type];
                } else if (array_key_exists($type, $this->scope->templates) === true) {
                    $type = $this->scope->templates[$type];
                } else {
                    $type = $this->scope->namespace.'\\'.$type;
                }

                assert($type !== '');
            }
        } else {
            throw new \Exception("Expected type, saw \"{$this->next}\".");
        }//end if

        // Suffixes.  We can't embed these in the class name section, because they could apply to relative classes.
        if ($this->next === '<'
            && (in_array('object', $this->superTypes($type)) === true)
        ) {
            // Generics.
            $this->phpFig = false;
            $this->parseToken('<');
            $more = false;
            do {
                $this->parseAnyType();
                $more = ($this->next === ',');
                if ($more === true) {
                    $this->parseToken(',');
                }
            } while ($more === true);
            $this->parseToken('>');
        } else if ($this->next === '::'
            && (in_array('object', $this->superTypes($type)) === true)
        ) {
            // Class constant.
            $this->phpFig = false;
            $this->parseToken('::');
            if ($this->next === null) {
                $nextChar = null;
            } else {
                $nextChar = $this->next[0];
            }

            $haveConstantName = $nextChar !== null && (ctype_alpha($nextChar) || $nextChar === '_');
            if ($haveConstantName === true) {
                $this->parseToken();
            }

            if ($this->next === '*' || $haveConstantName === false) {
                $this->parseToken('*');
            }

            $type = $this->unknown;
        }//end if

        return $type;

    }//end parseBasicType()


}//end class
