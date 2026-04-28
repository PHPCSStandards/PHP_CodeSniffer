<?php
/**
 * Tests for the CTRF (Common Test Report Format) reporter.
 *
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Reports;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Reports\Ctrf;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the CTRF reporter's envelope, summary aggregation, and per-violation mapping.
 *
 * @covers \PHP_CodeSniffer\Reports\Ctrf
 */
final class CtrfTest extends TestCase
{


    /**
     * Decode the captured output, asserting it parses as JSON.
     *
     * @param string $output The captured stdout to decode.
     *
     * @return array<string, mixed>
     */
    private function decode($output)
    {
        $decoded = json_decode($output, true);
        $this->assertIsArray($decoded, 'Reporter output should be valid JSON. Raw output: ' . $output);
        return $decoded;
    }


    /**
     * Build a File stub whose `config->encoding` is the given value.
     *
     * The reporter only ever reads `$phpcsFile->config->encoding`, so this
     * minimal stub is sufficient. The constructor is disabled because File's
     * real constructor requires a Ruleset, which we don't need for reporter
     * tests.
     *
     * @param string $encoding The encoding to expose via `$file->config->encoding`.
     *
     * @return \PHP_CodeSniffer\Files\File
     */
    private function fileWithEncoding($encoding)
    {
        $config           = new ConfigDouble();
        $config->encoding = $encoding;

        $file         = $this->getMockBuilder(File::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file->config = $config;

        return $file;
    }


    /**
     * The envelope must contain the required CTRF top-level fields with valid values.
     *
     * @return void
     */
    public function testEnvelopeShape()
    {
        $reporter = new Ctrf();
        ob_start();
        $reporter->generate('', 0, 0, 0, 0);
        $report = $this->decode(ob_get_clean());

        $this->assertSame('CTRF', $report['reportFormat']);
        $this->assertSame('1.0.0', $report['specVersion']);
        $this->assertRegex(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/',
            $report['reportId'],
            'reportId should be a v4 UUID.'
        );
        $this->assertRegex(
            '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}Z$/',
            $report['timestamp']
        );
        $this->assertStringStartsWith('PHP_CodeSniffer ', $report['generatedBy']);
        $this->assertSame('PHP_CodeSniffer', $report['results']['tool']['name']);
        $this->assertSame(Config::VERSION, $report['results']['tool']['version']);
    }


    /**
     * Cross-version regex assertion: assertMatchesRegularExpression() was added
     * in PHPUnit 9.1.0 and assertRegExp() was removed in PHPUnit 10. PHPCS
     * supports both, so dispatch by feature detection.
     *
     * @param string $regex   The regular expression pattern.
     * @param string $value   The string to match against.
     * @param string $message Optional failure message.
     *
     * @return void
     */
    private function assertRegex($regex, $value, $message = '')
    {
        if (method_exists($this, 'assertMatchesRegularExpression') === true) {
            $this->assertMatchesRegularExpression($regex, $value, $message);
        } else {
            // PHPUnit < 9.1.0.
            $this->assertRegExp($regex, $value, $message);
        }
    }


    /**
     * With no inputs the summary should still be valid: all counts 0, tests array empty.
     *
     * @return void
     */
    public function testEmptySummary()
    {
        $reporter = new Ctrf();
        ob_start();
        $reporter->generate('', 0, 0, 0, 0);
        $report = $this->decode(ob_get_clean());

        $summary = $report['results']['summary'];
        $this->assertSame(0, $summary['tests']);
        $this->assertSame(0, $summary['passed']);
        $this->assertSame(0, $summary['failed']);
        $this->assertSame(0, $summary['skipped']);
        $this->assertSame(0, $summary['pending']);
        $this->assertSame(0, $summary['other']);
        $this->assertSame(0, $summary['suites']);
        $this->assertSame(0, $summary['extra']['fixable']);
        $this->assertSame([], $report['results']['tests']);
    }


    /**
     * Errors must map to summary.failed; warnings must map to summary.other.
     *
     * @return void
     */
    public function testSummaryAggregatesErrorsAndWarnings()
    {
        $reporter = new Ctrf();
        ob_start();
        // Cached data simulates 2 passed, 3 failed, 1 other test entries.
        $cached = '{"status":"passed"},{"status":"passed"},{"status":"failed"},{"status":"failed"},{"status":"failed"},{"status":"other"},';
        $reporter->generate($cached, 5, 3, 1, 2);
        $report = $this->decode(ob_get_clean());

        $summary = $report['results']['summary'];
        $this->assertSame(2, $summary['passed']);
        $this->assertSame(3, $summary['failed']);
        $this->assertSame(1, $summary['other']);
        $this->assertSame(6, $summary['tests']);
        $this->assertSame(5, $summary['suites']);
        $this->assertSame(2, $summary['extra']['fixable']);
    }


    /**
     * A run-level start should be derived from the earliest per-test start in the cached data.
     *
     * @return void
     */
    public function testTimingDerivedFromCachedTests()
    {
        $reporter = new Ctrf();
        ob_start();
        $cached = '{"start":1700000000000,"stop":1700000000010},{"start":1699999999000,"stop":1700000000020},';
        $reporter->generate($cached, 1, 0, 0, 0);
        $report = $this->decode(ob_get_clean());

        $summary = $report['results']['summary'];
        $this->assertSame(1699999999000, $summary['start']);
        $this->assertGreaterThanOrEqual($summary['start'], $summary['stop']);
        $this->assertSame(($summary['stop'] - $summary['start']), $summary['duration']);
    }


    /**
     * A clean file (no violations) emits one passed CTRF test entry.
     *
     * @return void
     */
    public function testCleanFileEmitsPassedTest()
    {
        $reporter = new Ctrf();
        $file     = $this->fileWithEncoding('utf-8');
        $report   = [
            'filename' => '/tmp/clean.php',
            'errors'   => 0,
            'warnings' => 0,
            'fixable'  => 0,
            'messages' => [],
        ];

        ob_start();
        $reporter->generateFileReport($report, $file);
        $output = ob_get_clean();

        // Output is a comma-terminated JSON object — wrap as array to decode.
        $decoded = json_decode('[' . rtrim($output, ',') . ']', true);
        $this->assertIsArray($decoded);
        $this->assertCount(1, $decoded);

        $test = $decoded[0];
        $this->assertSame('/tmp/clean.php', $test['name']);
        $this->assertSame('passed', $test['status']);
        $this->assertSame('/tmp/clean.php', $test['filePath']);
        $this->assertSame(['/tmp/clean.php'], $test['suite']);
        $this->assertSame('lint', $test['type']);
    }


    /**
     * An ERROR violation maps to a failed CTRF test, preserving PHPCS metadata.
     *
     * @return void
     */
    public function testErrorViolationMapsToFailed()
    {
        $reporter = new Ctrf();
        $file     = $this->fileWithEncoding('utf-8');
        $report   = [
            'filename' => '/tmp/dirty.php',
            'errors'   => 1,
            'warnings' => 0,
            'fixable'  => 1,
            'messages' => [
                3 => [
                    10 => [
                        [
                            'message'  => 'Expected at least 1 space before "=="',
                            'source'   => 'PSR12.Operators.OperatorSpacing.NoSpaceBefore',
                            'severity' => 5,
                            'fixable'  => true,
                            'type'     => 'ERROR',
                        ],
                    ],
                ],
            ],
        ];

        ob_start();
        $reporter->generateFileReport($report, $file);
        $output = ob_get_clean();

        $decoded = json_decode('[' . rtrim($output, ',') . ']', true);
        $this->assertCount(1, $decoded);

        $test = $decoded[0];
        $this->assertSame('failed', $test['status']);
        $this->assertSame('ERROR', $test['rawStatus']);
        $this->assertSame('PSR12.Operators.OperatorSpacing.NoSpaceBefore at /tmp/dirty.php (3:10)', $test['name']);
        $this->assertSame('/tmp/dirty.php', $test['filePath']);
        $this->assertSame(3, $test['line']);
        $this->assertSame(['/tmp/dirty.php'], $test['suite']);
        $this->assertContains('ERROR', $test['tags']);
        $this->assertContains('fixable', $test['tags']);
        $this->assertSame(10, $test['extra']['column']);
        $this->assertSame(5, $test['extra']['severity']);
        $this->assertTrue($test['extra']['fixable']);
        $this->assertSame('PSR12.Operators.OperatorSpacing.NoSpaceBefore', $test['extra']['source']);
    }


    /**
     * A WARNING violation maps to status "other", and non-fixable warnings have no "fixable" tag.
     *
     * @return void
     */
    public function testWarningViolationMapsToOther()
    {
        $reporter = new Ctrf();
        $file     = $this->fileWithEncoding('utf-8');
        $report   = [
            'filename' => '/tmp/file.php',
            'errors'   => 0,
            'warnings' => 1,
            'fixable'  => 0,
            'messages' => [
                7 => [
                    1 => [
                        [
                            'message'  => 'Comment refers to a TODO task',
                            'source'   => 'Generic.Commenting.Todo.TaskFound',
                            'severity' => 5,
                            'fixable'  => false,
                            'type'     => 'WARNING',
                        ],
                    ],
                ],
            ],
        ];

        ob_start();
        $reporter->generateFileReport($report, $file);
        $output = ob_get_clean();

        $decoded = json_decode('[' . rtrim($output, ',') . ']', true);
        $test    = $decoded[0];

        $this->assertSame('other', $test['status']);
        $this->assertSame('WARNING', $test['rawStatus']);
        $this->assertSame(['WARNING'], $test['tags']);
        $this->assertFalse($test['extra']['fixable']);
    }


    /**
     * Messages from a non-UTF-8 source file must be transcoded so the JSON output is UTF-8.
     *
     * @return void
     */
    public function testNonUtf8EncodingIsTranscoded()
    {
        $reporter = new Ctrf();
        $file     = $this->fileWithEncoding('iso-8859-1');
        // The byte 0xE9 is "é" in ISO-8859-1 but invalid as a standalone byte in UTF-8.
        $latinMessage = "Found char \xE9 (e-acute)";
        $report       = [
            'filename' => '/tmp/iso.php',
            'errors'   => 1,
            'warnings' => 0,
            'fixable'  => 0,
            'messages' => [
                1 => [
                    1 => [
                        [
                            'message'  => $latinMessage,
                            'source'   => 'X.Y.Z',
                            'severity' => 5,
                            'fixable'  => false,
                            'type'     => 'ERROR',
                        ],
                    ],
                ],
            ],
        ];

        ob_start();
        $reporter->generateFileReport($report, $file);
        $output = ob_get_clean();

        $decoded = json_decode('[' . rtrim($output, ',') . ']', true);
        $this->assertCount(1, $decoded);
        // After transcoding, the message must contain the proper UTF-8 sequence for é.
        $this->assertStringContainsString("\xC3\xA9", $decoded[0]['message']);
    }


    /**
     * Invalid UTF-8 bytes in messages must not silently drop the test entry.
     *
     * Without `JSON_INVALID_UTF8_SUBSTITUTE`, json_encode() returns false for
     * any string containing invalid UTF-8, and `echo false . ','` would emit
     * just a stray comma. The summary count would then disagree with the
     * actual tests array. This regression test guards against that.
     *
     * @return void
     */
    public function testInvalidUtf8DoesNotDropTest()
    {
        $reporter = new Ctrf();
        $file     = $this->fileWithEncoding('utf-8');
        $report   = [
            'filename' => '/tmp/x.php',
            'errors'   => 1,
            'warnings' => 0,
            'fixable'  => 0,
            'messages' => [
                1 => [
                    1 => [
                        [
                            'message'  => "bad \xC3\x28 utf8 here",
                            'source'   => 'X.Y.Z',
                            'severity' => 5,
                            'fixable'  => false,
                            'type'     => 'ERROR',
                        ],
                    ],
                ],
            ],
        ];

        ob_start();
        $reporter->generateFileReport($report, $file);
        $output = ob_get_clean();

        $decoded = json_decode('[' . rtrim($output, ',') . ']', true);
        $this->assertIsArray($decoded);
        $this->assertCount(1, $decoded, 'Test entry must not be dropped due to invalid UTF-8.');
        $this->assertSame('failed', $decoded[0]['status']);
        $this->assertStringContainsString("\u{FFFD}", $decoded[0]['message']);
    }


    /**
     * Multiple violations on the same file each become their own test entry.
     *
     * @return void
     */
    public function testMultipleViolationsEmitMultipleTests()
    {
        $reporter = new Ctrf();
        $file     = $this->fileWithEncoding('utf-8');
        $report   = [
            'filename' => '/tmp/multi.php',
            'errors'   => 1,
            'warnings' => 1,
            'fixable'  => 0,
            'messages' => [
                1 => [
                    1 => [
                        [
                            'message'  => 'first',
                            'source'   => 'Cat.A.B',
                            'severity' => 5,
                            'fixable'  => false,
                            'type'     => 'ERROR',
                        ],
                    ],
                ],
                5 => [
                    3 => [
                        [
                            'message'  => 'second',
                            'source'   => 'Cat.C.D',
                            'severity' => 5,
                            'fixable'  => false,
                            'type'     => 'WARNING',
                        ],
                    ],
                ],
            ],
        ];

        ob_start();
        $reporter->generateFileReport($report, $file);
        $output = ob_get_clean();

        $decoded = json_decode('[' . rtrim($output, ',') . ']', true);
        $this->assertCount(2, $decoded);
        $this->assertSame('failed', $decoded[0]['status']);
        $this->assertSame('other', $decoded[1]['status']);
    }


    /**
     * A full end-to-end pass — file report fed back into generate() — produces
     * a single well-formed CTRF document.
     *
     * @return void
     */
    public function testFullRoundTrip()
    {
        $reporter = new Ctrf();
        $file     = $this->fileWithEncoding('utf-8');

        ob_start();
        $reporter->generateFileReport(
            [
                'filename' => '/tmp/clean.php',
                'errors'   => 0,
                'warnings' => 0,
                'fixable'  => 0,
                'messages' => [],
            ],
            $file
        );
        $reporter->generateFileReport(
            [
                'filename' => '/tmp/dirty.php',
                'errors'   => 1,
                'warnings' => 0,
                'fixable'  => 0,
                'messages' => [
                    1 => [
                        1 => [
                            [
                                'message'  => 'oops',
                                'source'   => 'Cat.X.Y',
                                'severity' => 5,
                                'fixable'  => false,
                                'type'     => 'ERROR',
                            ],
                        ],
                    ],
                ],
            ],
            $file
        );
        $cached = ob_get_clean();

        ob_start();
        $reporter->generate($cached, 2, 1, 0, 0);
        $report = $this->decode(ob_get_clean());

        $this->assertSame(2, $report['results']['summary']['tests']);
        $this->assertSame(1, $report['results']['summary']['passed']);
        $this->assertSame(1, $report['results']['summary']['failed']);
        $this->assertSame(2, $report['results']['summary']['suites']);
        $this->assertCount(2, $report['results']['tests']);
    }
}
