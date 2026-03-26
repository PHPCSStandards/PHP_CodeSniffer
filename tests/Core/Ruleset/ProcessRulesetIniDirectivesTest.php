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
final class ProcessRulesetIniDirectivesTest extends TestCase
{

    /**
     * Directory in which the XML fixtures for this test can be found (without trailing slash).
     *
     * @var string
     */
    private const FIXTURE_DIR = __DIR__ . '/Fixtures/ProcessRulesetIniDirectivesTest';

    /**
     * Cache to store the original ini values for ini settings being changed in these tests.
     *
     * @var array<string, string|null>
     */
    private static $originalIniValues = [
        'highlight.comment'  => null,
        'highlight.default'  => null,
        'highlight.html'     => null,
        'highlight.keyword'  => null,
        'highlight.string'   => null,
        'url_rewriter.hosts' => null,
        'url_rewriter.tags'  => null,
        'user_agent'         => null,
    ];

    /**
     * Whether or not the Config and Ruleset have been initialized.
     *
     * @var boolean
     */
    private static $initialized = false;


    /**
     * Store the original ini values to allow for restoring them after the tests.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        foreach (self::$originalIniValues as $name => $null) {
            $value = ini_get($name);
            if ($value !== false) {
                self::$originalIniValues[$name] = $value;
            }
        }
    }


    /**
     * Initialize the config and ruleset objects for this test only once (but do allow recording code coverage).
     *
     * @return void
     */
    protected function setUp(): void
    {
        if (self::$initialized === false) {
            // Set up the ruleset.
            $standard = self::FIXTURE_DIR . '/ProcessRulesetIniDirectivesTest.xml';
            $config   = new ConfigDouble(["--standard=$standard"]);
            new Ruleset($config);

            self::$initialized = true;
        }
    }


    /**
     * Restore the ini values after the tests.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        foreach (self::$originalIniValues as $name => $value) {
            if ($value === null) {
                continue;
            }

            ini_set($name, $value);
        }
    }


    /**
     * Verify the PHP ini directives are set based on the nesting level of the ruleset.
     *
     * - Highest level ruleset (root) should win over lower level (included) ruleset.
     * - When two rulesets at the same "level" both set the same ini, last included ruleset should win.
     * - But if no higher level ruleset sets the value, the values from lowel levels should be applied.
     * - The order of includes versus ini directives in a ruleset file is deliberately irrelevant.
     *
     * @param string $name     The name of the PHP ini setting we're checking.
     * @param string $expected The expected value for that ini setting.
     *
     * @dataProvider dataIniDirectives
     *
     * @return void
     */
    public function testIniDirectives($name, $expected)
    {
        $this->assertSame($expected, ini_get($name));
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string>>
     */
    public static function dataIniDirectives()
    {
        return [
            'Ini set in parent before includes; all includes try to overrule; parent should win'               => [
                'name'     => 'highlight.comment',
                'expected' => 'parent',
            ],
            'Ini set in parent after includes; all includes try to overrule; parent should win'                => [
                'name'     => 'highlight.default',
                'expected' => 'parent',
            ],
            'Ini set in child A before includes; also set in grandchild A; child A should win'                 => [
                'name'     => 'highlight.html',
                'expected' => 'child A',
            ],
            'Ini set in both child A and child B; B is included last via ruleset includes; child B should win' => [
                'name'     => 'highlight.keyword',
                'expected' => 'child B',
            ],
            'Ini set in child B; also set in non-direct grandchild A, child B should win'                      => [
                'name'     => 'highlight.string',
                'expected' => 'child B',
            ],
            'Ini set in parent; also set in grandchild A, parent should win'                                   => [
                'name'     => 'url_rewriter.hosts',
                'expected' => 'parent',
            ],
            'Ini set in child A - no overrules'                                                                => [
                'name'     => 'url_rewriter.tags',
                'expected' => 'child A',
            ],
            'Ini set only in grandchild A - no overrules'                                                      => [
                'name'     => 'user_agent',
                'expected' => 'grandchild A',
            ],
        ];
    }
}
