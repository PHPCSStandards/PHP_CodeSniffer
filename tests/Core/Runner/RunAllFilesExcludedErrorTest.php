<?php
/**
 * Tests for the "All files were excluded" error message.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Runner;

use PHP_CodeSniffer\Runner;
use PHP_CodeSniffer\Tests\Core\Runner\AbstractRunnerTestCase;
use PHP_CodeSniffer\Tests\Core\StatusWriterTestHelper;

/**
 * Tests for the "All files were excluded" error message.
 *
 * @covers \PHP_CodeSniffer\Runner::run
 */
final class RunAllFilesExcludedErrorTest extends AbstractRunnerTestCase
{
    use StatusWriterTestHelper;


    /**
     * Verify that the "All files were excluded" error message is shown when all files are excluded (PHPCS).
     *
     * @param string        $sourceDir The (fixture) directory to scan for files.
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     *
     * @dataProvider data
     *
     * @return void
     */
    public function testPhpcs($sourceDir, $extraArgs)
    {
        if (PHP_CODESNIFFER_CBF === true) {
            $this->markTestSkipped('This test needs CS mode to run');
        }

        $this->setupTest($sourceDir, $extraArgs);

        $runner = new Runner();
        $runner->runPHPCS();

        $this->verifyOutput();
    }


    /**
     * Verify that the "All files were excluded" error message is shown when all files are excluded (PHPCBF).
     *
     * @param string        $sourceDir The (fixture) directory to scan for files.
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     *
     * @dataProvider data
     * @group        CBF
     *
     * @return void
     */
    public function testPhpcbf($sourceDir, $extraArgs)
    {
        if (PHP_CODESNIFFER_CBF === false) {
            $this->markTestSkipped('This test needs CBF mode to run');
        }

        $this->setupTest($sourceDir, $extraArgs);

        $runner = new Runner();
        $runner->runPHPCBF();

        $this->verifyOutput();
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|array<string>>>
     */
    public static function data()
    {
        return [
            'All files filtered out via extension'      => [
                'sourceDir' => __DIR__ . '/Fixtures/AllFilesExcludedSetA/',
                'extraArgs' => ['--extensions=php'],
            ],
            'All files filtered out via ignore pattern' => [
                'sourceDir' => __DIR__ . '/Fixtures/AllFilesExcludedSetB/',
                'extraArgs' => ['--ignore=/place*\.php'],
            ],
        ];
    }


    /**
     * Helper method to prepare the test.
     *
     * @param string        $sourceDir The (fixture) directory to scan for files.
     * @param array<string> $extraArgs Any extra arguments to pass on the command line.
     *
     * @return void
     */
    private function setupTest($sourceDir, $extraArgs)
    {
        $_SERVER['argv'] = [
            'phpcs',
            $sourceDir,
            '--standard=PSR1',
            '--report-width=80',
        ];

        foreach ($extraArgs as $arg) {
            $_SERVER['argv'][] = $arg;
        }

        $this->expectNoStdoutOutput();
    }


    /**
     * Helper method to verify the output expectation for STDERR.
     *
     * @return void
     */
    private function verifyOutput()
    {
        $expected  = 'ERROR: No files were checked.' . PHP_EOL;
        $expected .= 'All specified files were excluded or did not match filtering rules.' . PHP_EOL . PHP_EOL;

        $this->assertStderrOutputSameString($expected);
    }
}
