# Changelog

The file documents changes to the PHP_CodeSniffer project for the 1.x series of releases.

## [1.5.6] - 2014-12-05

### Changed
- JS tokenizer now detects xor statements correctly
- The --config-show command now pretty-prints the config values
    - Thanks to [Ken Guest][@kenguest] for the patch
- Setting and removing config values now catches exceptions if the config file is not writable
    - Thanks to [Ken Guest][@kenguest] for the patch
- Setting and removing config values now prints a message to confirm the action and show old values
- You can now get PHP_CodeSniffer to ignore a single line by putting @codingStandardsIgnoreLine in a comment
    - When the comment is found, the comment line and the following line will be ignored
    - Thanks to [Andy Bulford][@abulford] for the contribution
- Generic ConstructorNameSniff no longer errors for PHP4 style constructors when __construct() is present
    - Thanks to [Thibaud Fabre][@fabre-thibaud] for the patch

### Fixed
- Fixed bug [#280][sq-280] : The --config-show option generates error when there is no config file
- Fixed bug [#306][sq-306] : File containing only a namespace declaration raises undefined index notice
- Fixed bug [#308][sq-308] : Squiz InlineIfDeclarationSniff fails on ternary operators inside closure
- Fixed bug [#310][sq-310] : Variadics not recognized by tokenizer
- Fixed bug [#311][sq-311] : Suppression of function prototype breaks checking of lines within function

[sq-280]: https://github.com/squizlabs/PHP_CodeSniffer/issues/280
[sq-306]: https://github.com/squizlabs/PHP_CodeSniffer/issues/306
[sq-308]: https://github.com/squizlabs/PHP_CodeSniffer/issues/308
[sq-310]: https://github.com/squizlabs/PHP_CodeSniffer/issues/310
[sq-311]: https://github.com/squizlabs/PHP_CodeSniffer/issues/311

## [1.5.5] - 2014-09-25

### Changed
- PHP tokenizer no longer converts class/function names to special tokens types
    - Class/function names such as parent and true would become special tokens such as T_PARENT and T_TRUE
- Improved closure support in Generic ScopeIndentSniff
- Improved indented PHP tag support in Generic ScopeIndentSniff
- Generic CamelCapsFunctionNameSniff now ignores a single leading underscore
    - Thanks to [Alex Slobodiskiy][@xt99] for the patch
- Standards can now be located within hidden directories (further fix for bug [#20323][pear-20323])
    - Thanks to [Klaus Purer][@klausi] for the patch
- Added Generic SyntaxSniff to check for syntax errors in PHP files
    - Thanks to [Blaine Schmeisser][@bayleedev] for the contribution
- Squiz DiscouragedFunctionsSniff now warns about var_dump()
- PEAR ValidFunctionNameSniff no longer throws an error for _()
- Squiz and PEAR FunctionCommentSnif now support _()
- Generic UpperCaseConstantSniff and LowerCaseConstantSniff now ignore function names

### Fixed
- Fixed bug [#248][sq-248] : FunctionCommentSniff expects ampersand on param name
- Fixed bug [#265][sq-265] : False positives with type hints in ForbiddenFunctionsSniff
- Fixed bug [#20373][pear-20373] : Inline comment sniff tab handling way
- Fixed bug [#20378][pear-20378] : Report appended to existing file if no errors found in run
- Fixed bug [#20381][pear-20381] : Invalid "Comment closer must be on a new line"
    - Thanks to [Brad Kent][@bkdotcom] for the patch
- Fixed bug [#20386][pear-20386] : Squiz.Commenting.ClassComment.SpacingBefore thrown if first block comment

[sq-248]: https://github.com/squizlabs/PHP_CodeSniffer/issues/248
[sq-265]: https://github.com/squizlabs/PHP_CodeSniffer/pull/265
[pear-20373]: https://pear.php.net/bugs/bug.php?id=20373
[pear-20378]: https://pear.php.net/bugs/bug.php?id=20378
[pear-20381]: https://pear.php.net/bugs/bug.php?id=20381
[pear-20386]: https://pear.php.net/bugs/bug.php?id=20386

## [1.5.4] - 2014-08-06

### Changed
- Removed use of sys_get_temp_dir() as this is not supported by the min PHP version
- The installed_paths config var now accepts relative paths
    - The paths are relative to the PHP_CodeSniffer install directory
    - Thanks to [Weston Ruter][@westonruter] for the patch
- Generic ScopeIndentSniff now accounts for different open tag indents
- PEAR FunctionDeclarationSniff now ignores short arrays when checking indent
    - Thanks to [Daniel Tschinder][@danez] for the patch
- PSR2 FunctionCallSignatureSniff now treats multi-line strings as a single-line argument, like arrays and closures
    - Thanks to [Dawid Nowak][@MacDada] for the patch
- Generic ForbiddenFunctionsSniff now detects calls to functions in the global namespace
    - Thanks to [Ole Martin Handeland][@olemartinorg] for the patch
- Generic LowerCaseConstantSniff and UpperCaseConstantSniff now ignore namespaces beginning with TRUE/FALSE/NULL
    - Thanks to [Renan Gonçalves][@renan] for the patch
- Squiz InlineCommentSniff no longer requires a blank line after post-statement comments (request [#20299][pear-20299])
- Squiz SelfMemberReferenceSniff now works correctly with namespaces
- Tab characters are now encoded in abstract pattern error messages
    - Thanks to [Blaine Schmeisser][@bayleedev] for the patch
- Invalid sniff codes passed to --sniffs now show a friendly error message (request [#20313][pear-20313])
- Generic LineLengthSniff now shows a warning if the iconv module is disabled (request [#20314][pear-20314])
- Source report no longer shows errors if category or sniff names ends in an uppercase error
    - Thanks to [Jonathan Marcil][@jmarcil] for the patch

### Fixed
- Fixed bug [#20268][pear-20268] : Incorrect documentation titles in PEAR documentation
- Fixed bug [#20296][pear-20296] : new array notion in function comma check fails
- Fixed bug [#20307][pear-20307] : PHP_CodeSniffer_Standards_AbstractVariableSniff analyze traits
- Fixed bug [#20308][pear-20308] : Squiz.ValidVariableNameSniff - wrong variable usage
- Fixed bug [#20309][pear-20309] : Use "member variable" term in sniff "processMemberVar" method
- Fixed bug [#20310][pear-20310] : PSR2 does not check for space after function name
- Fixed bug [#20322][pear-20322] : Display rules set to type=error even when suppressing warnings
- Fixed bug [#20323][pear-20323] : PHPCS tries to load sniffs from hidden directories

[pear-20268]: https://pear.php.net/bugs/bug.php?id=20268
[pear-20296]: https://pear.php.net/bugs/bug.php?id=20296
[pear-20299]: https://pear.php.net/bugs/bug.php?id=20299
[pear-20307]: https://pear.php.net/bugs/bug.php?id=20307
[pear-20308]: https://pear.php.net/bugs/bug.php?id=20308
[pear-20309]: https://pear.php.net/bugs/bug.php?id=20309
[pear-20310]: https://pear.php.net/bugs/bug.php?id=20310
[pear-20313]: https://pear.php.net/bugs/bug.php?id=20313
[pear-20314]: https://pear.php.net/bugs/bug.php?id=20314
[pear-20322]: https://pear.php.net/bugs/bug.php?id=20322
[pear-20323]: https://pear.php.net/bugs/bug.php?id=20323

## [1.5.3] - 2014-05-01

### Changed
- Improved detection of nested IF statements that use the alternate IF/ENDIF syntax
- PHP tokenizer now supports DEFAULT statements opened with a T_SEMICOLON
- PSR1 CamelCapsMethodNameSniff now ignores magic methods
    - Thanks to [Eser Ozvataf][@eser] for the patch
- PSR1 SideEffectsSniff now ignores methods named define()
- PSR1 and PEAR ClassDeclarationSniffs now support traits (request [#20208][pear-20208])
- PSR2 ControlStructureSpacingSniff now allows newlines before/after parentheses
    - Thanks to [Maurus Cuelenaere][@mcuelenaere] for the patch
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
- Fixed bug [#20240][pear-20240] : Squiz block comment sniff fails when newline present
- Fixed bug [#20247][pear-20247] : The Squiz.WhiteSpace.ControlStructureSpacing sniff and do-while
    - Thanks to [Alexander Obuhovich][@aik099] for the patch
- Fixed bug [#20248][pear-20248] : The Squiz_Sniffs_WhiteSpace_ControlStructureSpacingSniff sniff and empty scope
- Fixed bug [#20252][pear-20252] : Uninitialized string offset when package name starts with underscore

[pear-20200]: https://pear.php.net/bugs/bug.php?id=20200
[pear-20204]: https://pear.php.net/bugs/bug.php?id=20204
[pear-20208]: https://pear.php.net/bugs/bug.php?id=20208
[pear-20213]: https://pear.php.net/bugs/bug.php?id=20213
[pear-20225]: https://pear.php.net/bugs/bug.php?id=20225
[pear-20230]: https://pear.php.net/bugs/bug.php?id=20230
[pear-20240]: https://pear.php.net/bugs/bug.php?id=20240
[pear-20241]: https://pear.php.net/bugs/bug.php?id=20241
[pear-20247]: https://pear.php.net/bugs/bug.php?id=20247
[pear-20248]: https://pear.php.net/bugs/bug.php?id=20248
[pear-20252]: https://pear.php.net/bugs/bug.php?id=20252

## [1.5.2] - 2014-02-05

### Changed
- Improved support for the PHP 5.5. classname::class syntax
    - PSR2 SwitchDeclarationSniff no longer throws errors when this syntax is used in CASE conditions
- Improved support for negative checks of instanceOf in Squiz ComparisonOperatorUsageSniff
    - Thanks to [Martin Winkel][@storeman] for the patch
- Generic FunctionCallArgumentSpacingSniff now longer complains about space before comma when using here/nowdocs
    - Thanks to [Richard van Velzen][@rvanvelzen] for the patch
- Generic LowerCaseConstantSniff and UpperCaseConstantSniff now ignore class constants
    - Thanks to [Kristopher Wilson][@mrkrstphr] for the patch
- PEAR FunctionCallSignatureSniff now has settings to specify how many spaces should appear before/after parentheses
    - Override the 'requiredSpacesAfterOpen' and 'requiredSpacesBeforeClose' settings in a ruleset.xml file to change
    - Default remains at 0 for both
    - Thanks to [Astinus Eberhard][@Astinus-Eberhard] for the patch
- PSR2 ControlStructureSpacingSniff now has settings to specify how many spaces should appear before/after parentheses
    - Override the 'requiredSpacesAfterOpen' and 'requiredSpacesBeforeClose' settings in a ruleset.xml file to change
    - Default remains at 0 for both
    - Thanks to [Astinus Eberhard][@Astinus-Eberhard] for the patch
- Squiz ForEachLoopDeclarationSniff now has settings to specify how many spaces should appear before/after parentheses
    - Override the 'requiredSpacesAfterOpen' and 'requiredSpacesBeforeClose' settings in a ruleset.xml file to change
    - Default remains at 0 for both
    - Thanks to [Astinus Eberhard][@Astinus-Eberhard] for the patch
- Squiz ForLoopDeclarationSniff now has settings to specify how many spaces should appear before/after parentheses
    - Override the 'requiredSpacesAfterOpen' and 'requiredSpacesBeforeClose' settings in a ruleset.xml file to change
    - Default remains at 0 for both
    - Thanks to [Astinus Eberhard][@Astinus-Eberhard] for the patch
- Squiz FunctionDeclarationArgumentSpacingSniff now has settings to specify how many spaces should appear before/after parentheses
    - Override the 'requiredSpacesAfterOpen' and 'requiredSpacesBeforeClose' settings in a ruleset.xml file to change
    - Default remains at 0 for both
    - Thanks to [Astinus Eberhard][@Astinus-Eberhard] for the patch
- Removed UnusedFunctionParameter, CyclomaticComplexity and NestingLevel from the Squiz standard
- Generic FixmeSniff and TodoSniff now work correctly with accented characters

### Fixed
- Fixed bug [#20145][pear-20145] : Custom ruleset preferences directory over installed standard
- Fixed bug [#20147][pear-20147] : phpcs-svn-pre-commit - no more default error report
- Fixed bug [#20151][pear-20151] : Problem handling "if(): ... else: ... endif;" syntax
- Fixed bug [#20190][pear-20190] : Invalid regex in Squiz_Sniffs_WhiteSpace_SuperfluousWhitespaceSniff

[pear-20145]: https://pear.php.net/bugs/bug.php?id=20145
[pear-20147]: https://pear.php.net/bugs/bug.php?id=20147
[pear-20151]: https://pear.php.net/bugs/bug.php?id=20151
[pear-20190]: https://pear.php.net/bugs/bug.php?id=20190

## [1.5.1] - 2013-12-12

### Changed
- Config values can now be set at runtime using the command line argument `--runtime-set key value`
    - Runtime values are the same as config values, but are not written to the main config file
    - Thanks to [Wim Godden][@wimg] for the patch
- Config values can now be set in ruleset files
    - e.g., config name="zend_ca_path" value="/path/to/ZendCodeAnalyzer"
    - Can not be used to set config values that override command line values, such as show_warnings
    - Thanks to [Jonathan Marcil][@jmarcil] for helping with the patch
- Added a new installed_paths config value to allow for the setting of directories that contain standards
    - By default, standards have to be installed into the CodeSniffer/Standards directory to be considered installed
    - New config value allows a list of paths to be set in addition to this internal path
    - Installed standards appear when using the -i arg, and can be referenced in rulesets using only their name
    - Set paths by running: phpcs --config-set installed_paths /path/one,/path/two,...
- PSR2 ClassDeclarationSniff now allows a list of extended interfaces to be split across multiple lines
- Squiz DoubleQuoteUsageSniff now allows \b in double quoted strings
- Generic ForbiddenFunctionsSniff now ignores object creation
    - This is a further fix for bug [#20100][pear-20100] : incorrect Function mysql() has been deprecated report

### Fixed
- Fixed bug [#20136][pear-20136] : Squiz_Sniffs_WhiteSpace_ScopeKeywordSpacingSniff and Traits
- Fixed bug [#20138][pear-20138] : Protected property underscore and camel caps issue (in trait with Zend)
    - Thanks to [Gaetan Rousseau][@Naelyth] for the patch
- Fixed bug [#20139][pear-20139] : No report file generated on success

[pear-20136]: https://pear.php.net/bugs/bug.php?id=20136
[pear-20138]: https://pear.php.net/bugs/bug.php?id=20138
[pear-20139]: https://pear.php.net/bugs/bug.php?id=20139

## [1.5.0] - 2013-11-28

### Changed
- Doc generation is now working again for installed standards
    - Includes a fix for limiting the docs to specific sniffs
- Generic ScopeIndentSniff now allows for ignored tokens to be set via ruleset.xml files
    - E.g., to ignore comments, override a property using:
    - name="ignoreIndentationTokens" type="array" value="T_COMMENT,T_DOC_COMMENT"
- PSR2 standard now ignores comments when checking indentation rules
- Generic UpperCaseConstantNameSniff no longer reports errors where constants are used (request [#20090][pear-20090])
    - It still reports errors where constants are defined
- Individual messages can now be excluded in ruleset.xml files using the exclude tag (request [#20091][pear-20091])
    - Setting message severity to 0 continues to be supported
- Squiz OperatorSpacingSniff no longer throws errors for the ?: short ternary operator
    - Thanks to [Antoine Musso][@hashar] for the patch
- Comment parser now supports non-English characters when splitting comment lines into words
    - Thanks to [Nik Sun][@CandySunPlus] for the patch
- Exit statements are now recognised as valid closers for CASE and DEFAULT blocks
    - Thanks to [Maksim Kochkin][@ksimka] for the patch
- PHP_CodeSniffer_CLI::process() can now be passed an incomplete array of CLI values
    - Missing values will be set to the CLI defaults
    - Thanks to [Maksim Kochkin][@ksimka] for the patch

### Fixed
- Fixed bug [#20093][pear-20093] : Bug with ternary operator token
- Fixed bug [#20097][pear-20097] : `CLI.php` throws error in PHP 5.2
- Fixed bug [#20100][pear-20100] : incorrect Function mysql() has been deprecated report
- Fixed bug [#20119][pear-20119] : PHP warning: invalid argument to str_repeat() in SVN blame report with -s
- Fixed bug [#20123][pear-20123] : PSR2 complains about an empty second statement in for-loop
- Fixed bug [#20131][pear-20131] : PHP errors in svnblame report, if there are files not under version control
- Fixed bug [#20133][pear-20133] : Allow "HG: hg_id" as value for @version tag

[pear-20090]: https://pear.php.net/bugs/bug.php?id=20090
[pear-20091]: https://pear.php.net/bugs/bug.php?id=20091
[pear-20093]: https://pear.php.net/bugs/bug.php?id=20093

## [1.4.8] - 2013-11-26

### Changed
- Generic ScopeIndentSniff now allows for ignored tokens to be set via ruleset.xml files
    - E.g., to ignore comments, override a property using:
    - name="ignoreIndentationTokens" type="array" value="T_COMMENT,T_DOC_COMMENT"
- PSR2 standard now ignores comments when checking indentation rules
- Squiz OperatorSpacingSniff no longer throws errors for the ?: short ternary operator
    - Thanks to [Antoine Musso][@hashar] for the patch
- Comment parser now supports non-English characters when splitting comment lines into words
    - Thanks to [Nik Sun][@CandySunPlus] for the patch
- Exit statements are now recognised as valid closers for CASE and DEFAULT blocks
    - Thanks to [Maksim Kochkin][@ksimka] for the patch
- PHP_CodeSniffer_CLI::process() can now be passed an incomplete array of CLI values
    - Missing values will be set to the CLI defaults
    - Thanks to [Maksim Kochkin][@ksimka] for the patch

### Fixed
- Fixed bug [#20097][pear-20097] : `CLI.php` throws error in PHP 5.2
- Fixed bug [#20100][pear-20100] : incorrect Function mysql() has been deprecated report
- Fixed bug [#20119][pear-20119] : PHP warning: invalid argument to str_repeat() in SVN blame report with -s
- Fixed bug [#20123][pear-20123] : PSR2 complains about an empty second statement in for-loop
- Fixed bug [#20131][pear-20131] : PHP errors in svnblame report, if there are files not under version control
- Fixed bug [#20133][pear-20133] : Allow "HG: hg_id" as value for @version tag

[pear-20097]: https://pear.php.net/bugs/bug.php?id=20097
[pear-20100]: https://pear.php.net/bugs/bug.php?id=20100
[pear-20119]: https://pear.php.net/bugs/bug.php?id=20119
[pear-20123]: https://pear.php.net/bugs/bug.php?id=20123
[pear-20131]: https://pear.php.net/bugs/bug.php?id=20131
[pear-20133]: https://pear.php.net/bugs/bug.php?id=20133

## [1.5.0RC4] - 2013-09-26

### Changed
- You can now restrict violations to individual sniff codes using the --sniffs command line argument
    - Previously, this only restricted violations to an entire sniff and not individual messages
    - If you have scripts calling PHP_CodeSniffer::process() or creating PHP_CodeSniffer_File objects, you must update your code
    - The array of restrictions passed to PHP_CodeSniffer::process() must now be an array of sniff codes instead of class names
    - The PHP_CodeSniffer_File::__construct() method now requires an array of restrictions to be passed
- Doc generation is now working again
- Progress information now shows the percentage complete at the end of each line
- Added report type --report=junit to show the error list in a JUnit compatible format
    - Thanks to [Oleg Lobach][@bladeofsteel] for the contribution
- Added support for the PHP 5.4 callable type hint
- Fixed problem where some file content could be ignored when checking STDIN
- Version information is now printed when installed via composer or run from a Git clone (request [#20050][pear-20050])
- Added Squiz DisallowBooleanStatementSniff to ban boolean operators outside of control structure conditions
- The CSS tokenizer is now more reliable when encountering 'list' and 'break' strings
- Coding standard ignore comments can now appear instead doc blocks as well as inline comments
    - Thanks to [Stuart Langley][@sjlangley] for the patch
- Generic LineLengthSniff now ignores SVN URL and Head URL comments
    - Thanks to [Karl DeBisschop][@kdebisschop] for the patch
- PEAR MultiLineConditionSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the 'indent' setting in a ruleset.xml file to change
    - Thanks to [Szabolcs Sulik][@blerou] for the patch
- PEAR MultiLineAssignmentSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the 'indent' setting in a ruleset.xml file to change
    - Thanks to [Szabolcs Sulik][@blerou] for the patch
- PEAR FunctionDeclarationSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the 'indent' setting in a ruleset.xml file to change
    - Thanks to [Szabolcs Sulik][@blerou] for the patch
- Squiz SwitchDeclarationSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the 'indent' setting in a ruleset.xml file to change
    - Thanks to [Szabolcs Sulik][@blerou] for the patch
- Squiz CSS IndentationSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the 'indent' setting in a ruleset.xml file to change
    - Thanks to [Hugo Fonseca][@fonsecas72] for the patch
- Squiz and MySource File and Function comment sniffs now allow all tags and don't require a particular licence
- Squiz standard now allows lines to be 120 characters long before warning; up from 85
- Squiz LowercaseStyleDefinitionSniff no longer throws errors for class names in nested style definitions
- Squiz ClassFileNameSniff no longer throws errors when checking STDIN
- Squiz CSS sniffs no longer generate errors for IE filters
- Squiz CSS IndentationSniff no longer sees comments as blank lines
- Squiz LogicalOperatorSpacingSniff now ignores whitespace at the end of a line
- Squiz.Scope.MethodScope.Missing error message now mentions 'visibility' instead of 'scope modifier'
    - Thanks to [Renat Akhmedyanov][@r3nat] for the patch
- Added support for the PSR2 multi-line arguments errata
- The PSR2 standard no longer throws errors for additional spacing after a type hint
- PSR UseDeclarationSniff no longer throws errors for USE statements inside TRAITs

### Fixed
- Fixed cases where code was incorrectly assigned the T_GOTO_LABEL token when used in a complex CASE condition
- Fixed bug [#20026][pear-20026] : Check for multi-line arrays that should be single-line is slightly wrong
    - Adds new error message for single-line arrays that end with a comma
- Fixed bug [#20029][pear-20029] : ForbiddenFunction sniff incorrectly recognizes methods in USE clauses
- Fixed bug [#20043][pear-20043] : Mis-interpretation of Foo::class
- Fixed bug [#20044][pear-20044] : PSR1 camelCase check does not ignore leading underscores
- Fixed bug [#20045][pear-20045] : Errors about indentation for closures with multi-line 'use' in functions
- Fixed bug [#20051][pear-20051] : Undefined index: scope_opener / scope_closer
    - Thanks to [Anthon Pang][@robocoder] for the patch

[pear-20051]: https://pear.php.net/bugs/bug.php?id=20051

## [1.4.7] - 2013-09-26

### Changed
- Added report type --report=junit to show the error list in a JUnit compatible format
    - Thanks to [Oleg Lobach][@bladeofsteel] for the contribution
- Added support for the PHP 5.4 callable type hint
- Fixed problem where some file content could be ignored when checking STDIN
- Version information is now printed when installed via composer or run from a Git clone (request [#20050][pear-20050])
- The CSS tokenizer is now more reliable when encountering 'list' and 'break' strings
- Coding standard ignore comments can now appear instead doc blocks as well as inline comments
    - Thanks to [Stuart Langley][@sjlangley] for the patch
- Generic LineLengthSniff now ignores SVN URL and Head URL comments
    - Thanks to [Karl DeBisschop][@kdebisschop] for the patch
- PEAR MultiLineConditionSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the 'indent' setting in a ruleset.xml file to change
    - Thanks to [Szabolcs Sulik][@blerou] for the patch
- PEAR MultiLineAssignmentSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the 'indent' setting in a ruleset.xml file to change
    - Thanks to [Szabolcs Sulik][@blerou] for the patch
- PEAR FunctionDeclarationSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the 'indent' setting in a ruleset.xml file to change
    - Thanks to [Szabolcs Sulik][@blerou] for the patch
- Squiz SwitchDeclarationSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the 'indent' setting in a ruleset.xml file to change
    - Thanks to [Szabolcs Sulik][@blerou] for the patch
- Squiz CSS IndentationSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the 'indent' setting in a ruleset.xml file to change
    - Thanks to [Hugo Fonseca][@fonsecas72] for the patch
- Squiz and MySource File and Function comment sniffs now allow all tags and don't require a particular licence
- Squiz LowercaseStyleDefinitionSniff no longer throws errors for class names in nested style definitions
- Squiz ClassFileNameSniff no longer throws errors when checking STDIN
- Squiz CSS sniffs no longer generate errors for IE filters
- Squiz CSS IndentationSniff no longer sees comments as blank lines
- Squiz LogicalOperatorSpacingSniff now ignores whitespace at the end of a line
- Squiz.Scope.MethodScope.Missing error message now mentions 'visibility' instead of 'scope modifier'
    - Thanks to [Renat Akhmedyanov][@r3nat] for the patch
- Added support for the PSR2 multi-line arguments errata
- The PSR2 standard no longer throws errors for additional spacing after a type hint
- PSR UseDeclarationSniff no longer throws errors for USE statements inside TRAITs

### Fixed
- Fixed bug [#20026][pear-20026] : Check for multi-line arrays that should be single-line is slightly wrong
    - Adds new error message for single-line arrays that end with a comma
- Fixed bug [#20029][pear-20029] : ForbiddenFunction sniff incorrectly recognizes methods in USE clauses
- Fixed bug [#20043][pear-20043] : Mis-interpretation of Foo::class
- Fixed bug [#20044][pear-20044] : PSR1 camelCase check does not ignore leading underscores
- Fixed bug [#20045][pear-20045] : Errors about indentation for closures with multi-line 'use' in functions

[pear-20026]: https://pear.php.net/bugs/bug.php?id=20026
[pear-20029]: https://pear.php.net/bugs/bug.php?id=20029
[pear-20043]: https://pear.php.net/bugs/bug.php?id=20043
[pear-20044]: https://pear.php.net/bugs/bug.php?id=20044
[pear-20045]: https://pear.php.net/bugs/bug.php?id=20045
[pear-20050]: https://pear.php.net/bugs/bug.php?id=20050

## [1.5.0RC3] - 2013-07-25

### Changed
- Added report type --report=json to show the error list and total counts for all checked files
    - Thanks to [Jeffrey Fisher][@jeffslofish] for the contribution
- PHP_CodeSniffer::isCamelCaps now allows for acronyms at the start of a string if the strict flag is FALSE
    - acronyms are defined as at least 2 uppercase characters in a row
    - e.g., the following is now valid camel caps with strict set to FALSE: XMLParser
- The PHP tokenizer now tokenizes goto labels as T_GOTO_LABEL instead of T_STRING followed by T_COLON
- The JS tokenizer now has support for the T_THROW token
- Symlinked directories inside CodeSniffer/Standards and in ruleset.xml files are now supported
    - Only available since PHP 5.2.11 and 5.3.1
    - Thanks to [Maik Penz][@goatherd] for the patch
- The JS tokenizer now correctly identifies T_INLINE_ELSE tokens instead of leaving them as T_COLON
    - Thanks to [Arnout Boks][@aboks] for the patch
- Explaining a standard (phpcs -e) that uses namespaces now works correctly
- Restricting a check to specific sniffs (phpcs --sniffs=...) now works correctly with namespaced sniffs
    - Thanks to [Maik Penz][@goatherd] for the patch
- Docs added for the entire Generic standard, and many sniffs from other standards are now documented as well
    - Thanks to [Spencer Rinehart][@nubs] for the contribution
- Clearer error message for when the sniff class name does not match the directory structure
- Generated HTML docs now correctly show the open PHP tag in code comparison blocks
- Added Generic InlineHTMLSniff to ensure a file only contains PHP code
- Added Squiz ShorthandSizeSniff to check that CSS sizes are using shorthand notation only when 1 or 2 values are used
- Added Squiz ForbiddenStylesSniff to ban the use of some deprecated browser-specific styles
- Added Squiz NamedColoursSniff to ban the use of colour names
- PSR2 standard no longer enforces no whitespace between the closing parenthesis of a function call and the semicolon
- PSR2 ClassDeclarationSniff now ignores empty classes when checking the end brace position
- PSR2 SwitchDeclarationSniff no longer reports errors for empty lines between CASE statements
- PEAR ObjectOperatorIndentSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the indent setting in a ruleset.xml file to change
    - Thanks to [Andrey Mindubaev][@covex-nn] for the patch
- Squiz FileExtensionSniff now supports traits
    - Thanks to [Lucas Green][@mythril] for the patch
- Squiz ArrayDeclarationSniff no longer reports errors for no comma at the end of a line that contains a function call
- Squiz SwitchDeclarationSniff now supports T_CONTINUE and T_THROW as valid case/default breaking statements
- Squiz CommentedOutCodeSniff is now better at ignoring commented out HTML, XML and regular expressions
- Squiz DisallowComparisonAssignmentSniff no longer throws errors for the third expression in a FOR statement
- Squiz ColourDefinitionSniff no longer throws errors for some CSS class names
- Squiz ControlStructureSpacingSniff now supports all types of CASE/DEFAULT breaking statements
- Generic CallTimePassByReferenceSniff now reports errors for functions called using a variable
    - Thanks to [Maik Penz][@goatherd] for the patch
- Generic ConstructorNameSniff no longer throws a notice for abstract constructors inside abstract classes
    - Thanks to [Spencer Rinehart][@nubs] for the patch
- Squiz ComparisonOperatorUsageSniff now checks inside elseif statements
    - Thanks to [Arnout Boks][@aboks] for the patch
- Squiz OperatorSpacingSniff now reports errors for no spacing around inline then and else tokens
    - Thanks to [Arnout Boks][@aboks] for the patch

### Fixed
- Fixed bug [#19811][pear-19811] : Comments not ignored in all cases in AbstractPatternSniff
    - Thanks to [Erik Wiffin][@erikwiffin] for the patch
- Fixed bug [#19892][pear-19892] : ELSE with no braces causes incorrect SWITCH break statement indentation error
- Fixed bug [#19897][pear-19897] : Indenting warnings in templates not consistent
- Fixed bug [#19908][pear-19908] : PEAR MultiLineCondition Does Not Apply elseif
- Fixed bug [#19930][pear-19930] : option --report-file generate an empty file
- Fixed bug [#19935][pear-19935] : notify-send reports do not vanish in gnome-shell
    - Thanks to [Christian Weiske][@cweiske] for the patch
- Fixed bug [#19944][pear-19944] : docblock squiz sniff "return void" trips over return in lambda function
- Fixed bug [#19953][pear-19953] : PSR2 - Spaces before interface name for abstract class
- Fixed bug [#19956][pear-19956] : phpcs warns for Type Hint missing Resource
- Fixed bug [#19957][pear-19957] : Does not understand trait method aliasing
- Fixed bug [#19968][pear-19968] : Permission denied on excluded directory
- Fixed bug [#19969][pear-19969] : Sniffs with namespace not recognized in reports
- Fixed bug [#19997][pear-19997] : Class names incorrectly detected as constants

[pear-19930]: https://pear.php.net/bugs/bug.php?id=19930

## [1.4.6] - 2013-07-25

### Changed
- Added report type --report=json to show the error list and total counts for all checked files
    - Thanks to [Jeffrey Fisher][@jeffslofish] for the contribution
- The JS tokenizer now has support for the T_THROW token
- Symlinked directories inside CodeSniffer/Standards and in ruleset.xml files are now supported
    - Only available since PHP 5.2.11 and 5.3.1
    - Thanks to [Maik Penz][@goatherd] for the patch
- The JS tokenizer now correctly identifies T_INLINE_ELSE tokens instead of leaving them as T_COLON
    - Thanks to [Arnout Boks][@aboks] for the patch
- Explaining a standard (phpcs -e) that uses namespaces now works correctly
- Restricting a check to specific sniffs (phpcs --sniffs=...) now works correctly with namespaced sniffs
    - Thanks to [Maik Penz][@goatherd] for the patch
- Docs added for the entire Generic standard, and many sniffs from other standards are now documented as well
    - Thanks to [Spencer Rinehart][@nubs] for the contribution
- Clearer error message for when the sniff class name does not match the directory structure
- Generated HTML docs now correctly show the open PHP tag in code comparison blocks
- Added Generic InlineHTMLSniff to ensure a file only contains PHP code
- Added Squiz ShorthandSizeSniff to check that CSS sizes are using shorthand notation only when 1 or 2 values are used
- Added Squiz ForbiddenStylesSniff to ban the use of some deprecated browser-specific styles
- Added Squiz NamedColoursSniff to ban the use of colour names
- PSR2 standard no longer enforces no whitespace between the closing parenthesis of a function call and the semicolon
- PSR2 ClassDeclarationSniff now ignores empty classes when checking the end brace position
- PSR2 SwitchDeclarationSniff no longer reports errors for empty lines between CASE statements
- PEAR ObjectOperatorIndentSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the indent setting in a ruleset.xml file to change
    - Thanks to [Andrey Mindubaev][@covex-nn] for the patch
- Squiz FileExtensionSniff now supports traits
    - Thanks to [Lucas Green][@mythril] for the patch
- Squiz ArrayDeclarationSniff no longer reports errors for no comma at the end of a line that contains a function call
- Squiz SwitchDeclarationSniff now supports T_CONTINUE and T_THROW as valid case/default breaking statements
- Squiz CommentedOutCodeSniff is now better at ignoring commented out HTML, XML and regular expressions
- Squiz DisallowComparisonAssignmentSniff no longer throws errors for the third expression in a FOR statement
- Squiz ColourDefinitionSniff no longer throws errors for some CSS class names
- Squiz ControlStructureSpacingSniff now supports all types of CASE/DEFAULT breaking statements
- Generic CallTimePassByReferenceSniff now reports errors for functions called using a variable
    - Thanks to [Maik Penz][@goatherd] for the patch
- Generic ConstructorNameSniff no longer throws a notice for abstract constructors inside abstract classes
    - Thanks to [Spencer Rinehart][@nubs] for the patch
- Squiz ComparisonOperatorUsageSniff now checks inside elseif statements
    - Thanks to [Arnout Boks][@aboks] for the patch
- Squiz OperatorSpacingSniff now reports errors for no spacing around inline then and else tokens
    - Thanks to [Arnout Boks][@aboks] for the patch

### Fixed
- Fixed bug [#19811][pear-19811] : Comments not ignored in all cases in AbstractPatternSniff
    - Thanks to [Erik Wiffin][@erikwiffin] for the patch
- Fixed bug [#19892][pear-19892] : ELSE with no braces causes incorrect SWITCH break statement indentation error
- Fixed bug [#19897][pear-19897] : Indenting warnings in templates not consistent
- Fixed bug [#19908][pear-19908] : PEAR MultiLineCondition Does Not Apply elseif
- Fixed bug [#19913][pear-19913] : Running phpcs in interactive mode causes warnings
    - Thanks to [Harald Franndorfer][pear-gemineye] for the patch
- Fixed bug [#19935][pear-19935] : notify-send reports do not vanish in gnome-shell
    - Thanks to [Christian Weiske][@cweiske] for the patch
- Fixed bug [#19944][pear-19944] : docblock squiz sniff "return void" trips over return in lambda function
- Fixed bug [#19953][pear-19953] : PSR2 - Spaces before interface name for abstract class
- Fixed bug [#19956][pear-19956] : phpcs warns for Type Hint missing Resource
- Fixed bug [#19957][pear-19957] : Does not understand trait method aliasing
- Fixed bug [#19968][pear-19968] : Permission denied on excluded directory
- Fixed bug [#19969][pear-19969] : Sniffs with namespace not recognized in reports
- Fixed bug [#19997][pear-19997] : Class names incorrectly detected as constants

[pear-19811]: https://pear.php.net/bugs/bug.php?id=19811
[pear-19892]: https://pear.php.net/bugs/bug.php?id=19892
[pear-19897]: https://pear.php.net/bugs/bug.php?id=19897
[pear-19908]: https://pear.php.net/bugs/bug.php?id=19908
[pear-19913]: https://pear.php.net/bugs/bug.php?id=19913
[pear-19935]: https://pear.php.net/bugs/bug.php?id=19935
[pear-19944]: https://pear.php.net/bugs/bug.php?id=19944
[pear-19953]: https://pear.php.net/bugs/bug.php?id=19953
[pear-19956]: https://pear.php.net/bugs/bug.php?id=19956
[pear-19957]: https://pear.php.net/bugs/bug.php?id=19957
[pear-19968]: https://pear.php.net/bugs/bug.php?id=19968
[pear-19969]: https://pear.php.net/bugs/bug.php?id=19969
[pear-19997]: https://pear.php.net/bugs/bug.php?id=19997

## [1.5.0RC2] - 2013-04-04

### Changed
- Ruleset processing has been rewritten to be more predictable
    - Provides much better support for relative paths inside ruleset files
    - May mean that sniffs that were previously ignored are now being included when importing external rulesets
    - Ruleset processing output can be seen by using the -vv command line argument
    - Internal sniff registering functions have all changed, so please review custom scripts
- You can now pass multiple coding standards on the command line, comma separated (request [#19144][pear-19144])
    - Works with built-in or custom standards and rulesets, or a mix of both
- You can now exclude directories or whole standards in a ruleset XML file (request [#19731][pear-19731])
    - e.g., exclude "Generic.Commenting" or just "Generic"
    - You can also pass in a path to a directory instead, if you know it
- Added Generic LowerCaseKeywordSniff to ensure all PHP keywords are defined in lowercase
    - The PSR2 and Squiz standards now use this sniff
- Added Generic SAPIUsageSniff to ensure the `PHP_SAPI` constant is used instead of `php_sapi_name()` (request [#19863][pear-19863])
- Squiz FunctionSpacingSniff now has a setting to specify how many lines there should between functions (request [#19843][pear-19843])
    - Default remains at 2
    - Override the "spacing" setting in a ruleset.xml file to change
- Squiz LowercasePHPFunctionSniff no longer throws errors for the limited set of PHP keywords it was checking
    - Add a rule for Generic.PHP.LowerCaseKeyword to your ruleset to replicate this functionality
- Added support for the PHP 5.4 T_CALLABLE token so it can be used in lower PHP versions
- Generic EndFileNoNewlineSniff now supports checking of CSS and JS files
- PSR2 SwitchDeclarationSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the indent setting in a ruleset.xml file to change
    - Thanks to [Asher Snyder][@asnyder] for the patch
- Generic ScopeIndentSniff now has a setting to specify a list of tokens that should be ignored
    - The first token on the line is checked and the whole line is ignored if the token is in the array
    - Thanks to [Eloy Lafuente][@stronk7] for the patch
- Squiz LowercaseClassKeywordsSniff now checks for the TRAIT keyword
    - Thanks to [Anthon Pang][@robocoder] for the patch
- If you create your own PHP_CodeSniffer object, PHPCS will no longer exit when an unknown argument is found
    - This allows you to create wrapper scripts for PHPCS more easily
- PSR2 MethodDeclarationSniff no longer generates a notice for methods named "_"
    - Thanks to [Bart S][@zBart] for the patch
- Squiz BlockCommentSniff no longer reports that a blank line between a scope closer and block comment is invalid
- Generic DuplicateClassNameSniff no longer reports an invalid error if multiple PHP open tags exist in a file
- Generic DuplicateClassNameSniff no longer reports duplicate errors if multiple PHP open tags exist in a file

### Fixed
- Fixed bug [#19819][pear-19819] : Freeze with syntax error in use statement
- Fixed bug [#19820][pear-19820] : Wrong message level in Generic_Sniffs_CodeAnalysis_EmptyStatementSniff
- Fixed bug [#19859][pear-19859] : CodeSniffer::setIgnorePatterns API changed
- Fixed bug [#19871][pear-19871] : findExtendedClassName doesn't return FQCN on namespaced classes
- Fixed bug [#19879][pear-19879] : bitwise and operator interpreted as reference by value

[pear-19144]: https://pear.php.net/bugs/bug.php?id=19144
[pear-19731]: https://pear.php.net/bugs/bug.php?id=19731

## [1.4.5] - 2013-04-04

### Changed
- Added Generic LowerCaseKeywordSniff to ensure all PHP keywords are defined in lowercase
    - The PSR2 and Squiz standards now use this sniff
- Added Generic SAPIUsageSniff to ensure the `PHP_SAPI` constant is used instead of `php_sapi_name()` (request [#19863][pear-19863])
- Squiz FunctionSpacingSniff now has a setting to specify how many lines there should between functions (request [#19843][pear-19843])
    - Default remains at 2
    - Override the "spacing" setting in a ruleset.xml file to change
- Squiz LowercasePHPFunctionSniff no longer throws errors for the limited set of PHP keywords it was checking
    - Add a rule for Generic.PHP.LowerCaseKeyword to your ruleset to replicate this functionality
- Added support for the PHP 5.4 T_CALLABLE token so it can be used in lower PHP versions
- Generic EndFileNoNewlineSniff now supports checking of CSS and JS files
- PSR2 SwitchDeclarationSniff now has a setting to specify how many spaces code should be indented
    - Default remains at 4; override the indent setting in a ruleset.xml file to change
    - Thanks to [Asher Snyder][@asnyder] for the patch
- Generic ScopeIndentSniff now has a setting to specify a list of tokens that should be ignored
    - The first token on the line is checked and the whole line is ignored if the token is in the array
    - Thanks to [Eloy Lafuente][@stronk7] for the patch
- Squiz LowercaseClassKeywordsSniff now checks for the TRAIT keyword
    - Thanks to [Anthon Pang][@robocoder] for the patch
- If you create your own PHP_CodeSniffer object, PHPCS will no longer exit when an unknown argument is found
    - This allows you to create wrapper scripts for PHPCS more easily
- PSR2 MethodDeclarationSniff no longer generates a notice for methods named "_"
    - Thanks to [Bart S][@zBart] for the patch
- Squiz BlockCommentSniff no longer reports that a blank line between a scope closer and block comment is invalid
- Generic DuplicateClassNameSniff no longer reports an invalid error if multiple PHP open tags exist in a file
- Generic DuplicateClassNameSniff no longer reports duplicate errors if multiple PHP open tags exist in a file

### Fixed
- Fixed bug [#19819][pear-19819] : Freeze with syntax error in use statement
- Fixed bug [#19820][pear-19820] : Wrong message level in Generic_Sniffs_CodeAnalysis_EmptyStatementSniff
- Fixed bug [#19859][pear-19859] : CodeSniffer::setIgnorePatterns API changed
- Fixed bug [#19871][pear-19871] : findExtendedClassName doesn't return FQCN on namespaced classes
- Fixed bug [#19879][pear-19879] : bitwise and operator interpreted as reference by value

[pear-19819]: https://pear.php.net/bugs/bug.php?id=19819
[pear-19820]: https://pear.php.net/bugs/bug.php?id=19820
[pear-19843]: https://pear.php.net/bugs/bug.php?id=19843
[pear-19859]: https://pear.php.net/bugs/bug.php?id=19859
[pear-19863]: https://pear.php.net/bugs/bug.php?id=19863
[pear-19871]: https://pear.php.net/bugs/bug.php?id=19871
[pear-19879]: https://pear.php.net/bugs/bug.php?id=19879

## [1.5.0RC1] - 2013-02-08

### Changed
- Reports have been completely rewritten to consume far less memory
    - Each report is incrementally written to the file system during a run and then printed out when the run ends
    - There is no longer a need to keep the list of errors and warnings in memory during a run
- Multi-file sniff support has been removed because they are too memory intensive
    - If you have a custom multi-file sniff, you can convert it into a standard sniff quite easily
    - See `CodeSniffer/Standards/Generic/Sniffs/Classes/DuplicateClassNameSniff.php` for an example

## [1.4.4] - 2013-02-07

### Changed
- Ignored lines no longer cause the summary report to show incorrect error and warning counts
    - Thanks to [Bert Van Hauwaert][@becoded] for the patch
- Added Generic CSSLintSniff to run CSSLint over a CSS file and report warnings
    - Set full command to run CSSLint using phpcs --config-set csslint_path /path/to/csslint
    - Thanks to [Roman Levishchenko][@index0h] for the contribution
- Added PSR2 ControlStructureSpacingSniff to ensure there are no spaces before and after parenthesis in control structures
    - Fixes bug [#19732][pear-19732] : PSR2: some control structures errors not reported
- Squiz commenting sniffs now support non-English characters when checking for capital letters
    - Thanks to [Roman Levishchenko][@index0h] for the patch
- Generic EndFileNewlineSniff now supports JS and CSS files
    - Thanks to [Denis Ryabkov][@dryabkov] for the patch
- PSR1 SideEffectsSniff no longer reports constant declarations as side effects
- Notifysend report now supports notify-send versions before 0.7.3
    - Thanks to [Ken Guest][@kenguest] for the patch
- PEAR and Squiz FunctionCommentSniffs no longer report errors for misaligned argument comments when they are blank
    - Thanks to [Thomas Peterson][@boonkerz] for the patch
- Squiz FunctionDeclarationArgumentSpacingSniff now works correctly for equalsSpacing values greater than 0
    - Thanks to [Klaus Purer][@klausi] for the patch
- Squiz SuperfluousWhitespaceSniff no longer throws errors for CSS files with no newline at the end
- Squiz SuperfluousWhitespaceSniff now allows a single newline at the end of JS and CSS files

### Fixed
- Fixed bug [#19755][pear-19755] : Token of T_CLASS type has no scope_opener and scope_closer keys
- Fixed bug [#19759][pear-19759] : Squiz.PHP.NonExecutableCode fails for return function()...
- Fixed bug [#19763][pear-19763] : Use statements for traits not recognised correctly for PSR2 code style
- Fixed bug [#19764][pear-19764] : Instead of for traits throws uppercase constant name errors
- Fixed bug [#19772][pear-19772] : PSR2_Sniffs_Namespaces_UseDeclarationSniff does not properly recognize last use
- Fixed bug [#19775][pear-19775] : False positive in NonExecutableCode sniff when not using curly braces
- Fixed bug [#19782][pear-19782] : Invalid found size functions in loop when using object operator
- Fixed bug [#19799][pear-19799] : config folder is not created automatically
- Fixed bug [#19804][pear-19804] : JS Tokenizer wrong /**/ parsing

[pear-19732]: https://pear.php.net/bugs/bug.php?id=19732
[pear-19755]: https://pear.php.net/bugs/bug.php?id=19755
[pear-19759]: https://pear.php.net/bugs/bug.php?id=19759
[pear-19763]: https://pear.php.net/bugs/bug.php?id=19763
[pear-19764]: https://pear.php.net/bugs/bug.php?id=19764
[pear-19772]: https://pear.php.net/bugs/bug.php?id=19772
[pear-19775]: https://pear.php.net/bugs/bug.php?id=19775
[pear-19782]: https://pear.php.net/bugs/bug.php?id=19782
[pear-19799]: https://pear.php.net/bugs/bug.php?id=19799
[pear-19804]: https://pear.php.net/bugs/bug.php?id=19804

## [1.4.3] - 2012-12-04

### Changed
- Added support for the PHP 5.5 T_FINALLY token to detect try/catch/finally statements
- Added empty CodeSniffer.conf to enable config settings for Composer installs
- Added Generic EndFileNoNewlineSniff to ensure there is no newline at the end of a file
- Autoloader can now load PSR-0 compliant classes
    - Thanks to [Maik Penz][@goatherd] for the patch
- Squiz NonExecutableCodeSniff no longer throws error for multi-line RETURNs inside CASE statements
    - Thanks to [Marc Ypes][@ceeram] for the patch
- Squiz OperatorSpacingSniff no longer reports errors for negative numbers inside inline THEN statements
    - Thanks to [Klaus Purer][@klausi] for the patch
- Squiz OperatorSpacingSniff no longer reports errors for the assignment of operations involving negative numbers
- Squiz SelfMemberReferenceSniff can no longer get into an infinite loop when checking a static call with a namespace
    - Thanks to [Andy Grunwald][@andygrunwald] for the patch

### Fixed
- Fixed bug [#19699][pear-19699] : Generic.Files.LineLength giving false positives when tab-width is used
- Fixed bug [#19726][pear-19726] : Wrong number of spaces expected after instanceof static
- Fixed bug [#19727][pear-19727] : PSR2: no error reported when using } elseif {

[pear-19699]: https://pear.php.net/bugs/bug.php?id=19699
[pear-19726]: https://pear.php.net/bugs/bug.php?id=19726
[pear-19727]: https://pear.php.net/bugs/bug.php?id=19727

## [1.4.2] - 2012-11-09

### Changed
- PHP_CodeSniffer can now be installed using Composer
    - Require `squizlabs/php_codesniffer` in your `composer.json` file
    - Thanks to [Rob Bast][@alcohol], [Stephen Rees-Carter][@valorin], [Stefano Kowalke][@Konafets] and [Ivan Habunek][@ihabunek] for help with this
- Squiz BlockCommentSniff and InlineCommentSniff no longer report errors for trait block comments
- Squiz SelfMemberReferenceSniff now supports namespaces
    - Thanks to [Andy Grunwald][@andygrunwald] for the patch
- Squiz FileCommentSniff now uses tag names inside the error codes for many messages
    - This allows you to exclude specific missing, out of order etc., tags
- Squiz SuperfluousWhitespaceSniff now has an option to ignore blank lines
    - This will stop errors being reported for lines that contain only whitespace
    - Set the ignoreBlankLines property to TRUE in your ruleset.xml file to enable this
- PSR2 no longer reports errors for whitespace at the end of blank lines

### Fixed
- Fixed gitblame report not working on Windows
    - Thanks to [Rogerio Prado de Jesus][@rogeriopradoj]
- Fixed an incorrect error in Squiz OperatorSpacingSniff for default values inside a closure definition
- Fixed bug [#19691][pear-19691] : SubversionPropertiesSniff fails to find missing properties
    - Thanks to [Kevin Winahradsky][pear-kwinahradsky] for the patch
- Fixed bug [#19692][pear-19692] : DisallowMultipleAssignments is triggered by a closure
- Fixed bug [#19693][pear-19693] : exclude-patterns no longer work on specific messages
- Fixed bug [#19694][pear-19694] : Squiz.PHP.LowercasePHPFunctions incorrectly matches return by ref functions

[pear-19691]: https://pear.php.net/bugs/bug.php?id=19691
[pear-19692]: https://pear.php.net/bugs/bug.php?id=19692
[pear-19693]: https://pear.php.net/bugs/bug.php?id=19693
[pear-19694]: https://pear.php.net/bugs/bug.php?id=19694

## [1.4.1] - 2012-11-02

### Changed
- All ignore patterns have been reverted to being checked against the absolute path of a file
    - Patterns can be specified to be relative in a ruleset.xml file, but nowhere else
    - e.g., `<exclude-pattern type="relative">^tests/*</exclude-pattern>`
- Added support for PHP tokenizing of T_INLINE_ELSE colons, so this token type is now available
    - Custom sniffs that rely on looking for T_COLON tokens inside inline if statements must be changed to use the new token
    - Fixes bug [#19666][pear-19666] : PSR1.Files.SideEffects throws a notice Undefined index: scope_closer
- Messages can now be changed from errors to warnings (and vice versa) inside ruleset.xml files
    - As you would with "message" and "severity", specify a "type" tag under a "rule" tag and set the value to "error" or "warning"
- PHP_CodeSniffer will now generate a warning on files that it detects have mixed line endings
    - This warning has the code Internal.LineEndings.Mixed and can be overridden in a ruleset.xml file
    - Thanks to [Vit Brunner][@tasuki] for help with this
- Sniffs inside PHP 5.3 namespaces are now supported, along with the existing underscore-style emulated namespaces
    - For example: namespace MyStandard\Sniffs\Arrays; class ArrayDeclarationSniff implements \PHP_CodeSniffer_Sniff { ...
    - Thanks to [Till Klampaeckel][@till] for the patch
- Generic DuplicateClassNameSniff is no longer a multi-file sniff, so it won't max out your memory
    - Multi-file sniff support should be considered deprecated as standard sniffs can now do the same thing
- Added Generic DisallowSpaceIndent to check that files are indented using tabs
- Added Generic OneClassPerFileSniff to check that only one class is defined in each file
    - Thanks to [Andy Grunwald][@andygrunwald] for the contribution
- Added Generic OneInterfacePerFileSniff to check that only one interface is defined in each file
    - Thanks to [Andy Grunwald][@andygrunwald] for the contribution
- Added Generic LowercasedFilenameSniff to check that filenames are lowercase
    - Thanks to [Andy Grunwald][@andygrunwald] for the contribution
- Added Generic ClosingPHPTagSniff to check that each open PHP tag has a corresponding close tag
    - Thanks to [Andy Grunwald][@andygrunwald] for the contribution
- Added Generic CharacterBeforePHPOpeningTagSniff to check that the open PHP tag is the first content in a file
    - Thanks to [Andy Grunwald][@andygrunwald] for the contribution
- Fixed incorrect errors in Squiz OperatorBracketSniff and OperatorSpacingSniff for negative numbers in CASE statements
    - Thanks to [Arnout Boks][@aboks] for the patch
- Generic CamelCapsFunctionNameSniff no longer enforces exact case matching for PHP magic methods
- Generic CamelCapsFunctionNameSniff no longer throws errors for overridden SOAPClient methods prefixed with double underscores
    - Thanks to [Dorian Villet][@gnutix] for the patch
- PEAR ValidFunctionNameSniff now supports traits
- PSR1 ClassDeclarationSniff no longer throws an error for non-namespaced code if PHP version is less than 5.3.0

### Fixed
- Fixed bug [#19616][pear-19616] : Nested switches cause false error in PSR2
- Fixed bug [#19629][pear-19629] : PSR2 error for inline comments on multi-line argument lists
- Fixed bug [#19644][pear-19644] : Alternative syntax, e.g. if/endif triggers Inline Control Structure error
- Fixed bug [#19655][pear-19655] : Closures reporting as multi-line when they are not
- Fixed bug [#19675][pear-19675] : Improper indent of nested anonymous function bodies in a call
- Fixed bug [#19685][pear-19685] : PSR2 catch-22 with empty third statement in for loop
- Fixed bug [#19687][pear-19687] : Anonymous functions inside arrays marked as indented incorrectly in PSR2

[pear-19616]: https://pear.php.net/bugs/bug.php?id=19616
[pear-19629]: https://pear.php.net/bugs/bug.php?id=19629
[pear-19644]: https://pear.php.net/bugs/bug.php?id=19644
[pear-19655]: https://pear.php.net/bugs/bug.php?id=19655
[pear-19666]: https://pear.php.net/bugs/bug.php?id=19666
[pear-19675]: https://pear.php.net/bugs/bug.php?id=19675
[pear-19685]: https://pear.php.net/bugs/bug.php?id=19685
[pear-19687]: https://pear.php.net/bugs/bug.php?id=19687

## [1.4.0] - 2012-09-26

### Changed
- Added PSR1 and PSR2 coding standards that can be used to check your code against these guidelines
- PHP 5.4 short array syntax is now detected and tokens are assigned to the open and close characters
    - New tokens are T_OPEN_SHORT_ARRAY and T_CLOSE_SHORT_ARRAY as PHP does not define its own
- Added the ability to explain a coding standard by listing the sniffs that it includes
    - The sniff list includes all imported and native sniffs
    - Explain a standard by using the `-e` and `--standard=[standard]` command line arguments
    - E.g., `phpcs -e --standard=Squiz`
    - Thanks to [Ben Selby][@benmatselby] for the idea
- Added report to show results using notify-send
    - Use --report=notifysend to generate the report
    - Thanks to [Christian Weiske][@cweiske] for the contribution
- The JS tokenizer now recognises RETURN as a valid closer for CASE and DEFAULT inside switch statements
- AbstractPatternSniff now sets the ignoreComments option using a public var rather than through the constructor
    - This allows the setting to be overwritten in ruleset.xml files
    - Old method remains for backwards compatibility
- Generic LowerCaseConstantSniff and UpperCaseConstantSniff no longer report errors on classes named True, False or Null
- PEAR ValidFunctionNameSniff no longer enforces exact case matching for PHP magic methods
- Squiz SwitchDeclarationSniff now allows RETURN statements to close a CASE or DEFAULT statement
- Squiz BlockCommentSniff now correctly reports an error for blank lines before blocks at the start of a control structure

### Fixed
- Fixed a PHP notice generated when loading custom array settings from a ruleset.xml file
- Fixed bug [#17908][pear-17908] : CodeSniffer does not recognise optional @params
    - Thanks to [Pete Walker][pear-pete] for the patch
- Fixed bug [#19538][pear-19538] : Function indentation code sniffer checks inside short arrays
- Fixed bug [#19565][pear-19565] : Non-Executable Code Sniff Broken for Case Statements with both return and break
- Fixed bug [#19612][pear-19612] : Invalid @package suggestion

[pear-17908]: https://pear.php.net/bugs/bug.php?id=17908
[pear-19538]: https://pear.php.net/bugs/bug.php?id=19538
[pear-19565]: https://pear.php.net/bugs/bug.php?id=19565
[pear-19612]: https://pear.php.net/bugs/bug.php?id=19612

## [1.3.6] - 2012-08-08

### Changed
- Memory usage has been dramatically reduced when using the summary report
    - Reduced memory is only available when displaying a single summary report to the screen
    - PHP_CodeSniffer will not generate any messages in this case, storing only error counts instead
    - Impact is most notable with very high error and warning counts
- Significantly improved the performance of Squiz NonExecutableCodeSniff
- Ignore patterns now check the relative path of a file based on the dir being checked
    - Allows ignore patterns to become more generic as the path to the code is no longer included when checking
    - Thanks to [Kristof Coomans][@kristofser] for the patch
- Sniff settings can now be changed by specifying a special comment format inside a file
    - e.g., // @codingStandardsChangeSetting PEAR.Functions.FunctionCallSignature allowMultipleArguments false
    - If you change a setting, don't forget to change it back
- Added Generic EndFileNewlineSniff to ensure PHP files end with a newline character
- PEAR FunctionCallSignatureSniff now includes a setting to force one argument per line in multi-line calls
    - Set allowMultipleArguments to false
- Squiz standard now enforces one argument per line in multi-line function calls
- Squiz FunctionDeclarationArgumentSpacingSniff now supports closures
- Squiz OperatorSpacingSniff no longer throws an error for negative values inside an inline THEN statement
    - Thanks to [Klaus Purer][@klausi] for the patch
- Squiz FunctionCommentSniff now throws an error for not closing a comment with */
    - Thanks to [Klaus Purer][@klausi] for the patch
- Summary report no longer shows two lines of PHP_Timer output when showing sources

### Fixed
- Fixed undefined variable error in PEAR FunctionCallSignatureSniff for lines with no indent
- Fixed bug [#19502][pear-19502] : Generic.Files.LineEndingsSniff fails if no new-lines in file
- Fixed bug [#19508][pear-19508] : switch+return: Closing brace indented incorrectly
- Fixed bug [#19532][pear-19532] : The PSR-2 standard don't recognize Null in class names
- Fixed bug [#19546][pear-19546] : Error thrown for __call() method in traits

[pear-19502]: https://pear.php.net/bugs/bug.php?id=19502
[pear-19508]: https://pear.php.net/bugs/bug.php?id=19508
[pear-19532]: https://pear.php.net/bugs/bug.php?id=19532
[pear-19546]: https://pear.php.net/bugs/bug.php?id=19546

## [1.3.5] - 2012-07-12

### Changed
- Added Generic CamelCapsFunctionNameSniff to just check if function and method names use camel caps
    - Does not allow underscore prefixes for private/protected methods
    - Defaults to strict checking, where two uppercase characters can not be next to each other
    - Strict checking can be disabled in a ruleset.xml file
- Squiz FunctionDeclarationArgumentSpacing now has a setting to specify how many spaces should surround equals signs
    - Default remains at 0
    - Override the equalsSpacing setting in a ruleset.xml file to change
- Squiz ClassDeclarationSniff now throws errors for > 1 space before extends/implements class name with ns separator
- Squiz standard now warns about deprecated functions using Generic DeprecatedFunctionsSniff
- PEAR FunctionDeclarationSniff now reports an error for multiple spaces after the FUNCTION keyword and around USE
- PEAR FunctionDeclarationSniff now supports closures
- Squiz MultiLineFunctionDeclarationSniff now supports closures
- Exclude rules written for Unix systems will now work correctly on Windows
    - Thanks to [Walter Tamboer][@waltertamboer] for the patch
- The PHP tokenizer now recognises T_RETURN as a valid closer for T_CASE and T_DEFAULT inside switch statements

### Fixed
- Fixed duplicate message codes in Generic OpeningFunctionBraceKernighanRitchieSniff
- Fixed bug [#18651][pear-18651] : PHPUnit Test cases for custom standards are not working on Windows
- Fixed bug [#19416][pear-19416] : Shorthand arrays cause bracket spacing errors
- Fixed bug [#19421][pear-19421] : phpcs doesn't recognize ${x} as equivalent to $x
- Fixed bug [#19428][pear-19428] : PHPCS Report "hgblame" doesn't support windows paths
    - Thanks to [Justin Rovang][@rovangju] for the patch
- Fixed bug [#19448][pear-19448] : Problem with detecting remote standards
- Fixed bug [#19463][pear-19463] : Anonymous functions incorrectly being flagged by NonExecutableCodeSniff
- Fixed bug [#19469][pear-19469] : PHP_CodeSniffer_File::getMemberProperties() sets wrong scope
- Fixed bug [#19471][pear-19471] : phpcs on Windows, when using Zend standard, doesn't catch problems
    - Thanks to [Ivan Habunek][@ihabunek] for the patch
- Fixed bug [#19478][pear-19478] : Incorrect indent detection in PEAR standard
    - Thanks to [Shane Auckland][@shanethehat] for the patch
- Fixed bug [#19483][pear-19483] : Blame Reports fail with space in directory name

[pear-18651]: https://pear.php.net/bugs/bug.php?id=18651
[pear-19416]: https://pear.php.net/bugs/bug.php?id=19416
[pear-19421]: https://pear.php.net/bugs/bug.php?id=19421
[pear-19428]: https://pear.php.net/bugs/bug.php?id=19428
[pear-19448]: https://pear.php.net/bugs/bug.php?id=19448
[pear-19463]: https://pear.php.net/bugs/bug.php?id=19463
[pear-19469]: https://pear.php.net/bugs/bug.php?id=19469
[pear-19471]: https://pear.php.net/bugs/bug.php?id=19471
[pear-19478]: https://pear.php.net/bugs/bug.php?id=19478
[pear-19483]: https://pear.php.net/bugs/bug.php?id=19483

## [1.3.4] - 2012-05-17

### Changed
- Added missing package.xml entries for new Generic FixmeSniff
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Expected indents for PEAR ScopeClosingBraceSniff and FunctionCallSignatureSniff can now be set in ruleset files
    - Both sniffs use a variable called "indent"
    - Thanks to [Thomas Despoix][pear-tomdesp] for the patch
- Standards designed to be installed in the PHPCS Standards dir will now work outside this dir as well
    - In particular, allows the Drupal CS to work without needing to symlink it into the PHPCS install
    - Thanks to [Peter Philipp][@das-peter] for the patch
- Rule references for standards, directories and specific sniffs can now be relative in ruleset.xml files
    - For example: `ref="../MyStandard/Sniffs/Commenting/DisallowHashCommentsSniff.php"`
- Symlinked standards now work correctly, allowing aliasing of installed standards (request [#19417][pear-19417])
    - Thanks to [Tom Klingenberg][@ktomk] for the patch
- Squiz ObjectInstantiationSniff now allows objects to be returned without assigning them to a variable
- Added Squiz.Commenting.FileComment.MissingShort error message for file comments that only contains tags
    - Also stops undefined index errors being generated for these comments
- Debug option -vv now shows tokenizer status for CSS files
- Added support for new gjslint error formats
    - Thanks to [Meck][@yesmeck] for the patch
- Generic ScopeIndentSniff now allows comment indents to not be exact even if the exact flag is set
    - The start of the comment is still checked for exact indentation as normal
- Fixed an issue in AbstractPatternSniff where comments were not being ignored in some cases
- Fixed an issue in Zend ClosingTagSniff where the closing tag was not always being detected correctly
    - Thanks to [Jonathan Robson][@jnrbsn] for the patch
- Fixed an issue in Generic FunctionCallArgumentSpacingSniff where closures could cause incorrect errors
- Fixed an issue in Generic UpperCaseConstantNameSniff where errors were incorrectly reported on goto statements
    - Thanks to [Tom Klingenberg][@ktomk] for the patch
- PEAR FileCommentSniff and ClassCommentSniff now support author emails with a single character in the local part
    - E.g., `a@me.com`
    - Thanks to Denis Shapkin for the patch

### Fixed
- Fixed bug [#19290][pear-19290] : Generic indent sniffer fails for anonymous functions
- Fixed bug [#19324][pear-19324] : Setting show_warnings configuration option does not work
- Fixed bug [#19354][pear-19354] : Not recognizing references passed to method
- Fixed bug [#19361][pear-19361] : CSS tokenizer generates errors when PHP embedded in CSS file
- Fixed bug [#19374][pear-19374] : HEREDOC/NOWDOC Indentation problems
- Fixed bug [#19381][pear-19381] : traits and indentations in traits are not handled properly
- Fixed bug [#19394][pear-19394] : Notice in NonExecutableCodeSniff
- Fixed bug [#19402][pear-19402] : Syntax error when executing phpcs on Windows with parens in PHP path
    - Thanks to [Tom Klingenberg][@ktomk] for the patch
- Fixed bug [#19411][pear-19411] : magic method error on __construct()
    - The fix required a rewrite of AbstractScopeSniff, so please test any sniffs that extend this class
- Fixed bug [#19412][pear-19412] : Incorrect error about assigning objects to variables when inside inline IF
- Fixed bug [#19413][pear-19413] : PHP_CodeSniffer thinks I haven't used a parameter when I have
- Fixed bug [#19414][pear-19414] : PHP_CodeSniffer seems to not track variables correctly in heredocs

[pear-19290]: https://pear.php.net/bugs/bug.php?id=19290
[pear-19324]: https://pear.php.net/bugs/bug.php?id=19324
[pear-19354]: https://pear.php.net/bugs/bug.php?id=19354
[pear-19361]: https://pear.php.net/bugs/bug.php?id=19361
[pear-19374]: https://pear.php.net/bugs/bug.php?id=19374
[pear-19381]: https://pear.php.net/bugs/bug.php?id=19381
[pear-19394]: https://pear.php.net/bugs/bug.php?id=19394
[pear-19402]: https://pear.php.net/bugs/bug.php?id=19402
[pear-19411]: https://pear.php.net/bugs/bug.php?id=19411
[pear-19412]: https://pear.php.net/bugs/bug.php?id=19412
[pear-19413]: https://pear.php.net/bugs/bug.php?id=19413
[pear-19414]: https://pear.php.net/bugs/bug.php?id=19414
[pear-19417]: https://pear.php.net/bugs/bug.php?id=19417

## [1.3.3] - 2012-02-07

### Changed
- Added new Generic FixmeSniff that shows error messages for all FIXME comments left in your code
    - Thanks to [Sam Graham][@illusori] for the contribution
- The maxPercentage setting in the Squiz CommentedOutCodeSniff can now be overridden in a ruleset.xml file
    - Thanks to [Volker Dusch][@edorian] for the patch
- The Checkstyle and XML reports now use XMLWriter
    - Only change in output is that empty file tags are no longer produced for files with no violations
    - Thanks to [Sebastian Bergmann][@sebastianbergmann] for the patch
- Added PHP_CodeSniffer_Tokens::$bracketTokens to give sniff writers fast access to open and close bracket tokens
- Fixed an issue in AbstractPatternSniff where EOL tokens were not being correctly checked in some cases
- PHP_CodeSniffer_File::getTokensAsString() now detects incorrect length value (request [#19313][pear-19313])

### Fixed
- Fixed bug [#19114][pear-19114] : CodeSniffer checks extension even for single file
- Fixed bug [#19171][pear-19171] : Show sniff codes option is ignored by some report types
    - Thanks to [Dominic Scheirlinck][@dominics] for the patch
- Fixed bug [#19188][pear-19188] : Lots of PHP Notices when analyzing the Symfony framework
    - First issue was list-style.. lines in CSS files not properly adjusting open/close bracket positions
    - Second issue was notices caused by bug [#19137][pear-19137]
- Fixed bug [#19208][pear-19208] : UpperCaseConstantName reports class members
    - Was also a problem with LowerCaseConstantName as well
- Fixed bug [#19256][pear-19256] : T_DOC_COMMENT in CSS files breaks ClassDefinitionNameSpacingSniff
    - Thanks to [Klaus Purer][@klausi] for the patch
- Fixed bug [#19264][pear-19264] : Squiz.PHP.NonExecutableCode does not handle RETURN in CASE without BREAK
- Fixed bug [#19270][pear-19270] : DuplicateClassName does not handle namespaces correctly
- Fixed bug [#19283][pear-19283] : CSS @media rules cause false positives
    - Thanks to [Klaus Purer][@klausi] for the patch

[pear-19114]: https://pear.php.net/bugs/bug.php?id=19114
[pear-19137]: https://pear.php.net/bugs/bug.php?id=19137
[pear-19171]: https://pear.php.net/bugs/bug.php?id=19171
[pear-19188]: https://pear.php.net/bugs/bug.php?id=19188
[pear-19208]: https://pear.php.net/bugs/bug.php?id=19208
[pear-19256]: https://pear.php.net/bugs/bug.php?id=19256
[pear-19264]: https://pear.php.net/bugs/bug.php?id=19264
[pear-19270]: https://pear.php.net/bugs/bug.php?id=19270
[pear-19283]: https://pear.php.net/bugs/bug.php?id=19283
[pear-19313]: https://pear.php.net/bugs/bug.php?id=19313

## [1.3.2] - 2011-12-01

### Changed
- Added Generic JSHintSniff to run jshint.js over a JS file and report warnings
    - Set jshint path using phpcs --config-set jshint_path /path/to/jshint-rhino.js
    - Set rhino path using phpcs --config-set rhino_path /path/to/rhino
    - Thanks to Alexander Weiß for the contribution
- Nowdocs are now tokenized using PHP_CodeSniffer specific T_NOWDOC tokens for easier identification
- Generic UpperCaseConstantNameSniff no longer throws errors for namespaces
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Squiz NonExecutableCodeSniff now detects code after thrown exceptions
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Squiz OperatorSpacingSniff now ignores references
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Squiz FunctionCommentSniff now reports a missing function comment if it finds a standard code comment instead
- Squiz FunctionCommentThrownTagSniff no longer reports errors if it can't find a function comment

### Fixed
- Fixed unit tests not running under Windows
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Fixed bug [#18964][pear-18964] : "$stackPtr must be of type T_VARIABLE" on heredocs and nowdocs
- Fixed bug [#18973][pear-18973] : phpcs is looking for variables in a nowdoc
- Fixed bug [#18974][pear-18974] : Blank line causes "Multi-line function call not indented correctly"
    - Adds new error message to ban empty lines in multi-line function calls
- Fixed bug [#18975][pear-18975] : "Closing parenthesis must be on a line by itself" also causes indentation error

[pear-18964]: https://pear.php.net/bugs/bug.php?id=18964
[pear-18973]: https://pear.php.net/bugs/bug.php?id=18973
[pear-18974]: https://pear.php.net/bugs/bug.php?id=18974
[pear-18975]: https://pear.php.net/bugs/bug.php?id=18975

## 1.3.1 - 2011-11-03

### Changed
- All report file command line arguments now work with relative paths (request [#17240][pear-17240])
- The extensions command line argument now supports multi-part file extensions (request [#17227][pear-17227])
- Added report type --report=hgblame to show number of errors/warnings committed by authors in a Mercurial repository
    - Has the same functionality as the svnblame report
    - Thanks to [Ben Selby][@benmatselby] for the patch
- Added T_BACKTICK token type to make detection of backticks easier (request [#18799][pear-18799])
- Added pattern matching support to Generic ForbiddenFunctionsSniff
    - If you are extending it and overriding register() or addError() you will need to review your sniff
- Namespaces are now recognised as scope openers, although they do not require braces (request [#18043][pear-18043])
- Added new ByteOrderMarkSniff to Generic standard (request [#18194][pear-18194])
    - Throws an error if a byte order mark is found in any PHP file
    - Thanks to [Piotr Karas][pear-ryba] for the contribution
- PHP_Timer output is no longer included in reports when being written to a file (request [#18252][pear-18252])
    - Also now shown for all report types if nothing is being printed to the screen
- Generic DeprecatedFunctionSniff now reports functions as deprecated and not simply forbidden (request [#18288][pear-18288])
- PHPCS now accepts file contents from STDIN (request [#18447][pear-18447])
    - Example usage: `cat temp.php | phpcs [options]`  -OR-  `phpcs [options] &lt; temp.php`
    - Not every sniff will work correctly due to the lack of a valid file path
- PHP_CodeSniffer_Exception no longer extends PEAR_Exception (request [#18483][pear-18483])
    - PEAR_Exception added a requirement that PEAR had to be installed
    - PHP_CodeSniffer is not used as a library, so unlikely to have any impact
- PEAR FileCommentSniff now allows GIT IDs in the version tag (request [#14874][pear-14874])
- AbstractVariableSniff now supports heredocs
    - Also includes some variable detection fixes
    - Thanks to [Sam Graham][@illusori] for the patch
- Squiz FileCommentSniff now enforces rule that package names cannot start with the word Squiz
- MySource AssignThisSniff now allows "this" to be assigned to the private var _self
- PEAR ClassDeclaration sniff now supports indentation checks when using the alternate namespace syntax
    - PEAR.Classes.ClassDeclaration.SpaceBeforeBrace message now contains 2 variables instead of 1
    - Sniff allows overriding of the default indent level, which is set to 4
    - Fixes bug [#18933][pear-18933] : Alternative namespace declaration syntax confuses scope sniffs

### Fixed
- Fixed issue in Squiz FileCommentSniff where suggested package name was the same as the incorrect package name
- Fixed some issues with Squiz ArrayDeclarationSniff when using function calls in array values
- Fixed doc generation so it actually works again
    - Also now works when being run from an SVN checkout as well as when installed as a PEAR package
    - Should fix bug [#18949][pear-18949] : Call to private method from static
- Fixed bug [#18465][pear-18465] : "self::" does not work in lambda functions
    - Also corrects conversion of T_FUNCTION tokens to T_CLOSURE, which was not fixing token condition arrays
- Fixed bug [#18543][pear-18543] : CSS Tokenizer deletes too many #
- Fixed bug [#18624][pear-18624] : @throws namespace problem
    - Thanks to [Gavin Davies][pear-boxgav] for the patch
- Fixed bug [#18628][pear-18628] : Generic.Files.LineLength gives incorrect results with Windows line-endings
- Fixed bug [#18633][pear-18633] : CSS Tokenizer doesn't replace T_LIST tokens inside some styles
- Fixed bug [#18657][pear-18657] : anonymous functions wrongly indented
- Fixed bug [#18670][pear-18670] : UpperCaseConstantNameSniff fails on dynamic retrieval of class constant
- Fixed bug [#18709][pear-18709] : Code sniffer sniffs file even if it's in --ignore
    - Thanks to [Artem Lopata][@biozshock] for the patch
- Fixed bug [#18762][pear-18762] : Incorrect handling of define and constant in UpperCaseConstantNameSniff
    - Thanks to [Thomas Baker][pear-bakert] for the patch
- Fixed bug [#18769][pear-18769] : CSS Tokenizer doesn't replace T_BREAK tokens inside some styles
- Fixed bug [#18835][pear-18835] : Unreachable errors of inline returns of closure functions
    - Thanks to [Patrick Schmidt][pear-woellchen] for the patch
- Fixed bug [#18839][pear-18839] : Fix miscount of warnings in `AbstractSniffUnitTest.php`
    - Thanks to [Sam Graham][@illusori] for the patch
- Fixed bug [#18844][pear-18844] : Generic_Sniffs_CodeAnalysis_UnusedFunctionParameterSniff with empty body
    - Thanks to [Dmitri Medvedev][pear-dvino] for the patch
- Fixed bug [#18847][pear-18847] : Running Squiz_Sniffs_Classes_ClassDeclarationSniff results in PHP notice
- Fixed bug [#18868][pear-18868] : jslint+rhino: errors/warnings not detected
    - Thanks to [Christian Weiske][@cweiske] for the patch
- Fixed bug [#18879][pear-18879] : phpcs-svn-pre-commit requires escapeshellarg
    - Thanks to [Bjorn Katuin][pear-bjorn] for the patch
- Fixed bug [#18951][pear-18951] : weird behaviour with closures and multi-line use () params

[pear-14874]: https://pear.php.net/bugs/bug.php?id=14874
[pear-17227]: https://pear.php.net/bugs/bug.php?id=17227
[pear-17240]: https://pear.php.net/bugs/bug.php?id=17240
[pear-18043]: https://pear.php.net/bugs/bug.php?id=18043
[pear-18194]: https://pear.php.net/bugs/bug.php?id=18194
[pear-18252]: https://pear.php.net/bugs/bug.php?id=18252
[pear-18288]: https://pear.php.net/bugs/bug.php?id=18288
[pear-18447]: https://pear.php.net/bugs/bug.php?id=18447
[pear-18465]: https://pear.php.net/bugs/bug.php?id=18465
[pear-18483]: https://pear.php.net/bugs/bug.php?id=18483
[pear-18543]: https://pear.php.net/bugs/bug.php?id=18543
[pear-18624]: https://pear.php.net/bugs/bug.php?id=18624
[pear-18628]: https://pear.php.net/bugs/bug.php?id=18628
[pear-18633]: https://pear.php.net/bugs/bug.php?id=18633
[pear-18657]: https://pear.php.net/bugs/bug.php?id=18657
[pear-18670]: https://pear.php.net/bugs/bug.php?id=18670
[pear-18709]: https://pear.php.net/bugs/bug.php?id=18709
[pear-18762]: https://pear.php.net/bugs/bug.php?id=18762
[pear-18769]: https://pear.php.net/bugs/bug.php?id=18769
[pear-18799]: https://pear.php.net/bugs/bug.php?id=18799
[pear-18835]: https://pear.php.net/bugs/bug.php?id=18835
[pear-18839]: https://pear.php.net/bugs/bug.php?id=18839
[pear-18844]: https://pear.php.net/bugs/bug.php?id=18844
[pear-18847]: https://pear.php.net/bugs/bug.php?id=18847
[pear-18868]: https://pear.php.net/bugs/bug.php?id=18868
[pear-18879]: https://pear.php.net/bugs/bug.php?id=18879
[pear-18933]: https://pear.php.net/bugs/bug.php?id=18933
[pear-18949]: https://pear.php.net/bugs/bug.php?id=18949
[pear-18951]: https://pear.php.net/bugs/bug.php?id=18951

## 1.3.0 - 2011-03-17

### Changed
- Add a new token T_CLOSURE that replaces T_FUNCTION if the function keyword is anonymous
- Many Squiz sniffs no longer report errors when checking closures; they are now ignored
- Fixed some error messages in PEAR MultiLineConditionSniff that were not using placeholders for message data
- AbstractVariableSniff now correctly finds variable names wrapped with curly braces inside double quoted strings
- PEAR FunctionDeclarationSniff now ignores arrays in argument default values when checking multi-line declarations

### Fixed
- Fixed bug [#18200][pear-18200] : Using custom named ruleset file as standard no longer works
- Fixed bug [#18196][pear-18196] : PEAR MultiLineCondition.SpaceBeforeOpenBrace not consistent with newline chars
- Fixed bug [#18204][pear-18204] : FunctionCommentThrowTag picks wrong exception type when throwing function call
- Fixed bug [#18222][pear-18222] : Add __invoke method to PEAR standard
- Fixed bug [#18235][pear-18235] : Invalid error generation in Squiz.Commenting.FunctionCommentThrowTag
- Fixed bug [#18250][pear-18250] : --standard with relative path skips Standards' "implicit" sniffs
- Fixed bug [#18274][pear-18274] : Multi-line IF and function call indent rules conflict
- Fixed bug [#18282][pear-18282] : Squiz doesn't handle final keyword before function comments
    - Thanks to [Dave Perrett][pear-recurser] for the patch
- Fixed bug [#18336][pear-18336] : Function isUnderscoreName gives PHP notices

[pear-18196]: https://pear.php.net/bugs/bug.php?id=18196
[pear-18200]: https://pear.php.net/bugs/bug.php?id=18200
[pear-18204]: https://pear.php.net/bugs/bug.php?id=18204
[pear-18222]: https://pear.php.net/bugs/bug.php?id=18222
[pear-18235]: https://pear.php.net/bugs/bug.php?id=18235
[pear-18250]: https://pear.php.net/bugs/bug.php?id=18250
[pear-18274]: https://pear.php.net/bugs/bug.php?id=18274
[pear-18282]: https://pear.php.net/bugs/bug.php?id=18282
[pear-18336]: https://pear.php.net/bugs/bug.php?id=18336

## 1.3.0RC2 - 2011-01-14

### Changed
- You can now print multiple reports for each run and print each to the screen or a file (request [#12434][pear-12434])
    - Format is `--report-[report][=file]` (e.g., `--report-xml=out.xml`)
    - Printing to screen is done by leaving `[file]` empty (e.g., `--report-xml`)
    - Multiple reports can be specified in this way (e.g., `--report-summary --report-xml=out.xml`)
    - The standard `--report` and `--report-file` command line arguments are unchanged
- Added `-d` command line argument to set `php.ini` settings while running (request [#17244][pear-17244])
    - Usage is: `phpcs -d memory_limit=32M -d ...`
    - Thanks to [Ben Selby][@benmatselby] for the patch
- Added -p command line argument to show progress during a run
    - Dot means pass, E means errors found, W means only warnings found and S means skipped file
    - Particularly good for runs where you are checking more than 100 files
    - Enable by default with --config-set show_progress 1
    - Will not print anything if you are already printing verbose output
    - This has caused a big change in the way PHP_CodeSniffer processes files (API changes around processing)
- You can now add exclude rules for individual sniffs or error messages (request [#17903][pear-17903])
    - Only available when using a ruleset.xml file to specify rules
    - Uses the same exclude-pattern tags as normal but allows them inside rule tags
- Using the -vvv option will now print a list of sniffs executed for each file and how long they took to process
- Added Generic ClosureLinterSniff to run Google's gjslint over your JS files
- The XML and CSV reports now include the severity of the error (request [#18165][pear-18165])
    - The Severity column in the CSV report has been renamed to Type, and a new Severity column added for this
- Fixed issue with Squiz FunctionCommentSniff reporting incorrect type hint when default value uses namespace
    - Thanks to Anti Veeranna for the patch
- Generic FileLengthSniff now uses iconv_strlen to check line length if an encoding is specified (request [#14237][pear-14237])
- Generic UnnecessaryStringConcatSniff now allows strings to be combined to form a PHP open or close tag
- Squiz SwitchDeclarationSniff no longer reports indentation errors for BREAK statements inside IF conditions
- Interactive mode now always prints the full error report (ignores command line)
- Improved regular expression detection in JavaScript files
    - Added new T_TYPEOF token that can be used to target the typeof JS operator
    - Fixes bug [#17611][pear-17611] : Regular expression tokens not recognised
- Squiz ScopeIndentSniff removed
    - Squiz standard no longer requires additional indents between ob_* methods
    - Also removed Squiz OutputBufferingIndentSniff that was checking the same thing
- PHP_CodeSniffer_File::getMemberProperties() performance improved significantly
    - Improves performance of Squiz ValidVariableNameSniff significantly
- Squiz OperatorSpacingSniff performance improved significantly
- Squiz NonExecutableCodeSniff performance improved significantly
    - Will throw duplicate errors in some cases now, but these should be rare
- MySource IncludeSystemSniff performance improved significantly
- MySource JoinStringsSniff no longer reports an error when using join() on a named JS array
- Warnings are now reported for each file when they cannot be opened instead of stopping the script
    - Hide warnings with the -n command line argument
    - Can override the warnings using the code Internal.DetectLineEndings

### Fixed
- Fixed bug [#17693][pear-17693] : issue with pre-commit hook script with filenames that start with v
- Fixed bug [#17860][pear-17860] : isReference function fails with references in array
    - Thanks to [Lincoln Maskey][pear-ljmaskey] for the patch
- Fixed bug [#17902][pear-17902] : Cannot run tests when tests are symlinked into tests dir
    - Thanks to [Matt Button][@BRMatt] for the patch
- Fixed bug [#17928][pear-17928] : Improve error message for Generic_Sniffs_PHP_UpperCaseConstantSniff
    - Thanks to [Stefano Kowalke][@Konafets] for the patch
- Fixed bug [#18039][pear-18039] : JS Tokenizer crash when ] is last character in file
- Fixed bug [#18047][pear-18047] : Incorrect handling of namespace aliases as constants
    - Thanks to [Dmitri Medvedev][pear-dvino] for the patch
- Fixed bug [#18072][pear-18072] : Impossible to exclude path from processing when symlinked
- Fixed bug [#18073][pear-18073] : Squiz.PHP.NonExecutableCode fault
- Fixed bug [#18117][pear-18117] : PEAR coding standard: Method constructor not sniffed as a function
- Fixed bug [#18135][pear-18135] : Generic FunctionCallArgumentSpacingSniff reports function declaration errors
- Fixed bug [#18140][pear-18140] : Generic scope indent in exact mode: strange expected/found values for switch
- Fixed bug [#18145][pear-18145] : Sniffs are not loaded for custom ruleset file
    - Thanks to [Scott McCammon][pear-mccammos] for the patch
- Fixed bug [#18152][pear-18152] : While and do-while with AbstractPatternSniff
- Fixed bug [#18191][pear-18191] : Squiz.PHP.LowercasePHPFunctions does not work with new Date()
- Fixed bug [#18193][pear-18193] : CodeSniffer doesn't reconize CR (\r) line endings

[pear-12434]: https://pear.php.net/bugs/bug.php?id=12434
[pear-14237]: https://pear.php.net/bugs/bug.php?id=14237
[pear-17244]: https://pear.php.net/bugs/bug.php?id=17244
[pear-17611]: https://pear.php.net/bugs/bug.php?id=17611
[pear-17693]: https://pear.php.net/bugs/bug.php?id=17693
[pear-17860]: https://pear.php.net/bugs/bug.php?id=17860
[pear-17902]: https://pear.php.net/bugs/bug.php?id=17902
[pear-17903]: https://pear.php.net/bugs/bug.php?id=17903
[pear-17928]: https://pear.php.net/bugs/bug.php?id=17928
[pear-18039]: https://pear.php.net/bugs/bug.php?id=18039
[pear-18047]: https://pear.php.net/bugs/bug.php?id=18047
[pear-18072]: https://pear.php.net/bugs/bug.php?id=18072
[pear-18073]: https://pear.php.net/bugs/bug.php?id=18073
[pear-18117]: https://pear.php.net/bugs/bug.php?id=18117
[pear-18135]: https://pear.php.net/bugs/bug.php?id=18135
[pear-18140]: https://pear.php.net/bugs/bug.php?id=18140
[pear-18145]: https://pear.php.net/bugs/bug.php?id=18145
[pear-18152]: https://pear.php.net/bugs/bug.php?id=18152
[pear-18165]: https://pear.php.net/bugs/bug.php?id=18165
[pear-18191]: https://pear.php.net/bugs/bug.php?id=18191
[pear-18193]: https://pear.php.net/bugs/bug.php?id=18193

## 1.3.0RC1 - 2010-09-03

### Changed
- Added exclude pattern support to ruleset.xml file so you can specify ignore patterns in a standard (request [#17683][pear-17683])
    - Use new exclude-pattern tags to include the ignore rules into your ruleset.xml file
    - See CodeSniffer/Standards/PHPCS/ruleset.xml for an example
- Added new --encoding command line argument to specify the encoding of the files being checked
    - When set to utf-8, stops the XML-based reports from double-encoding
    - When set to something else, helps the XML-based reports encode to utf-8
    - Default value is iso-8859-1 but can be changed with `--config-set encoding [value]`
- The report is no longer printed to screen when using the --report-file command line option (request [#17467][pear-17467])
    - If you want to print it to screen as well, use the -v command line argument
- The SVN and GIT blame reports now also show percentage of reported errors per author (request [#17606][pear-17606])
    - Thanks to [Ben Selby][@benmatselby] for the patch
- Updated the SVN pre-commit hook to work with the new severity levels feature
- Generic SubversionPropertiesSniff now allows properties to have NULL values (request [#17682][pear-17682])
    - A null value indicates that the property should exist but the value should not be checked
- Generic UpperCaseConstantName Sniff now longer complains about the PHPUnit_MAIN_METHOD constant (request [#17798][pear-17798])
- Squiz FileComment sniff now checks JS files as well as PHP files
- Squiz FunctionCommentSniff now supports namespaces in type hints

### Fixed
- Fixed a problem in Squiz OutputBufferingIndentSniff where block comments were reported as not indented
- Fixed bug [#17092][pear-17092] : Problems with utf8_encode and htmlspecialchars with non-ascii chars
    - Use the new --encoding=utf-8 command line argument if your files are utf-8 encoded
- Fixed bug [#17629][pear-17629] : PHP_CodeSniffer_Tokens::$booleanOperators missing T_LOGICAL_XOR
    - Thanks to [Matthew Turland][@elazar] for the patch
- Fixed bug [#17699][pear-17699] : Fatal error generating code coverage with PHPUnit 5.3.0RC1
- Fixed bug [#17718][pear-17718] : Namespace 'use' statement: used global class name is recognized as constant
- Fixed bug [#17734][pear-17734] : Generic SubversionPropertiesSniff complains on non SVN files
- Fixed bug [#17742][pear-17742] : EmbeddedPhpSniff reacts negatively to file without closing PHP tag
- Fixed bug [#17823][pear-17823] : Notice: Please no longer include `PHPUnit/Framework.php`

[pear-17092]: https://pear.php.net/bugs/bug.php?id=17092
[pear-17467]: https://pear.php.net/bugs/bug.php?id=17467
[pear-17606]: https://pear.php.net/bugs/bug.php?id=17606
[pear-17629]: https://pear.php.net/bugs/bug.php?id=17629
[pear-17682]: https://pear.php.net/bugs/bug.php?id=17682
[pear-17683]: https://pear.php.net/bugs/bug.php?id=17683
[pear-17699]: https://pear.php.net/bugs/bug.php?id=17699
[pear-17718]: https://pear.php.net/bugs/bug.php?id=17718
[pear-17734]: https://pear.php.net/bugs/bug.php?id=17734
[pear-17742]: https://pear.php.net/bugs/bug.php?id=17742
[pear-17798]: https://pear.php.net/bugs/bug.php?id=17798
[pear-17823]: https://pear.php.net/bugs/bug.php?id=17823

## 1.3.0a1 - 2010-07-15

### Changed
- All `CodingStandard.php` files have been replaced by `ruleset.xml` files
    - Custom standards will need to be converted over to this new format to continue working
- You can specify a path to your own custom ruleset.xml file by using the --standard command line arg
    - e.g., phpcs --standard=/path/to/my/ruleset.xml
- Added a new report type --report=gitblame to show how many errors and warnings were committed by each author
    - Has the same functionality as the svnblame report
    - Thanks to [Ben Selby][@benmatselby] for the patch
- A new token type T_DOLLAR has been added to allow you to sniff for variable variables (feature request [#17095][pear-17095])
    - Thanks to [Ian Young][pear-youngian] for the patch
- JS tokenizer now supports T_POWER (^) and T_MOD_EQUAL (%=) tokens (feature request [#17441][pear-17441])
- If you have PHP_Timer installed, you'll now get a time/memory summary at the end of a script run
    - Only happens when printing reports that are designed to be read on the command line
- Added Generic DeprecatedFunctionsSniff to warn about the use of deprecated functions (feature request [#16694][pear-16694])
    - Thanks to [Sebastian Bergmann][@sebastianbergmann] for the patch
- Added Squiz LogicalOperatorSniff to ensure that logical operators are surrounded by single spaces
- Added MySource ChannelExceptionSniff to ensure action files only throw ChannelException
- Added new method getClassProperties() for sniffs to use to determine if a class is abstract and/or final
    - Thanks to [Christian Kaps][@akkie] for the patch
- Generic UpperCaseConstantSniff no longer throws errors about namespaces
    - Thanks to [Christian Kaps][@akkie] for the patch
- Squiz OperatorBracketSniff now correctly checks value assignments in arrays
- Squiz LongConditionClosingCommentSniff now requires a comment for long CASE statements that use curly braces
- Squiz LongConditionClosingCommentSniff now requires an exact comment match on the brace
- MySource IncludeSystemSniff now ignores DOMDocument usage
- MySource IncludeSystemSniff no longer requires inclusion of systems that are being implemented
- Removed found and expected messages from Squiz ConcatenationSpacingSniff because they were messy and not helpful

### Fixed
- Fixed a problem where Generic CodeAnalysisSniff could show warnings if checking multi-line strings
- Fixed error messages in Squiz ArrayDeclarationSniff reporting incorrect number of found and expected spaces
- Fixed bug [#17048][pear-17048] : False positive in Squiz_WhiteSpace_ScopeKeywordSpacingSniff
- Fixed bug [#17054][pear-17054] : phpcs more strict than PEAR CS regarding function parameter spacing
- Fixed bug [#17096][pear-17096] : Notice: Undefined index: `scope_condition` in `ScopeClosingBraceSniff.php`
    - Moved PEAR.Functions.FunctionCallArgumentSpacing to Generic.Functions.FunctionCallArgumentSpacing
- Fixed bug [#17144][pear-17144] : Deprecated: Function eregi() is deprecated
- Fixed bug [#17236][pear-17236] : PHP Warning due to token_get_all() in DoubleQuoteUsageSniff
- Fixed bug [#17243][pear-17243] : Alternate Switch Syntax causes endless loop of Notices in SwitchDeclaration
- Fixed bug [#17313][pear-17313] : Bug with switch case structure
- Fixed bug [#17331][pear-17331] : Possible parse error: interfaces may not include member vars
- Fixed bug [#17337][pear-17337] : CSS tokenizer fails on quotes urls
- Fixed bug [#17420][pear-17420] : Uncaught exception when comment before function brace
- Fixed bug [#17503][pear-17503] : closures formatting is not supported

[pear-16694]: https://pear.php.net/bugs/bug.php?id=16694
[pear-17048]: https://pear.php.net/bugs/bug.php?id=17048
[pear-17054]: https://pear.php.net/bugs/bug.php?id=17054
[pear-17095]: https://pear.php.net/bugs/bug.php?id=17095
[pear-17096]: https://pear.php.net/bugs/bug.php?id=17096
[pear-17144]: https://pear.php.net/bugs/bug.php?id=17144
[pear-17236]: https://pear.php.net/bugs/bug.php?id=17236
[pear-17243]: https://pear.php.net/bugs/bug.php?id=17243
[pear-17313]: https://pear.php.net/bugs/bug.php?id=17313
[pear-17331]: https://pear.php.net/bugs/bug.php?id=17331
[pear-17337]: https://pear.php.net/bugs/bug.php?id=17337
[pear-17420]: https://pear.php.net/bugs/bug.php?id=17420
[pear-17441]: https://pear.php.net/bugs/bug.php?id=17441
[pear-17503]: https://pear.php.net/bugs/bug.php?id=17503

## 1.2.2 - 2010-01-27

### Changed
- The core PHP_CodeSniffer_File methods now understand the concept of closures (feature request [#16866][pear-16866])
    - Thanks to [Christian Kaps][@akkie] for the sample code
- Sniffs can now specify violation codes for each error and warning they add
    - Future versions will allow you to override messages and severities using these codes
    - Specifying a code is optional, but will be required if you wish to support overriding
- All reports have been broken into separate classes
    - Command line usage and report output remains the same
    - Thanks to Gabriele Santini for the patch
- Added an interactive mode that can be enabled using the -a command line argument
    - Scans files and stops when it finds a file with errors
    - Waits for user input to recheck the file (hopefully you fixed the errors) or skip the file
    - Useful for very large code bases where full rechecks take a while
- The reports now show the correct number of errors and warnings found
- The isCamelCaps method now allows numbers in class names
- The JS tokenizer now correctly identifies boolean and bitwise AND and OR tokens
- The JS tokenizer now correctly identifies regular expressions used in conditions
- PEAR ValidFunctionNameSniff now ignores closures
- Squiz standard now uses the PEAR setting of 85 chars for LineLengthSniff
- Squiz ControlStructureSpacingSniff now ensure there are no spaces around parentheses
- Squiz LongConditionClosingCommentSniff now checks for comments at the end of try/catch statements
- Squiz LongConditionClosingCommentSniff now checks validity of comments for short structures if they exist
- Squiz IncrementDecrementUsageSniff now has better checking to ensure it only looks at simple variable assignments
- Squiz PostStatementCommentSniff no longer throws errors for end function comments
- Squiz InlineCommentSniff no longer throws errors for end function comments
- Squiz OperatorBracketSniff now allows simple arithmetic operations in SWITCH conditions
- Squiz ValidFunctionNameSniff now ignores closures
- Squiz MethodScopeSniff now ignores closures
- Squiz ClosingDeclarationCommentSniff now ignores closures
- Squiz GlobalFunctionSniff now ignores closures
- Squiz DisallowComparisonAssignmentSniff now ignores the assigning of arrays
- Squiz DisallowObjectStringIndexSniff now allows indexes that contain dots and reserved words
- Squiz standard now throws nesting level and cyclomatic complexity errors at much higher levels
- Squiz CommentedOutCodeSniff now ignores common comment framing characters
- Squiz ClassCommentSniff now ensures the open comment tag is the only content on the first line
- Squiz FileCommentSniff now ensures the open comment tag is the only content on the first line
- Squiz FunctionCommentSniff now ensures the open comment tag is the only content on the first line
- Squiz VariableCommentSniff now ensures the open comment tag is the only content on the first line
- Squiz NonExecutableCodeSniff now warns about empty return statements that are not required
- Removed ForbiddenStylesSniff from Squiz standard
    - It is now in the MySource standard as BrowserSpecificStylesSniff
    - New BrowserSpecificStylesSniff ignores files with browser-specific suffixes
- MySource IncludeSystemSniff no longer throws errors when extending the Exception class
- MySource IncludeSystemSniff no longer throws errors for the abstract widget class
- MySource IncludeSystemSniff and UnusedSystemSniff now allow includes inside IF statements
- MySource IncludeSystemSniff no longer throws errors for included widgets inside methods
- MySource GetRequestDataSniff now throws errors for using $_FILES
- MySource CreateWidgetTypeCallbackSniff now allows return statements in nested functions
- MySource DisallowSelfActionsSniff now ignores abstract classes

### Fixed
- Fixed a problem with the SVN pre-commit hook for PHP versions without vertical whitespace regex support
- Fixed bug [#16740][pear-16740] : False positives for heredoc strings and unused parameter sniff
- Fixed bug [#16794][pear-16794] : ValidLogicalOperatorsSniff doesn't report operators not in lowercase
- Fixed bug [#16804][pear-16804] : Report filename is shortened too much
- Fixed bug [#16821][pear-16821] : Bug in Squiz_Sniffs_WhiteSpace_OperatorSpacingSniff
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Fixed bug [#16836][pear-16836] : Notice raised when using semicolon to open case
- Fixed bug [#16855][pear-16855] : Generic standard sniffs incorrectly for define() method
- Fixed bug [#16865][pear-16865] : Two bugs in Squiz_Sniffs_WhiteSpace_OperatorSpacingSniff
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Fixed bug [#16902][pear-16902] : Inline If Declaration bug
- Fixed bug [#16960][pear-16960] : False positive for late static binding in Squiz/ScopeKeywordSpacingSniff
    - Thanks to [Jakub Tománek][pear-thezero] for the patch
- Fixed bug [#16976][pear-16976] : The phpcs attempts to process symbolic links that don't resolve to files
- Fixed bug [#17017][pear-17017] : Including one file in the files sniffed alters errors reported for another file

[pear-16740]: https://pear.php.net/bugs/bug.php?id=16740
[pear-16794]: https://pear.php.net/bugs/bug.php?id=16794
[pear-16804]: https://pear.php.net/bugs/bug.php?id=16804
[pear-16821]: https://pear.php.net/bugs/bug.php?id=16821
[pear-16836]: https://pear.php.net/bugs/bug.php?id=16836
[pear-16855]: https://pear.php.net/bugs/bug.php?id=16855
[pear-16865]: https://pear.php.net/bugs/bug.php?id=16865
[pear-16866]: https://pear.php.net/bugs/bug.php?id=16866
[pear-16902]: https://pear.php.net/bugs/bug.php?id=16902
[pear-16960]: https://pear.php.net/bugs/bug.php?id=16960
[pear-16976]: https://pear.php.net/bugs/bug.php?id=16976
[pear-17017]: https://pear.php.net/bugs/bug.php?id=17017

## 1.2.1 - 2009-11-17

### Changed
- Added a new report type --report=svnblame to show how many errors and warnings were committed by each author
    - Also shows the percentage of their code that are errors and warnings
    - Requires you to have the SVN command in your path
    - Make sure SVN is storing usernames and passwords (if required) or you will need to enter them for each file
    - You can also use the -s command line argument to see the different types of errors authors are committing
    - You can use the -v command line argument to see all authors, even if they have no errors or warnings
- Added a new command line argument --report-width to allow you to set the column width of screen reports
    - Reports won't accept values less than 70 or else they get too small
    - Can also be set via a config var: phpcs --config-set report_width 100
- You can now get PHP_CodeSniffer to ignore a whole file by adding @codingStandardsIgnoreFile in the content
    - If you put it in the first two lines the file won't even be tokenized, so it will be much quicker
- Reports now print their file lists in alphabetical order
- PEAR FunctionDeclarationSniff now reports error for incorrect closing bracket placement in multi-line definitions
- Added Generic CallTimePassByReferenceSniff to prohibit the passing of variables into functions by reference
    - Thanks to Florian Grandel for the contribution
- Added Squiz DisallowComparisonAssignmentSniff to ban the assignment of comparison values to a variable
- Added Squiz DuplicateStyleDefinitionSniff to check for duplicate CSS styles in a single class block
- Squiz ArrayDeclarationSniff no longer checks the case of array indexes because that is not its job
- Squiz PostStatementCommentSniff now allows end comments for class member functions
- Squiz InlineCommentSniff now supports the checking of JS files
- MySource CreateWidgetTypeCallbackSniff now allows the callback to be passed to another function
- MySource CreateWidgetTypeCallbackSniff now correctly ignores callbacks used inside conditions
- Generic MultipleStatementAlignmentSniff now enforces a single space before equals sign if max padding is reached
- Fixed a problem in the JS tokenizer where regular expressions containing \// were not converted correctly
- Fixed a problem tokenizing CSS files where multiple ID targets on a line would look like comments
- Fixed a problem tokenizing CSS files where class names containing a colon looked like style definitions
- Fixed a problem tokenizing CSS files when style statements had empty url() calls
- Fixed a problem tokenizing CSS colours with the letter E in first half of the code
- Squiz ColonSpacingSniff now ensures it is only checking style definitions in CSS files and not class names
- Squiz DisallowComparisonAssignmentSniff no longer reports errors when assigning the return value of a function
- CSS tokenizer now correctly supports multi-line comments
- When only the case of var names differ for function comments, the error now indicates the case is different

### Fixed
- Fixed an issue with Generic UnnecessaryStringConcatSniff where it incorrectly suggested removing a concat
- Fixed bug [#16530][pear-16530] : ScopeIndentSniff reports false positive
- Fixed bug [#16533][pear-16533] : Duplicate errors and warnings
- Fixed bug [#16563][pear-16563] : Check file extensions problem in phpcs-svn-pre-commit
    - Thanks to [Kaijung Chen][pear-et3w503] for the patch
- Fixed bug [#16592][pear-16592] : Object operator indentation incorrect when first operator is on a new line
- Fixed bug [#16641][pear-16641] : Notice output
- Fixed bug [#16682][pear-16682] : Squiz_Sniffs_Strings_DoubleQuoteUsageSniff reports string "\0" as invalid
- Fixed bug [#16683][pear-16683] : Typing error in PHP_CodeSniffer_CommentParser_AbstractParser
- Fixed bug [#16684][pear-16684] : Bug in Squiz_Sniffs_PHP_NonExecutableCodeSniff
- Fixed bug [#16692][pear-16692] : Spaces in paths in Squiz_Sniffs_Debug_JavaScriptLintSniff
    - Thanks to [Jaroslav Hanslík][@kukulich] for the patch
- Fixed bug [#16696][pear-16696] : Spelling error in MultiLineConditionSniff
- Fixed bug [#16697][pear-16697] : MultiLineConditionSniff incorrect result with inline IF
- Fixed bug [#16698][pear-16698] : Notice in JavaScript Tokenizer
- Fixed bug [#16736][pear-16736] : Multi-files sniffs aren't processed when FILE is a single directory
    - Thanks to [Alexey Shein][pear-conf] for the patch
- Fixed bug [#16792][pear-16792] : Bug in Generic_Sniffs_PHP_ForbiddenFunctionsSniff

[pear-16530]: https://pear.php.net/bugs/bug.php?id=16530
[pear-16533]: https://pear.php.net/bugs/bug.php?id=16533
[pear-16563]: https://pear.php.net/bugs/bug.php?id=16563
[pear-16592]: https://pear.php.net/bugs/bug.php?id=16592
[pear-16641]: https://pear.php.net/bugs/bug.php?id=16641
[pear-16682]: https://pear.php.net/bugs/bug.php?id=16682
[pear-16683]: https://pear.php.net/bugs/bug.php?id=16683
[pear-16684]: https://pear.php.net/bugs/bug.php?id=16684
[pear-16692]: https://pear.php.net/bugs/bug.php?id=16692
[pear-16696]: https://pear.php.net/bugs/bug.php?id=16696
[pear-16697]: https://pear.php.net/bugs/bug.php?id=16697
[pear-16698]: https://pear.php.net/bugs/bug.php?id=16698
[pear-16736]: https://pear.php.net/bugs/bug.php?id=16736
[pear-16792]: https://pear.php.net/bugs/bug.php?id=16792

## 1.2.0 - 2009-08-17

### Changed
- Installed standards are now favoured over custom standards when using the cmd line arg with relative paths
- Unit tests now use a lot less memory while running
- Squiz standard now uses Generic EmptyStatementSniff but throws errors instead of warnings
- Squiz standard now uses Generic UnusedFunctionParameterSniff
- Removed unused ValidArrayIndexNameSniff from the Squiz standard

### Fixed
- Fixed bug [#16424][pear-16424] : SubversionPropertiesSniff print PHP Warning
- Fixed bug [#16450][pear-16450] : Constant `PHP_CODESNIFFER_VERBOSITY` already defined (unit tests)
- Fixed bug [#16453][pear-16453] : function declaration long line splitted error
- Fixed bug [#16482][pear-16482] : phpcs-svn-pre-commit ignores extensions parameter

[pear-16424]: https://pear.php.net/bugs/bug.php?id=16424
[pear-16450]: https://pear.php.net/bugs/bug.php?id=16450
[pear-16453]: https://pear.php.net/bugs/bug.php?id=16453
[pear-16482]: https://pear.php.net/bugs/bug.php?id=16482

## 1.2.0RC3 - 2009-07-07

### Changed
- You can now use @codingStandardsIgnoreStart and @...End comments to suppress messages (feature request [#14002][pear-14002])
- A warning is now included for files without any code when short_open_tag is set to Off (feature request [#12952][pear-12952])
- You can now use relative paths to your custom standards with the --standard cmd line arg (feature request [#14967][pear-14967])
- You can now override magic methods and functions in PEAR ValidFunctionNameSniff (feature request [#15830][pear-15830])
- MySource IncludeSystemSniff now recognises widget action classes
- MySource IncludeSystemSniff now knows about unit test classes and changes rules accordingly

[pear-12952]: https://pear.php.net/bugs/bug.php?id=12952
[pear-14002]: https://pear.php.net/bugs/bug.php?id=14002
[pear-14967]: https://pear.php.net/bugs/bug.php?id=14967
[pear-15830]: https://pear.php.net/bugs/bug.php?id=15830

## 1.2.0RC2 - 2009-05-25

### Changed
- Test suite can now be run using the full path to `AllTests.php` (feature request [#16179][pear-16179])

### Fixed
- Fixed bug [#15980][pear-15980] : PHP_CodeSniffer change PHP current directory
    - Thanks to [Dolly Aswin Harahap][pear-dollyaswin] for the patch
- Fixed bug [#16001][pear-16001] : Notice triggered
- Fixed bug [#16054][pear-16054] : phpcs-svn-pre-commit not showing any errors
- Fixed bug [#16071][pear-16071] : Fatal error: Uncaught PHP_CodeSniffer_Exception
- Fixed bug [#16170][pear-16170] : Undefined Offset -1 in `MultiLineConditionSniff.php` on line 68
- Fixed bug [#16175][pear-16175] : Bug in Squiz-IncrementDecrementUsageSniff

[pear-15980]: https://pear.php.net/bugs/bug.php?id=15980
[pear-16001]: https://pear.php.net/bugs/bug.php?id=16001
[pear-16054]: https://pear.php.net/bugs/bug.php?id=16054
[pear-16071]: https://pear.php.net/bugs/bug.php?id=16071
[pear-16170]: https://pear.php.net/bugs/bug.php?id=16170
[pear-16175]: https://pear.php.net/bugs/bug.php?id=16175
[pear-16179]: https://pear.php.net/bugs/bug.php?id=16179

## 1.2.0RC1 - 2009-03-09

### Changed
- Reports that are output to a file now include a trailing newline at the end of the file
- Fixed sniff names not shown in -vvv token processing output
- Added Generic SubversionPropertiesSniff to check that specific svn props are set for files
    - Thanks to Jack Bates for the contribution
- The PHP version check can now be overridden in classes that extend PEAR FileCommentSniff
    - Thanks to [Helgi Þormar Þorbjörnsson][@helgi] for the suggestion
- Added Generic ConstructorNameSniff to check for PHP4 constructor name usage
    - Thanks to Leif Wickland for the contribution
- Squiz standard now supports multi-line function and condition sniffs from PEAR standard
- Squiz standard now uses Generic ConstructorNameSniff
- Added MySource GetRequestDataSniff to ensure REQUEST, GET and POST are not accessed directly
- Squiz OperatorBracketSniff now allows square brackets in simple unbracketed operations

### Fixed
- Fixed the incorrect tokenizing of multi-line block comments in CSS files
- Fixed bug [#15383][pear-15383] : Uncaught PHP_CodeSniffer_Exception
- Fixed bug [#15408][pear-15408] : An unexpected exception has been caught: Undefined offset: 2
- Fixed bug [#15519][pear-15519] : Uncaught PHP_CodeSniffer_Exception
- Fixed bug [#15624][pear-15624] : Pre-commit hook fails with PHP errors
- Fixed bug [#15661][pear-15661] : Uncaught PHP_CodeSniffer_Exception
- Fixed bug [#15722][pear-15722] : "declare(encoding = 'utf-8');" leads to "Missing file doc comment"
- Fixed bug [#15910][pear-15910] : Object operator indention not calculated correctly

[pear-15383]: https://pear.php.net/bugs/bug.php?id=15383
[pear-15408]: https://pear.php.net/bugs/bug.php?id=15408
[pear-15519]: https://pear.php.net/bugs/bug.php?id=15519
[pear-15624]: https://pear.php.net/bugs/bug.php?id=15624
[pear-15661]: https://pear.php.net/bugs/bug.php?id=15661
[pear-15722]: https://pear.php.net/bugs/bug.php?id=15722
[pear-15910]: https://pear.php.net/bugs/bug.php?id=15910

## 1.2.0a1 - 2008-12-18

### Changed
- PHP_CodeSniffer now has a CSS tokenizer for checking CSS files
- Added support for a new multi-file sniff that sniffs all processed files at once
- Added new output format --report=emacs to output errors using the emacs standard compile output format
    - Thanks to Len Trigg for the contribution
- Reports can now be written to a file using the --report-file command line argument (feature request [#14953][pear-14953])
    - The report is also written to screen when using this argument
- The CheckStyle, CSV and XML reports now include a source for each error and warning (feature request [#13242][pear-13242])
    - A new report type --report=source can be used to show you the most common errors in your files
- Added new command line argument -s to show error sources in all reports
- Added new command line argument --sniffs to specify a list of sniffs to restrict checking to
    - Uses the sniff source codes that are optionally displayed in reports
- Changed the max width of error lines from 80 to 79 chars to stop blank lines in the default windows cmd window
- PHP_CodeSniffer now has a token for an asperand (@ symbol) so sniffs can listen for them
    - Thanks to Andy Brockhurst for the patch
- Added Generic DuplicateClassNameSniff that will warn if the same class name is used in multiple files
    - Not currently used by any standard; more of a multi-file sniff sample than anything useful
- Added Generic NoSilencedErrorsSniff that warns if PHP errors are being silenced using the @ symbol
    - Thanks to Andy Brockhurst for the contribution
- Added Generic UnnecessaryStringConcatSniff that checks for two strings being concatenated
- Added PEAR FunctionDeclarationSniff to enforce the new multi-line function declaration PEAR standard
- Added PEAR MultiLineAssignmentSniff to enforce the correct indentation of multi-line assignments
- Added PEAR MultiLineConditionSniff to enforce the new multi-line condition PEAR standard
- Added PEAR ObjectOperatorIndentSniff to enforce the new chained function call PEAR standard
- Added MySource DisallowSelfActionSniff to ban the use of self::method() calls in Action classes
- Added MySource DebugCodeSniff to ban the use of Debug::method() calls
- Added MySource CreateWidgetTypeCallback sniff to check callback usage in widget type create methods
- Added Squiz DisallowObjectStringIndexSniff that forces object dot notation in JavaScript files
    - Thanks to [Sertan Danis][@sertand] for the contribution
- Added Squiz DiscouragedFunctionsSniff to warn when using debug functions
- Added Squiz PropertyLabelSniff to check whitespace around colons in JS property and label declarations
- Added Squiz DuplicatePropertySniff to check for duplicate property names in JS classes
- Added Squiz ColonSpacingSniff to check for spacing around colons in CSS style definitions
- Added Squiz SemicolonSpacingSniff to check for spacing around semicolons in CSS style definitions
- Added Squiz IndentationSniff to check for correct indentation of CSS files
- Added Squiz ColourDefinitionSniff to check that CSS colours are defined in uppercase and using shorthand
- Added Squiz EmptyStyleDefinitionSniff to check for CSS style definitions without content
- Added Squiz EmptyClassDefinitionSniff to check for CSS class definitions without content
- Added Squiz ClassDefinitionOpeningBraceSpaceSniff to check for spaces around opening brace of CSS class definitions
- Added Squiz ClassDefinitionClosingBraceSpaceSniff to check for a single blank line after CSS class definitions
- Added Squiz ClassDefinitionNameSpacingSniff to check for a blank lines inside CSS class definition names
- Added Squiz DisallowMultipleStyleDefinitionsSniff to check for multiple style definitions on a single line
- Added Squiz DuplicateClassDefinitionSniff to check for duplicate CSS class blocks that can be merged
- Added Squiz ForbiddenStylesSniff to check for usage of browser specific styles
- Added Squiz OpacitySniff to check for incorrect opacity values in CSS
- Added Squiz LowercaseStyleDefinitionSniff to check for styles that are not defined in lowercase
- Added Squiz MissingColonSniff to check for style definitions where the colon has been forgotten
- Added Squiz MultiLineFunctionDeclarationSniff to check that multi-line declarations contain one param per line
- Added Squiz JSLintSniff to check for JS errors using the jslint.js script through Rhino
    - Set jslint path using phpcs --config-set jslint_path /path/to/jslint.js
    - Set rhino path using phpcs --config-set rhino_path /path/to/rhino
- Added Generic TodoSniff that warns about comments that contain the word TODO
- Removed MultipleStatementAlignmentSniff from the PEAR standard as alignment is now optional
- Generic ForbiddenFunctionsSniff now has protected member var to specify if it should use errors or warnings
- Generic MultipleStatementAlignmentSniff now has correct error message if assignment is on a new line
- Generic MultipleStatementAlignmentSniff now has protected member var to allow it to ignore multi-line assignments
- Generic LineEndingsSniff now supports checking of JS files
- Generic LineEndingsSniff now supports checking of CSS files
- Generic DisallowTabIndentSniff now supports checking of CSS files
- Squiz DoubleQuoteUsageSniff now bans the use of variables in double quoted strings in favour of concatenation
- Squiz SuperfluousWhitespaceSniff now supports checking of JS files
- Squiz SuperfluousWhitespaceSniff now supports checking of CSS files
- Squiz DisallowInlineIfSniff now supports checking of JS files
- Squiz SemicolonSpacingSniff now supports checking of JS files
- Squiz PostStatementCommentSniff now supports checking of JS files
- Squiz FunctionOpeningBraceSpacingSniff now supports checking of JS files
- Squiz FunctionClosingBraceSpacingSniff now supports checking of JS files
    - Empty JS functions must have their opening and closing braces next to each other
- Squiz ControlStructureSpacingSniff now supports checking of JS files
- Squiz LongConditionClosingCommentSniff now supports checking of JS files
- Squiz OperatorSpacingSniff now supports checking of JS files
- Squiz SwitchDeclarationSniff now supports checking of JS files
- Squiz CommentedOutCodeSniff now supports checking of CSS files
- Squiz DisallowSizeFunctionsInLoopsSniff now supports checking of JS files for the use of object.length
- Squiz DisallowSizeFunctionsInLoopsSniff no longer complains about size functions outside of the FOR condition
- Squiz ControlStructureSpacingSniff now bans blank lines at the end of a control structure
- Squiz ForLoopDeclarationSniff no longer throws errors for JS FOR loops without semicolons
- Squiz MultipleStatementAlignmentSniff no longer throws errors if a statement would take more than 8 spaces to align
- Squiz standard now uses Generic TodoSniff
- Squiz standard now uses Generic UnnecessaryStringConcatSniff
- Squiz standard now uses PEAR MultiLineAssignmentSniff
- Squiz standard now uses PEAR MultiLineConditionSniff
- Zend standard now uses OpeningFunctionBraceBsdAllmanSniff (feature request [#14647][pear-14647])
- MySource JoinStringsSniff now bans the use of inline array joins and suggests the + operator
- Fixed incorrect errors that can be generated from abstract scope sniffs when moving to a new file
- Core tokenizer now matches orphaned curly braces in the same way as square brackets
- Whitespace tokens at the end of JS files are now added to the token stack
- JavaScript tokenizer now identifies properties and labels as new token types
- JavaScript tokenizer now identifies object definitions as a new token type and matches curly braces for them
- JavaScript tokenizer now identifies DIV_EQUAL and MUL_EQUAL tokens
- Improved regular expression detection in the JavaScript tokenizer
- Improve AbstractPatternSniff support so it can listen for any token type, not just weighted tokens

### Fixed
- Fixed Squiz DoubleQuoteUsageSniff so it works correctly with short_open_tag=Off
- Fixed bug [#14409][pear-14409] : Output of warnings to log file
- Fixed bug [#14520][pear-14520] : Notice: Undefined offset: 1 in `CodeSniffer/File.php` on line
- Fixed bug [#14637][pear-14637] : Call to processUnknownArguments() misses second parameter $pos
    - Thanks to [Peter Buri][pear-burci] for the patch
- Fixed bug [#14889][pear-14889] : Lack of clarity: licence or license
- Fixed bug [#15008][pear-15008] : Nested Parentheses in Control Structure Sniffs
- Fixed bug [#15091][pear-15091] : pre-commit hook attempts to sniff folders
    - Thanks to [Bruce Weirdan][pear-weirdan] for the patch
- Fixed bug [#15124][pear-15124] : `AbstractParser.php` uses deprecated `split()` function
    - Thanks to [Sebastian Bergmann][@sebastianbergmann] for the patch
- Fixed bug [#15188][pear-15188] : PHPCS vs HEREDOC strings
- Fixed bug [#15231][pear-15231] : Notice: Uninitialized string offset: 0 in `FileCommentSniff.php` on line 555
- Fixed bug [#15336][pear-15336] : Notice: Undefined offset: 2 in `CodeSniffer/File.php` on line

[pear-13242]: https://pear.php.net/bugs/bug.php?id=13242
[pear-14409]: https://pear.php.net/bugs/bug.php?id=14409
[pear-14520]: https://pear.php.net/bugs/bug.php?id=14520
[pear-14637]: https://pear.php.net/bugs/bug.php?id=14637
[pear-14647]: https://pear.php.net/bugs/bug.php?id=14647
[pear-14889]: https://pear.php.net/bugs/bug.php?id=14889
[pear-14953]: https://pear.php.net/bugs/bug.php?id=14953
[pear-15008]: https://pear.php.net/bugs/bug.php?id=15008
[pear-15091]: https://pear.php.net/bugs/bug.php?id=15091
[pear-15124]: https://pear.php.net/bugs/bug.php?id=15124
[pear-15188]: https://pear.php.net/bugs/bug.php?id=15188
[pear-15231]: https://pear.php.net/bugs/bug.php?id=15231
[pear-15336]: https://pear.php.net/bugs/bug.php?id=15336

## 1.1.0 - 2008-07-14

### Changed
- PEAR FileCommentSniff now allows tag orders to be overridden in child classes
    - Thanks to Jeff Hodsdon for the patch
- Added Generic DisallowMultipleStatementsSniff to ensure there is only one statement per line
- Squiz standard now uses DisallowMultipleStatementsSniff

### Fixed
- Fixed error in Zend ValidVariableNameSniff when checking vars in form: $class->{$var}
- Fixed bug [#14077][pear-14077] : Fatal error: Uncaught PHP_CodeSniffer_Exception: $stackPtr is not a class member
- Fixed bug [#14168][pear-14168] : Global Function -> Static Method and __autoload()
- Fixed bug [#14238][pear-14238] : Line length not checked at last line of a file
- Fixed bug [#14249][pear-14249] : wrong detection of scope_opener
- Fixed bug [#14250][pear-14250] : ArrayDeclarationSniff emit warnings at malformed array
- Fixed bug [#14251][pear-14251] : --extensions option doesn't work

## 1.1.0RC3 - 2008-07-03

### Changed
- PEAR FileCommentSniff now allows tag orders to be overridden in child classes
    - Thanks to Jeff Hodsdon for the patch
- Added Generic DisallowMultipleStatementsSniff to ensure there is only one statement per line
- Squiz standard now uses DisallowMultipleStatementsSniff

### Fixed
- Fixed error in Zend ValidVariableNameSniff when checking vars in form: $class->{$var}
- Fixed bug [#14077][pear-14077] : Fatal error: Uncaught PHP_CodeSniffer_Exception: $stackPtr is not a class member
- Fixed bug [#14168][pear-14168] : Global Function -> Static Method and __autoload()
- Fixed bug [#14238][pear-14238] : Line length not checked at last line of a file
- Fixed bug [#14249][pear-14249] : wrong detection of scope_opener
- Fixed bug [#14250][pear-14250] : ArrayDeclarationSniff emit warnings at malformed array
- Fixed bug [#14251][pear-14251] : --extensions option doesn't work

[pear-14077]: https://pear.php.net/bugs/bug.php?id=14077
[pear-14168]: https://pear.php.net/bugs/bug.php?id=14168
[pear-14238]: https://pear.php.net/bugs/bug.php?id=14238
[pear-14249]: https://pear.php.net/bugs/bug.php?id=14249
[pear-14250]: https://pear.php.net/bugs/bug.php?id=14250
[pear-14251]: https://pear.php.net/bugs/bug.php?id=14251

## 1.1.0RC2 - 2008-06-13

### Changed
- Permission denied errors now stop script execution but still display current errors (feature request [#14076][pear-14076])
- Added Squiz ValidArrayIndexNameSniff to ensure array indexes do not use camel case
- Squiz ArrayDeclarationSniff now ensures arrays are not declared with camel case index values
- PEAR ValidVariableNameSniff now alerts about a possible parse error for member vars inside an interface

### Fixed
- Fixed bug [#13921][pear-13921] : js parsing fails for comments on last line of file
- Fixed bug [#13922][pear-13922] : crash in case of malformed (but tokenized) PHP file
    - PEAR and Squiz ClassDeclarationSniff now throw warnings for possible parse errors
    - Squiz ValidClassNameSniff now throws warning for possible parse errors
    - Squiz ClosingDeclarationCommentSniff now throws additional warnings for parse errors

[pear-13921]: https://pear.php.net/bugs/bug.php?id=13921
[pear-13922]: https://pear.php.net/bugs/bug.php?id=13922
[pear-14076]: https://pear.php.net/bugs/bug.php?id=14076

## 1.1.0RC1 - 2008-05-13

### Changed
- Added support for multiple tokenizers so PHP_CodeSniffer can check more than just PHP files
    - PHP_CodeSniffer now has a JS tokenizer for checking JavaScript files
    - Sniffs need to be updated to work with additional tokenizers, or new sniffs written for them
- phpcs now exits with status 2 if the tokenizer extension has been disabled (feature request [#13269][pear-13269])
- Added scripts/phpcs-svn-pre-commit that can be used as an SVN pre-commit hook
    - Also reworked the way the phpcs script works to make it easier to wrap it with other functionality
    - Thanks to Jack Bates for the contribution
- Fixed error in phpcs error message when a supplied file does not exist
- Fixed a cosmetic error in AbstractPatternSniff where the "found" string was missing some content
- Added sniffs that implement part of the PMD rule catalog to the Generic standard
    - Thanks to [Manuel Pichler][@manuelpichler] for the contribution of all these sniffs.
- Squiz FunctionCommentThrowTagSniff no longer throws errors for function that only throw variables
- Generic ScopeIndentSniff now has private member to enforce exact indent matching
- Replaced Squiz DisallowCountInLoopsSniff with Squiz DisallowSizeFunctionsInLoopsSniff
    - Thanks to Jan Miczaika for the sniff
- Squiz BlockCommentSniff now checks inline doc block comments
- Squiz InlineCommentSniff now checks inline doc block comments
- Squiz BlockCommentSniff now checks for no blank line before first comment in a function
- Squiz DocCommentAlignmentSniff now ignores inline doc block comments
- Squiz ControlStructureSpacingSniff now ensures no blank lines at the start of control structures
- Squiz ControlStructureSpacingSniff now ensures no blank lines between control structure closing braces
- Squiz IncrementDecrementUsageSniff now ensures inc/dec ops are bracketed in string concats
- Squiz IncrementDecrementUsageSniff now ensures inc/dec ops are not used in arithmetic operations
- Squiz FunctionCommentSniff no longer throws errors if return value is mixed but function returns void somewhere
- Squiz OperatorBracketSniff no allows function call brackets to count as operator brackets
- Squiz DoubleQuoteUsageSniff now supports \x \f and \v (feature request [#13365][pear-13365])
- Squiz ComparisonOperatorUsageSniff now supports JS files
- Squiz ControlSignatureSniff now supports JS files
- Squiz ForLoopDeclarationSniff now supports JS files
- Squiz OperatorBracketSniff now supports JS files
- Squiz InlineControlStructureSniff now supports JS files
- Generic LowerCaseConstantSniff now supports JS files
- Generic DisallowTabIndentSniff now supports JS files
- Generic MultipleStatementAlignmentSniff now supports JS files
- Added Squiz ObjectMemberCommaSniff to ensure the last member of a JS object is not followed by a comma
- Added Squiz ConstantCaseSniff to ensure the PHP constants are uppercase and JS lowercase
- Added Squiz JavaScriptLintSniff to check JS files with JSL
    - Set path using phpcs --config-set jsl_path /path/to/jsl
- Added MySource FirebugConsoleSniff to ban the use of "console" for JS variable and function names
- Added MySource JoinStringsSniff to enforce the use of join() to concatenate JS strings
- Added MySource AssignThisSniff to ensure this is only assigned to a var called self
- Added MySource DisallowNewWidgetSniff to ban manual creation of widget objects
- Removed warning shown in Zend CodeAnalyzerSniff when the ZCA path is not set

### Fixed
- Fixed error in Squiz ValidVariableNameSniff when checking vars in the form $obj->$var
- Fixed error in Squiz DisallowMultipleAssignmentsSniff when checking vars in the form $obj->$var
- Fixed error in Squiz InlineCommentSniff where comments for class constants were seen as inline
- Fixed error in Squiz BlockCommentSniff where comments for class constants were not ignored
- Fixed error in Squiz OperatorBracketSniff where negative numbers were ignored during comparisons
- Fixed error in Squiz FunctionSpacingSniff where functions after member vars reported incorrect spacing
- Fixed bug [#13062][pear-13062] : Interface comments aren't handled in PEAR standard
    - Thanks to [Manuel Pichler][@manuelpichler] for the path
- Fixed bug [#13119][pear-13119] : PHP minimum requirement need to be fix
- Fixed bug [#13156][pear-13156] : Bug in Squiz_Sniffs_PHP_NonExecutableCodeSniff
- Fixed bug [#13158][pear-13158] : Strange behaviour in AbstractPatternSniff
- Fixed bug [#13169][pear-13169] : Undefined variables
- Fixed bug [#13178][pear-13178] : Catch exception in `File.php`
- Fixed bug [#13254][pear-13254] : Notices output in checkstyle report causes XML issues
- Fixed bug [#13446][pear-13446] : crash with src of phpMyAdmin
    - Thanks to [Manuel Pichler][@manuelpichler] for the path

[pear-13062]: https://pear.php.net/bugs/bug.php?id=13062
[pear-13119]: https://pear.php.net/bugs/bug.php?id=13119
[pear-13156]: https://pear.php.net/bugs/bug.php?id=13156
[pear-13158]: https://pear.php.net/bugs/bug.php?id=13158
[pear-13169]: https://pear.php.net/bugs/bug.php?id=13169
[pear-13178]: https://pear.php.net/bugs/bug.php?id=13178
[pear-13254]: https://pear.php.net/bugs/bug.php?id=13254
[pear-13269]: https://pear.php.net/bugs/bug.php?id=13269
[pear-13365]: https://pear.php.net/bugs/bug.php?id=13365
[pear-13446]: https://pear.php.net/bugs/bug.php?id=13446

## 1.0.1a1 - 2008-04-21

### Changed
- Fixed error in PEAR ValidClassNameSniff when checking class names with double underscores
- Moved Squiz InlineControlStructureSniff into Generic standard
- PEAR standard now throws warnings for inline control structures
- Squiz OutputBufferingIndentSniff now ignores the indentation of inline HTML
- MySource IncludeSystemSniff now ignores usage of ZipArchive
- Removed "function" from error messages for Generic function brace sniffs (feature request [#13820][pear-13820])
- Generic UpperCaseConstantSniff no longer throws errors for declare(ticks = ...)
    - Thanks to Josh Snyder for the patch
- Squiz ClosingDeclarationCommentSniff and AbstractVariableSniff now throw warnings for possible parse errors

### Fixed
- Fixed bug [#13827][pear-13827] : AbstractVariableSniff throws "undefined index"
- Fixed bug [#13846][pear-13846] : Bug in Squiz.NonExecutableCodeSniff
- Fixed bug [#13849][pear-13849] : infinite loop in PHP_CodeSniffer_File::findNext()

[pear-13820]: https://pear.php.net/bugs/bug.php?id=13820
[pear-13827]: https://pear.php.net/bugs/bug.php?id=13827
[pear-13846]: https://pear.php.net/bugs/bug.php?id=13846
[pear-13849]: https://pear.php.net/bugs/bug.php?id=13849

## 1.0.1 - 2008-02-04

### Changed
- Squiz ArrayDeclarationSniff now throws error if the array keyword is followed by a space
- Squiz ArrayDeclarationSniff now throws error for empty multi-line arrays
- Squiz ArrayDeclarationSniff now throws error for multi-line arrays with a single value
- Squiz DocCommentAlignmentSniff now checks for a single space before tags inside docblocks
- Squiz ForbiddenFunctionsSniff now disallows is_null() to force use of (=== NULL) instead
- Squiz VariableCommentSniff now continues throwing errors after the first one is found
- Squiz SuperfluousWhitespaceSniff now throws errors for multiple blank lines inside functions
- MySource IncludedSystemSniff now checks extended class names
- MySource UnusedSystemSniff now checks extended and implemented class names
- MySource IncludedSystemSniff now supports includeWidget()
- MySource UnusedSystemSniff now supports includeWidget()
- Added PEAR ValidVariableNameSniff to check that only private member vars are prefixed with an underscore
- Added Squiz DisallowCountInLoopsSniff to check for the use of count() in FOR and WHILE loop conditions
- Added MySource UnusedSystemSniff to check for included classes that are never used

### Fixed
- Fixed a problem that caused the parentheses map to sometimes contain incorrect values
- Fixed bug [#12767][pear-12767] : Cant run phpcs from dir with PEAR subdir
- Fixed bug [#12773][pear-12773] : Reserved variables are not detected in strings
    - Thanks to [Wilfried Loche][pear-wloche] for the patch
- Fixed bug [#12832][pear-12832] : Tab to space conversion does not work
- Fixed bug [#12888][pear-12888] : extra space indentation = Notice: Uninitialized string offset...
- Fixed bug [#12909][pear-12909] : Default generateDocs function does not work under linux
    - Thanks to [Paul Smith][pear-thing2b] for the patch
- Fixed bug [#12957][pear-12957] : PHP 5.3 magic method __callStatic
    - Thanks to [Manuel Pichler][@manuelpichler] for the patch

[pear-12767]: https://pear.php.net/bugs/bug.php?id=12767
[pear-12773]: https://pear.php.net/bugs/bug.php?id=12773
[pear-12832]: https://pear.php.net/bugs/bug.php?id=12832
[pear-12888]: https://pear.php.net/bugs/bug.php?id=12888
[pear-12909]: https://pear.php.net/bugs/bug.php?id=12909
[pear-12957]: https://pear.php.net/bugs/bug.php?id=12957

## 1.0.0 - 2007-12-21

### Changed
- You can now specify the full path to a coding standard on the command line (feature request [#11886][pear-11886])
    - This allows you to use standards that are stored outside of PHP_CodeSniffer's own Standard dir
    - You can also specify full paths in the `CodingStandard.php` include and exclude methods
    - Classes, dirs and files need to be names as if the standard was part of PHP_CodeSniffer
    - Thanks to Dirk Thomas for the doc generator patch and testing
- Modified the scope map to keep checking after 3 lines for some tokens (feature request [#12561][pear-12561])
    - Those tokens that must have an opener (like T_CLASS) now keep looking until EOF
    - Other tokens (like T_FUNCTION) still stop after 3 lines for performance
- You can now escape commas in ignore patterns so they can be matched in file names
    - Thanks to [Carsten Wiedmann][pear-cwiedmann] for the patch
- Config data is now cached in a global var so the file system is not hit so often
    - You can also set config data temporarily for the script if you are using your own external script
    - Pass TRUE as the third argument to PHP_CodeSniffer::setConfigData()
- PEAR ClassDeclarationSniff no longer throws errors for multi-line class declarations
- Squiz ClassDeclarationSniff now ensures there is one blank line after a class closing brace
- Squiz ClassDeclarationSniff now throws errors for a missing end PHP tag after the end class tag
- Squiz IncrementDecrementUsageSniff no longer throws errors when -= and += are being used with vars
- Squiz SwitchDeclarationSniff now throws errors for switch statements that do not contain a case statement
    - Thanks to [Sertan Danis][@sertand] for the patch
- MySource IncludeSystemSniff no longer throws errors for the Util package

### Fixed
- Fixed bug [#12621][pear-12621] : "space after AS" check is wrong
    - Thanks to [Satoshi Oikawa][pear-renoiv] for the patch
- Fixed bug [#12645][pear-12645] : error message is wrong
    - Thanks to [Satoshi Oikawa][pear-renoiv] for the patch
- Fixed bug [#12651][pear-12651] : Increment/Decrement Operators Usage at -1

[pear-11886]: https://pear.php.net/bugs/bug.php?id=11886
[pear-12561]: https://pear.php.net/bugs/bug.php?id=12561
[pear-12621]: https://pear.php.net/bugs/bug.php?id=12621
[pear-12645]: https://pear.php.net/bugs/bug.php?id=12645
[pear-12651]: https://pear.php.net/bugs/bug.php?id=12651

## 1.0.0RC3 - 2007-11-30

### Changed
- Added new command line argument --tab-width that will convert tabs to spaces before testing
    - This allows you to use the existing sniffs that check for spaces even when you use tabs
    - Can also be set via a config var: phpcs --config-set tab_width 4
    - A value of zero (the default) tells PHP_CodeSniffer not to replace tabs with spaces
- You can now change the default report format from "full" to something else
    - Run: phpcs `--config-set report_format [format]`
- Improved performance by optimising the way the scope map is created during tokenizing
- Added new Squiz DisallowInlineIfSniff to disallow the usage of inline IF statements
- Fixed incorrect errors being thrown for nested switches in Squiz SwitchDeclarationSniff
- PEAR FunctionCommentSniff no longer complains about missing comments for @throws tags
- PEAR FunctionCommentSniff now throws error for missing exception class name for @throws tags
- PHP_CodeSniffer_File::isReference() now correctly returns for functions that return references
- Generic LineLengthSniff no longer warns about @version lines with CVS or SVN id tags
- Generic LineLengthSniff no longer warns about @license lines with long URLs
- Squiz FunctionCommentThrowTagSniff no longer complains about throwing variables
- Squiz ComparisonOperatorUsageSniff no longer throws incorrect errors for inline IF statements
- Squiz DisallowMultipleAssignmentsSniff no longer throws errors for assignments in inline IF statements

### Fixed
- Fixed bug [#12455][pear-12455] : CodeSniffer treats content inside heredoc as PHP code
- Fixed bug [#12471][pear-12471] : Checkstyle report is broken
- Fixed bug [#12476][pear-12476] : PHP4 destructors are reported as error
- Fixed bug [#12513][pear-12513] : Checkstyle XML messages need to be utf8_encode()d
    - Thanks to [Sebastian Bergmann][@sebastianbergmann] for the patch.
- Fixed bug [#12517][pear-12517] : getNewlineAfter() and dos files

[pear-12455]: https://pear.php.net/bugs/bug.php?id=12455
[pear-12471]: https://pear.php.net/bugs/bug.php?id=12471
[pear-12476]: https://pear.php.net/bugs/bug.php?id=12476
[pear-12513]: https://pear.php.net/bugs/bug.php?id=12513
[pear-12517]: https://pear.php.net/bugs/bug.php?id=12517

## 1.0.0RC2 - 2007-11-14

### Changed
- Added a new Checkstyle report format
    - Like the current XML format but modified to look like Checkstyle output
    - Thanks to [Manuel Pichler][@manuelpichler] for helping get the format correct
- You can now hide warnings by default
    - Run: phpcs --config-set show_warnings 0
    - If warnings are hidden by default, use the new -w command line argument to override
- Added new command line argument --config-delete to delete a config value and revert to the default
- Improved overall performance by optimising tokenizing and next/prev methods (feature request [#12421][pear-12421])
    - Thanks to [Christian Weiske][@cweiske] for the patch
- Added FunctionCallSignatureSniff to Squiz standard
- Added @subpackage support to file and class comment sniffs in PEAR standard (feature request [#12382][pear-12382])
    - Thanks to [Carsten Wiedmann][pear-cwiedmann] for the patch
- An error is now displayed if you use a PHP version less than 5.1.0 (feature request [#12380][pear-12380])
    - Thanks to [Carsten Wiedmann][pear-cwiedmann] for the patch
- phpcs now exits with status 2 if it receives invalid input (feature request [#12380][pear-12380])
    - This is distinct from status 1, which indicates errors or warnings were found
- Added new Squiz LanguageConstructSpacingSniff to throw errors for additional whitespace after echo etc.
- Removed Squiz ValidInterfaceNameSniff
- PEAR FunctionCommentSniff no longer complains about unknown tags

### Fixed
- Fixed incorrect errors about missing function comments in PEAR FunctionCommentSniff
- Fixed incorrect function docblock detection in Squiz FunctionCommentSniff
- Fixed incorrect errors for list() in Squiz DisallowMultipleAssignmentsSniff
- Errors no longer thrown if control structure is followed by a CASE's BREAK in Squiz ControlStructureSpacingSniff
- Fixed bug [#12368][pear-12368] : Autoloader cannot be found due to include_path override
    - Thanks to [Richard Quadling][pear-rquadling] for the patch
- Fixed bug [#12378][pear-12378] : equal sign alignments problem with while()

[pear-12368]: https://pear.php.net/bugs/bug.php?id=12368
[pear-12378]: https://pear.php.net/bugs/bug.php?id=12378
[pear-12380]: https://pear.php.net/bugs/bug.php?id=12380
[pear-12382]: https://pear.php.net/bugs/bug.php?id=12382
[pear-12421]: https://pear.php.net/bugs/bug.php?id=12421

## 1.0.0RC1 - 2007-11-01

### Changed
- Main phpcs script can now be run from a CVS checkout without installing the package
- Added a new CSV report format
    - Header row indicates what position each element is in
    - Always use the header row to determine positions rather than assuming the format, as it may change
- XML and CSV report formats now contain information about which column the error occurred at
    - Useful if you want to highlight the token that caused the error in a custom application
- Square bracket tokens now have bracket_opener and bracket_closer set
- Added new Squiz SemicolonSpacingSniff to throw errors if whitespace is found before a semicolon
- Added new Squiz ArrayBracketSpacingSniff to throw errors if whitespace is found around square brackets
- Added new Squiz ObjectOperatorSpacingSniff to throw errors if whitespace is found around object operators
- Added new Squiz DisallowMultipleAssignmentsSniff to throw errors if multiple assignments are on the same line
- Added new Squiz ScopeKeywordSpacingSniff to throw errors if there is not a single space after a scope modifier
- Added new Squiz ObjectInstantiationSniff to throw errors if new objects are not assigned to a variable
- Added new Squiz FunctionDuplicateArgumentSniff to throw errors if argument is declared multiple times in a function
- Added new Squiz FunctionOpeningBraceSpaceSniff to ensure there are no blank lines after a function open brace
- Added new Squiz CommentedOutCodeSniff to warn about comments that looks like they are commented out code blocks
- Added CyclomaticComplexitySniff to Squiz standard
- Added NestingLevelSniff to Squiz standard
- Squiz ForbiddenFunctionsSniff now recommends echo() instead of print()
- Squiz ValidLogicalOperatorsSniff now recommends ^ instead of xor
- Squiz SwitchDeclarationSniff now contains more checks
    - A single space is required after the case keyword
    - No space is allowed before the colon in a case or default statement
    - All switch statements now require a default case
    - Default case must contain a break statement
    - Empty default case must contain a comment describing why the default is ignored
    - Empty case statements are not allowed
    - Case and default statements must not be followed by a blank line
    - Break statements must be followed by a blank line or the closing brace
    - There must be no blank line before a break statement
- Squiz standard is now using the PEAR IncludingFileSniff
- PEAR ClassCommentSniff no longer complains about unknown tags
- PEAR FileCommentSniff no longer complains about unknown tags
- PEAR FileCommentSniff now accepts multiple @copyright tags
- Squiz BlockCommentSniff now checks that comment starts with a capital letter
- Squiz InlineCommentSniff now has better checking to ensure comment starts with a capital letter
- Squiz ClassCommentSniff now checks that short and long comments start with a capital letter
- Squiz FunctionCommentSniff now checks that short, long and param comments start with a capital letter
- Squiz VariableCommentSniff now checks that short and long comments start with a capital letter

### Fixed
- Fixed error with multi-token array indexes in Squiz ArrayDeclarationSniff
- Fixed error with checking shorthand IF statements without a semicolon in Squiz InlineIfDeclarationSniff
- Fixed error where constants used as default values in function declarations were seen as type hints
- Fixed bug [#12316][pear-12316] : PEAR is no longer the default standard
- Fixed bug [#12321][pear-12321] : wrong detection of missing function docblock

[pear-12316]: https://pear.php.net/bugs/bug.php?id=12316
[pear-12321]: https://pear.php.net/bugs/bug.php?id=12321


<!--
=== Link list for release links ====
-->

[1.5.6]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.5...1.5.6
[1.5.5]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.4...1.5.5
[1.5.4]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.3...1.5.4
[1.5.3]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.2...1.5.3
[1.5.2]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.1...1.5.2
[1.5.1]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.0...1.5.1
[1.5.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.0RC4...1.5.0
[1.5.0RC4]:   https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.0RC3...1.5.0RC4
[1.5.0RC3]:   https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.0RC2...1.5.0RC3
[1.5.0RC2]:   https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.5.0RC1...1.5.0RC2
[1.5.0RC1]:   https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.4.8...1.5.0RC1
[1.4.8]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.4.7...1.4.8
[1.4.7]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.4.6...1.4.7
[1.4.6]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.4.5...1.4.6
[1.4.5]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.4.4...1.4.5
[1.4.4]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.4.3...1.4.4
[1.4.3]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.4.2...1.4.3
[1.4.2]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.4.1...1.4.2
[1.4.1]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.4.0...1.4.1
[1.4.0]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.3.6...1.4.0
[1.3.6]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.3.5...1.3.6
[1.3.5]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.3.4...1.3.5
[1.3.4]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.3.3...1.3.4
[1.3.3]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.3.2...1.3.3
[1.3.2]:      https://github.com/PHPCSStandards/PHP_CodeSniffer/compare/1.3.1...1.3.2

<!--
=== Link list for contributor profiles ====
-->

[@aboks]:               https://github.com/aboks
[@abulford]:            https://github.com/abulford
[@aik099]:              https://github.com/aik099
[@akkie]:               https://github.com/akkie
[@alcohol]:             https://github.com/alcohol
[@andygrunwald]:        https://github.com/andygrunwald
[@asnyder]:             https://github.com/asnyder
[@Astinus-Eberhard]:    https://github.com/Astinus-Eberhard
[@bayleedev]:           https://github.com/bayleedev
[@becoded]:             https://github.com/becoded
[@benmatselby]:         https://github.com/benmatselby
[@biozshock]:           https://github.com/biozshock
[@bkdotcom]:            https://github.com/bkdotcom
[@bladeofsteel]:        https://github.com/bladeofsteel
[@blerou]:              https://github.com/blerou
[@boonkerz]:            https://github.com/boonkerz
[@BRMatt]:              https://github.com/BRMatt
[@CandySunPlus]:        https://github.com/CandySunPlus
[@ceeram]:              https://github.com/ceeram
[@covex-nn]:            https://github.com/covex-nn
[@cweiske]:             https://github.com/cweiske
[@danez]:               https://github.com/danez
[@das-peter]:           https://github.com/das-peter
[@dominics]:            https://github.com/dominics
[@dryabkov]:            https://github.com/dryabkov
[@edorian]:             https://github.com/edorian
[@elazar]:              https://github.com/elazar
[@erikwiffin]:          https://github.com/erikwiffin
[@eser]:                https://github.com/eser
[@fabre-thibaud]:       https://github.com/fabre-thibaud
[@fonsecas72]:          https://github.com/fonsecas72
[@gnutix]:              https://github.com/gnutix
[@goatherd]:            https://github.com/goatherd
[@hashar]:              https://github.com/hashar
[@helgi]:               https://github.com/helgi
[@ihabunek]:            https://github.com/ihabunek
[@illusori]:            https://github.com/illusori
[@index0h]:             https://github.com/index0h
[@jeffslofish]:         https://github.com/jeffslofish
[@jmarcil]:             https://github.com/jmarcil
[@jnrbsn]:              https://github.com/jnrbsn
[@kdebisschop]:         https://github.com/kdebisschop
[@kenguest]:            https://github.com/kenguest
[@klausi]:              https://github.com/klausi
[@Konafets]:            https://github.com/Konafets
[@kristofser]:          https://github.com/kristofser
[@ksimka]:              https://github.com/ksimka
[@ktomk]:               https://github.com/ktomk
[@kukulich]:            https://github.com/kukulich
[@MacDada]:             https://github.com/MacDada
[@manuelpichler]:       https://github.com/manuelpichler
[@maxgalbu]:            https://github.com/maxgalbu
[@mcuelenaere]:         https://github.com/mcuelenaere
[@mrkrstphr]:           https://github.com/mrkrstphr
[@mythril]:             https://github.com/mythril
[@Naelyth]:             https://github.com/Naelyth
[@nubs]:                https://github.com/nubs
[@olemartinorg]:        https://github.com/olemartinorg
[@r3nat]:               https://github.com/r3nat
[@renan]:               https://github.com/renan
[@robocoder]:           https://github.com/robocoder
[@rogeriopradoj]:       https://github.com/rogeriopradoj
[@rovangju]:            https://github.com/rovangju
[@rvanvelzen]:          https://github.com/rvanvelzen
[@sebastianbergmann]:   https://github.com/sebastianbergmann
[@sertand]:             https://github.com/sertand
[@shanethehat]:         https://github.com/shanethehat
[@sjlangley]:           https://github.com/sjlangley
[@storeman]:            https://github.com/storeman
[@stronk7]:             https://github.com/stronk7
[@tasuki]:              https://github.com/tasuki
[@till]:                https://github.com/till
[@valorin]:             https://github.com/valorin
[@waltertamboer]:       https://github.com/waltertamboer
[@westonruter]:         https://github.com/westonruter
[@wimg]:                https://github.com/wimg
[@xt99]:                https://github.com/xt99
[@yesmeck]:             https://github.com/yesmeck
[@zBart]:               https://github.com/zBart
[pear-bakert]:          https://pear.php.net/user/bakert
[pear-bjorn]:           https://pear.php.net/user/bjorn
[pear-boxgav]:          https://pear.php.net/user/boxgav
[pear-burci]:           https://pear.php.net/user/burci
[pear-conf]:            https://pear.php.net/user/conf
[pear-cwiedmann]:       https://pear.php.net/user/cwiedmann
[pear-dollyaswin]:      https://pear.php.net/user/dollyaswin
[pear-dvino]:           https://pear.php.net/user/dvino
[pear-et3w503]:         https://pear.php.net/user/et3w503
[pear-gemineye]:        https://pear.php.net/user/gemineye
[pear-kwinahradsky]:    https://pear.php.net/user/kwinahradsky
[pear-ljmaskey]:        https://pear.php.net/user/ljmaskey
[pear-mccammos]:        https://pear.php.net/user/mccammos
[pear-pete]:            https://pear.php.net/user/pete
[pear-recurser]:        https://pear.php.net/user/recurser
[pear-renoiv]:          https://pear.php.net/user/renoiv
[pear-rquadling]:       https://pear.php.net/user/rquadling
[pear-ryba]:            https://pear.php.net/user/ryba
[pear-thezero]:         https://pear.php.net/user/thezero
[pear-thing2b]:         https://pear.php.net/user/thing2b
[pear-tomdesp]:         https://pear.php.net/user/tomdesp
[pear-weirdan]:         https://pear.php.net/user/weirdan
[pear-wloche]:          https://pear.php.net/user/wloche
[pear-woellchen]:       https://pear.php.net/user/woellchen
[pear-youngian]:        https://pear.php.net/user/youngian
