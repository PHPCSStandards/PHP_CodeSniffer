# Contributing

Thank you for your interest in contributing to PHP_CodeSniffer!


## Table of Contents

* [Reporting Bugs](#reporting-bugs)
    * [Reporting Security Issues](#reporting-security-issues)
    * [Support/Questions About Using PHP_CodeSniffer](#supportquestions-about-using-php_codesniffer)
* [Contributing Without Writing Code](#contributing-without-writing-code)
    * [Bug Triage](#bug-triage)
    * [Testing Open Pull Requests](#testing-open-pull-requests)
    * [Writing sniff documentation](#writing-sniff-documentation)
    * [Other tasks](#other-tasks)
* [Contributing With Code](#contributing-with-code)
    * [Requesting/Submitting New Features](#requestingsubmitting-new-features)
    * [Getting started](#getting-started)
    * [While working on a patch](#while-working-on-a-patch)
    * [Writing tests](#writing-tests)
    * [Submitting your pull request](#submitting-your-pull-request)
* [Licensing](#licensing)


## Reporting Bugs

Please search the [open issues](https://github.com/PHPCSStandards/PHP_CodeSniffer/issues) to see if your issue has been reported
already and if so, comment in that issue if you have additional information, instead of opening a new one.

Before reporting a bug, you should check what sniff an error is coming from.
Running `phpcs` with the `-s` flag will show the name of the sniff for each error.

If the error code starts with anything other than `Generic`, `MySource`, `PEAR`, `PSR1`, `PSR2`, `PSR12`, `Squiz` or `Zend`,
the error is likely coming from an external PHP_CodeSniffer standard.
**Please report bugs for externally maintained sniffs to the appropriate repository.**

Bug reports containing a minimal code sample which can be used to reproduce the issue are highly appreciated as those are most
easily actionable.

:point_right: Reports which only include a _screenshot_ of the code will be closed without hesitation as not actionable.


### Reporting Security Issues

PHP_CodeSniffer is a developer tool and should generally not be used in a production environment.

Having said that, responsible disclosure of security issues is highly appreciated.
Issues can be reported privately to the maintainers by opening a
[Security vulnerability report](https://github.com/PHPCSStandards/PHP_CodeSniffer/security/advisories/new).


### Support/Questions About Using PHP_CodeSniffer

Please read the [documentation in the wiki](https://github.com/PHPCSStandards/PHP_CodeSniffer/wiki) before opening an issue
with a support question.

The [discussion forum](https://github.com/PHPCSStandards/PHP_CodeSniffer/discussions) or
[StackOverflow](https://stackoverflow.com/questions/tagged/phpcodesniffer) are the appropriate places for support questions.


## Contributing Without Writing Code

### Bug Triage

We welcome bug triage.

Bug triage is the action of verifying a reported bug is reproducible and is actually an issue.
This includes checking whether the bug is something which should be fixed in **_this_** repository.

To find bugs which need triage, look for issues and PRs with the
["Status: triage"](https://github.com/PHPCSStandards/PHP_CodeSniffer/labels/Status%3A%20triage) label.

#### Typical bug triage tasks
* Verify whether the bug is reproducible with the given information.
* Ask for additional information if it is not.
* If you find the issue is reported to the wrong repo, ask the reporter to report it to the correct external standard repo
    and suggest closing the issue.

Additionally, for older issues:
* Check whether an issue still exists or has been fixed in `master` since the issue was initially reported.
* If it has been fixed, document (in a comment) which commit/PR was responsible for fixing the issue
    and suggest closing the ticket.


### Testing Open Pull Requests

Testing pull requests to verify they fix the issue they are supposed to fix without side effects is an important task.

To get access to a PHPCS version which includes the patch from a pull request, you can:
* Either use a git clone of the PHP_CodeSniffer repository and check out the PR.
* Or download the PHAR file(s) for the PR, which is available from the
    [Test workflow](https://github.com/PHPCSStandards/PHP_CodeSniffer/actions/workflows/test.yml)
    as an artifact of the workflow run.
    The PHAR files can be found on the summary page of the test workflow run for the PR.
    If the workflow has not been run (yet), the PHAR artifact may not be available (yet).

#### Typical test tasks
* Verify that the patch solves the originally reported problem.
* Verify that the tests added in the PR fail without the fix and pass with the fix.
* For a fix for false negatives: verify that the correct error message(s) are thrown by the patched code.
* Run the patched PHPCS version against real codebases to see if the fix creates any side effects
    (new false positives/false negatives).


### Writing sniff documentation

Sniffs in PHP_CodeSniffer should preferably be accompanied by documentation. There is currently still a lot of
[documentation missing](https://github.com/PHPCSStandards/PHP_CodeSniffer/issues/148).

Sniff documentation is provided via XML files in the standard's `Docs` directory and is available to end-users
via the command-line and/or can be compiled into an HTML or Markdown file.

To see an example of some of the available documentation, run:
```bash
phpcs --standard=PSR12 --generator=Text
```

Pull requests to update existing documentation, or to add documentation for sniffs which currently don't have any, are welcome.

For the documentation to be recognized, the naming conventions have to be followed.

For example, for the sniff named `Generic.NamingConventions.ConstructorName`:
* The sniff lives in the `src/Standards/Generic/Sniffs/NamingConventions/ConstructorNameSniff.php` file.
* The associated documentation should be in a `src/Standards/Generic/Docs/NamingConventions/ConstructorNameStandard.xml` file.

The XML files consist of several parts:
* The `title` attribute in the `<documentation>` tag should generally reflect the name of the sniff.
* Each XML file can contain multiple `<standard>` blocks.
* Each `<standard>` block can be accompanied by one or more `<code_comparison>` blocks.
* Each code comparison block should have two `<code>` blocks, the first one showing "valid" code, the second one
    showing "invalid" code.

Some guidelines to get you started:
* Keep it as simple as possible.
* When a sniff shows multiple different errors/warnings, it is recommended to have a separate `<standard>` block
    for each error/warning.
* The title of a "good" code sample (on the left) should start with `Valid:`.
* The title of a "bad" code sample (on the right) should start with `Invalid:`.
* Don't use example code which can be traced back to a specific project.
* Each line within the code sample should be max 48 characters.
* Code used in code samples should be valid PHP.
* To highlight the "good" and the "bad" bits in the code examples, surround those bits with `<em> ...</em>` tags.
    These will be removed automatically when using the text generator, but ensure highlighting of the code in HTML.
* The indentation in the XML file should use spaces only. Four spaces for each indent.

Make sure to test the documentation before submitting a PR by running:
```bash
phpcs --standard=StandardName --generator=Text --sniffs=StandardName.Category.SniffName
```

Kind request to add only one new XML file per PR to make the PR easier to review.


### Other tasks

There are also tasks looking for contributions, which don't necessarily fall into the above categories.

#### Issues marked with "Status: waiting for opinions"

Proposals for new features, proposals for (structural) changes to PHP_CodeSniffer itself or to the contributor workflow,
will initially be marked with the
["Status: waiting for opinions"](https://github.com/PHPCSStandards/PHP_CodeSniffer/labels/Status%3A%20waiting%20for%20opinions)
label.

This is an open invitation for interested parties to gather their thoughts about the issue and to leave their opinion.

> Kind request: If you don't have something to add to the discussion, but do want to indicate a positive or negative opinion
> on a topic, please add an emoji on the original post instead of leaving a comment.

On a subset of these issues - the ones which impact maintainers or integrators -, a list of known interested parties
will be pinged (cc-ed) to gather their thoughts on the topic.

> [!TIP]
> This cc-list list is public and
> [maintained in a markdown file](https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/.github/community-cc-list.md).
>
> To add or remove yourself to/from this list, submit a PR to the repo updating the `community-cc-list.md` file.
> PRs adding/removing _other people_ to/from the list will only be merged if the people being added/removed leave a comment
> on the PR consenting to it.


#### Issues marked with "Status: needs investigation"

Sometimes an issue has been identified, but it has not yet been pinpointed what the exact cause of the problem is.

Other times, like with syntax changes in PHP itself, PHP_CodeSniffer _may_, or _may not_, handle them correctly
and this will need verification.

Issues like these will be marked with the
["Status: needs investigation"](https://github.com/PHPCSStandards/PHP_CodeSniffer/labels/Status%3A%20needs%20investigation)
and investigating those can be a good way to learn more about the source code of PHP_CodeSniffer.

#### Issues marked with "Status: help wanted"

If you don't know where to start, have a browse through issues marked with the
["Status: help wanted"](https://github.com/PHPCSStandards/PHP_CodeSniffer/labels/Status%3A%20help%20wanted) and/or the
["Status: good first issue"](https://github.com/PHPCSStandards/PHP_CodeSniffer/labels/Status%3A%20good%20first%20issue) labels.


## Contributing With Code

### Requesting/Submitting New Features

Ideally, start by [opening an issue](https://github.com/PHPCSStandards/PHP_CodeSniffer/issues/new/choose) to check whether
the feature is something which is suitable to be included in PHP_CodeSniffer.

It's possible that a feature may be rejected at an early stage, and it's better to find out before you write the code.

It is also good to discuss potential different implementation options ahead of time and get guidance for the preferred option
from the maintainers.

Note: There may be an issue or PR open already. If so, please join the discussion in that issue or PR instead of opening
a duplicate issue/PR.

> Please note: Auto-fixers will only be accepted for "non-risky" sniffs.
> If a fixer could cause parse errors or a change in the behaviour of the scanned code, the fixer will **NOT** be accepted
> in PHP_CodeSniffer and may be better suited to an external standard.


### Getting started

1. Fork/clone the repository.
2. Run `composer install`.
3. Create a new branch off the `master` branch to hold your patch.
    If there is an open issue associated with your patch, including the issue number in the branch name is good practice.


### While working on a patch

Please make sure your code conforms to the PHPCS coding standard, is covered by tests and that all the PHP_CodeSniffer
unit tests still pass.

Also, please make sure your code is compatible with the PHP_CodeSniffer minimum supported PHP version, PHP 5.4.

To help you with this, a number of convenience scripts are available:
* `composer check-all` will run the `cs` + `test` checks in one go.
* `composer cs` will check for code style violations.
* `composer cbf` will run the autofixers for code style violations.
* `composer test` will run the unit tests.
* `composer coverage` will run the unit tests with code coverage and show a text summary.
* `composer coverage-local` will run the unit tests with code coverage and generate an HTML coverage report,
    which will be placed in a `build/coverage-html` subdirectory.
* `composer build` will build the phpcs.phar and phpcbf.phar files.

N.B.: You can ignore any skipped tests as these are for external tools.


### Writing tests

Tests for the PHP_CodeSniffer engine can be found in the `tests/Core` directory.
Tests for individual sniffs can be found in the `src/Standards/[StandardName]/Tests/[Category]/` directory.

Tests will, in most cases, consist of a set of related files and follow strict naming conventions.

For example, for the sniff named `Generic.NamingConventions.ConstructorName`:
* The sniff lives in the `src/Standards/Generic/Sniffs/NamingConventions/` directory.
* The tests live in the `src/Standards/Generic/Tests/NamingConventions/` directory.
* The tests consist of two files:
    * `src/Standards/Generic/Tests/NamingConventions/ConstructorNameUnitTest.inc` which is the test _case_ file containing
       code for the sniff to analyse.
    * `src/Standards/Generic/Tests/NamingConventions/ConstructorNameUnitTest.php` which is the test file, containing two methods,
        `getErrorList()` and `getWarningList()`, which should each return an array with as the keys the line number
        in the test _case_ file and as the values the number of errors or warnings which are expected on each line.
        Only lines on which errors/warnings are expected need to be included in the lists. All other lines will automatically
        be set to expect no errors and no warnings.

#### Multiple test case files

At times, one test _case_ file is not enough, for instance when the sniff needs to behave differently depending on whether code
is namespaced or not, or when a sniff needs to check something at the top of a file.

The test framework allows for multiple test _case_ files.
In that case, the files should be numbered and the number should be placed between the file name and the extension.

So for the above example, the `src/Standards/Generic/Tests/NamingConventions/ConstructorNameUnitTest.inc` would be renamed to
`src/Standards/Generic/Tests/NamingConventions/ConstructorNameUnitTest.1.inc` and additional test case files should be numbered
sequentially like `src/Standards/Generic/Tests/NamingConventions/ConstructorNameUnitTest.2.inc`,
`src/Standards/Generic/Tests/NamingConventions/ConstructorNameUnitTest.3.inc` etc.

The `getErrorList()` and the `getWarningList()` methods will receive an optional `$testFile=''` parameter with the file name
of the file being scanned - `ConstructorNameUnitTest.2.inc` - and should return the appropriate array for each file.

#### Testing fixers

If a sniff contains errors/warnings which can be auto-fixed, these fixers should also be tested.

This is done by adding a test _case_ file with an extra `.fixed` extension for each test _case_ file which expects fixes.

For example, if the above `Generic.NamingConventions.ConstructorName` would contain an auto-fixer, there should be an
additional `src/Standards/Generic/Tests/NamingConventions/ConstructorNameUnitTest.inc.fixed` file containing the code
as it is expected to be after the fixer has run.

The test framework will compare the actual fixes made with the expected fixes and will fail the tests if these don't match.

#### Tests related to parse errors/live coding

PHP_CodeSniffer can be, and is, regularly used during live coding via an IDE integration.

This means that sniffs will often need to contain extra defensive coding related to this.
It is common for sniffs to bow out early for parse errors/live coding when it cannot be reliably determined whether
the code should be flagged or not. Additionally, making auto-fixes to code in a parse error state can make things worse.

This defensive coding in a sniff should, of course, also be safeguarded via tests.

Parse/compile errors can take various forms. Some can be handled without much problems by PHPCS, some can not.

If a code snippet to be tested could lead to a broken token stream due to a parse/compile error, the code snippet should always
be put in a separate test case file by itself and be accompanied by a comment stating the test is an intentional parse error.

Example:
```php
<?php
// Intentional parse error (missing open parenthesis).
// This should be the only test in this file.
// Testing that the sniff is *not* triggered.
for
```


### Submitting your pull request

Some guidelines for submitting pull requests (PRs) and improving the chance that your PR will be merged:
* Please keep your PR as small as possible, but no smaller than that.
    If your change is complex, make sure you add a proper commit message explaining what you have done and why.
* Please clean up your branch before pulling your PR.
    Small PRs using atomic, descriptive commits are hugely appreciated as it will make reviewing your changes
    easier for the maintainers.
* Only open your PR when you've finished work on it, and you are confident that it is ready for review.
* Please make sure your pull request passes all continuous integration checks.
    PRs which are failing their CI checks will likely be ignored by the maintainers or closed.
* Please respond to PR reviews in a timely manner.

Your time is valuable, and we appreciate your willingness to spend it on this project.
However, the maintainers time is also valuable and often, more scarce, so please be considerate of that.

#### Some git best practices

While not strictly required, it is greatly appreciated if you comply with the following git best practices:

* Prefix the commit short description with a hint as to what code is touched in the commit.
    Example: If you have a bug fix for the `Squiz.WhiteSpace.OperatorSpacing` sniff, it is a good idea to prefix
    the short description with `Squiz/OperatorSpacing:`.
    Another example: if your PR addresses an issue with the Filter classes, prefix the short description
    with `Filters:` or `Filters/FilterName:`.
    Doing so will:
    1. Allow for searches on GitHub to find all issues/PRs related to a particular sniff/area of the code more easily.
    2. Create a more descriptive git history.
* Being wordy in the commit message is not a bad thing.
    It is greatly preferable to have the details about a fix in the commit message over just having those details
    in the PR description.
    Code hosting platforms come and go (think: SourceForge, PEAR), commit messages are here to stay, even if the code base
    would move to another platform at some point in the future.
* Ensure that the tests (and docs) related to a particular fix are in the same commit.
    It is much harder to track down what a particular code snippet in a test case file was supposed to be testing if the fix
    and the tests are in separate commits.
    Using atomic commits like this, also makes it much more straight forward to use tooling like `git blame` or `git bisect`
    or to revert a patch if necessary.
* Do not merge-back the main branch into your PR, even if your PR has been open for a while and/or has conflicts.
    Spaghetti merges make for much harder to track down git history.
    If your PR has not been reviewed yet, feel free to rebase at will.
    Once a PR is under review, consult with the reviewer about rebasing the PR.

#### Final words

##### Do not violate copyright

Only submit a PR with your own original code. Do NOT submit a PR containing code which you have largely copied from
an externally available sniff, unless you wrote said sniff yourself.
Open source does not mean that copyright does not apply.
Copyright infringements will not be tolerated and can lead to you being banned from the repo.

##### Do not submit AI generated PRs

The same goes for (largely) AI-generated PRs. These are not welcome as they will be based on copyrighted code from others
without accreditation and without taking the license of the original code into account, let alone getting permission
for the use of the code or for re-licensing.

Aside from that, the experience is that AI-generated PRs will be incorrect 100% of the time and cost reviewers too much time.
Submitting a (largely) AI-generated PR will lead to you being banned from the repo.


## Licensing

By contributing code to this repository, you agree to license your code for use under the
[BSD-3-Clause license](https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt).
