<?php
/**
 * CTRF (Common Test Report Format) report for PHP_CodeSniffer.
 *
 * Emits results in the open standard CTRF JSON format (https://ctrf.io/),
 * mapping each sniff violation to a CTRF test entry. ERROR violations are
 * reported with status "failed", WARNING violations with status "other",
 * and clean files emit a single "passed" test so the report contains the
 * full set of files that were processed.
 *
 * Implementation note: PHPCS supports parallel scanning by forking child
 * processes which each call generateFileReport() and append the captured
 * output to a shared temp file. The parent process later reads the merged
 * file and calls generate() once. This means we cannot share PHP state
 * across the boundary, so:
 *   - generateFileReport() emits each test as a self-contained JSON object
 *     terminated by a comma. The order-independent stream concatenates
 *     correctly regardless of which child wrote which file.
 *   - generate() derives the run-level start time and the passed count by
 *     scanning the merged cached data (mirroring the regex-on-cached-data
 *     pattern used by the JUnit reporter). This is safe because json_encode
 *     escapes inner quotes, so the only `"status":"passed"` and `"start":N`
 *     occurrences in the cached stream are top-level keys we emitted.
 *
 * @author    Lucas Bustamante <lucasfbustamante@gmail.com>
 * @copyright 2006-2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2023 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Reports;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\File;

class Ctrf implements Report
{

    /**
     * The CTRF specification version targeted by this reporter.
     *
     * @var string
     */
    private const SPEC_VERSION = '1.0.0';

    /**
     * Flags passed to every json_encode() call.
     *
     * `JSON_INVALID_UTF8_SUBSTITUTE` substitutes the Unicode replacement
     * character (U+FFFD) for invalid UTF-8 byte sequences. Without it,
     * a single bad byte in a violation message or filename would cause
     * json_encode() to return false and silently drop the entire test
     * entry, leaving the summary counts disagreeing with the tests array.
     *
     * @var int
     */
    private const JSON_FLAGS = JSON_INVALID_UTF8_SUBSTITUTE;


    /**
     * Generate a partial report for a single processed file.
     *
     * Each violation produces one CTRF test entry. A file with no violations
     * emits a single "passed" test entry so consumers can see clean files in
     * the report. Each emitted test is a complete JSON object terminated with
     * a trailing comma, which is later joined and de-trailed in {@see generate()}.
     *
     * @param array<string, string|int|array> $report      Prepared report data.
     *                                                     See the {@see Report} interface for a detailed specification.
     * @param \PHP_CodeSniffer\Files\File     $phpcsFile   The file being reported on.
     * @param bool                            $showSources Show sources?
     * @param int                             $width       Maximum allowed line width.
     *
     * @return bool
     */
    public function generateFileReport(array $report, File $phpcsFile, bool $showSources = false, int $width = 80)
    {
        $now = (int) (microtime(true) * 1000);

        if (count($report['messages']) === 0) {
            $test = [
                'name'     => $report['filename'],
                'status'   => 'passed',
                'duration' => 0,
                'start'    => $now,
                'stop'     => $now,
                'filePath' => $report['filename'],
                'suite'    => [$report['filename']],
                'type'     => 'lint',
            ];
            echo json_encode($test, self::JSON_FLAGS) . ',';
            return true;
        }

        $encoding = $phpcsFile->config->encoding;
        foreach ($report['messages'] as $line => $lineErrors) {
            foreach ($lineErrors as $column => $colErrors) {
                foreach ($colErrors as $error) {
                    $message = $error['message'];
                    if ($encoding !== 'utf-8') {
                        $message = iconv($encoding, 'utf-8', $message);
                    }

                    if ($error['type'] === 'ERROR') {
                        $status = 'failed';
                    } else {
                        $status = 'other';
                    }

                    $tags = [$error['type']];
                    if ($error['fixable'] === true) {
                        $tags[] = 'fixable';
                    }

                    $test = [
                        'name'      => $error['source'] . ' at ' . $report['filename'] . " ($line:$column)",
                        'status'    => $status,
                        'duration'  => 0,
                        'start'     => $now,
                        'stop'      => $now,
                        'message'   => $message,
                        'filePath'  => $report['filename'],
                        'line'      => $line,
                        'suite'     => [$report['filename']],
                        'rawStatus' => $error['type'],
                        'type'      => 'lint',
                        'tags'      => $tags,
                        'extra'     => [
                            'column'   => $column,
                            'severity' => $error['severity'],
                            'fixable'  => $error['fixable'],
                            'source'   => $error['source'],
                        ],
                    ];
                    echo json_encode($test, self::JSON_FLAGS) . ',';
                }
            }
        }

        return true;
    }


    /**
     * Generates a CTRF JSON report.
     *
     * @param string $cachedData    Any partial report data that was returned from
     *                              generateFileReport during the run.
     * @param int    $totalFiles    Total number of files processed during the run.
     * @param int    $totalErrors   Total number of errors found during the run.
     * @param int    $totalWarnings Total number of warnings found during the run.
     * @param int    $totalFixable  Total number of problems that can be fixed.
     * @param bool   $showSources   Show sources?
     * @param int    $width         Maximum allowed line width.
     * @param bool   $interactive   Are we running in interactive mode?
     * @param bool   $toScreen      Is the report being printed to screen?
     *
     * @return void
     */
    public function generate(
        string $cachedData,
        int $totalFiles,
        int $totalErrors,
        int $totalWarnings,
        int $totalFixable,
        bool $showSources = false,
        int $width = 80,
        bool $interactive = false,
        bool $toScreen = true
    ) {
        $now = (int) (microtime(true) * 1000);

        // Run start = earliest per-test start in the cached partials; run stop
        // = the moment we are generating the envelope. If no tests were emitted
        // (e.g. no files processed), both fall back to "now".
        $start = $now;
        if ($cachedData !== '') {
            $matches = [];
            if (preg_match_all('/"start":(\d+)/', $cachedData, $matches) > 0) {
                $start = min(array_map('intval', $matches[1]));
            }
        }

        $stop     = $now;
        $duration = ($stop - $start);

        // `failed` and `other` come from the authoritative parameters PHPCS
        // passes us. `passed` is not provided as a parameter (PHPCS doesn't
        // separately track clean files), so we count it from the cached
        // partials, where each clean file emitted exactly one entry with
        // `"status":"passed"`. The asymmetry is intentional: prefer the
        // authoritative source where one exists.
        $passed = substr_count($cachedData, '"status":"passed"');
        $failed = $totalErrors;
        $other  = $totalWarnings;
        $tests  = ($passed + $failed + $other);

        $tool = [
            'name'    => 'PHP_CodeSniffer',
            'version' => Config::VERSION,
        ];

        $summary = [
            'tests'    => $tests,
            'passed'   => $passed,
            'failed'   => $failed,
            'skipped'  => 0,
            'pending'  => 0,
            'other'    => $other,
            'suites'   => $totalFiles,
            'start'    => $start,
            'stop'     => $stop,
            'duration' => $duration,
            'extra'    => ['fixable' => $totalFixable],
        ];

        // Build the envelope as a regular PHP array and json_encode it whole.
        // The `tests` array contains the cached per-file output, which is already
        // a comma-separated stream of JSON objects. We splice it in via a
        // unique placeholder so we don't have to re-decode and re-encode each
        // test entry just to wrap the envelope around them.
        $placeholder = '__ctrf_tests_' . bin2hex(random_bytes(8)) . '__';
        $envelope    = [
            'reportFormat' => 'CTRF',
            'specVersion'  => self::SPEC_VERSION,
            'reportId'     => $this->generateUuidV4(),
            'timestamp'    => gmdate('Y-m-d\TH:i:s\Z'),
            'generatedBy'  => 'PHP_CodeSniffer ' . Config::VERSION,
            'results'      => [
                'tool'    => $tool,
                'summary' => $summary,
                'tests'   => $placeholder,
            ],
        ];

        $json = json_encode($envelope, self::JSON_FLAGS);
        $json = str_replace('"' . $placeholder . '"', '[' . rtrim($cachedData, ',') . ']', $json);
        echo $json . PHP_EOL;
    }


    /**
     * Generate a random RFC 4122 v4 UUID.
     *
     * @return string
     */
    private function generateUuidV4()
    {
        $data    = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0F) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3F) | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
