<?php
/**
 * Tests for the \PHP_CodeSniffer\Ruleset class.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Ruleset;

use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the \PHP_CodeSniffer\Ruleset class.
 *
 * @covers \PHP_CodeSniffer\Ruleset::processRuleset
 */
final class ProcessRulesetCliArgsTest extends TestCase
{

    /**
     * Directory in which the XML fixtures for this test can be found (without trailing slash).
     *
     * @var string
     */
    private const FIXTURE_DIR = __DIR__ . '/Fixtures/ProcessRulesetCliArgsTest';

    /**
     * The Config object.
     *
     * @var \PHP_CodeSniffer\Config
     */
    private static $config;


    /**
     * Initialize the config and ruleset objects for this test only once (but do allow recording code coverage).
     *
     * @return void
     */
    protected function setUp(): void
    {
        if (isset(self::$config) === false) {
            // Set up the ruleset.
            $standard     = self::FIXTURE_DIR . '/.phpcs.xml';
            self::$config = new ConfigDouble(["--standard=$standard"]);
            new Ruleset(self::$config);
        }
    }


    /**
     * Make sure the Config object is destroyed.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        // Explicitly trigger __destruct() on the ConfigDouble to reset the Config statics.
        // The explicit method call prevents potential stray test-local references to the $config object
        // preventing the destructor from running the clean up (which without stray references would be
        // automagically triggered when this object is destroyed, but we can't definitively rely on that).
        if (isset(self::$config) === true) {
            self::$config->__destruct();
        }
    }


    /**
     * Verify the CLI arguments passed from within rulesets are set based on the nesting level of the ruleset.
     *
     * - Highest level ruleset (root) should win over lower level (included) ruleset.
     * - When two rulesets at the same "level" both set the same ini, last included ruleset should win.
     * - But if no higher level ruleset sets the value, the values from lowel levels should be applied.
     * - The order of includes versus ini directives in a ruleset file is deliberately irrelevant.
     *
     * @param string $name     The name of the PHP ini setting we're checking.
     * @param mixed  $expected The expected value for that ini setting.
     *
     * @dataProvider dataCliArgs
     *
     * @return void
     */
    public function testCliArgs($name, $expected)
    {
        $this->assertSame($expected, self::$config->{$name});
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function dataCliArgs()
    {
        return [
            'Issue squiz#2395: "no-colors" set in parent before includes; "colors" set in child; parent should win'                  => [
                'name'     => 'colors',
                'expected' => false,
            ],
            'Issue squiz#2395: "w" set in parent after includes; "n" set in child; warningSeverity in grandchild; parent should win' => [
                'name'     => 'warningSeverity',
                'expected' => 5,
            ],
            'Issue squiz#2395: "cache" set to file in parent before includes; "no-cache" set in child; parent should win [1]'        => [
                'name'     => 'cache',
                'expected' => true,
            ],
            'Issue squiz#2395: "q" in child A before includes; "p" set in grandchild A, child A should win'                          => [
                'name'     => 'showProgress',
                'expected' => false,
            ],

            'Issue squiz#2597: "extensions" set in parent before includes; also set in child; parent should win'                     => [
                'name'     => 'extensions',
                'expected' => [
                    'inc'     => 'PHP',
                    'install' => 'PHP',
                    'module'  => 'PHP',
                    'php'     => 'PHP',
                    'profile' => 'PHP',
                    'test'    => 'PHP',
                    'theme'   => 'PHP',
                ],
            ],
            'Issue squiz#2602: "tab-width" set in parent after includes; also set in both children; parent should win'               => [
                'name'     => 'tabWidth',
                'expected' => 3,
            ],

            // Verify overrule order for various other miscellaneous settings.
            'Flag set in child A before includes; also set in grandchild A; child A should win'                                      => [
                'name'     => 'parallel',
                'expected' => 10,
            ],
            'Flag set in parent before includes; also set in grandchild A; parent should win'                                        => [
                'name'     => 'reports',
                'expected' => [
                    'full'    => null,
                    'summary' => null,
                    'source'  => null,
                ],
            ],
            'Flag set in child A after includes; also set in child B; child A should win'                                            => [
                'name'     => 'reportWidth',
                'expected' => 120,
            ],
        ];
    }


    /**
     * Verify that path resolution for CLI flags passing paths is done based on the location of the ruleset setting the flag.
     *
     * @param string               $name     The name of the Config setting we're checking.
     * @param string|array<string> $expected The expected value for that setting.
     *
     * @dataProvider dataCliArgsWithPaths
     *
     * @return void
     */
    public function testCliArgsWithPaths($name, $expected)
    {
        // Normalize slashes everywhere to allow the tests to pass on all OS-es.
        $expected = $this->normalizeSlashes($expected);
        $actual   = $this->normalizeSlashes(self::$config->{$name});

        $this->assertSame($expected, $actual);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|array<string>>>
     */
    public static function dataCliArgsWithPaths()
    {
        $data = [
            'Paths should be resolved based on the ruleset location: basepath'  => [
                'name'     => 'basepath',
                'expected' => self::FIXTURE_DIR,
            ],
            'Paths should be resolved based on the ruleset location: bootstrap' => [
                'name'     => 'bootstrap',
                'expected' => [
                    self::FIXTURE_DIR . '/vendor/OrgName/ExtStandard/bootstrap.php',
                ],
            ],
            'Paths should be resolved based on the ruleset location: cacheFile' => [
                'name'     => 'cacheFile',
                'expected' => self::FIXTURE_DIR . '/config/phpcs/.cache.phpcs',
            ],
        ];

        // Setting the `--report-file=` arg is only supported when running `phpcs`.
        if (PHP_CODESNIFFER_CBF === false) {
            $data['Paths should be resolved based on the ruleset location: reportFile'] = [
                'name'     => 'reportFile',
                'expected' => self::FIXTURE_DIR . '/config/phpcs/report.txt',
            ];
        }

        return $data;
    }


    /**
     * Test helper to allow for path comparisons to succeed, independently of the OS on which the tests are run.
     *
     * @param string|array<string> $path Path(s) to normalize.
     *
     * @return string|array<string>
     */
    private function normalizeSlashes($path)
    {
        if (is_array($path) === true) {
            foreach ($path as $k => $v) {
                $path[$k] = $this->normalizeSlashes($v);
            }

            return $path;
        }

        return str_replace(DIRECTORY_SEPARATOR, '/', $path);
    }
}
