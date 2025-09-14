# Changelog

The file documents changes to the PHP_CodeSniffer project for the 0.x series of releases.

## 0.9.0 - 2007-09-24

### Changed
- Added a config system for setting config data across phpcs runs
- You can now change the default coding standard from PEAR to something else
    - Run: phpcs `--config-set default_standard [standard]`
- Added new Zend coding standard to check code against the Zend Framework standards
    - The complete standard is not yet implemented
    - Specify --standard=Zend to use
    - Thanks to Johann-Peter Hartmann for the contribution of some sniffs
    - Thanks to Holger Kral for the Code Analyzer sniff

## 0.8.0 - 2007-08-08

### Changed
- Added new XML report format; --report=xml (feature request [#11535][pear-11535])
    - Thanks to [Brett Bieber][@saltybeagle] for the patch
- Added new command line argument --ignore to specify a list of files to skip (feature request [#11556][pear-11556])
- Added PHPCS and MySource coding standards into the core install
- Scope map no longer gets confused by curly braces that act as string offsets
- Removed `CodeSniffer/SniffException.php` as it is no longer used
- Unit tests can now be run directly from a CVS checkout
- Made private vars and functions protected in PHP_CodeSniffer class so this package can be overridden
- Added new Metrics category to Generic coding standard
    - Contains Cyclomatic Complexity and Nesting Level sniffs
    - Thanks to Johann-Peter Hartmann for the contribution
- Added new Generic DisallowTabIndentSniff to throw errors if tabs are used for indentation (feature request [#11738][pear-11738])
    - PEAR and Squiz standards use this new sniff to throw more specific indentation errors
- Generic MultipleStatementAlignmentSniff has new private var to set a padding size limit (feature request [#11555][pear-11555])
- Generic MultipleStatementAlignmentSniff can now handle assignments that span multiple lines (feature request [#11561][pear-11561])
- Generic LineLengthSniff now has a max line length after which errors are thrown instead of warnings
    - BC BREAK: Override the protected member var absoluteLineLimit and set it to zero in custom LineLength sniffs
    - Thanks to Johann-Peter Hartmann for the contribution
- Comment sniff errors about incorrect tag orders are now more descriptive (feature request [#11693][pear-11693])

### Fixed
- Fixed bug [#11473][pear-11473] : Invalid CamelCaps name when numbers used in names

[pear-11473]: https://pear.php.net/bugs/bug.php?id=11473
[pear-11535]: https://pear.php.net/bugs/bug.php?id=11535
[pear-11555]: https://pear.php.net/bugs/bug.php?id=11555
[pear-11556]: https://pear.php.net/bugs/bug.php?id=11556
[pear-11561]: https://pear.php.net/bugs/bug.php?id=11561
[pear-11693]: https://pear.php.net/bugs/bug.php?id=11693
[pear-11738]: https://pear.php.net/bugs/bug.php?id=11738

## 0.7.0 - 2007-07-02

### Changed
- BC BREAK: EOL character is now auto-detected and used instead of hard-coded \n
    - Pattern sniffs must now specify "EOL" instead of "\n" or "\r\n" to use auto-detection
    - Please use $phpcsFile->eolChar to check for newlines instead of hard-coding "\n" or "\r\n"
    - Comment parser classes now require you to pass $phpcsFile as an additional argument
- BC BREAK: Included and excluded sniffs now require `.php` extension
    - Please update your coding standard classes and add `.php` to all sniff entries
    - See `CodeSniffer/Standards/PEAR/PEARCodingStandard.php` for an example
- Fixed error where including a directory of sniffs in a coding standard class did not work
- Coding standard classes can now specify a list of sniffs to exclude as well as include (feature request [#11056][pear-11056])
- Two uppercase characters can now be placed side-by-side in class names in Squiz ValidClassNameSniff
- SVN tags now allowed in PEAR file doc blocks (feature request [#11038][pear-11038])
    - Thanks to [Torsten Roehr][pear-troehr] for the patch
- Private methods in commenting sniffs and comment parser are now protected (feature request [#11087][pear-11087])
- Added Generic LineEndingsSniff to check the EOL character of a file
- PEAR standard now only throws one error per file for incorrect line endings (eg. /r/n)
- Command line arg -v now shows number of registered sniffs
- Command line arg -vvv now shows list of registered sniffs
- Squiz ControlStructureSpacingSniff no longer throws errors if the control structure is at the end of the script
- Squiz FunctionCommentSniff now throws error for "return void" if function has return statement
- Squiz FunctionCommentSniff now throws error for functions that return void but specify something else
- Squiz ValidVariableNameSniff now allows multiple uppercase letters in a row
- Squiz ForEachLoopDeclarationSniff now throws error for AS keyword not being lowercase
- Squiz SwitchDeclarationSniff now throws errors for CASE/DEFAULT/BREAK keywords not being lowercase
- Squiz ArrayDeclarationSniff now handles multi-token array values when checking alignment
- Squiz standard now enforces a space after cast tokens
- Generic MultipleStatementAlignmentSniff no longer gets confused by assignments inside FOR conditions
- Generic MultipleStatementAlignmentSniff no longer gets confused by the use of list()
- Added Generic SpaceAfterCastSniff to ensure there is a single space after a cast token
- Added Generic NoSpaceAfterCastSniff to ensure there is no whitespace after a cast token
- Added PEAR ClassDeclarationSniff to ensure the opening brace of a class is on the line after the keyword
- Added Squiz ScopeClosingBraceSniff to ensure closing braces are aligned correctly
- Added Squiz EvalSniff to discourage the use of eval()
- Added Squiz LowercaseDeclarationSniff to ensure all declaration keywords are lowercase
- Added Squiz LowercaseClassKeywordsSniff to ensure all class declaration keywords are lowercase
- Added Squiz LowercaseFunctionKeywordsSniff to ensure all function declaration keywords are lowercase
- Added Squiz LowercasePHPFunctionsSniff to ensure all calls to inbuilt PHP functions are lowercase
- Added Squiz CastSpacingSniff to ensure cast statements don't contain whitespace
- Errors no longer thrown when checking 0 length files with verbosity on

### Fixed
- Fixed bug [#11105][pear-11105] : getIncludedSniffs() not working anymore
    - Thanks to [Blair Robertson][pear-adviva] for the patch
- Fixed bug [#11120][pear-11120] : Uninitialized string offset in `AbstractParser.php` on line 200

[pear-11038]: https://pear.php.net/bugs/bug.php?id=11038
[pear-11056]: https://pear.php.net/bugs/bug.php?id=11056
[pear-11087]: https://pear.php.net/bugs/bug.php?id=11087
[pear-11105]: https://pear.php.net/bugs/bug.php?id=11105
[pear-11120]: https://pear.php.net/bugs/bug.php?id=11120

## 0.6.0 - 2007-05-15

### Changed
- The number of errors and warnings found is now shown for each file while checking the file if verbosity is enabled
- Now using PHP_EOL instead of hard-coded \n so output looks good on Windows (feature request [#10761][pear-10761])
    - Thanks to [Carsten Wiedmann][pear-cwiedmann] for the patch.
- phpcs now exits with status 0 (no errors) or 1 (errors found) (feature request [#10348][pear-10348])
- Added new -l command line argument to stop recursion into directories (feature request [#10979][pear-10979])

### Fixed
- Fixed variable name error causing incorrect error message in Squiz ValidVariableNameSniff
- Fixed bug [#10757][pear-10757] : Error in ControlSignatureSniff
- Fixed bugs [#10751][pear-10751], [#10777][pear-10777] : Sniffer class paths handled incorrectly in Windows
    - Thanks to [Carsten Wiedmann][pear-cwiedmann] for the patch.
- Fixed bug [#10961][pear-10961] : Error "Last parameter comment requires a blank newline after it" thrown
- Fixed bug [#10983][pear-10983] : phpcs outputs notices when checking invalid PHP
- Fixed bug [#10980][pear-10980] : Incorrect warnings for equals sign

[pear-10348]: https://pear.php.net/bugs/bug.php?id=10348
[pear-10751]: https://pear.php.net/bugs/bug.php?id=10751
[pear-10757]: https://pear.php.net/bugs/bug.php?id=10757
[pear-10761]: https://pear.php.net/bugs/bug.php?id=10761
[pear-10777]: https://pear.php.net/bugs/bug.php?id=10777
[pear-10961]: https://pear.php.net/bugs/bug.php?id=10961
[pear-10979]: https://pear.php.net/bugs/bug.php?id=10979
[pear-10980]: https://pear.php.net/bugs/bug.php?id=10980
[pear-10983]: https://pear.php.net/bugs/bug.php?id=10983

## 0.5.0 - 2007-04-17

### Changed
- BC BREAK: Coding standards now require a class to be added so PHP_CodeSniffer can get information from them
    - Please read the end user docs for info about the new class required for all coding standards
- Coding standards can now include sniffs from other standards, or whole standards, without writing new sniff files
- PHP_CodeSniffer_File::isReference() now correctly returns for references in function declarations
- PHP_CodeSniffer_File::isReference() now returns false if you don't pass it a T_BITWISE_AND token
- PHP_CodeSniffer_File now stores the absolute path to the file so sniffs can check file locations correctly
- Fixed undefined index error in AbstractVariableSniff for variables inside an interface function definition
- Added MemberVarSpacingSniff to Squiz standard to enforce one-line spacing between member vars
- Add FunctionCommentThrowTagSniff to Squiz standard to check that @throws tags are correct

### Fixed
- Fixed problems caused by references and type hints in Squiz FunctionDeclarationArgumentSpacingSniff
- Fixed problems with errors not being thrown for some misaligned @param comments in Squiz FunctionCommentSniff
- Fixed badly spaced comma error being thrown for "extends" class in Squiz ClassDeclarationSniff
- Errors no longer thrown for class method names in Generic ForbiddenFunctionsSniff
- Errors no longer thrown for type hints in front of references in Generic UpperCaseConstantNameSniff
- Errors no longer thrown for correctly indented buffered lines in Squiz ScopeIndexSniff
- Errors no longer thrown for user-defined functions named as forbidden functions in Generic ForbiddenFunctionsSniff
- Errors no longer thrown on __autoload functions in PEAR ValidFunctionNameSniff
- Errors now thrown for __autoload methods in PEAR ValidFunctionNameSniff
- Errors now thrown if constructors or destructors have @return tags in Squiz FunctionCommentSniff
- Errors now thrown if @throws tags don't start with a capital and end with a full stop in Squiz FunctionCommentSniff
- Errors now thrown for invalid @var tag values in Squiz VariableCommentSniff
- Errors now thrown for missing doc comment in Squiz VariableCommentSniff
- Errors now thrown for unspaced operators in FOR loop declarations in Squiz OperatorSpacingSniff
- Errors now thrown for using ob_get_clean/flush functions to end buffers in Squiz OutputBufferingIndentSniff
- Errors now thrown for all missing member variable comments in Squiz VariableCommentSniff

## 0.4.0 - 2007-02-19

### Changed
- Standard name specified with --standard command line argument is no longer case sensitive
- Long error and warning messages are now wrapped to 80 characters in the full error report (thanks Endre Czirbesz)
- Shortened a lot of error and warning messages so they don't take up so much room
- Squiz FunctionCommentSniff now checks that param comments start with a capital letter and end with a full stop
- Squiz FunctionSpacingSniff now reports incorrect lines below function on closing brace, not function keyword
- Squiz FileCommentSniff now checks that there are no blank lines between the open PHP tag and the comment
- PHP_CodeSniffer_File::isReference() now returns correctly when checking refs on right side of =>

### Fixed
- Fixed incorrect error with switch closing brace in Squiz SwitchDeclarationSniff
- Fixed missing error when multiple statements are not aligned correctly with object operators
- Fixed incorrect errors for some PHP special variables in Squiz ValidVariableNameSniff
- Fixed incorrect errors for arrays that only contain other arrays in Squiz ArrayDeclarationSniff
- Fixed bug [#9844][pear-9844] : throw new Exception(\n accidentally reported as error but it ain't

[pear-9844]: https://pear.php.net/bugs/bug.php?id=9844

## 0.3.0 - 2007-01-11

### Changed
- Updated package.xml to version 2
- Specifying coding standard on command line is now optional, even if you have multiple standards installed
    - PHP_CodeSniffer uses the PEAR coding standard by default if no standard is specified
- New command line option, --extensions, to specify a comma separated list of file extensions to check
- Converted all unit tests to PHPUnit 3 format
- Added new coding standard, Squiz, that can be used as an alternative to PEAR
    - also contains more examples of sniffs
    - some may be moved into the Generic coding standard if required
- Added MultipleStatementAlignmentSniff to Generic standard
- Added ScopeIndentSniff to Generic standard
- Added ForbiddenFunctionsSniff to Generic standard
- Added FileCommentSniff to PEAR standard
- Added ClassCommentSniff to PEAR standard
- Added FunctionCommentSniff to PEAR standard
- Change MultipleStatementSniff to MultipleStatementAlignmentSniff in PEAR standard
- Replaced Methods directory with Functions directory in Generic and PEAR standards
    - also renamed some of the sniffs in those directories
- Updated file, class and method comments for all files

### Fixed
- Fixed bug [#9274][pear-9274] : nested_parenthesis element not set for open and close parenthesis tokens
- Fixed bug [#9411][pear-9411] : too few pattern characters cause incorrect error report

[pear-9411]: https://pear.php.net/bugs/bug.php?id=9411

## 0.2.1 - 2006-11-09

### Fixed
- Fixed bug [#9274][pear-9274] : nested_parenthesis element not set for open and close parenthesis tokens

[pear-9274]: https://pear.php.net/bugs/bug.php?id=9274

## 0.2.0 - 2006-10-13

### Changed
- Added a generic standards package that will contain generic sniffs to be used in specific coding standards
    - thanks to Frederic Poeydomenge for the idea
- Changed PEAR standard to use generic sniffs where available
- Added LowerCaseConstantSniff to Generic standard
- Added UpperCaseConstantSniff to Generic standard
- Added DisallowShortOpenTagSniff to Generic standard
- Added LineLengthSniff to Generic standard
- Added UpperCaseConstantNameSniff to Generic standard
- Added OpeningMethodBraceBsdAllmanSniff to Generic standard (contrib by Frederic Poeydomenge)
- Added OpeningMethodBraceKernighanRitchieSniff to Generic standard (contrib by Frederic Poeydomenge)
- Added framework for core PHP_CodeSniffer unit tests
- Added unit test for PHP_CodeSniffer:isCamelCaps method
- ScopeClosingBraceSniff now checks indentation of BREAK statements
- Added new command line arg (-vv) to show developer debug output

### Fixed
- Fixed some coding standard errors
- Fixed bug [#8834][pear-8834] : Massive memory consumption
- Fixed bug [#8836][pear-8836] : path case issues in package.xml
- Fixed bug [#8843][pear-8843] : confusion on nested switch()
- Fixed bug [#8841][pear-8841] : comments taken as whitespace
- Fixed bug [#8884][pear-8884] : another problem with nested switch() statements

[pear-8834]: https://pear.php.net/bugs/bug.php?id=8834
[pear-8836]: https://pear.php.net/bugs/bug.php?id=8836
[pear-8841]: https://pear.php.net/bugs/bug.php?id=8841
[pear-8843]: https://pear.php.net/bugs/bug.php?id=8843
[pear-8884]: https://pear.php.net/bugs/bug.php?id=8884

## 0.1.1 - 2006-09-25

### Changed
- Added unit tests for all PEAR sniffs
- Exception class now extends from PEAR_Exception

### Fixed
- Fixed summary report so files without errors but with warnings are not shown when warnings are hidden

## 0.1.0 - 2006-09-19

### Changed
- Reorganised package contents to conform to PEAR standards
- Changed version numbering to conform to PEAR standards
- Removed duplicate `require_once()` of `Exception.php` from `CodeSniffer.php`

## 0.0.5 - 2006-09-18

### Fixed
- Fixed `.bat` file for situation where `php.ini` cannot be found so `include_path` is not set

## 0.0.4 - 2006-08-28

### Changed
- Added .bat file for easier running of PHP_CodeSniffer on Windows
- Sniff that checks method names now works for PHP4 style code where there is no scope keyword
- Sniff that checks method names now works for PHP4 style constructors
- Sniff that checks method names no longer incorrectly reports error with magic methods
- Sniff that checks method names now reports errors with non-magic methods prefixed with __
- Sniff that checks for constant names no longer incorrectly reports errors with heredoc strings
- Sniff that checks for constant names no longer incorrectly reports errors with created objects
- Sniff that checks indentation no longer incorrectly reports errors with heredoc strings
- Sniff that checks indentation now correctly reports errors with improperly indented multi-line strings
- Sniff that checks function declarations now checks for spaces before and after an equals sign for default values
- Sniff that checks function declarations no longer incorrectly reports errors with multi-line declarations
- Sniff that checks included code no longer incorrectly reports errors when return value is used conditionally
- Sniff that checks opening brace of function no longer incorrectly reports errors with multi-line declarations
- Sniff that checks spacing after commas in function calls no longer reports too many errors for some code
- Sniff that checks control structure declarations now gives more descriptive error message

## 0.0.3 - 2006-08-22

### Changed
- Added sniff to check for invalid class and interface names
- Added sniff to check for invalid function and method names
- Added sniff to warn if line is greater than 85 characters
- Added sniff to check that function calls are in the correct format
- Added command line arg to print current version (--version)

### Fixed
- Fixed error where comments were not allowed on the same line as a control structure declaration

## 0.0.2 - 2006-07-25

### Changed
- Removed the including of checked files to stop errors caused by parsing them
- Removed the use of reflection so checked files do not have to be included
- Memory usage has been greatly reduced
- Much faster tokenizing and checking times
- Reworked the PEAR coding standard sniffs (much faster now)
- Fix some bugs with the PEAR scope indentation standard
- Better checking for installed coding standards
- Can now accept multiple files and dirs on the command line
- Added an option to list installed coding standards
- Added an option to print a summary report (number of errors and warnings shown for each file)
- Added an option to hide warnings from reports
- Added an option to print verbose output (so you know what is going on)
- Reordered command line args to put switches first (although order is not enforced)
- Switches can now be specified together (e.g. `phpcs -nv`) as well as separately (`phpcs -n -v`)

## 0.0.1 - 2006-07-19

### Added
- Initial preview release

<!--
=== Link list for contributor profiles ====
-->

[@saltybeagle]:         https://github.com/saltybeagle
[pear-adviva]:          https://pear.php.net/user/adviva
[pear-cwiedmann]:       https://pear.php.net/user/cwiedmann
[pear-troehr]:          https://pear.php.net/user/troehr
