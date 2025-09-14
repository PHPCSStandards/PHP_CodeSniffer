<?php
/**
 * Integration tests for the exit codes generation.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\ExitCode;

use PHP_CodeSniffer\Runner;
use PHP_CodeSniffer\Tests\Core\Runner\AbstractRunnerTestCase;
use PHP_CodeSniffer\Tests\Core\StatusWriterTestHelper;

/**
 * Integration tests for the exit codes generation.
 *
 * @covers \PHP_CodeSniffer\Util\ExitCode
 */
final class ExitCodeTest extends AbstractRunnerTestCase
{
    // Using the Helper to catch output send to STDERR. For this test, we don't care about the output.
    use StatusWriterTestHelper;

    /**
     * Location where the "files to scan" can be found for these tests.
     *
     * @var string
     */
    private const SOURCE_DIR = __DIR__ . '/Fixtures/ExitCodeTest/';

    /**
     * Path to a file to use for the caching tests.
     *
     * @var string
     */
    private const CACHE_FILE = __DIR__ . '/Fixtures/ExitCodeTest/phpcs.cache';


    /**
     * Prepare a clean test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        // Redirect the StatusWriter output from STDERR to memory.
        $this->redirectStatusWriterOutputToStream();

        // Reset static properties on the Config class.
        AbstractRunnerTestCase::setUp();
    }


    /**
     * Clean up after the test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        // Reset all static properties on the StatusWriter class.
        $this->resetStatusWriterProperties();

        // Reset $_SERVER['argv'] between tests.
        AbstractRunnerTestCase::tearDown();

        // Delete the cache file between tests to prevent a cache from an earlier test run influencing the results of the tests.
        @unlink(self::CACHE_FILE);
    }


    /**
     * Clean up after the tests.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        $globPattern = self::SOURCE_DIR . '/*.inc.fixed';
        $globPattern = str_replace('/', DIRECTORY_SEPARATOR, $globPattern);

        $fixedFiles = glob($globPattern, GLOB_NOESCAPE);

        if (is_array($fixedFiles) === true) {
            foreach ($fixedFiles as $file) {
                @unlink($file);
            }
        }

        AbstractRunnerTestCase::tearDownAfterClass();
    }


    /**
     * Verify generated exit codes (PHPCS).
     *
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     * @param int           $expected  The expected exit code.
     *
     * @dataProvider dataPhpcs
     *
     * @return void
     */
    public function testPhpcsNoParallel($extraArgs, $expected)
    {
        $extraArgs[] = self::SOURCE_DIR . 'mix-errors-warnings.inc';

        $this->runPhpcsAndCheckExitCode($extraArgs, $expected);
    }


    /**
     * Verify generated exit codes (PHPCS) when using parallel processing.
     *
     * Note: there tests are skipped on Windows as the PCNTL extension needed for parallel processing
     * isn't available on Windows.
     *
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     * @param int           $expected  The expected exit code.
     *
     * @dataProvider dataPhpcs
     * @requires     OS ^(?!WIN).*
     *
     * @return void
     */
    public function testPhpcsParallel($extraArgs, $expected)
    {
        // Deliberately using `parallel=3` to scan 5 files to make sure that the results
        // from multiple batches get recorded and added correctly.
        $extraArgs[] = self::SOURCE_DIR;
        $extraArgs[] = '--parallel=3';

        $this->runPhpcsAndCheckExitCode($extraArgs, $expected);
    }


    /**
     * Verify generated exit codes (PHPCS) when caching of results is used.
     *
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     * @param int           $expected  The expected exit code.
     *
     * @dataProvider dataPhpcs
     *
     * @return void
     */
    public function testPhpcsWithCache($extraArgs, $expected)
    {
        $extraArgs[] = self::SOURCE_DIR . 'mix-errors-warnings.inc';
        $extraArgs[] = '--cache=' . self::CACHE_FILE;

        // Make sure we start without a cache.
        if (method_exists($this, 'assertFileDoesNotExist') === true) {
            $this->assertFileDoesNotExist(self::CACHE_FILE);
        } else {
            // PHPUnit < 9.1.0.
            $this->assertFileNotExists(self::CACHE_FILE);
        }

        // First run with these arguments to create the cache.
        $this->runPhpcsAndCheckExitCode($extraArgs, $expected);

        // Check that the cache file was created.
        $this->assertFileExists(self::CACHE_FILE);

        // Second run to verify the exit code is the same when the results are taking from the cache.
        $this->runPhpcsAndCheckExitCode($extraArgs, $expected);
    }


    /**
     * Test Helper: run PHPCS and verify the generated exit code.
     *
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     * @param int           $expected  The expected exit code.
     *
     * @return void
     */
    private function runPhpcsAndCheckExitCode($extraArgs, $expected)
    {
        if (PHP_CODESNIFFER_CBF === true) {
            $this->markTestSkipped('This test needs CS mode to run');
        }

        $this->setServerArgs('phpcs', $extraArgs);

        // Catch & discard the screen output. That's not what we're interested in for this test.
        ob_start();
        $runner = new Runner();
        $actual = $runner->runPHPCS();
        ob_end_clean();

        $this->assertSame($expected, $actual);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, int|array<string>>>
     */
    public static function dataPhpcs()
    {
        return [
            'No issues'                                                                      => [
                'extraArgs' => ['--sniffs=TestStandard.ExitCodes.NoIssues'],
                'expected'  => 0,
            ],
            'Only auto-fixable issues'                                                       => [
                'extraArgs' => ['--sniffs=TestStandard.ExitCodes.FixableError,TestStandard.ExitCodes.FixableWarning'],
                'expected'  => 1,
            ],
            'Only non-fixable issues'                                                        => [
                'extraArgs' => ['--sniffs=TestStandard.ExitCodes.Error,TestStandard.ExitCodes.Warning'],
                'expected'  => 2,
            ],
            'Both auto-fixable + non-fixable issues'                                         => [
                'extraArgs' => [],
                'expected'  => 3,
            ],

            // In both the below cases, we still have both fixable and non-fixable issues, so exit code = 3.
            'Only errors'                                                                    => [
                'extraArgs' => ['--exclude=TestStandard.ExitCodes.FixableWarning,TestStandard.ExitCodes.Warning'],
                'expected'  => 3,
            ],
            'Only warnings'                                                                  => [
                'extraArgs' => ['--exclude=TestStandard.ExitCodes.FixableError,TestStandard.ExitCodes.Error'],
                'expected'  => 3,
            ],

            // In both the below cases, we still have 1 fixable and 1 non-fixable issue which we need to take into account, so exit code = 3.
            'Mix of errors and warnings, ignoring warnings for exit code'                    => [
                'extraArgs' => [
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '1',
                ],
                'expected'  => 3,
            ],
            'Mix of errors and warnings, ignoring errors for exit code'                      => [
                'extraArgs' => [
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '1',
                ],
                'expected'  => 3,
            ],

            'Mix of errors and warnings, ignoring non-auto-fixable for exit code'            => [
                'extraArgs' => [
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 1,
            ],
            'Mix of errors and warnings, ignoring errors + non-auto-fixable for exit code'   => [
                'extraArgs' => [
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '1',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 1,
            ],
            'Mix of errors and warnings, ignoring warnings + non-auto-fixable for exit code' => [
                'extraArgs' => [
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '1',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 1,
            ],
            'Mix of errors and warnings, ignoring errors + warnings for exit code'           => [
                'extraArgs' => [
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '1',
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '1',
                ],
                'expected'  => 0,
            ],
            'Mix of errors and warnings, explicitly ignoring nothing for exit code'          => [
                'extraArgs' => [
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '0',
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '0',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '0',
                ],
                'expected'  => 3,
            ],

            'Fixable error and non-fixable warning, ignoring errors for exit code'           => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.FixableError,TestStandard.ExitCodes.Warning',
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '1',
                ],
                'expected'  => 2,
            ],
            'Non-fixable error and fixable warning, ignoring errors for exit code'           => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.Error,TestStandard.ExitCodes.FixableWarning',
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '1',
                ],
                'expected'  => 1,
            ],

            'Fixable error and non-fixable warning, ignoring warnings for exit code'         => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.FixableError,TestStandard.ExitCodes.Warning',
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '1',
                ],
                'expected'  => 1,
            ],
            'Non-fixable error and fixable warning, ignoring warnings for exit code'         => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.Error,TestStandard.ExitCodes.FixableWarning',
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '1',
                ],
                'expected'  => 2,
            ],

            'Fixable error and non-fixable warning, ignoring non-auto-fixable for exit code' => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.FixableError,TestStandard.ExitCodes.Warning',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 1,
            ],
            'Non-fixable error and fixable warning, ignoring non-auto-fixable for exit code' => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.Error,TestStandard.ExitCodes.FixableWarning',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 1,
            ],
        ];
    }


    /**
     * Verify generated exit codes (PHPCBF).
     *
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     * @param int           $expected  The expected exit code.
     *
     * @dataProvider dataPhpcbf
     * @group        CBF
     *
     * @return void
     */
    public function testPhpcbfNoParallel($extraArgs, $expected)
    {
        $extraArgs[] = self::SOURCE_DIR . 'mix-errors-warnings.inc';

        $this->runPhpcbfAndCheckExitCode($extraArgs, $expected);
    }


    /**
     * Verify generated exit codes (PHPCBF) when using parallel processing.
     *
     * Note: there tests are skipped on Windows as the PCNTL extension needed for parallel processing
     * isn't available on Windows.
     *
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     * @param int           $expected  The expected exit code.
     *
     * @dataProvider dataPhpcbf
     * @group        CBF
     * @requires     OS ^(?!WIN).*
     *
     * @return void
     */
    public function testPhpcbfParallel($extraArgs, $expected)
    {
        // Deliberately using `parallel=3` to scan 5 files to make sure that the results
        // from multiple batches get recorded and added correctly.
        $extraArgs[] = self::SOURCE_DIR;
        $extraArgs[] = '--parallel=3';

        $this->runPhpcbfAndCheckExitCode($extraArgs, $expected);
    }


    /**
     * Test Helper: run PHPCBF and verify the generated exit code.
     *
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     * @param int           $expected  The expected exit code.
     *
     * @return void
     */
    private function runPhpcbfAndCheckExitCode($extraArgs, $expected)
    {
        if (PHP_CODESNIFFER_CBF === false) {
            $this->markTestSkipped('This test needs CBF mode to run');
        }

        $this->setServerArgs('phpcbf', $extraArgs);

        // Catch & discard the screen output. That's not what we're interested in for this test.
        ob_start();
        $runner = new Runner();
        $actual = $runner->runPHPCBF();
        ob_end_clean();

        $this->assertSame($expected, $actual);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, int|array<string>>>
     */
    public static function dataPhpcbf()
    {
        return [
            'No issues'                                                                                      => [
                'extraArgs' => ['--sniffs=TestStandard.ExitCodes.NoIssues'],
                'expected'  => 0,
            ],
            'Fixed all auto-fixable issues, no issues left'                                                  => [
                'extraArgs' => ['--sniffs=TestStandard.ExitCodes.FixableError,TestStandard.ExitCodes.FixableWarning'],
                'expected'  => 0,
            ],
            'Fixed all auto-fixable issues, has non-autofixable issues left'                                 => [
                'extraArgs' => ['--exclude=TestStandard.ExitCodes.FailToFix'],
                'expected'  => 2,
            ],
            'Fixed all auto-fixable issues, has non-autofixable issues left, ignoring those for exit code'   => [
                'extraArgs' => [
                    '--exclude=TestStandard.ExitCodes.FailToFix',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 0,
            ],
            'Failed to fix, only fixable issues remaining'                                                   => [
                'extraArgs' => ['--exclude=TestStandard.ExitCodes.Error,TestStandard.ExitCodes.Warning'],
                'expected'  => 5,
            ],
            'Failed to fix, both fixable + non-fixable issues remaining'                                     => [
                'extraArgs' => [],
                'expected'  => 7,
            ],
            'Failed to fix, both fixable + non-fixable issues remaining, ignoring non-fixable for exit code' => [
                'extraArgs' => [
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 5,
            ],

            // In both the below cases, we still have 1 non-fixable issue which we need to take into account, so exit code = 2.
            'Only errors'                                                                                    => [
                'extraArgs' => ['--exclude=TestStandard.ExitCodes.FailToFix,TestStandard.ExitCodes.FixableWarning,TestStandard.ExitCodes.Warning'],
                'expected'  => 2,
            ],
            'Only warnings'                                                                                  => [
                'extraArgs' => ['--exclude=TestStandard.ExitCodes.FailToFix,TestStandard.ExitCodes.FixableError,TestStandard.ExitCodes.Error'],
                'expected'  => 2,
            ],

            // In both the below cases, we still have 1 non-fixable issue which we need to take into account, so exit code = 2.
            'Mix of errors and warnings, ignoring warnings for exit code'                                    => [
                'extraArgs' => [
                    '--exclude=TestStandard.ExitCodes.FailToFix',
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '1',
                ],
                'expected'  => 2,
            ],
            'Mix of errors and warnings, ignoring errors for exit code'                                      => [
                'extraArgs' => [
                    '--exclude=TestStandard.ExitCodes.FailToFix',
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '1',
                ],
                'expected'  => 2,
            ],

            'Mix of errors and warnings, ignoring non-auto-fixable for exit code'                            => [
                'extraArgs' => [
                    '--exclude=TestStandard.ExitCodes.FailToFix',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 0,
            ],
            'Mix of errors and warnings, ignoring errors + non-auto-fixable for exit code'                   => [
                'extraArgs' => [
                    '--exclude=TestStandard.ExitCodes.FailToFix',
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '1',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 0,
            ],
            'Mix of errors and warnings, ignoring warnings + non-auto-fixable for exit code'                 => [
                'extraArgs' => [
                    '--exclude=TestStandard.ExitCodes.FailToFix',
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '1',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 0,
            ],
            'Mix of errors and warnings, ignoring errors + warnings for exit code'                           => [
                'extraArgs' => [
                    '--exclude=TestStandard.ExitCodes.FailToFix',
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '1',
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '1',
                ],
                'expected'  => 0,
            ],
            'Mix of errors and warnings, explicitly ignoring nothing for exit code'                          => [
                'extraArgs' => [
                    '--exclude=TestStandard.ExitCodes.FailToFix',
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '0',
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '0',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '0',
                ],
                'expected'  => 2,
            ],

            'Fixable error and non-fixable warning, ignoring errors for exit code'                           => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.FixableError,TestStandard.ExitCodes.Warning',
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '1',
                ],
                'expected'  => 2,
            ],
            'Non-fixable error and fixable warning, ignoring errors for exit code'                           => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.Error,TestStandard.ExitCodes.FixableWarning',
                    '--runtime-set',
                    'ignore_errors_on_exit',
                    '1',
                ],
                'expected'  => 0,
            ],

            'Fixable error and non-fixable warning, ignoring warnings for exit code'                         => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.FixableError,TestStandard.ExitCodes.Warning',
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '1',
                ],
                'expected'  => 0,
            ],
            'Non-fixable error and fixable warning, ignoring warnings for exit code'                         => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.Error,TestStandard.ExitCodes.FixableWarning',
                    '--runtime-set',
                    'ignore_warnings_on_exit',
                    '1',
                ],
                'expected'  => 2,
            ],

            'Fixable error and non-fixable warning, ignoring non-auto-fixable for exit code'                 => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.FixableError,TestStandard.ExitCodes.Warning',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 0,
            ],
            'Non-fixable error and fixable warning, ignoring non-auto-fixable for exit code'                 => [
                'extraArgs' => [
                    '--sniffs=TestStandard.ExitCodes.Error,TestStandard.ExitCodes.FixableWarning',
                    '--runtime-set',
                    'ignore_non_auto_fixable_on_exit',
                    '1',
                ],
                'expected'  => 0,
            ],
        ];
    }


    /**
     * Helper method to prepare the CLI arguments for a test.
     *
     * @param string        $cmd       The command. Either 'phpcs' or 'phpcbf'.
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     *
     * @return void
     */
    private function setServerArgs($cmd, $extraArgs)
    {
        $standard = __DIR__ . '/ExitCodeTest.xml';

        $_SERVER['argv'] = [
            $cmd,
            "--standard=$standard",
            '--report-width=80',
            '--suffix=.fixed',
        ];

        foreach ($extraArgs as $arg) {
            $_SERVER['argv'][] = $arg;
        }
    }
}
