# Changelog

The file documents changes to the PHP_CodeSniffer project for the 2.x series of releases.

## [2.9.2] - 2018-11-08

### Changed
- PHPCS should now run under PHP 7.3 without deprecation warnings
    - Thanks to [Nick Wilde][@NickDickinsonWilde] for the patch

### Fixed
- Fixed bug [#1496][sq-1496] : Squiz.Strings.DoubleQuoteUsage not unescaping dollar sign when fixing
    - Thanks to [Michał Bundyra][@michalbundyra] for the patch
- Fixed bug [#1549][sq-1549] : Squiz.PHP.EmbeddedPhp fixer conflict with // comment before PHP close tag
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Fixed bug [#1890][sq-1890] : Incorrect Squiz.WhiteSpace.ControlStructureSpacing.NoLineAfterClose error between catch and finally statements

## [2.9.1] - 2017-05-22

### Fixed
- Fixed bug [#1442][sq-1442] : T_NULLABLE detection not working for nullable parameters and return type hints in some cases
- Fixed bug [#1448][sq-1448] : Generic.Classes.OpeningBraceSameLine doesn't detect comment before opening brace
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch

[sq-1442]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1442
[sq-1448]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1448
[sq-1496]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1496
[sq-1549]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1549
[sq-1890]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1890

## [2.9.0] - 2017-05-04

### Changed
- Added Generic.Debug.ESLint sniff to run ESLint over JS files and report errors
    - Set eslint path using: phpcs --config-set eslint_path /path/to/eslint
    - Thanks to [Ryan McCue][@rmccue] for the contribution
- T_POW is now properly considered an arithmetic operator, and will be checked as such
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- T_SPACESHIP and T_COALESCE are now properly considered comparison operators, and will be checked as such
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Generic.PHP.DisallowShortOpenTag now warns about possible short open tags even when short_open_tag is set to OFF
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Generic.WhiteSpace.DisallowTabIndent now finds and fixes improper use of spaces anywhere inside the line indent
    - Previously, only the first part of the indent was used to determine the indent type
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- PEAR.Commenting.ClassComment now supports checking of traits as well as classes and interfaces
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Squiz.Commenting.FunctionCommentThrowTag now supports re-throwing exceptions (request [#946][sq-946])
    - Thanks to [Samuel Levy][@samlev] for the patch
- Squiz.PHP.DisallowMultipleAssignments now ignores PHP4-style member var assignments
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Squiz.WhiteSpace.FunctionSpacing now ignores spacing above functions when they are preceded by inline comments
    - Stops conflicts between this sniff and comment spacing sniffs
- Squiz.WhiteSpace.OperatorSpacing no longer checks the equal sign in declare statements
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Added missing error codes for a couple of sniffs so they can now be customised as normal

### Fixed
- Fixed bug [#1266][sq-1266] : PEAR.WhiteSpace.ScopeClosingBrace can throw an error while fixing mixed PHP/HTML
- Fixed bug [#1364][sq-1364] : Yield From values are not recognised as returned values in Squiz FunctionComment sniff
- Fixed bug [#1373][sq-1373] : Error in tab expansion results in white-space of incorrect size
    - Thanks to [Mark Clements][@MarkMaldaba] for the patch
- Fixed bug [#1381][sq-1381] : Tokenizer: dereferencing incorrectly identified as short array
- Fixed bug [#1387][sq-1387] : Squiz.ControlStructures.ControlSignature does not handle alt syntax when checking space after closing brace
- Fixed bug [#1392][sq-1392] : Scope indent calculated incorrectly when using array destructuring
- Fixed bug [#1394][sq-1394] : integer type hints appearing as TypeHintMissing instead of ScalarTypeHintMissing
    - PHP 7 type hints were also being shown when run under PHP 5 in some cases
- Fixed bug [#1405][sq-1405] : Squiz.WhiteSpace.ScopeClosingBrace fails to fix closing brace within indented PHP tags
- Fixed bug [#1421][sq-1421] : Ternaries used in constant scalar expression for param default misidentified by tokenizer
- Fixed bug [#1431][sq-1431] : PHPCBF can't fix short open tags when they are not followed by a space
    - Thanks to [Gonçalo Queirós][@ghunti] for the patch
- Fixed bug [#1432][sq-1432] : PHPCBF can make invalid fixes to inline JS control structures that make use of JS objects

[sq-946]: https://github.com/squizlabs/PHP_CodeSniffer/pull/946
[sq-1266]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1266
[sq-1364]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1364
[sq-1373]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1373
[sq-1381]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1381
[sq-1387]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1387
[sq-1392]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1392
[sq-1394]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1394
[sq-1405]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1405
[sq-1421]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1421
[sq-1431]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1431
[sq-1432]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1432

## [2.8.1] - 2017-03-02

### Security
- This release contains a fix for a security advisory related to the improper handling of shell commands
    - Uses of shell_exec() and exec() were not escaping filenames and configuration settings in most cases
    - A properly crafted filename or configuration option would allow for arbitrary code execution when using some features
    - All users are encouraged to upgrade to this version, especially if you are checking 3rd-party code
          - e.g., you run PHPCS over libraries that you did not write
          - e.g., you provide a web service that runs PHPCS over user-uploaded files or 3rd-party repositories
          - e.g., you allow external tool paths to be set by user-defined values
    - If you are unable to upgrade but you check 3rd-party code, ensure you are not using the following features:
          - The diff report
          - The notify-send report
          - The Generic.PHP.Syntax sniff
          - The Generic.Debug.CSSLint sniff
          - The Generic.Debug.ClosureLinter sniff
          - The Generic.Debug.JSHint sniff
          - The Squiz.Debug.JSLint sniff
          - The Squiz.Debug.JavaScriptLint sniff
          - The Zend.Debug.CodeAnalyzer sniff
    - Thanks to [Klaus Purer][@klausi] for the report

### Changed
- The PHP-supplied T_COALESCE_EQUAL token has been replicated for PHP versions before 7.2
- PEAR.Functions.FunctionDeclaration now reports an error for blank lines found inside a function declaration
- PEAR.Functions.FunctionDeclaration no longer reports indent errors for blank lines in a function declaration
- Squiz.Functions.MultiLineFunctionDeclaration no longer reports errors for blank lines in a function declaration
    - It would previously report that only one argument is allowed per line
- Squiz.Commenting.FunctionComment now corrects multi-line param comment padding more accurately
- Squiz.Commenting.FunctionComment now properly fixes pipe-separated param types
- Squiz.Commenting.FunctionComment now works correctly when function return types also contain a comment
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Squiz.ControlStructures.InlineIfDeclaration now supports the elvis operator
    - As this is not a real PHP operator, it enforces no spaces between ? and : when the THEN statement is empty
- Squiz.ControlStructures.InlineIfDeclaration is now able to fix the spacing errors it reports

### Fixed
- Fixed bug [#1340][sq-1340] : STDIN file contents not being populated in some cases
    - Thanks to [David Biňovec][@david-binda] for the patch
- Fixed bug [#1344][sq-1344] : PEAR.Functions.FunctionCallSignatureSniff throws error for blank comment lines
- Fixed bug [#1347][sq-1347] : PSR2.Methods.FunctionCallSignature strips some comments during fixing
    - Thanks to [Algirdas Gurevicius][@uniquexor] for the patch
- Fixed bug [#1349][sq-1349] : Squiz.Strings.DoubleQuoteUsage.NotRequired message is badly formatted when string contains a CR newline char
    - Thanks to [Algirdas Gurevicius][@uniquexor] for the patch
- Fixed bug [#1350][sq-1350] : Invalid Squiz.Formatting.OperatorBracket error when using namespaces
- Fixed bug [#1369][sq-1369] : Empty line in multi-line function declaration cause infinite loop

[sq-1340]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1340
[sq-1344]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1344
[sq-1347]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1347
[sq-1349]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1349
[sq-1350]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1350
[sq-1369]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1369

## [2.8.0] - 2017-02-02

### Changed
- The Internal.NoCodeFound error is no longer generated for content sourced from STDIN
    - This should stop some Git hooks generating errors because PHPCS is trying to process the refs passed on STDIN
- Squiz.Commenting.DocCommentAlignment now checks comments on class properties defined using the VAR keyword
    - Thanks to [Klaus Purer][@klausi] for the patch
- The getMethodParameters() method now recognises "self" as a valid type hint
    - The return array now contains a new "content" index containing the raw content of the param definition
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- The getMethodParameters() method now supports nullable types
    - The return array now contains a new "nullable_type" index set to true or false for each method param
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- The getMethodParameters() method now supports closures
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Added more guard code for JS files with syntax errors (request [#1271][sq-1271] and request [#1272][sq-1272])
- Added more guard code for CSS files with syntax errors (request [#1304][sq-1304])
- PEAR.Commenting.FunctionComment fixers now correctly handle multi-line param comments
- AbstractVariableSniff now supports anonymous classes
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Generic.NamingConventions.ConstructorName and PEAR.NamingConventions.ValidVariable now support anonymous classes
- Generic.NamingConventions.CamelCapsFunctionName and PEAR.NamingConventions.ValidFunctionName now support anonymous classes
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Generic.CodeAnalysis.UnusedFunctionParameter and PEAR.Functions.ValidDefaultValue now support closures
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- PEAR.NamingConventions.ValidClassName and Squiz.Classes.ValidClassName now support traits
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Generic.Functions.FunctionCallArgumentSpacing now supports closures other PHP-provided functions
    - Thanks to [Algirdas Gurevicius][@uniquexor] for the patch
- Fixed an error where a nullable type character was detected as an inline then token
    - A new T_NULLABLE token has been added to represent the ? nullable type character
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Squiz.WhiteSpace.SemicolonSpacing no longer removes comments while fixing the placement of semicolons
    - Thanks to [Algirdas Gurevicius][@uniquexor] for the patch

### Fixed
- Fixed bug [#1230][sq-1230] : JS tokeniser incorrectly tokenises bitwise shifts as comparison
    - Thanks to [Ryan McCue][@rmccue] for the patch
- Fixed bug [#1237][sq-1237] : Uninitialized string offset in PHP Tokenizer on PHP 5.2
- Fixed bug [#1239][sq-1239] : Warning when static method name is 'default'
- Fixed bug [#1240][sq-1240] : False positive for function names starting with triple underscore
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Fixed bug [#1245][sq-1245] : SELF is not recognised as T_SELF token in: return new self
- Fixed bug [#1246][sq-1246] : A mix of USE statements with and without braces can cause the tokenizer to mismatch brace tokens
    - Thanks to [Michał Bundyra][@michalbundyra] for the patch
- Fixed bug [#1249][sq-1249] : GitBlame report requires a .git directory
- Fixed bug [#1252][sq-1252] : Squiz.Strings.ConcatenationSpacing fix creates syntax error when joining a number to a string
- Fixed bug [#1253][sq-1253] : Generic.ControlStructures.InlineControlStructure fix creates syntax error fixing if-try/catch
- Fixed bug [#1255][sq-1255] : Inconsistent indentation check results when ELSE on new line
- Fixed bug [#1257][sq-1257] : Double dash in CSS class name can lead to "Named colours are forbidden" false positives
- Fixed bug [#1260][sq-1260] : Syntax errors not being shown when error_prepend_string is set
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Fixed bug [#1264][sq-1264] : Array return type hint is sometimes detected as T_ARRAY_HINT instead of T_RETURN_TYPE
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Fixed bug [#1265][sq-1265] : ES6 arrow function raises unexpected operator spacing errors
- Fixed bug [#1267][sq-1267] : Fixer incorrectly handles filepaths with repeated dir names
    - Thanks to [Sergey Ovchinnikov][@orx0r] for the patch
- Fixed bug [#1276][sq-1276] : Commenting.FunctionComment.InvalidReturnVoid conditional issue with anonymous classes
- Fixed bug [#1277][sq-1277] : Squiz.PHP.DisallowMultipleAssignments.Found error when var assignment is on the same line as an open tag
- Fixed bug [#1284][sq-1284] : Squiz.Arrays.ArrayBracketSpacing.SpaceBeforeBracket false positive match for short list syntax

[sq-1230]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1230
[sq-1237]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1237
[sq-1239]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1239
[sq-1240]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1240
[sq-1245]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1245
[sq-1246]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1246
[sq-1249]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1249
[sq-1252]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1252
[sq-1253]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1253
[sq-1255]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1255
[sq-1257]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1257
[sq-1260]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1260
[sq-1264]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1264
[sq-1265]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1265
[sq-1267]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1267
[sq-1271]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1271
[sq-1272]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1272
[sq-1276]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1276
[sq-1277]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1277
[sq-1284]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1284
[sq-1304]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1304

## [2.7.1] - 2016-11-30

### Changed
- Squiz.ControlStructures.ControlSignature.SpaceAfterCloseParenthesis fix now removes unnecessary whitespace
- Squiz.Formatting.OperatorBracket no longer errors for negative array indexes used within a function call
- Squiz.PHP.EmbeddedPhp no longer expects a semicolon after statements that are only opening a scope
- Fixed a problem where the content of T_DOC_COMMENT_CLOSE_TAG tokens could sometimes be (boolean) false
- Developers of custom standards with custom test runners can now have their standards ignored by the built-in test runner
    - Set the value of an environment variable called PHPCS_IGNORE_TESTS with a comma separated list of your standard names
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- The unit test runner now loads the test sniff outside of the standard's ruleset so that exclude rules do not get applied
    - This may have caused problems when testing custom sniffs inside custom standards
    - Also makes the unit tests runs a little faster
- The SVN pre-commit hook now works correctly when installed via composer
    - Thanks to [Sergey][@sserbin] for the patch

### Fixed
- Fixed bug [#1135][sq-1135] : PEAR.ControlStructures.MultiLineCondition.CloseBracketNewLine not detected if preceded by multiline function call
- Fixed bug [#1138][sq-1138] : PEAR.ControlStructures.MultiLineCondition.Alignment not detected if closing brace is first token on line
- Fixed bug [#1141][sq-1141] : Sniffs that check EOF newlines don't detect newlines properly when the last token is a doc block
- Fixed bug [#1150][sq-1150] : Squiz.Strings.EchoedStrings does not properly fix bracketed statements
- Fixed bug [#1156][sq-1156] : Generic.Formatting.DisallowMultipleStatements errors when multiple short echo tags are used on the same line
    - Thanks to [Nikola Kovacs][@nkovacs] for the patch
- Fixed bug [#1161][sq-1161] : Absolute report path is treated like a relative path if it also exists within the current directory
- Fixed bug [#1170][sq-1170] : Javascript regular expression literal not recognized after comparison operator
- Fixed bug [#1180][sq-1180] : Class constant named FUNCTION is incorrectly tokenized
- Fixed bug [#1181][sq-1181] : Squiz.Operators.IncrementDecrementUsage.NoBrackets false positive when incrementing properties
    - Thanks to [Jürgen Henge-Ernst][@hernst42] for the patch
- Fixed bug [#1188][sq-1188] : Generic.WhiteSpace.ScopeIndent issues with inline HTML and multi-line function signatures
- Fixed bug [#1190][sq-1190] : phpcbf on if/else with trailing comment generates erroneous code
- Fixed bug [#1191][sq-1191] : Javascript sniffer fails with function called "Function"
- Fixed bug [#1203][sq-1203] : Inconsistent behavior of PHP_CodeSniffer_File::findEndOfStatement
- Fixed bug [#1218][sq-1218] : CASE conditions using class constants named NAMESPACE/INTERFACE/TRAIT etc are incorrectly tokenized
- Fixed bug [#1221][sq-1221] : Indented function call with multiple closure arguments can cause scope indent error
- Fixed bug [#1224][sq-1224] : PHPCBF fails to fix code with heredoc/nowdoc as first argument to a function

[sq-1135]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1135
[sq-1138]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1138
[sq-1141]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1141
[sq-1150]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1150
[sq-1156]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1156
[sq-1161]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1161
[sq-1170]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1170
[sq-1180]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1180
[sq-1181]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1181
[sq-1188]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1188
[sq-1190]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1190
[sq-1191]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1191
[sq-1203]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1203
[sq-1218]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1218
[sq-1221]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1221
[sq-1224]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1224

## [2.7.0] - 2016-09-02

### Changed
- Added --file-list command line argument to allow a list of files and directories to be specified in an external file
    - Useful if you have a generated list of files to check that would be too long for the command line
    - File and directory paths are listed one per line
    - Usage is: phpcs --file-list=/path/to/file-list ...
    - Thanks to [Blotzu][@andrei-propertyguru] for the patch
- Values set using @codingStandardsChangeSetting comments can now contain spaces
- Sniff unit tests can now specify a list of test files instead of letting the runner pick them (request [#1078][sq-1078])
    - Useful if a sniff needs to exclude files based on the environment, or is checking filenames
    - Override the new getTestFiles() method to specify your own list of test files
- Generic.Functions.OpeningFunctionBraceKernighanRitchie now ignores spacing for function return types
    - The sniff code Generic.Functions.OpeningFunctionBraceKernighanRitchie.SpaceAfterBracket has been removed
    - Replaced by Generic.Functions.OpeningFunctionBraceKernighanRitchie.SpaceBeforeBrace
    - The new error message is slightly clearer as it indicates that a single space is needed before the brace
- Squiz.Commenting.LongConditionClosingComment now allows for the length of a code block to be configured
    - Set the lineLimit property (default is 20) in your ruleset.xml file to set the code block length
    - When the code block length is reached, the sniff will enforce a closing comment after the closing brace
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Squiz.Commenting.LongConditionClosingComment now allows for the end comment format to be configured
    - Set the commentFormat property (default is "//end %s") in your ruleset.xml file to set the format
    - The placeholder %s will be replaced with the type of condition opener, e.g., "//end foreach"
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Generic.PHPForbiddenFunctions now allows forbidden functions to have mixed case
    - Previously, it would only do a strtolower comparison
    - Error message now shows what case was found in the code and what the correct case should be
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Added Generic.Classes.OpeningBraceSameLine to ensure opening brace of class/interface/trait is on the same line as the declaration
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Added Generic.PHP.BacktickOperator to ban the use of the backtick operator for running shell commands
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Added Generic.PHP.DisallowAlternativePHPTags to ban the use of alternate PHP tags
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Squiz.WhiteSpace.LanguageConstructSpacing no longer checks for spaces if parenthesis are being used (request [#1062][sq-1062])
    - Makes this sniff more compatible with those that check parenthesis spacing of function calls
- Squiz.WhiteSpace.ObjectOperatorSpacing now has a setting to ignore newline characters around object operators
    - Default remains FALSE, so newlines are not allowed
    - Override the "ignoreNewlines" setting in a ruleset.xml file to change
    - Thanks to [Alex Howansky][@AlexHowansky] for the patch
- Squiz.Scope.MethodScope now sniffs traits as well as classes and interfaces
    - Thanks to [Jesse Donat][@donatj] for the patch
- PHPCBF is now able to fix Squiz.SelfMemberReference.IncorrectCase errors
    - Thanks to [Nikola Kovacs][@nkovacs] for the patch
- PHPCBF is now able to fix Squiz.Commenting.VariableComment.IncorrectVarType
    - Thanks to [Walt Sorensen][@photodude] for the patch
- PHPCBF is now able to fix Generic.PHP.DisallowShortOpenTag
    - Thanks to [Juliette Reinders Folmer][@jrfnl] for the patch
- Improved the formatting of the end brace when auto fixing InlineControlStructure errors (request [#1121][sq-1121])
- Generic.Functions.OpeningFunctionBraceKernighanRitchie.BraceOnNewLine fix no longer leaves blank line after brace (request [#1085][sq-1085])
- Generic UpperCaseConstantNameSniff now allows lowercase namespaces in constant definitions
    - Thanks to [Daniel Schniepp][@dschniepp] for the patch
- Squiz DoubleQuoteUsageSniff is now more tolerant of syntax errors caused by mismatched string tokens
- A few sniffs that produce errors based on the current PHP version can now be told to run using a specific PHP version
    - Set the `php_version` config var using `--config-set`, `--runtime-set`, or in a ruleset to specify a specific PHP version
    - The format of the PHP version is the same as the `PHP_VERSION_ID` constant (e.g., 50403 for version 5.4.3)
    - Supported sniffs are Generic.PHP.DisallowAlternativePHPTags, PSR1.Classes.ClassDeclaration, Squiz.Commenting.FunctionComment
    - Thanks to [Finlay Beaton][@ofbeaton] for the patch

### Fixed
- Fixed bug [#985][sq-985] : Duplicate class definition detection generates false-positives in media queries
    - Thanks to [Raphael Horber][@rhorber] for the patch
- Fixed bug [#1014][sq-1014] : Squiz VariableCommentSniff doesn't always detect a missing comment
- Fixed bug [#1066][sq-1066] : Undefined index: quiet in `CLI.php` during unit test run with `-v` command line arg
- Fixed bug [#1072][sq-1072] : Squiz.SelfMemberReference.NotUsed not detected if leading namespace separator is used
- Fixed bug [#1089][sq-1089] : Rulesets cannot be loaded if the path contains urlencoded characters
- Fixed bug [#1091][sq-1091] : PEAR and Squiz FunctionComment sniffs throw errors for some invalid @param line formats
- Fixed bug [#1092][sq-1092] : PEAR.Functions.ValidDefaultValue should not flag type hinted methods with a NULL default argument
- Fixed bug [#1095][sq-1095] : Generic LineEndings sniff replaces tabs with spaces with --tab-width is set
- Fixed bug [#1096][sq-1096] : Squiz FunctionDeclarationArgumentSpacing gives incorrect error/fix when variadic operator is followed by a space
- Fixed bug [#1099][sq-1099] : Group use declarations are incorrectly fixed by the PSR2 standard
    - Thanks to [Jason McCreary][@jasonmccreary] for the patch
- Fixed bug [#1101][sq-1101] : Incorrect indent errors when breaking out of PHP inside an IF statement
- Fixed bug [#1102][sq-1102] : Squiz.Formatting.OperatorBracket.MissingBrackets faulty bracketing fix
- Fixed bug [#1109][sq-1109] : Wrong scope indent reported in anonymous class
- Fixed bug [#1112][sq-1112] : File docblock not recognized when require_once follows it
- Fixed bug [#1120][sq-1120] : InlineControlStructureSniff does not handle auto-fixing for control structures that make function calls
- Fixed bug [#1124][sq-1124] : Squiz.Operators.ComparisonOperatorUsage does not detect bracketed conditions for inline IF statements
    - Thanks to [Raphael Horber][@rhorber] for the patch

[sq-985]: https://github.com/squizlabs/PHP_CodeSniffer/issues/985
[sq-1014]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1014
[sq-1062]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1062
[sq-1066]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1066
[sq-1072]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1072
[sq-1078]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1078
[sq-1085]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1085
[sq-1089]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1089
[sq-1091]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1091
[sq-1092]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1092
[sq-1095]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1095
[sq-1096]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1096
[sq-1099]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1099
[sq-1101]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1101
[sq-1102]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1102
[sq-1109]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1109
[sq-1112]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1112
[sq-1120]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1120
[sq-1121]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1121
[sq-1124]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1124

## [2.6.2] - 2016-07-14

### Changed
- Added a new --exclude CLI argument to exclude a list of sniffs from checking and fixing (request [#904][sq-904])
    - Accepts the same sniff codes as the --sniffs command line argument, but provides the opposite functionality
- Added a new -q command line argument to disable progress and verbose information from being printed (request [#969][sq-969])
    - Useful if a coding standard hard-codes progress or verbose output but you want PHPCS to be quiet
    - Use the command "phpcs --config-set quiet true" to turn quiet mode on by default
- Generic LineLength sniff no longer errors for comments that cannot be broken out onto a new line (request [#766][sq-766])
    - A typical case is a comment that contains a very long URL
    - The comment is ignored if putting the URL on an indented new comment line would be longer than the allowed length
- Settings extensions in a ruleset no longer causes PHP notices during unit testing
    - Thanks to [Klaus Purer][@klausi] for the patch
- Version control reports now show which errors are fixable if you are showing sources
- Added a new sniff to enforce a single space after a NOT operator (request [#1051][sq-1051])
    - Include in a ruleset using the code Generic.Formatting.SpaceAfterNot
- The Squiz.Commenting.BlockComment sniff now supports tabs for indenting comment lines (request [#1056][sq-1056])

### Fixed
- Fixed bug [#790][sq-790] : Incorrect missing @throws error in methods that use closures
- Fixed bug [#908][sq-908] : PSR2 standard is not checking that closing brace is on line following the body
- Fixed bug [#945][sq-945] : Incorrect indent behavior using deep-nested function and arrays
- Fixed bug [#961][sq-961] : Two anonymous functions passed as function/method arguments cause indentation false positive
- Fixed bug [#1005][sq-1005] : Using global composer vendor autoload breaks PHP lowercase built-in function sniff
    - Thanks to [Michael Butler][@michaelbutler] for the patch
- Fixed bug [#1007][sq-1007] : Squiz Unreachable code detection is not working properly with a closure inside a case
- Fixed bug [#1023][sq-1023] : PSR2.Classes.ClassDeclaration fails if class extends base class and "implements" is on trailing line
- Fixed bug [#1026][sq-1026] : Arrays in comma delimited class properties cause ScopeIndent to increase indent
- Fixed bug [#1028][sq-1028] : Squiz ArrayDeclaration incorrectly fixes multi-line array where end bracket is not on a new line
- Fixed bug [#1034][sq-1034] : Squiz FunctionDeclarationArgumentSpacing gives incorrect error when first arg is a variadic
- Fixed bug [#1036][sq-1036] : Adjacent assignments aligned analysis statement wrong
- Fixed bug [#1049][sq-1049] : Version control reports can show notices when the report width is very small
- Fixed bug [#21050][pear-21050] : PEAR MultiLineCondition sniff suppresses errors on last condition line

[sq-766]: https://github.com/squizlabs/PHP_CodeSniffer/issues/766
[sq-790]: https://github.com/squizlabs/PHP_CodeSniffer/issues/790
[sq-904]: https://github.com/squizlabs/PHP_CodeSniffer/issues/904
[sq-908]: https://github.com/squizlabs/PHP_CodeSniffer/issues/908
[sq-945]: https://github.com/squizlabs/PHP_CodeSniffer/issues/945
[sq-961]: https://github.com/squizlabs/PHP_CodeSniffer/issues/961
[sq-969]: https://github.com/squizlabs/PHP_CodeSniffer/issues/969
[sq-1005]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1005
[sq-1007]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1007
[sq-1023]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1023
[sq-1026]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1026
[sq-1028]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1028
[sq-1034]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1034
[sq-1036]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1036
[sq-1049]: https://github.com/squizlabs/PHP_CodeSniffer/pull/1049
[sq-1051]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1051
[sq-1056]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1056
[pear-21050]: https://pear.php.net/bugs/bug.php?id=21050

## [2.6.1] - 2016-05-31

### Changed
- The PHP-supplied T_COALESCE token has been replicated for PHP versions before 7.0
- Function return types of self, parent and callable are now tokenized as T_RETURN_TYPE
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- The default_standard config setting now allows multiple standards to be listed, like on the command line
    - Thanks to [Michael Mayer][@schnittstabil] for the patch
- Installations done via composer now only include the composer autoloader for PHP 5.3.2+ (request [#942][sq-942])
- Added a rollbackChangeset() method to the Fixer class to purposely rollback the active changeset

### Fixed
- Fixed bug [#940][sq-940] : Auto-fixing issue encountered with inconsistent use of braces
- Fixed bug [#943][sq-943] : Squiz.PHP.InnerFunctions.NotAllowed reported in anonymous classes
- Fixed bug [#944][sq-944] : PHP warning when running the latest phar
- Fixed bug [#951][sq-951] : InlineIfDeclaration: invalid error produced with UTF-8 string
- Fixed bug [#957][sq-957] : Operator spacing sniff errors when plus is used as part of a number
    - Thanks to [Klaus Purer][@klausi] for the patch
- Fixed bug [#959][sq-959] : Call-time pass-by-reference false positive if there is a square bracket before the ampersand
    - Thanks to [Konstantin Leboev][@realmfoo] for the patch
- Fixed bug [#962][sq-962] : Null coalescing operator (??) not detected as a token
    - Thanks to [Joel Posti][@joelposti] for the patch
- Fixed bug [#973][sq-973] : Anonymous class declaration and PSR1.Files.SideEffects.FoundWithSymbols
- Fixed bug [#974][sq-974] : Error when file ends with "function"
- Fixed bug [#979][sq-979] : Anonymous function with return type hint is not refactored as expected
- Fixed bug [#983][sq-983] : Squiz.WhiteSpace.MemberVarSpacing.AfterComment fails to fix error when comment is not a docblock
- Fixed bug [#1010][sq-1010] : Squiz NonExecutableCode sniff does not detect boolean OR
    - Thanks to [Derek Henderson][@2shediac] for the patch
- Fixed bug [#1015][sq-1015] : The Squiz.Commenting.FunctionComment sniff doesn't allow description in @return tag
    - Thanks to [Alexander Obuhovich][@aik099] for the patch
- Fixed bug [#1022][sq-1022] : Duplicate spaces after opening bracket error with PSR2 standard
- Fixed bug [#1025][sq-1025] : Syntax error in JS file can cause undefined index for parenthesis_closer

[sq-940]: https://github.com/squizlabs/PHP_CodeSniffer/issues/940
[sq-942]: https://github.com/squizlabs/PHP_CodeSniffer/issues/942
[sq-943]: https://github.com/squizlabs/PHP_CodeSniffer/issues/943
[sq-944]: https://github.com/squizlabs/PHP_CodeSniffer/issues/944
[sq-951]: https://github.com/squizlabs/PHP_CodeSniffer/issues/951
[sq-957]: https://github.com/squizlabs/PHP_CodeSniffer/pull/957
[sq-959]: https://github.com/squizlabs/PHP_CodeSniffer/issues/959
[sq-962]: https://github.com/squizlabs/PHP_CodeSniffer/issues/962
[sq-973]: https://github.com/squizlabs/PHP_CodeSniffer/issues/973
[sq-974]: https://github.com/squizlabs/PHP_CodeSniffer/issues/974
[sq-979]: https://github.com/squizlabs/PHP_CodeSniffer/issues/979
[sq-983]: https://github.com/squizlabs/PHP_CodeSniffer/issues/983
[sq-1010]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1010
[sq-1015]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1015
[sq-1022]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1022
[sq-1025]: https://github.com/squizlabs/PHP_CodeSniffer/issues/1025

## [2.6.0] - 2016-04-04

### Changed
- Paths used when setting CLI arguments inside ruleset.xml files are now relative to the ruleset location (request [#847][sq-847])
    - This change only applies to paths within ARG tags, used to set CLI arguments
    - Previously, the paths were relative to the directory PHPCS was being run from
    - Absolute paths are still allowed and work the same way they always have
    - This change allows ruleset.xml files to be more portable
- Content passed via STDIN will now be processed even if files are specified on the command line or in a ruleset
- When passing content via STDIN, you can now specify the file path to use on the command line (request [#934][sq-934])
    - This allows sniffs that check file paths to work correctly
    - This is the same functionality provided by the phpcs_input_file line, except it is available on the command line
- Files processed with custom tokenizers will no longer be skipped if they appear minified (request [#877][sq-877])
    - If the custom tokenizer wants minified files skipped, it can set a $skipMinified member var to TRUE
    - See the included JS and CSS tokenizers for an example
- Config vars set in ruleset.xml files are now processed earlier, allowing them to be used during sniff registration
    - Among other things, this allows the installed_paths config var to be set in ruleset.xml files
    - Thanks to [Pieter Frenssen][@pfrenssen] for the patch
- Improved detection of regular expressions in the JS tokenizer
- Generic PHP Syntax sniff now uses PHP_BINARY (if available) to determine the path to PHP if no other path is available
    - You can still manually set `php_path` to use a specific binary for testing
    - Thanks to [Andrew Berry][@deviantintegral] for the patch
- The PHP-supplied T_POW_EQUAL token has been replicated for PHP versions before 5.6
- Added support for PHP7 use group declarations (request [#878][sq-878])
    - New tokens T_OPEN_USE_GROUP and T_CLOSE_USE_GROUP are assigned to the open and close curly braces
- Generic ScopeIndent sniff now reports errors for every line that needs the indent changed (request [#903][sq-903])
    - Previously, it ignored lines that were indented correctly in the context of their block
    - This change produces more technically accurate error messages, but is much more verbose
- The PSR2 and Squiz standards now allow multi-line default values in function declarations (request [#542][sq-542])
    - Previously, these would automatically make the function a multi-line declaration
- Squiz InlineCommentSniff now allows docblocks on require(_once) and include(_once) statements
    - Thanks to [Gary Jones][@GaryJones] for the patch
- Squiz and PEAR Class and File sniffs no longer assume the first comment in a file is always a file comment
    - phpDocumentor assigns the comment to the file only if it is not followed by a structural element
    - These sniffs now follow this same rule
- Squiz ClassCommentSniff no longer checks for blank lines before class comments
    - Removes the error Squiz.Commenting.ClassComment.SpaceBefore
- Renamed Squiz.CSS.Opacity.SpacingAfterPoint to Squiz.CSS.Opacity.DecimalPrecision
    - Please update your ruleset if you are referencing this error code directly
- Fixed PHP tokenizer problem that caused an infinite loop when checking a comment with specific content
- Generic Disallow Space and Tab indent sniffs now detect and fix indents inside embedded HTML chunks (request [#882][sq-882])
- Squiz CSS IndentationSniff no longer assumes the class opening brace is at the end of a line
- Squiz FunctionCommentThrowTagSniff now ignores non-docblock comments
- Squiz ComparisonOperatorUsageSniff now allows conditions like while(true)
- PEAR FunctionCallSignatureSniff (and the Squiz and PSR2 sniffs that use it) now correctly check the first argument
    - Further fix for bug [#698][sq-698]

### Fixed
- Fixed bug [#791][sq-791] : codingStandardsChangeSetting settings not working with namespaces
- Fixed bug [#872][sq-872] : Incorrect detection of blank lines between CSS class names
- Fixed bug [#879][sq-879] : Generic InlineControlStructureSniff can create parse error when case/if/elseif/else have mixed brace and braceless definitions
- Fixed bug [#883][sq-883] : PSR2 is not checking for blank lines at the start and end of control structures
- Fixed bug [#884][sq-884] : Incorrect indentation notice for anonymous classes
- Fixed bug [#887][sq-887] : Using curly braces for a shared CASE/DEFAULT statement can generate an error in PSR2 SwitchDeclaration
- Fixed bug [#889][sq-889] : Closure inside catch/else/elseif causes indentation error
- Fixed bug [#890][sq-890] : Function call inside returned short array value can cause indentation error inside CASE statements
- Fixed bug [#897][sq-897] : Generic.Functions.CallTimePassByReference.NotAllowed false positive when short array syntax
- Fixed bug [#900][sq-900] : Squiz.Functions.FunctionDeclarationArgumentSpacing bug when no space between type hint and argument
- Fixed bug [#902][sq-902] : T_OR_EQUAL and T_POW_EQUAL are not seen as assignment tokens
- Fixed bug [#910][sq-910] : Unrecognized "extends" and indentation on anonymous classes
- Fixed bug [#915][sq-915] : JS Tokenizer generates errors when processing some decimals
- Fixed bug [#928][sq-928] : Endless loop when sniffing a PHP file with a git merge conflict inside a function
- Fixed bug [#937][sq-937] : Shebang can cause PSR1 SideEffects warning
    - Thanks to [Clay Loveless][@claylo] for the patch
- Fixed bug [#938][sq-938] : CallTimePassByReferenceSniff ignores functions with return value

[sq-542]: https://github.com/squizlabs/PHP_CodeSniffer/issues/542
[sq-791]: https://github.com/squizlabs/PHP_CodeSniffer/issues/791
[sq-847]: https://github.com/squizlabs/PHP_CodeSniffer/issues/847
[sq-872]: https://github.com/squizlabs/PHP_CodeSniffer/issues/872
[sq-877]: https://github.com/squizlabs/PHP_CodeSniffer/issues/877
[sq-878]: https://github.com/squizlabs/PHP_CodeSniffer/issues/878
[sq-879]: https://github.com/squizlabs/PHP_CodeSniffer/issues/879
[sq-882]: https://github.com/squizlabs/PHP_CodeSniffer/issues/882
[sq-883]: https://github.com/squizlabs/PHP_CodeSniffer/issues/883
[sq-884]: https://github.com/squizlabs/PHP_CodeSniffer/issues/884
[sq-887]: https://github.com/squizlabs/PHP_CodeSniffer/issues/887
[sq-889]: https://github.com/squizlabs/PHP_CodeSniffer/issues/889
[sq-890]: https://github.com/squizlabs/PHP_CodeSniffer/issues/890
[sq-897]: https://github.com/squizlabs/PHP_CodeSniffer/issues/897
[sq-900]: https://github.com/squizlabs/PHP_CodeSniffer/issues/900
[sq-902]: https://github.com/squizlabs/PHP_CodeSniffer/issues/902
[sq-903]: https://github.com/squizlabs/PHP_CodeSniffer/issues/903
[sq-910]: https://github.com/squizlabs/PHP_CodeSniffer/issues/910
[sq-915]: https://github.com/squizlabs/PHP_CodeSniffer/issues/915
[sq-928]: https://github.com/squizlabs/PHP_CodeSniffer/issues/928
[sq-934]: https://github.com/squizlabs/PHP_CodeSniffer/issues/934
[sq-937]: https://github.com/squizlabs/PHP_CodeSniffer/pull/937
[sq-938]: https://github.com/squizlabs/PHP_CodeSniffer/issues/938

## [2.5.1] - 2016-01-20

### Changed
- The PHP-supplied T_SPACESHIP token has been replicated for PHP versions before 7.0
- T_SPACESHIP is now correctly identified as an operator
    - Thanks to [Alexander Obuhovich][@aik099] for the patch
- Generic LowerCaseKeyword now ensures array type hints are lowercase as well
    - Thanks to [Mathieu Rochette][@mathroc] for the patch
- Squiz ComparisonOperatorUsageSniff no longer hangs on JS FOR loops that don't use semicolons
- PHP_CodesSniffer now includes the composer `autoload.php` file, if there is one
    - Thanks to [Klaus Purer][@klausi] for the patch
- Added error Squiz.Commenting.FunctionComment.ScalarTypeHintMissing for PHP7 only (request [#858][sq-858])
    - These errors were previously reported as Squiz.Commenting.FunctionComment.TypeHintMissing on PHP7
    - Disable this error message in a ruleset.xml file if your code needs to run on both PHP5 and PHP7
- The PHP 5.6 __debugInfo magic method no longer produces naming convention errors
    - Thanks to [Michael Nowack][@syranez] for the patch
- PEAR and Squiz FunctionComment sniffs now support variadic functions (request [#841][sq-841])

### Fixed
- Fixed bug [#622][sq-622] : Wrong detection of Squiz.CSS.DuplicateStyleDefinition with media queries
- Fixed bug [#752][sq-752] : The missing exception error is reported in first found DocBlock
- Fixed bug [#794][sq-794] : PSR2 MultiLineFunctionDeclaration forbids comments after opening parenthesis of a multiline call
- Fixed bug [#820][sq-820] : PEAR/PSR2 FunctionCallSignature sniffs suggest wrong indent when there are multiple arguments on a line
- Fixed bug [#822][sq-822] : Ruleset hard-coded file paths are not used if not running from the same directory as the ruleset
- Fixed bug [#825][sq-825] : FunctionCallArgumentSpacing sniff complains about more than one space before comment in multi-line function call
- Fixed bug [#828][sq-828] : Null classname is tokenized as T_NULL instead of T_STRING
- Fixed bug [#829][sq-829] : Short array argument not fixed correctly when multiple function arguments are on the same line
- Fixed bug [#831][sq-831] : PHPCS freezes in an infinite loop under Windows if no standard is passed
- Fixed bug [#832][sq-832] : Tokenizer does not support context sensitive parsing
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Fixed bug [#835][sq-835] : PEAR.Functions.FunctionCallSignature broken when closure uses return types
- Fixed bug [#838][sq-838] : CSS indentation fixer changes color codes
    - Thanks to [Klaus Purer][@klausi] for the patch
- Fixed bug [#839][sq-839] : "__()" method is marked as not camel caps
    - Thanks to [Tim Bezhashvyly][@tim-bezhashvyly] for the patch
- Fixed bug [#852][sq-852] : Generic.Commenting.DocComment not finding errors when long description is omitted
- Fixed bug [#854][sq-854] : Return typehints in interfaces are not reported as T_RETURN_TYPE
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Fixed bug [#855][sq-855] : Capital letter detection for multibyte strings doesn't work correctly
- Fixed bug [#857][sq-857] : PSR2.ControlStructure.SwitchDeclaration shouldn't check indent of curly brace closers
- Fixed bug [#859][sq-859] : Switch statement indention issue when returning function call with closure
- Fixed bug [#861][sq-861] : Single-line arrays and function calls can generate incorrect indentation errors
- Fixed bug [#867][sq-867] : Squiz.Strings.DoubleQuoteUsage broken for some escape codes
    - Thanks to [Jack Blower][@ElvenSpellmaker] for the help with the fix
- Fixed bug [#21005][pear-21005] : Incorrect indent detection when multiple properties are initialized to arrays
- Fixed bug [#21010][pear-21010] : Incorrect missing colon detection in CSS when first style is not on new line
- Fixed bug [#21011][pear-21011] : Incorrect error message text when newline found after opening brace

[sq-622]: https://github.com/squizlabs/PHP_CodeSniffer/issues/622
[sq-752]: https://github.com/squizlabs/PHP_CodeSniffer/issues/752
[sq-794]: https://github.com/squizlabs/PHP_CodeSniffer/issues/794
[sq-820]: https://github.com/squizlabs/PHP_CodeSniffer/issues/820
[sq-822]: https://github.com/squizlabs/PHP_CodeSniffer/issues/822
[sq-825]: https://github.com/squizlabs/PHP_CodeSniffer/issues/825
[sq-828]: https://github.com/squizlabs/PHP_CodeSniffer/issues/828
[sq-829]: https://github.com/squizlabs/PHP_CodeSniffer/issues/829
[sq-831]: https://github.com/squizlabs/PHP_CodeSniffer/issues/831
[sq-832]: https://github.com/squizlabs/PHP_CodeSniffer/issues/832
[sq-835]: https://github.com/squizlabs/PHP_CodeSniffer/issues/835
[sq-838]: https://github.com/squizlabs/PHP_CodeSniffer/pull/838
[sq-839]: https://github.com/squizlabs/PHP_CodeSniffer/issues/839
[sq-841]: https://github.com/squizlabs/PHP_CodeSniffer/issues/841
[sq-852]: https://github.com/squizlabs/PHP_CodeSniffer/issues/852
[sq-854]: https://github.com/squizlabs/PHP_CodeSniffer/issues/854
[sq-855]: https://github.com/squizlabs/PHP_CodeSniffer/pull/855
[sq-857]: https://github.com/squizlabs/PHP_CodeSniffer/issues/857
[sq-858]: https://github.com/squizlabs/PHP_CodeSniffer/issues/858
[sq-859]: https://github.com/squizlabs/PHP_CodeSniffer/issues/859
[sq-861]: https://github.com/squizlabs/PHP_CodeSniffer/issues/861
[sq-867]: https://github.com/squizlabs/PHP_CodeSniffer/issues/867
[pear-21005]: https://pear.php.net/bugs/bug.php?id=21005
[pear-21010]: https://pear.php.net/bugs/bug.php?id=21010
[pear-21011]: https://pear.php.net/bugs/bug.php?id=21011

## [2.5.0] - 2015-12-11

### Changed
- PHPCS will now look for a phpcs.xml file in parent directories as well as the current directory (request [#626][sq-626])
- PHPCS will now use a phpcs.xml file even if files are specified on the command line
    - This file is still only used if no standard is specified on the command line
- Added support for a phpcs.xml.dist file (request [#583][sq-583])
    - If both a phpcs.xml and phpcs.xml.dist file are present, the phpcs.xml file will be used
- Added support for setting PHP ini values in ruleset.xml files (request [#560][sq-560])
    - Setting the value of the new ini tags to name="memory_limit" value="32M" is the same as -d memory_limit=32M
- Added support for one or more bootstrap files to be run before processing begins
    - Use the --bootstrap=file,file,file command line argument to include bootstrap files
    - Useful if you want to override some of the high-level settings of PHPCS or PHPCBF
    - Thanks to [John Maguire][@johnmaguire] for the patch
- Added additional verbose output for CSS tokenizing
- Squiz ComparisonOperatorUsageSniff now checks FOR, WHILE and DO-WHILE statements
    - Thanks to [Arnout Boks][@aboks] for the patch

### Fixed
- Fixed bug [#660][sq-660] : Syntax checks can fail on Windows with PHP5.6
- Fixed bug [#784][sq-784] : $this->trait is seen as a T_TRAIT token
- Fixed bug [#786][sq-786] : Switch indent issue with short array notation
- Fixed bug [#787][sq-787] : SpacingAfterDefaultBreak confused by multi-line statements
- Fixed bug [#797][sq-797] : Parsing CSS url() value breaks further parsing
- Fixed bug [#805][sq-805] : Squiz.Commenting.FunctionComment.InvalidTypeHint on Scalar types on PHP7
- Fixed bug [#807][sq-807] : Cannot fix line endings when open PHP tag is not on the first line
- Fixed bug [#808][sq-808] : JS tokenizer incorrectly setting some function and class names to control structure tokens
- Fixed bug [#809][sq-809] : PHPCBF can break a require_once statement with a space before the open parenthesis
- Fixed bug [#813][sq-813] : PEAR FunctionCallSignature checks wrong indent when first token on line is part of a multi-line string

[sq-560]: https://github.com/squizlabs/PHP_CodeSniffer/issues/560
[sq-583]: https://github.com/squizlabs/PHP_CodeSniffer/issues/583
[sq-626]: https://github.com/squizlabs/PHP_CodeSniffer/issues/626
[sq-660]: https://github.com/squizlabs/PHP_CodeSniffer/pull/660
[sq-784]: https://github.com/squizlabs/PHP_CodeSniffer/issues/784
[sq-786]: https://github.com/squizlabs/PHP_CodeSniffer/issues/786
[sq-787]: https://github.com/squizlabs/PHP_CodeSniffer/issues/787
[sq-797]: https://github.com/squizlabs/PHP_CodeSniffer/issues/797
[sq-805]: https://github.com/squizlabs/PHP_CodeSniffer/issues/805
[sq-807]: https://github.com/squizlabs/PHP_CodeSniffer/issues/807
[sq-808]: https://github.com/squizlabs/PHP_CodeSniffer/issues/808
[sq-809]: https://github.com/squizlabs/PHP_CodeSniffer/issues/809
[sq-813]: https://github.com/squizlabs/PHP_CodeSniffer/issues/813

## [2.4.0] - 2015-11-24

### Changed
- Added support for PHP 7 anonymous classes
    - Anonymous classes are now tokenized as T_ANON_CLASS and ignored by normal class sniffs
- Added support for PHP 7 function return type declarations
    - Return types are now tokenized as T_RETURN_TYPE
- Fixed tokenizing of the XOR operator, which was incorrectly identified as a power operator (bug [#765][sq-765])
    - The T_POWER token has been removed and replaced by the T_BITWISE_XOR token
    - The PHP-supplied T_POW token has been replicated for PHP versions before 5.6
- Traits are now tokenized in PHP versions before 5.4 to make testing easier
- Improved regular expression detection in JS files
- PEAR FunctionCallSignatureSniff now properly detects indents in more mixed HTML/PHP code blocks
- Full report now properly indents lines when newlines are found inside error messages
- Generating documentation without specifying a standard now uses the default standard instead
    - Thanks to [Ken Guest][@kenguest] for the patch
- Generic InlineControlStructureSniff now supports braceless do/while loops in JS
    - Thanks to [Pieter Frenssen][@pfrenssen] for the patch
- Added more guard code for function declarations with syntax errors
    - Thanks to Yun Young-jin for the patch
- Added more guard code for foreach declarations with syntax errors
    - Thanks to [Johan de Ruijter][@johanderuijter] for the patch
- Added more guard code for class declarations with syntax errors
- Squiz ArrayDeclarationSniff now has guard code for arrays with syntax errors
- Generic InlineControlStructureSniff now correctly fixes ELSEIF statements

### Fixed
- Fixed bug [#601][sq-601] : Expected type hint int[]; found array in Squiz FunctionCommentSniff
    - Thanks to [Scato Eggen][@scato] for the patch
- Fixed bug [#625][sq-625] : Consider working around T_HASHBANG in HHVM 3.5.x and 3.6.x
    - Thanks to [Kunal Mehta][@legoktm] for the patch
- Fixed bug [#692][sq-692] : Comment tokenizer can break when using mbstring function overloading
- Fixed bug [#694][sq-694] : Long sniff codes can cause PHP warnings in source report when showing error codes
- Fixed bug [#698][sq-698] : PSR2.Methods.FunctionCallSignature.Indent forces exact indent of ternary operator parameters
- Fixed bug [#704][sq-704] : ScopeIndent can fail when an opening parenthesis is on a line by itself
- Fixed bug [#707][sq-707] : Squiz MethodScopeSniff doesn't handle nested functions
- Fixed bug [#709][sq-709] : Squiz.Sniffs.Whitespace.ScopeClosingBraceSniff marking indented endif in mixed inline HTML blocks
- Fixed bug [#711][sq-711] : Sniffing from STDIN shows Generic.Files.LowercasedFilename.NotFound error
- Fixed bug [#714][sq-714] : Fixes suppression of errors using docblocks
    - Thanks to [Andrzej Karmazyn][@akarmazyn] for the patch
- Fixed bug [#716][sq-716] : JSON report is invalid when messages contain newlines or tabs
    - Thanks to [Pieter Frenssen][@pfrenssen] for the patch
- Fixed bug [#723][sq-723] : ScopeIndent can fail when multiple array closers are on the same line
- Fixed bug [#730][sq-730] : ScopeIndent can fail when a short array opening square bracket is on a line by itself
- Fixed bug [#732][sq-732] : PHP Notice if @package name is made up of all invalid characters
    - Adds new error code PEAR.Commenting.FileComment.InvalidPackageValue
- Fixed bug [#748][sq-748] : Auto fix for Squiz.Commenting.BlockComment.WrongEnd is incorrect
    - Thanks to [J.D. Grimes][@JDGrimes] for the patch
- Fixed bug [#753][sq-753] : PSR2 standard shouldn't require space after USE block when next code is a closing tag
- Fixed bug [#768][sq-768] : PEAR FunctionCallSignature sniff forbids comments after opening parenthesis of a multiline call
- Fixed bug [#769][sq-769] : Incorrect detection of variable reference operator when used with short array syntax
    - Thanks to [Klaus Purer][@klausi] for the patch
- Fixed bug [#772][sq-772] : Syntax error when using PHPCBF on alternative style foreach loops
- Fixed bug [#773][sq-773] : Syntax error when stripping trailing PHP close tag and previous statement has no semicolon
- Fixed bug [#778][sq-778] : PHPCBF creates invalid PHP for inline FOREACH containing multiple control structures
- Fixed bug [#781][sq-781] : Incorrect checking for PHP7 return types on multi-line function declarations
- Fixed bug [#782][sq-782] : Conditional function declarations cause fixing conflicts in Squiz standard
    - Squiz.ControlStructures.ControlSignature no longer enforces a single newline after open brace
    - Squiz.WhiteSpace.ControlStructureSpacing can be used to check spacing at the start/end of control structures

[sq-601]: https://github.com/squizlabs/PHP_CodeSniffer/issues/601
[sq-625]: https://github.com/squizlabs/PHP_CodeSniffer/issues/625
[sq-692]: https://github.com/squizlabs/PHP_CodeSniffer/pull/692
[sq-694]: https://github.com/squizlabs/PHP_CodeSniffer/issues/694
[sq-698]: https://github.com/squizlabs/PHP_CodeSniffer/issues/698
[sq-704]: https://github.com/squizlabs/PHP_CodeSniffer/issues/704
[sq-707]: https://github.com/squizlabs/PHP_CodeSniffer/pull/707
[sq-709]: https://github.com/squizlabs/PHP_CodeSniffer/issues/709
[sq-711]: https://github.com/squizlabs/PHP_CodeSniffer/issues/711
[sq-714]: https://github.com/squizlabs/PHP_CodeSniffer/pull/714
[sq-716]: https://github.com/squizlabs/PHP_CodeSniffer/pull/716
[sq-723]: https://github.com/squizlabs/PHP_CodeSniffer/issues/723
[sq-730]: https://github.com/squizlabs/PHP_CodeSniffer/pull/730
[sq-732]: https://github.com/squizlabs/PHP_CodeSniffer/pull/732
[sq-748]: https://github.com/squizlabs/PHP_CodeSniffer/pull/748
[sq-753]: https://github.com/squizlabs/PHP_CodeSniffer/issues/753
[sq-765]: https://github.com/squizlabs/PHP_CodeSniffer/issues/765
[sq-768]: https://github.com/squizlabs/PHP_CodeSniffer/issues/768
[sq-769]: https://github.com/squizlabs/PHP_CodeSniffer/pull/769
[sq-772]: https://github.com/squizlabs/PHP_CodeSniffer/issues/772
[sq-773]: https://github.com/squizlabs/PHP_CodeSniffer/issues/773
[sq-778]: https://github.com/squizlabs/PHP_CodeSniffer/issues/778
[sq-781]: https://github.com/squizlabs/PHP_CodeSniffer/issues/781
[sq-782]: https://github.com/squizlabs/PHP_CodeSniffer/issues/782

## [2.3.4] - 2015-09-09

### Changed
- JSON report format now includes the fixable status for each error message and the total number of fixable errors
- Added more guard code for function declarations with syntax errors
- Added tokenizer support for the PHP declare construct
    - Thanks to [Andy Blyler][@ablyler] for the patch
- Generic UnnecessaryStringConcatSniff can now allow strings concatenated over multiple lines
    - Set the allowMultiline property to TRUE (default is FALSE) in your ruleset.xml file to enable this
    - By default, concat used only for getting around line length limits still generates an error
    - Thanks to [Stefan Lenselink][@stefanlenselink] for the contribution
- Invalid byte sequences no longer throw iconv_strlen() errors (request [#639][sq-639])
    - Thanks to [Willem Stuursma][@willemstuursma] for the patch
- Generic TodoSniff and FixmeSniff are now better at processing strings with invalid characters
- PEAR FunctionCallSignatureSniff now ignores indentation of inline HTML content
- Squiz ControlSignatureSniff now supports control structures with only inline HTML content

### Fixed
- Fixed bug [#636][sq-636] : Some class names cause CSS tokenizer to hang
- Fixed bug [#638][sq-638] : VCS blame reports output error content from the blame commands for files not under VC
- Fixed bug [#642][sq-642] : Method params incorrectly detected when default value uses short array syntax
    - Thanks to [Josh Davis][@joshdavis11] for the patch
- Fixed bug [#644][sq-644] : PEAR ScopeClosingBrace sniff does not work with mixed HTML/PHP
- Fixed bug [#645][sq-645] : FunctionSignature and ScopeIndent sniffs don't detect indents correctly when PHP open tag is not on a line by itself
- Fixed bug [#648][sq-648] : Namespace not tokenized correctly when followed by multiple use statements
- Fixed bug [#654][sq-654] : Comments affect indent check for BSDAllman brace style
- Fixed bug [#658][sq-658] : Squiz.Functions.FunctionDeclarationSpacing error for multi-line declarations with required spaces greater than zero
    - Thanks to [J.D. Grimes][@JDGrimes] for the patch
- Fixed bug [#663][sq-663] : No space after class name generates: Class name "" is not in camel caps format
- Fixed bug [#667][sq-667] : Scope indent check can go into infinite loop due to some parse errors
- Fixed bug [#670][sq-670] : Endless loop in PSR1 SideEffects sniffer if no semicolon after last statement
    - Thanks to [Thomas Jarosch][@thomasjfox] for the patch
- Fixed bug [#672][sq-672] : Call-time pass-by-reference false positive
- Fixed bug [#683][sq-683] : Comments are incorrectly reported by PSR2.ControlStructures.SwitchDeclaration sniff
- Fixed bug [#687][sq-687] : ScopeIndent does not check indent correctly for method prefixes like public and abstract
- Fixed bug [#689][sq-689] : False error on some comments after class closing brace

[sq-636]: https://github.com/squizlabs/PHP_CodeSniffer/issues/636
[sq-638]: https://github.com/squizlabs/PHP_CodeSniffer/issues/638
[sq-639]: https://github.com/squizlabs/PHP_CodeSniffer/pull/639
[sq-642]: https://github.com/squizlabs/PHP_CodeSniffer/pull/642
[sq-644]: https://github.com/squizlabs/PHP_CodeSniffer/issues/644
[sq-645]: https://github.com/squizlabs/PHP_CodeSniffer/issues/645
[sq-648]: https://github.com/squizlabs/PHP_CodeSniffer/issues/648
[sq-654]: https://github.com/squizlabs/PHP_CodeSniffer/issues/654
[sq-658]: https://github.com/squizlabs/PHP_CodeSniffer/pull/658
[sq-663]: https://github.com/squizlabs/PHP_CodeSniffer/issues/663
[sq-667]: https://github.com/squizlabs/PHP_CodeSniffer/issues/667
[sq-670]: https://github.com/squizlabs/PHP_CodeSniffer/pull/670
[sq-672]: https://github.com/squizlabs/PHP_CodeSniffer/issues/672
[sq-683]: https://github.com/squizlabs/PHP_CodeSniffer/issues/683
[sq-687]: https://github.com/squizlabs/PHP_CodeSniffer/issues/687
[sq-689]: https://github.com/squizlabs/PHP_CodeSniffer/issues/689

## [2.3.3] - 2015-06-24

### Changed
- Improved the performance of the CSS tokenizer, especially on very large CSS files (thousands of lines)
    - Thanks to [Klaus Purer][@klausi] for the patch
- Defined tokens for lower PHP versions are now phpcs-specific strings instead of ints
    - Stops conflict with other projects, like PHP_CodeCoverage
- Added more guard code for syntax errors to various sniffs
- Improved support for older HHVM versions
    - Thanks to [Kunal Mehta][@legoktm] for the patch
- Squiz ValidLogicalOperatorsSniff now ignores XOR as type casting is different when using the ^ operator (request [#567][sq-567])
- Squiz CommentedOutCodeSniff is now better at ignoring URLs inside comments
- Squiz ControlSignatureSniff is now better at checking embedded PHP code
- Squiz ScopeClosingBraceSniff is now better at checking embedded PHP code

### Fixed
- Fixed bug [#584][sq-584] : Squiz.Arrays.ArrayDeclaration sniff gives incorrect NoComma error for multiline string values
- Fixed bug [#589][sq-589] : PEAR.Functions.FunctionCallSignature sniff not checking all function calls
- Fixed bug [#592][sq-592] : USE statement tokenizing can sometimes result in mismatched scopes
- Fixed bug [#594][sq-594] : Tokenizer issue on closure that returns by reference
- Fixed bug [#595][sq-595] : Colons in CSS selectors within media queries throw false positives
    - Thanks to [Klaus Purer][@klausi] for the patch
- Fixed bug [#598][sq-598] : PHPCBF can break function/use closure brace placement
- Fixed bug [#603][sq-603] : Squiz ControlSignatureSniff hard-codes opener type while fixing
- Fixed bug [#605][sq-605] : Auto report-width specified in ruleset.xml ignored
- Fixed bug [#611][sq-611] : Invalid numeric literal on CSS files under PHP7
- Fixed bug [#612][sq-612] : Multi-file diff generating incorrectly if files do not end with EOL char
- Fixed bug [#615][sq-615] : Squiz OperatorBracketSniff incorrectly reports and fixes operations using self::
- Fixed bug [#616][sq-616] : Squiz DisallowComparisonAssignmentSniff inconsistent errors with inline IF statements
- Fixed bug [#617][sq-617] : Space after switch keyword in PSR-2 is not being enforced
- Fixed bug [#621][sq-621] : PSR2 SwitchDeclaration sniff doesn't detect, or correctly fix, case body on same line as statement

[sq-567]: https://github.com/squizlabs/PHP_CodeSniffer/issues/567
[sq-584]: https://github.com/squizlabs/PHP_CodeSniffer/issues/584
[sq-589]: https://github.com/squizlabs/PHP_CodeSniffer/issues/589
[sq-592]: https://github.com/squizlabs/PHP_CodeSniffer/issues/592
[sq-594]: https://github.com/squizlabs/PHP_CodeSniffer/issues/594
[sq-595]: https://github.com/squizlabs/PHP_CodeSniffer/pull/595
[sq-598]: https://github.com/squizlabs/PHP_CodeSniffer/issues/598
[sq-603]: https://github.com/squizlabs/PHP_CodeSniffer/issues/603
[sq-605]: https://github.com/squizlabs/PHP_CodeSniffer/issues/605
[sq-611]: https://github.com/squizlabs/PHP_CodeSniffer/issues/611
[sq-612]: https://github.com/squizlabs/PHP_CodeSniffer/issues/612
[sq-615]: https://github.com/squizlabs/PHP_CodeSniffer/issues/615
[sq-616]: https://github.com/squizlabs/PHP_CodeSniffer/issues/616
[sq-617]: https://github.com/squizlabs/PHP_CodeSniffer/issues/617
[sq-621]: https://github.com/squizlabs/PHP_CodeSniffer/issues/621

## [2.3.2] - 2015-04-29

### Changed
- The error message for PSR2.ControlStructures.SwitchDeclaration.WrongOpenercase is now clearer (request [#579][sq-579])

### Fixed
- Fixed bug [#545][sq-545] : Long list of CASE statements can cause tokenizer to reach a depth limit
- Fixed bug [#565][sq-565] : Squiz.WhiteSpace.OperatorSpacing reports negative number in short array
    - Thanks to [Vašek Purchart][@VasekPurchart] for the patch
    - Same fix also applied to Squiz.Formatting.OperatorBracket
- Fixed bug [#569][sq-569] : Generic ScopeIndentSniff throws PHP notices in JS files
- Fixed bug [#570][sq-570] : Phar class fatals in PHP less than 5.3

[sq-545]: https://github.com/squizlabs/PHP_CodeSniffer/issues/545
[sq-565]: https://github.com/squizlabs/PHP_CodeSniffer/pull/565
[sq-569]: https://github.com/squizlabs/PHP_CodeSniffer/pull/569
[sq-570]: https://github.com/squizlabs/PHP_CodeSniffer/issues/570
[sq-579]: https://github.com/squizlabs/PHP_CodeSniffer/issues/579

## [2.3.1] - 2015-04-23

### Changed
- PHPCS can now exit with 0 even if errors are found
    - Set the ignore_errors_on_exit config variable to 1 to set this behaviour
    - Use with the ignore_warnings_on_exit config variable to never return a non-zero exit code
- Added Generic DisallowLongArraySyntaxSniff to enforce the use of the PHP short array syntax (request [#483][sq-483])
    - Thanks to [Xaver Loppenstedt][@xalopp] for helping with tests
- Added Generic DisallowShortArraySyntaxSniff to ban the use of the PHP short array syntax (request [#483][sq-483])
    - Thanks to [Xaver Loppenstedt][@xalopp] for helping with tests
- Generic ScopeIndentSniff no longer does exact checking for content inside parenthesis (request [#528][sq-528])
    - Only applies to custom coding standards that set the "exact" flag to TRUE
- Squiz ConcatenationSpacingSniff now has a setting to ignore newline characters around operators (request [#511][sq-511])
    - Default remains FALSE, so newlines are not allowed
    - Override the "ignoreNewlines" setting in a ruleset.xml file to change
- Squiz InlineCommentSniff no longer checks the last char of a comment if the first char is not a letter (request [#505][sq-505])
- The Squiz standard has increased the max padding for statement alignment from 12 to 20

### Fixed
- Fixed bug [#479][sq-479] : Yielded values are not recognised as returned values in Squiz FunctionComment sniff
- Fixed bug [#512][sq-512] : Endless loop whilst parsing mixture of control structure styles
- Fixed bug [#515][sq-515] : Spaces in JS block incorrectly flagged as indentation error
- Fixed bug [#523][sq-523] : Generic ScopeIndent errors for IF in FINALLY
- Fixed bug [#527][sq-527] : Closure inside IF statement is not tokenized correctly
- Fixed bug [#529][sq-529] : Squiz.Strings.EchoedStrings gives false positive when echoing using an inline condition
- Fixed bug [#537][sq-537] : Using --config-set is breaking phpcs.phar
- Fixed bug [#543][sq-543] : SWITCH with closure in condition generates inline control structure error
- Fixed bug [#551][sq-551] : Multiple catch blocks not checked in Squiz.ControlStructures.ControlSignature sniff
- Fixed bug [#554][sq-554] : ScopeIndentSniff causes errors when encountering an unmatched parenthesis
- Fixed bug [#558][sq-558] : PHPCBF adds brace for ELSE IF split over multiple lines
- Fixed bug [#564][sq-564] : Generic MultipleStatementAlignment sniff reports incorrect errors for multiple assignments on a single line

[sq-479]: https://github.com/squizlabs/PHP_CodeSniffer/issues/479
[sq-483]: https://github.com/squizlabs/PHP_CodeSniffer/issues/483
[sq-505]: https://github.com/squizlabs/PHP_CodeSniffer/issues/505
[sq-511]: https://github.com/squizlabs/PHP_CodeSniffer/issues/511
[sq-512]: https://github.com/squizlabs/PHP_CodeSniffer/issues/512
[sq-515]: https://github.com/squizlabs/PHP_CodeSniffer/issues/515
[sq-523]: https://github.com/squizlabs/PHP_CodeSniffer/issues/523
[sq-527]: https://github.com/squizlabs/PHP_CodeSniffer/issues/527
[sq-528]: https://github.com/squizlabs/PHP_CodeSniffer/issues/528
[sq-529]: https://github.com/squizlabs/PHP_CodeSniffer/issues/529
[sq-537]: https://github.com/squizlabs/PHP_CodeSniffer/issues/537
[sq-543]: https://github.com/squizlabs/PHP_CodeSniffer/issues/543
[sq-551]: https://github.com/squizlabs/PHP_CodeSniffer/issues/551
[sq-554]: https://github.com/squizlabs/PHP_CodeSniffer/issues/554
[sq-558]: https://github.com/squizlabs/PHP_CodeSniffer/issues/558
[sq-564]: https://github.com/squizlabs/PHP_CodeSniffer/issues/564

## [2.3.0] - 2015-03-04

### Changed
- The existence of the main config file is now cached to reduce is_file() calls when it doesn't exist (request [#486][sq-486])
- Abstract classes inside the Sniffs directory are now ignored even if they are named `[Name]Sniff.php` (request [#476][sq-476])
    - Thanks to [David Vernet][@Decave] for the patch
- PEAR and Squiz FileComment sniffs no longer have @ in their error codes
    - e.g., PEAR.Commenting.FileComment.Duplicate@categoryTag becomes PEAR.Commenting.FileComment.DuplicateCategoryTag
    - e.g., Squiz.Commenting.FileComment.Missing@categoryTag becomes Squiz.Commenting.FileComment.MissingCategoryTag
- PEAR MultiLineConditionSniff now allows comment lines inside multi-line IF statement conditions
    - Thanks to [Klaus Purer][@klausi] for the patch
- Generic ForbiddenFunctionsSniff now supports setting null replacements in ruleset files (request [#263][sq-263])
- Generic opening function brace sniffs now support checking of closures
    - Set the checkClosures property to TRUE (default is FALSE) in your ruleset.xml file to enable this
    - Can also set the checkFunctions property to FALSE (default is TRUE) in your ruleset.xml file to only check closures
    - Affects OpeningFunctionBraceBsdAllmanSniff and OpeningFunctionBraceKernighanRitchieSniff
- Generic OpeningFunctionBraceKernighanRitchieSniff can now fix all the errors it finds
- Generic OpeningFunctionBraceKernighanRitchieSniff now allows empty functions with braces next to each other
- Generic OpeningFunctionBraceBsdAllmanSniff now allows empty functions with braces next to each other
- Improved auto report width for the "full" report
- Improved conflict detection during auto fixing
- Generic ScopeIndentSniff is no longer confused by empty closures
- Squiz ControlSignatureSniff now always ignores comments (fixes bug [#490][sq-490])
    - Include the Squiz.Commenting.PostStatementComment sniff in your ruleset.xml to ban these comments again
- Squiz OperatorSpacingSniff no longer throws errors for code in the form ($foo || -1 === $bar)
- Fixed errors tokenizing T_ELSEIF tokens on HHVM 3.5
- Squiz ArrayDeclarationSniff is no longer tricked by comments after array values
- PEAR IncludingFileSniff no longer produces invalid code when removing parenthesis from require/include statements

### Fixed
- Fixed bug [#415][sq-415] : The @codingStandardsIgnoreStart has no effect during fixing
- Fixed bug [#432][sq-432] : Properties of custom sniffs cannot be configured
- Fixed bug [#453][sq-453] : PSR2 standard does not allow closing tag for mixed PHP/HTML files
- Fixed bug [#457][sq-457] : FunctionCallSignature sniffs do not support here/nowdoc syntax and can cause syntax error when fixing
- Fixed bug [#466][sq-466] : PropertyLabelSpacing JS fixer issue when there is no space after colon
- Fixed bug [#473][sq-473] : Writing a report for an empty folder to existing file includes the existing contents
- Fixed bug [#485][sq-485] : PHP notice in Squiz.Commenting.FunctionComment when checking malformed @throws comment
- Fixed bug [#491][sq-491] : Generic InlineControlStructureSniff can correct with missing semicolon
    - Thanks to [Jesse Donat][@donatj] for the patch
- Fixed bug [#492][sq-492] : Use statements don't increase the scope indent
- Fixed bug [#493][sq-493] : PSR1_Sniffs_Methods_CamelCapsMethodNameSniff false positives for some magic method detection
    - Thanks to [Andreas Möller][@localheinz] for the patch
- Fixed bug [#496][sq-496] : Closures in PSR2 are not checked for a space after the function keyword
- Fixed bug [#497][sq-497] : Generic InlineControlStructureSniff does not support alternative SWITCH syntax
- Fixed bug [#500][sq-500] : Functions not supported as values in Squiz ArrayDeclaration sniff
- Fixed bug [#501][sq-501] : ScopeClosingBrace and ScopeIndent conflict with closures used as array values
    - Generic ScopeIndentSniff may now report fewer errors for closures, but perform the same fixes
- Fixed bug [#502][sq-502] : PSR1 SideEffectsSniff sees declare() statements as side effects

[sq-415]: https://github.com/squizlabs/PHP_CodeSniffer/issues/415
[sq-432]: https://github.com/squizlabs/PHP_CodeSniffer/issues/432
[sq-453]: https://github.com/squizlabs/PHP_CodeSniffer/issues/453
[sq-457]: https://github.com/squizlabs/PHP_CodeSniffer/issues/457
[sq-466]: https://github.com/squizlabs/PHP_CodeSniffer/issues/466
[sq-473]: https://github.com/squizlabs/PHP_CodeSniffer/issues/473
[sq-476]: https://github.com/squizlabs/PHP_CodeSniffer/issues/476
[sq-485]: https://github.com/squizlabs/PHP_CodeSniffer/issues/485
[sq-486]: https://github.com/squizlabs/PHP_CodeSniffer/issues/486
[sq-490]: https://github.com/squizlabs/PHP_CodeSniffer/issues/490
[sq-491]: https://github.com/squizlabs/PHP_CodeSniffer/pull/491
[sq-492]: https://github.com/squizlabs/PHP_CodeSniffer/pull/492
[sq-493]: https://github.com/squizlabs/PHP_CodeSniffer/pull/493
[sq-496]: https://github.com/squizlabs/PHP_CodeSniffer/issues/496
[sq-497]: https://github.com/squizlabs/PHP_CodeSniffer/issues/497
[sq-500]: https://github.com/squizlabs/PHP_CodeSniffer/issues/500
[sq-501]: https://github.com/squizlabs/PHP_CodeSniffer/issues/501
[sq-502]: https://github.com/squizlabs/PHP_CodeSniffer/issues/502

## [2.2.0] - 2015-01-22

### Changed
- Added (hopefully) tastefully used colors to report and progress output for the phpcs command
    - Use the --colors command line argument to use colors in output
    - Use the command "phpcs --config-set colors true" to turn colors on by default
    - Use the --no-colors command line argument to turn colors off when the config value is set
- Added support for using the full terminal width for report output
    - Use the --report-width=auto command line argument to auto-size the reports
    - Use the command "phpcs --config-set report_width auto" to use auto-sizing by default
- Reports will now size to fit inside the report width setting instead of always using padding to fill the space
- If no files or standards are specified, PHPCS will now look for a phpcs.xml file in the current directory
    - This file has the same format as a standard ruleset.xml file
    - The phpcs.xml file should specify (at least) files to process and a standard/sniffs to use
    - Useful for running the phpcs and phpcbf commands without any arguments at the top of a repository
- Default file paths can now be specified in a ruleset.xml file using the "file" tag
    - File paths are only processed if no files were specified on the command line
- Extensions specified on the CLI are now merged with those set in ruleset.xml files
    - Previously, the ruleset.xml file setting replaced the CLI setting completely
- Squiz coding standard now requires lowercase PHP constants (true, false and null)
    - Removed Squiz.NamingConventions.ConstantCase sniff as the rule is now consistent across PHP and JS files
- Squiz FunctionOpeningBraceSpaceSniff no longer does additional checks for JS functions
    - PHP and JS functions and closures are now treated the same way
- Squiz MultiLineFunctionDeclarationSniff now supports JS files
- Interactive mode no longer breaks if you also specify a report type on the command line
- PEAR InlineCommentSniff now fixes the Perl-style comments that it finds (request [#375][sq-375])
- PSR2 standard no longer fixes the placement of docblock open tags as comments are excluded from this standard
- PSR2 standard now sets a default tab width of 4 spaces
- Generic DocCommentSniff now only disallows lowercase letters at the start of a long/short comment (request [#377][sq-377])
    - All non-letter characters are now allowed, including markdown special characters and numbers
- Generic DisallowMultipleStatementsSniff now allows multiple open/close tags on the same line (request [#423][sq-423])
- Generic CharacterBeforePHPOpeningTagSniff now only checks the first PHP tag it finds (request [#423][sq-423])
- Generic CharacterBeforePHPOpeningTagSniff now allows a shebang line at the start of the file (request [#20481][pear-20481])
- Generic InlineHTMLUnitTest now allows a shebang line at the start of the file (request [#20481][pear-20481])
- PEAR ObjectOperatorIndentSniff now only checks object operators at the start of a line
- PEAR FileComment and ClassComment sniffs no longer have @ in their error codes
    - E.g., PEAR.Commenting.FileComment.Missing@categoryTag becomes PEAR.Commenting.FileComment.MissingCategoryTag
    - Thanks to [Grzegorz Rygielski][@grzr] for the patch
- Squiz ControlStructureSpacingSniff no longer enforces a blank line before CATCH statements
- Squiz FunctionCommentSniff now fixes the return type in the @return tag (request [#392][sq-392])
- Squiz BlockCommentSniff now only disallows lowercase letters at the start of the comment
- Squiz InlineCommentSniff now only disallows lowercase letters at the start of the comment
- Squiz OperatorSpacingSniff now has a setting to ignore newline characters around operators (request [#348][sq-348])
    - Default remains FALSE, so newlines are not allowed
    - Override the "ignoreNewlines" setting in a ruleset.xml file to change
- PSR2 ControlStructureSpacingSniff now checks for, and fixes, newlines after the opening parenthesis
- Added a markdown document generator (--generator=markdown to use)
    - Thanks to [Stefano Kowalke][@Konafets] for the contribution

### Fixed
- Fixed bug [#379][sq-379] : Squiz.Arrays.ArrayDeclaration.NoCommaAfterLast incorrectly detects comments
- Fixed bug [#382][sq-382] : JS tokenizer incorrect for inline conditionally created immediately invoked anon function
- Fixed bug [#383][sq-383] : Squiz.Arrays.ArrayDeclaration.ValueNoNewline incorrectly detects nested arrays
- Fixed bug [#386][sq-386] : Undefined offset in Squiz.FunctionComment sniff when param has no comment
- Fixed bug [#390][sq-390] : Indentation of non-control structures isn't adjusted when containing structure is fixed
- Fixed bug [#400][sq-400] : InlineControlStructureSniff fails to fix when statement has no semicolon
- Fixed bug [#401][sq-401] : PHPCBF no-patch option shows an error when there are no fixable violations in a file
- Fixed bug [#405][sq-405] : The "Squiz.WhiteSpace.FunctionSpacing" sniff removes class "}" during fixing
- Fixed bug [#407][sq-407] : PEAR.ControlStructures.MultiLineCondition doesn't account for comments at the end of lines
- Fixed bug [#410][sq-410] : The "Squiz.WhiteSpace.MemberVarSpacing" not respecting "var"
- Fixed bug [#411][sq-411] : Generic.WhiteSpace.ScopeIndent.Incorrect - false positive with multiple arrays in argument list
- Fixed bug [#412][sq-412] : PSR2 multi-line detection doesn't work for inline IF and string concats
- Fixed bug [#414][sq-414] : Squiz.WhiteSpace.MemberVarSpacing - inconsistent checking of member vars with comment
- Fixed bug [#433][sq-433] : Wrong detection of Squiz.Arrays.ArrayDeclaration.KeyNotAligned when key contains space
- Fixed bug [#434][sq-434] : False positive for spacing around "=>" in inline array within foreach
- Fixed bug [#452][sq-452] : Ruleset exclude-pattern for specific sniff code ignored when using CLI --ignore option
- Fixed bug [#20482][pear-20482] : Scope indent sniff can get into infinite loop when processing a parse error

[sq-348]: https://github.com/squizlabs/PHP_CodeSniffer/issues/348
[sq-375]: https://github.com/squizlabs/PHP_CodeSniffer/issues/375
[sq-377]: https://github.com/squizlabs/PHP_CodeSniffer/issues/377
[sq-379]: https://github.com/squizlabs/PHP_CodeSniffer/issues/379
[sq-382]: https://github.com/squizlabs/PHP_CodeSniffer/issues/382
[sq-383]: https://github.com/squizlabs/PHP_CodeSniffer/issues/383
[sq-386]: https://github.com/squizlabs/PHP_CodeSniffer/issues/386
[sq-390]: https://github.com/squizlabs/PHP_CodeSniffer/issues/390
[sq-392]: https://github.com/squizlabs/PHP_CodeSniffer/issues/392
[sq-400]: https://github.com/squizlabs/PHP_CodeSniffer/issues/400
[sq-401]: https://github.com/squizlabs/PHP_CodeSniffer/issues/401
[sq-405]: https://github.com/squizlabs/PHP_CodeSniffer/issues/405
[sq-407]: https://github.com/squizlabs/PHP_CodeSniffer/issues/407
[sq-410]: https://github.com/squizlabs/PHP_CodeSniffer/issues/410
[sq-411]: https://github.com/squizlabs/PHP_CodeSniffer/issues/411
[sq-412]: https://github.com/squizlabs/PHP_CodeSniffer/issues/412
[sq-414]: https://github.com/squizlabs/PHP_CodeSniffer/issues/414
[sq-423]: https://github.com/squizlabs/PHP_CodeSniffer/issues/423
[sq-433]: https://github.com/squizlabs/PHP_CodeSniffer/issues/433
[sq-434]: https://github.com/squizlabs/PHP_CodeSniffer/issues/434
[sq-452]: https://github.com/squizlabs/PHP_CodeSniffer/issues/452
[pear-20481]: https://pear.php.net/bugs/bug.php?id=20481
[pear-20482]: https://pear.php.net/bugs/bug.php?id=20482

## [2.1.0] - 2014-12-18

### Changed
- Time and memory output is now shown if progress information is also shown (request [#335][sq-335])
- A tilde can now be used to reference a user's home directory in a path to a standard (request [#353][sq-353])
- Added PHP_CodeSniffer_File::findStartOfStatement() to find the first non-whitespace token in a statement
    - Possible alternative for code using PHP_CodeSniffer_File::findPrevious() with the local flag set
- Added PHP_CodeSniffer_File::findEndOfStatement() to find the last non-whitespace token in a statement
    - Possible alternative for code using PHP_CodeSniffer_File::findNext() with the local flag set
- Generic opening function brace sniffs now ensure the opening brace is the last content on the line
    - Affects OpeningFunctionBraceBsdAllmanSniff and OpeningFunctionBraceKernighanRitchieSniff
    - Also enforced in PEAR FunctionDeclarationSniff and Squiz MultiLineFunctionDeclarationSniff
- Generic DisallowTabIndentSniff now replaces tabs everywhere it finds them, except in strings and here/now docs
- Generic EmptyStatementSniff error codes now contain the type of empty statement detected (request [#314][sq-314])
    - All messages generated by this sniff are now errors (empty CATCH was previously a warning)
    - Message code `Generic.CodeAnalysis.EmptyStatement.NotAllowed` has been removed
    - Message code `Generic.CodeAnalysis.EmptyStatement.NotAllowedWarning` has been removed
    - New message codes have the format `Generic.CodeAnalysis.EmptyStatement.Detected[TYPE]`
    - Example code is `Generic.CodeAnalysis.EmptyStatement.DetectedCATCH`
    - You can now use a custom ruleset to change messages to warnings and to exclude them
- PEAR and Squiz FunctionCommentSniffs no longer ban `@return` tags for constructors and destructors
    - Removed message PEAR.Commenting.FunctionComment.ReturnNotRequired
    - Removed message Squiz.Commenting.FunctionComment.ReturnNotRequired
    - Change initiated by request [#324][sq-324] and request [#369][sq-369]
- Squiz EmptyStatementSniff has been removed
    - Squiz standard now includes Generic EmptyStatementSniff and turns off the empty CATCH error
- Squiz ControlSignatureSniff fixes now retain comments between the closing parenthesis and open brace
- Squiz SuperfluousWhitespaceSniff now checks for extra blank lines inside closures
    - Thanks to [Sertan Danis][@sertand] for the patch
- Squiz ArrayDeclarationSniff now skips function calls while checking multi-line arrays

### Fixed
- Fixed bug [#337][sq-337] : False positive with anonymous functions in Generic_Sniffs_WhiteSpace_ScopeIndentSniff
- Fixed bug [#339][sq-339] : reformatting brace location can result in broken code
- Fixed bug [#342][sq-342] : Nested ternary operators not tokenized correctly
- Fixed bug [#345][sq-345] : Javascript regex not tokenized when inside array
- Fixed bug [#346][sq-346] : PHP path can't be determined in some cases in "phpcs.bat" (on Windows XP)
- Fixed bug [#358][sq-358] : False positives for Generic_Sniffs_WhiteSpace_ScopeIndentSniff
- Fixed bug [#361][sq-361] : Sniff-specific exclude patterns don't work for Windows
- Fixed bug [#364][sq-364] : Don't interpret "use function" as declaration
- Fixed bug [#366][sq-366] : phpcbf with PSR2 errors on control structure alternative syntax
- Fixed bug [#367][sq-367] : Nested Anonymous Functions Causing False Negative
- Fixed bug [#371][sq-371] : Shorthand binary cast causes tokenizer errors
    - New token T_BINARY_CAST added for the b"string" cast format (the 'b' is the T_BINARY_CAST token)
- Fixed bug [#372][sq-372] : phpcbf parse problem, wrong brace placement for inline IF
- Fixed bug [#373][sq-373] : Double quote usage fix removing too many double quotes
- Fixed bug [#20196][pear-20196] : 1.5.2 breaks scope_closer position

[sq-314]: https://github.com/squizlabs/PHP_CodeSniffer/issues/314
[sq-324]: https://github.com/squizlabs/PHP_CodeSniffer/issues/324
[sq-335]: https://github.com/squizlabs/PHP_CodeSniffer/issues/335
[sq-337]: https://github.com/squizlabs/PHP_CodeSniffer/issues/337
[sq-339]: https://github.com/squizlabs/PHP_CodeSniffer/issues/339
[sq-342]: https://github.com/squizlabs/PHP_CodeSniffer/issues/342
[sq-345]: https://github.com/squizlabs/PHP_CodeSniffer/issues/345
[sq-346]: https://github.com/squizlabs/PHP_CodeSniffer/issues/346
[sq-353]: https://github.com/squizlabs/PHP_CodeSniffer/issues/353
[sq-358]: https://github.com/squizlabs/PHP_CodeSniffer/issues/358
[sq-361]: https://github.com/squizlabs/PHP_CodeSniffer/issues/361
[sq-364]: https://github.com/squizlabs/PHP_CodeSniffer/pull/364
[sq-366]: https://github.com/squizlabs/PHP_CodeSniffer/issues/366
[sq-367]: https://github.com/squizlabs/PHP_CodeSniffer/issues/367
[sq-369]: https://github.com/squizlabs/PHP_CodeSniffer/issues/369
[sq-371]: https://github.com/squizlabs/PHP_CodeSniffer/issues/371
[sq-372]: https://github.com/squizlabs/PHP_CodeSniffer/issues/372
[sq-373]: https://github.com/squizlabs/PHP_CodeSniffer/issues/373
[pear-20196]: https://pear.php.net/bugs/bug.php?id=20196

## [2.0.0] - 2014-12-05

### Changed
- JS tokenizer now sets functions as T_CLOSUREs if the function is anonymous
- JS tokenizer now sets all objects to T_OBJECT
    - Object end braces are set to a new token T_CLOSE_OBJECT
    - T_OBJECT tokens no longer act like scopes; i.e., they have no condition/opener/closer
    - T_PROPERTY tokens no longer act like scopes; i.e., they have no condition/opener/closer
    - T_OBJECT tokens have a bracket_closer instead, which can be used to find the ending
    - T_CLOSE_OBJECT tokens have a bracket_opener
- Improved regular expression detection in the JS tokenizer
- You can now get PHP_CodeSniffer to ignore a single line by putting @codingStandardsIgnoreLine in a comment
    - When the comment is found, the comment line and the following line will be ignored
    - Thanks to [Andy Bulford][@abulford] for the contribution
- PHPCBF now prints output when it is changing into directories
- Improved conflict detection during auto fixing
- The -vvv command line argument will now output the current file content for each loop during fixing
- Generic ScopeIndentSniff now checks that open/close PHP tags are aligned to the correct column
- PEAR FunctionCallSignatureSniff now checks indent of closing parenthesis even if it is not on a line by itself
- PEAR FunctionCallSignatureSniff now supports JS files
- PEAR MultiLineConditionSniff now supports JS files
- Squiz DocCommentAlignmentSniff now supports JS files
- Fixed a problem correcting the closing brace line in Squiz ArrayDeclarationSniff
- Fixed a problem auto-fixing the Squiz.WhiteSpace.FunctionClosingBraceSpace.SpacingBeforeNestedClose error
- Squiz EmbeddedPhpSniff no longer reports incorrect alignment of tags when they are not on new lines
- Squiz EmbeddedPhpSniff now aligns open tags correctly when moving them onto a new line
- Improved fixing of arrays with multiple values in Squiz ArrayDeclarationSniff
- Improved detection of function comments in Squiz FunctionCommentSpacingSniff
- Improved fixing of lines after cases statements in Squiz SwitchDeclarationSniff

### Fixed
- Fixed bug [#311][sq-311] : Suppression of function prototype breaks checking of lines within function
- Fixed bug [#320][sq-320] : Code sniffer indentation issue
- Fixed bug [#333][sq-333] : Nested ternary operators causing problems

[sq-311]: https://github.com/squizlabs/PHP_CodeSniffer/issues/311
[sq-320]: https://github.com/squizlabs/PHP_CodeSniffer/issues/320
[sq-333]: https://github.com/squizlabs/PHP_CodeSniffer/issues/333

## [2.0.0RC4] - 2014-11-07

### Changed
- JS tokenizer now detects xor statements correctly
- Improved detection of properties and objects in the JS tokenizer
- Generic ScopeIndentSniff can now fix indents using tabs instead of spaces
    - Set the tabIndent property to TRUE in your ruleset.xml file to enable this
    - It is important to also set a tab-width setting, either in the ruleset or on the command line, for accuracy
- Generic ScopeIndentSniff now checks and auto-fixes JS files
- Generic DisallowSpaceIndentSniff is now able to replace space indents with tab indents during fixing
- Support for phpcs-only and phpcbf-only attributes has been added to all ruleset.xml elements
    - Allows parts of the ruleset to only apply when using a specific tool
    - Useful for doing things like excluding indent fixes but still reporting indent errors
- Unit tests can now set command line arguments during a test run
    - Override getCliValues() and pass an array of CLI arguments for each file being tested
- File-wide sniff properties can now be set using T_INLINE_HTML content during unit test runs
    - Sniffs that start checking at the open tag can only, normally, have properties set using a ruleset
- Generic ConstructorNameSniff no longer errors for PHP4 style constructors when __construct() is present
    - Thanks to [Thibaud Fabre][@fabre-thibaud] for the patch
- Generic DocCommentSniff now checks that the end comment tag is on a new line
- Generic MultipleStatementAlignmentSniff no longer skips assignments for closures
- Squiz DocCommentAlignment sniff now has better checking for single line doc block
- Running unit tests with the -v CLI argument no longer generates PHP errors

### Fixed
- Fixed bug [#295][sq-295] : ScopeIndentSniff hangs when processing nested closures
- Fixed bug [#298][sq-298] : False positive in ScopeIndentSniff when anonymous functions are used with method chaining
- Fixed bug [#302][sq-302] : Fixing code in Squiz InlineComment sniff can remove some comment text
- Fixed bug [#303][sq-303] : Open and close tag on same line can cause a PHP notice checking scope indent
- Fixed bug [#306][sq-306] : File containing only a namespace declaration raises undefined index notice
- Fixed bug [#307][sq-307] : Conditional breaks in case statements get incorrect indentations
- Fixed bug [#308][sq-308] : Squiz InlineIfDeclarationSniff fails on ternary operators inside closure
- Fixed bug [#310][sq-310] : Variadics not recognized by tokenizer

[sq-295]: https://github.com/squizlabs/PHP_CodeSniffer/issues/295
[sq-298]: https://github.com/squizlabs/PHP_CodeSniffer/issues/298
[sq-302]: https://github.com/squizlabs/PHP_CodeSniffer/issues/302
[sq-303]: https://github.com/squizlabs/PHP_CodeSniffer/issues/303
[sq-306]: https://github.com/squizlabs/PHP_CodeSniffer/issues/306
[sq-307]: https://github.com/squizlabs/PHP_CodeSniffer/issues/307
[sq-308]: https://github.com/squizlabs/PHP_CodeSniffer/issues/308
[sq-310]: https://github.com/squizlabs/PHP_CodeSniffer/issues/310

## [2.0.0RC3] - 2014-10-16

### Changed
- Improved default output for PHPCBF and removed the options to print verbose and progress output
- If a .fixed file is supplied for a unit test file, the auto fixes will be checked against it during testing
    - See Generic ScopeIndentUnitTest.inc and ScopeIndentUnitTest.inc.fixed for an example
- Fixer token replacement methods now return TRUE if the change was accepted and FALSE if rejected
- The --config-show command now pretty-prints the config values
    - Thanks to [Ken Guest][@kenguest] for the patch
- Setting and removing config values now catches exceptions if the config file is not writable
    - Thanks to [Ken Guest][@kenguest] for the patch
- Setting and removing config values now prints a message to confirm the action and show old values
- Generic ScopeIndentSniff has been completely rewritten to improve fixing and embedded PHP detection
- Generic DisallowTabIndent and DisallowSpaceIndent sniffs now detect indents at the start of block comments
- Generic DisallowTabIndent and DisallowSpaceIndent sniffs now detect indents inside multi-line strings
- Generic DisallowTabIndentSniff now replaces tabs inside doc block comments
- Squiz ControlStructureSpacingSniff error codes have been corrected; they were reversed
- Squiz EmbeddedPhpSniff now checks open and close tag indents and fixes some errors
- Squiz FileCommentSniff no longer throws incorrect blank line before comment errors in JS files
- Squiz ClassDeclarationSniff now has better checking for blank lines after a closing brace
- Removed error Squiz.Classes.ClassDeclaration.NoNewlineAfterCloseBrace (request [#285][sq-285])
    - Already handled by Squiz.Classes.ClassDeclaration.CloseBraceSameLine

### Fixed
- Fixed bug [#280][sq-280] : The --config-show option generates error when there is no config file

[sq-280]: https://github.com/squizlabs/PHP_CodeSniffer/issues/280
[sq-285]: https://github.com/squizlabs/PHP_CodeSniffer/issues/285

## [2.0.0RC2] - 2014-09-26

### Changed
- Minified JS and CSS files are now detected and skipped (fixes bug [#252][sq-252] and bug [#19899][pear-19899])
    - A warning will be added to the file so it can be found in the report and ignored in the future
- Fixed incorrect length of JS object operator tokens
- PHP tokenizer no longer converts class/function names to special tokens types
    - Class/function names such as parent and true would become special tokens such as T_PARENT and T_TRUE
- PHPCS can now exit with 0 if only warnings were found (request [#262][sq-262])
    - Set the ignore_warnings_on_exit config variable to 1 to set this behaviour
    - Default remains at exiting with 0 only if no errors and no warnings were found
    - Also changes return value of PHP_CodeSniffer_Reporting::printReport()
- Rulesets can now set associative array properties
    - property `name="[property]" type="array" value="foo=>bar,baz=>qux"`
- Generic ForbiddenFunctionsSniff now has a public property called forbiddenFunctions (request [#263][sq-263])
    - Override the property in a ruleset.xml file to define forbidden functions and their replacements
    - A replacement of NULL indicates that no replacement is available
    - e.g., value="delete=>unset,print=>echo,create_function=>null"
    - Custom sniffs overriding this one will need to change the visibility of their member var
- Improved closure support in Generic ScopeIndentSniff
- Improved indented PHP tag support in Generic ScopeIndentSniff
- Improved fixing of mixed line indents in Generic ScopeIndentSniff
- Added conflict detection to the file fixer
    - If 2 sniffs look to be conflicting, one change will be ignored to allow a fix to occur
- Generic CamelCapsFunctionNameSniff now ignores a single leading underscore
    - Thanks to [Alex Slobodiskiy][@xt99] for the patch
- Standards can now be located within hidden directories (further fix for bug [#20323][pear-20323])
    - Thanks to [Klaus Purer][@klausi] for the patch
- Sniff ignore patterns now replace Win dir separators like file ignore patterns already did
- Exclude patterns now use backtick delimiters, allowing all special characters to work correctly again
    - Thanks to [Jeremy Edgell][@jedgell] for the patch
- Errors converted to warnings in a ruleset (and vice versa) now retain their fixable status
    - Thanks to [Alexander Obuhovich][@aik099] for the patch
- Squiz ConcatenationSpacingSniff now has a setting to specify how many spaces there should be around concat operators
    - Default remains at 0
    - Override the "spacing" setting in a ruleset.xml file to change
- Added auto-fixes for Squiz InlineCommentSniff
- Generic DocCommentSniff now correctly fixes additional blank lines at the end of a comment
- Squiz OperatorBracketSniff now correctly fixes operations that include arrays
- Zend ClosingTagSniff fix now correctly leaves closing tags when followed by HTML
- Added Generic SyntaxSniff to check for syntax errors in PHP files
    - Thanks to [Blaine Schmeisser][@bayleedev] for the contribution
- Added Generic OneTraitPerFileSniff to check that only one trait is defined in each file
    - Thanks to [Alexander Obuhovich][@aik099] for the contribution
- Squiz DiscouragedFunctionsSniff now warns about var_dump()
- PEAR ValidFunctionNameSniff no longer throws an error for _()
- Squiz and PEAR FunctionCommentSniffs now support _()
- Generic DisallowTabIndentSniff now checks for, and fixes, mixed indents again
- Generic UpperCaseConstantSniff and LowerCaseConstantSniff now ignore function names

### Fixed
- Fixed bug [#243][sq-243] : Missing DocBlock not detected
- Fixed bug [#248][sq-248] : FunctionCommentSniff expects ampersand on param name
- Fixed bug [#265][sq-265] : False positives with type hints in ForbiddenFunctionsSniff
- Fixed bug [#20373][pear-20373] : Inline comment sniff tab handling way
- Fixed bug [#20377][pear-20377] : Error when trying to execute phpcs with report=json
- Fixed bug [#20378][pear-20378] : Report appended to existing file if no errors found in run
- Fixed bug [#20381][pear-20381] : Invalid "Comment closer must be on a new line"
    - Thanks to [Brad Kent][@bkdotcom] for the patch
- Fixed bug [#20402][pear-20402] : SVN pre-commit hook fails due to unknown argument error

[sq-243]: https://github.com/squizlabs/PHP_CodeSniffer/issues/243
[sq-248]: https://github.com/squizlabs/PHP_CodeSniffer/issues/248
[sq-252]: https://github.com/squizlabs/PHP_CodeSniffer/issues/252
[sq-262]: https://github.com/squizlabs/PHP_CodeSniffer/issues/262
[sq-263]: https://github.com/squizlabs/PHP_CodeSniffer/issues/263
[sq-265]: https://github.com/squizlabs/PHP_CodeSniffer/pull/265
[pear-19899]: https://pear.php.net/bugs/bug.php?id=19899
[pear-20377]: https://pear.php.net/bugs/bug.php?id=20377
[pear-20402]: https://pear.php.net/bugs/bug.php?id=20402
[pear-20373]: https://pear.php.net/bugs/bug.php?id=20373
[pear-20378]: https://pear.php.net/bugs/bug.php?id=20378
[pear-20381]: https://pear.php.net/bugs/bug.php?id=20381

## [2.0.0RC1] - 2014-08-06

### Changed
- PHPCBF will now fix incorrect newline characters in a file
- PHPCBF now exits cleanly when there are no errors to fix
- Added phpcbf.bat file for Windows
- Verbose option no longer errors when using a phar file with a space in the path
- Fixed a reporting error when using HHVM
    - Thanks to [Martins Sipenko][@martinssipenko] for the patch
- addFixableError() and addFixableWarning() now only return true if the fixer is enabled
    - Saves checking ($phpcsFile->fixer->enabled === true) before every fix
- Added addErrorOnLine() and addWarningOnLine() to add a non-fixable violation to a line at column 1
    - Useful if you are generating errors using an external tool or parser and only know line numbers
    - Thanks to [Ondřej Mirtes][@ondrejmirtes] for the patch
- CSS tokenizer now identifies embedded PHP code using the new T_EMBEDDED_PHP token type
    - The entire string of PHP is contained in a single token
- PHP tokenizer contains better detection of short array syntax
- Unit test runner now also test any standards installed under the installed_paths config var
- Exclude patterns now use {} delimiters, allowing the | special character to work correctly again
- The filtering component of the --extensions argument is now ignored again when passing filenames
    - Can still be used to specify a custom tokenizer for each extension when passing filenames
    - If no tokenizer is specified, default values will be used for common file extensions
- Diff report now produces relative paths on Windows, where possible (further fix for bug [#20234][pear-20234])
- If a token's content has been modified by the tab-width setting, it will now have an orig_content in the tokens array
- Generic DisallowSpaceIndent and DisallowTabIndent sniffs now check original indent content even when tab-width is set
    - Previously, setting --tab-width would force both to check the indent as spaces
- Fixed a problem where PHPCBF could replace tabs with too many spaces when changing indents
- Fixed a problem that could occur with line numbers when using HHVM to check files with Windows newline characters
- Removed use of sys_get_temp_dir() as this is not supported by the min PHP version
- Squiz ArrayDeclarationSniff now supports short array syntax
- Squiz ControlSignatureSniff no longer uses the Abstract Pattern sniff
    - If you are extending this sniff, you'll need to rewrite your code
    - The rewrite allows this sniff to fix all control structure formatting issues it finds
- The installed_paths config var now accepts relative paths
    - The paths are relative to the PHP_CodeSniffer install directory
    - Thanks to [Weston Ruter][@westonruter] for the patch
- Generic ScopeIndentSniff now accounts for different open tag indents
- PEAR FunctionDeclarationSniff now ignores short arrays when checking indent
    - Thanks to [Daniel Tschinder][@danez] for the patch
- PSR2 FunctionCallSignatureSniff now treats multi-line strings as a single-line argument, like arrays and closures
    - Thanks to [Dawid Nowak][@MacDada] for the patch
- PSR2 UseDeclarationSniff now checks for a single space after the USE keyword
- Generic ForbiddenFunctionsSniff now detects calls to functions in the global namespace
    - Thanks to [Ole Martin Handeland][@olemartinorg] for the patch
- Generic LowerCaseConstantSniff and UpperCaseConstantSniff now ignore namespaces beginning with TRUE/FALSE/NULL
    - Thanks to [Renan Gonçalves][@renan] for the patch
- Squiz InlineCommentSniff no longer requires a blank line after post-statement comments (request [#20299][pear-20299])
- Squiz SelfMemberReferenceSniff now works correctly with namespaces
- Squiz FunctionCommentSniff is now more relaxed when checking namespaced type hints
- Tab characters are now encoded in abstract pattern error messages
    - Thanks to [Blaine Schmeisser][@bayleedev] for the patch
- Invalid sniff codes passed to --sniffs now show a friendly error message (request [#20313][pear-20313])
- Generic LineLengthSniff now shows a warning if the iconv module is disabled (request [#20314][pear-20314])
- Source report no longer shows errors if category or sniff names ends in an uppercase error
    - Thanks to [Jonathan Marcil][@jmarcil] for the patch

### Fixed
- Fixed bug [#20261][pear-20261] : phpcbf has an endless fixing loop
- Fixed bug [#20268][pear-20268] : Incorrect documentation titles in PEAR documentation
- Fixed bug [#20296][pear-20296] : new array notion in function comma check fails
- Fixed bug [#20297][pear-20297] : phar does not work when renamed it to phpcs
- Fixed bug [#20307][pear-20307] : PHP_CodeSniffer_Standards_AbstractVariableSniff analyze traits
- Fixed bug [#20308][pear-20308] : Squiz.ValidVariableNameSniff - wrong variable usage
- Fixed bug [#20309][pear-20309] : Use "member variable" term in sniff "processMemberVar" method
- Fixed bug [#20310][pear-20310] : PSR2 does not check for space after function name
- Fixed bug [#20322][pear-20322] : Display rules set to type=error even when suppressing warnings
- Fixed bug [#20323][pear-20323] : PHPCS tries to load sniffs from hidden directories
- Fixed bug [#20346][pear-20346] : Fixer endless loop with Squiz.CSS sniffs
- Fixed bug [#20355][pear-20355] : No sniffs are registered with PHAR on Windows

[pear-20261]: https://pear.php.net/bugs/bug.php?id=20261
[pear-20268]: https://pear.php.net/bugs/bug.php?id=20268
[pear-20296]: https://pear.php.net/bugs/bug.php?id=20296
[pear-20297]: https://pear.php.net/bugs/bug.php?id=20297
[pear-20299]: https://pear.php.net/bugs/bug.php?id=20299
[pear-20307]: https://pear.php.net/bugs/bug.php?id=20307
[pear-20308]: https://pear.php.net/bugs/bug.php?id=20308
[pear-20309]: https://pear.php.net/bugs/bug.php?id=20309
[pear-20310]: https://pear.php.net/bugs/bug.php?id=20310
[pear-20313]: https://pear.php.net/bugs/bug.php?id=20313
[pear-20314]: https://pear.php.net/bugs/bug.php?id=20314
[pear-20322]: https://pear.php.net/bugs/bug.php?id=20322
[pear-20323]: https://pear.php.net/bugs/bug.php?id=20323
[pear-20346]: https://pear.php.net/bugs/bug.php?id=20346
[pear-20355]: https://pear.php.net/bugs/bug.php?id=20355

## [2.0.0a2] - 2014-05-01

### Changed
- Added report type --report=info to show information about the checked code to make building a standard easier
    - Checks a number of things, such as what line length you use, and spacing are brackets, but not everything
    - Still highly experimental
- Generic LineLengthSniff now shows warnings for long lines referring to licence and VCS information
    - It previously ignored these lines, but at the expense of performance
- Generic DisallowTabIndent and DisallowSpaceIndent sniffs no longer error when detecting mixed indent types
    - Only the first type of indent found on a line (space or indent) is considered
- Lots of little performance improvements that can add up to a substantial saving over large code bases
    - Added a "length" array index to tokens so you don't need to call strlen() of them, or deal with encoding
    - Can now use isset() to find tokens inside the PHP_CodeSniffer_Tokens static vars instead of in_array()
- Custom reports can now specify a $recordErrors member var; this previously only worked for built-in reports
    - When set to FALSE, error messages will not be recorded and only totals will be returned
    - This can save significant memory while processing a large code base
- Removed dependence on PHP_Timer
- PHP tokenizer now supports DEFAULT statements opened with a T_SEMICOLON
- The Squiz and PHPCS standards have increased the max padding for statement alignment from 8 to 12
- Squiz EchoedStringsSniff now supports statements without a semicolon, such as PHP embedded in HTML
- Squiz DoubleQuoteUsageSniff now properly replaces escaped double quotes when fixing a doubled quoted string
- Improved detection of nested IF statements that use the alternate IF/ENDIF syntax
- PSR1 CamelCapsMethodNameSniff now ignores magic methods
    - Thanks to [Eser Ozvataf][@eser] for the patch
- PSR1 SideEffectsSniff now ignores methods named define()
- PSR1 and PEAR ClassDeclarationSniffs now support traits (request [#20208][pear-20208])
- PSR2 ControlStructureSpacingSniff now allows newlines before/after parentheses
    - Thanks to [Maurus Cuelenaere][@mcuelenaere] for the patch
- PSR2 ControlStructureSpacingSniff now checks TRY and CATCH statements
- Squiz SuperfluousWhitespaceSniff now detects whitespace at the end of block comment lines
    - Thanks to [Klaus Purer][@klausi] for the patch
- Squiz LowercasePHPFunctionsSniff no longer reports errors for namespaced functions
    - Thanks to [Max Galbusera][@maxgalbu] for the patch
- Squiz SwitchDeclarationSniff now allows exit() as a breaking statement for case/default
- Squiz ValidVariableNameSniff and Zend ValidVariableNameSniff now ignore additional PHP reserved vars
    - Thanks to Mikuláš Dítě and Adrian Crepaz for the patch
- Sniff code Squiz.WhiteSpace.MemberVarSpacing.After changed to Squiz.WhiteSpace.MemberVarSpacing.Incorrect (request [#20241][pear-20241])

### Fixed
- Fixed bug [#20200][pear-20200] : Invalid JSON produced with specific error message
- Fixed bug [#20204][pear-20204] : Ruleset exclude checks are case sensitive
- Fixed bug [#20213][pear-20213] : Invalid error, Inline IF must be declared on single line
- Fixed bug [#20225][pear-20225] : array_merge() that takes more than one line generates error
- Fixed bug [#20230][pear-20230] : Squiz ControlStructureSpacing sniff assumes specific condition formatting
- Fixed bug [#20234][pear-20234] : phpcbf patch command absolute paths
- Fixed bug [#20240][pear-20240] : Squiz block comment sniff fails when newline present
- Fixed bug [#20247][pear-20247] : The Squiz.WhiteSpace.ControlStructureSpacing sniff and do-while
    - Thanks to [Alexander Obuhovich][@aik099] for the patch
- Fixed bug [#20248][pear-20248] : The Squiz_Sniffs_WhiteSpace_ControlStructureSpacingSniff sniff and empty scope
- Fixed bug [#20252][pear-20252] : Unitialized string offset when package name starts with underscore

[pear-20200]: https://pear.php.net/bugs/bug.php?id=20200
[pear-20204]: https://pear.php.net/bugs/bug.php?id=20204
[pear-20208]: https://pear.php.net/bugs/bug.php?id=20208
[pear-20213]: https://pear.php.net/bugs/bug.php?id=20213
[pear-20225]: https://pear.php.net/bugs/bug.php?id=20225
[pear-20230]: https://pear.php.net/bugs/bug.php?id=20230
[pear-20234]: https://pear.php.net/bugs/bug.php?id=20234
[pear-20240]: https://pear.php.net/bugs/bug.php?id=20240
[pear-20241]: https://pear.php.net/bugs/bug.php?id=20241
[pear-20247]: https://pear.php.net/bugs/bug.php?id=20247
[pear-20248]: https://pear.php.net/bugs/bug.php?id=20248
[pear-20252]: https://pear.php.net/bugs/bug.php?id=20252

## [2.0.0a1] - 2014-02-05

### Changed
- Added the phpcbf script to automatically fix many errors found by the phpcs script
- Added report type --report=diff to show suggested changes to fix coding standard violations
- The --report argument now allows for custom reports to be used
    - Use the full path to your custom report class as the report name
- The --extensions argument is now respected when passing filenames; not just with directories
- The --extensions argument now allows you to specify the tokenizer for each extension
    - e.g., `--extensions=module/php,es/js`
- Command line arguments can now be set in ruleset files
    - e.g., `arg name="report" value="summary"` (print summary report; same as `--report=summary`)
    - e.g., `arg value="sp"` (print source and progress information; same as `-sp`)
    - The `-vvv`, `--sniffs`, `--standard` and `-l` command line arguments cannot be set in this way
- Sniff process() methods can now optionally return a token to ignore up to
    - If returned, the sniff will not be executed again until the passed token is reached in the file
    - Useful if you are looking for tokens like T_OPEN_TAG but only want to process the first one
- Removed the comment parser classes and replaced it with a simple comment tokenizer
    - T_DOC_COMMENT tokens are now tokenized into T_DOC_COMMENT_* tokens so they can be used more easily
    - This change requires a significant rewrite of sniffs that use the comment parser
    - This change requires minor changes to sniffs that listen for T_DOC_COMMENT tokens directly
- Added Generic DocCommentSniff to check generic doc block formatting
    - Removed doc block formatting checks from PEAR ClassCommentSniff
    - Removed doc block formatting checks from PEAR FileCommentSniff
    - Removed doc block formatting checks from PEAR FunctionCommentSniff
    - Removed doc block formatting checks from Squiz ClassCommentSniff
    - Removed doc block formatting checks from Squiz FileCommentSniff
    - Removed doc block formatting checks from Squiz FunctionCommentSniff
    - Removed doc block formatting checks from Squiz VariableCommentSniff
- Squiz DocCommentAlignmentSniff has had its error codes changed
    - NoSpaceBeforeTag becomes NoSpaceAfterStar
    - SpaceBeforeTag becomes SpaceAfterStar
    - SpaceBeforeAsterisk becomes SpaceBeforeStar
- Generic MultipleStatementAlignment now aligns assignments within a block so they fit within their max padding setting
    - The sniff previously requested the padding as 1 space if max padding was exceeded
    - It now aligns the assignment with surrounding assignments if it can
    - Removed property ignoreMultiline as multi-line assignments are now handled correctly and should not be ignored
- Squiz FunctionClosingBraceSpaceSniff now requires a blank line before the brace in all cases except function args
- Added error Squiz.Commenting.ClassComment.SpacingAfter to ensure there are no blank lines after a class comment
- Added error Squiz.WhiteSpace.MemberVarSpacing.AfterComment to ensure there are no blank lines after a member var comment
    - Fixes have also been corrected to not strip the member var comment or indent under some circumstances
    - Thanks to [Mark Scherer][@dereuromark] for help with this fix
- Added error Squiz.Commenting.FunctionCommentThrowTag.Missing to ensure a throw is documented
- Removed error Squiz.Commenting.FunctionCommentThrowTag.WrongType
- Content passed via STDIN can now specify the filename to use so that sniffs can run the correct filename checks
    - Ensure the first line of the content is: phpcs_input_file: /path/to/file
- Squiz coding standard now enforces no closing PHP tag at the end of a pure PHP file
- Squiz coding standard now enforces a single newline character at the end of the file
- Squiz ClassDeclarationSniff no longer checks for a PHP ending tag after a class definition
- Squiz ControlStructureSpacingSniff now checks TRY and CATCH statements as well
- Removed MySource ChannelExceptionSniff


<!--
=== Link list for release links ====
-->

[2.9.2]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.9.1...2.9.2
[2.9.1]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.9.0...2.9.1
[2.9.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.8.1...2.9.0
[2.8.1]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.8.0...2.8.1
[2.8.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.7.1...2.8.0
[2.7.1]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.7.0...2.7.1
[2.7.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.6.2...2.7.0
[2.6.2]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.6.1...2.6.2
[2.6.1]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.6.0...2.6.1
[2.6.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.5.1...2.6.0
[2.5.1]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.5.0...2.5.1
[2.5.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.4.0...2.5.0
[2.4.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.3.4...2.4.0
[2.3.4]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.3.3...2.3.4
[2.3.3]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.3.2...2.3.3
[2.3.2]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.3.1...2.3.2
[2.3.1]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.3.0...2.3.1
[2.3.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.2.0...2.3.0
[2.2.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.1.0...2.2.0
[2.1.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.0.0...2.1.0
[2.0.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.0.0RC4...2.0.0
[2.0.0RC4]:   https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.0.0RC3...2.0.0RC4
[2.0.0RC3]:   https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.0.0RC2...2.0.0RC3
[2.0.0RC2]:   https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.0.0RC1...2.0.0RC2
[2.0.0RC1]:   https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.0.0a2...2.0.0RC1
[2.0.0a2]:    https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/2.0.0a1...2.0.0a2
[2.0.0a1]:    https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.6...2.0.0a1


<!--
=== Link list for contributor profiles ====
-->

[@2shediac]:            https://github.com/2shediac
[@ablyler]:             https://github.com/ablyler
[@aboks]:               https://github.com/aboks
[@abulford]:            https://github.com/abulford
[@aik099]:              https://github.com/aik099
[@akarmazyn]:           https://github.com/akarmazyn
[@AlexHowansky]:        https://github.com/AlexHowansky
[@andrei-propertyguru]: https://github.com/andrei-propertyguru
[@bayleedev]:           https://github.com/bayleedev
[@bkdotcom]:            https://github.com/bkdotcom
[@claylo]:              https://github.com/claylo
[@danez]:               https://github.com/danez
[@david-binda]:         https://github.com/david-binda
[@Decave]:              https://github.com/Decave
[@dereuromark]:         https://github.com/dereuromark
[@deviantintegral]:     https://github.com/deviantintegral
[@donatj]:              https://github.com/donatj
[@dschniepp]:           https://github.com/dschniepp
[@ElvenSpellmaker]:     https://github.com/ElvenSpellmaker
[@eser]:                https://github.com/eser
[@fabre-thibaud]:       https://github.com/fabre-thibaud
[@GaryJones]:           https://github.com/GaryJones
[@ghunti]:              https://github.com/ghunti
[@grzr]:                https://github.com/grzr
[@hernst42]:            https://github.com/hernst42
[@jasonmccreary]:       https://github.com/jasonmccreary
[@JDGrimes]:            https://github.com/JDGrimes
[@jedgell]:             https://github.com/jedgell
[@jmarcil]:             https://github.com/jmarcil
[@joelposti]:           https://github.com/joelposti
[@johanderuijter]:      https://github.com/johanderuijter
[@johnmaguire]:         https://github.com/johnmaguire
[@joshdavis11]:         https://github.com/joshdavis11
[@jrfnl]:               https://github.com/jrfnl
[@kenguest]:            https://github.com/kenguest
[@klausi]:              https://github.com/klausi
[@Konafets]:            https://github.com/Konafets
[@kukulich]:            https://github.com/kukulich
[@legoktm]:             https://github.com/legoktm
[@localheinz]:          https://github.com/localheinz
[@MacDada]:             https://github.com/MacDada
[@MarkMaldaba]:         https://github.com/MarkMaldaba
[@martinssipenko]:      https://github.com/martinssipenko
[@mathroc]:             https://github.com/mathroc
[@maxgalbu]:            https://github.com/maxgalbu
[@mcuelenaere]:         https://github.com/mcuelenaere
[@michaelbutler]:       https://github.com/michaelbutler
[@michalbundyra]:       https://github.com/michalbundyra
[@NickDickinsonWilde]:  https://github.com/NickDickinsonWilde
[@nkovacs]:             https://github.com/nkovacs
[@ofbeaton]:            https://github.com/ofbeaton
[@olemartinorg]:        https://github.com/olemartinorg
[@ondrejmirtes]:        https://github.com/ondrejmirtes
[@orx0r]:               https://github.com/orx0r
[@pfrenssen]:           https://github.com/pfrenssen
[@photodude]:           https://github.com/photodude
[@realmfoo]:            https://github.com/realmfoo
[@renan]:               https://github.com/renan
[@rhorber]:             https://github.com/rhorber
[@rmccue]:              https://github.com/rmccue
[@samlev]:              https://github.com/samlev
[@scato]:               https://github.com/scato
[@schnittstabil]:       https://github.com/schnittstabil
[@sertand]:             https://github.com/sertand
[@sserbin]:             https://github.com/sserbin
[@stefanlenselink]:     https://github.com/stefanlenselink
[@syranez]:             https://github.com/syranez
[@tim-bezhashvyly]:     https://github.com/tim-bezhashvyly
[@thomasjfox]:          https://github.com/thomasjfox
[@uniquexor]:           https://github.com/uniquexor
[@VasekPurchart]:       https://github.com/VasekPurchart
[@westonruter]:         https://github.com/westonruter
[@willemstuursma]:      https://github.com/willemstuursma
[@xalopp]:              https://github.com/xalopp
[@xt99]:                https://github.com/xt99
