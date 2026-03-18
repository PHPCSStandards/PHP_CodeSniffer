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
final class ProcessRulesetConfigDirectivesTest extends TestCase
{

    /**
     * Directory in which the XML fixtures for this test can be found (without trailing slash).
     *
     * @var string
     */
    private const FIXTURE_DIR = __DIR__ . '/Fixtures/ProcessRulesetConfigDirectivesTest';

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
            $standardA    = self::FIXTURE_DIR . '/ProcessRulesetConfigDirectivesATest.xml';
            $standardB    = self::FIXTURE_DIR . '/ProcessRulesetConfigDirectivesBTest.xml';
            self::$config = new ConfigDouble(["--standard=$standardA,$standardB"]);
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
     * Verify the config directives are set based on the nesting level of the ruleset.
     *
     * - Highest level ruleset (root) should win over lower level (included) ruleset.
     * - When two rulesets at the same "level" both set the same config, last included ruleset should win.
     * - But if no higher level ruleset sets the value, the values from lowel levels should be applied.
     * - The order of includes versus config directives in a ruleset file is deliberately irrelevant.
     *
     * @param string $name     The name of the config setting we're checking.
     * @param string $expected The expected value for that config setting.
     *
     * @dataProvider dataConfigDirectives
     *
     * @return void
     */
    public function testConfigDirectives($name, $expected)
    {
        $this->assertSame($expected, self::$config->getConfigData($name));
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string>>
     */
    public static function dataConfigDirectives()
    {
        return [
            'Config set in parent A before includes; all includes try to overrule; parent A should win'           => [
                'name'     => 'expectValueFromParentATestSetBeforeIncludes',
                'expected' => 'parent A',
            ],
            'Config set in parent A after includes; all includes try to overrule; parent A should win'            => [
                'name'     => 'expectValueFromParentATestSetAfterIncludes',
                'expected' => 'parent A',
            ],
            'Config set in both parent A and parent B; B is included last via CLI; parent B should win'           => [
                'name'     => 'expectValueFromParentBTest',
                'expected' => 'parent B',
            ],
            'Config set in parent B; also set in non-direct grandchild B; parent B should win'                    => [
                'name'     => 'expectValueFromParentBTestAlsoInGrandChildB',
                'expected' => 'parent B',
            ],
            'Config set in child A before includes; also set in grandchild A; child A should win'                 => [
                'name'     => 'expectValueFromChildATestSetBeforeIncludes',
                'expected' => 'child A',
            ],
            'Config set in child A after includes; also set in grandchild B; child A should win'                  => [
                'name'     => 'expectValueFromChildATestSetAfterIncludes',
                'expected' => 'child A',
            ],
            'Config set in both child A and child B; B is included last via ruleset includes; child B should win' => [
                'name'     => 'expectValueFromChildBTestInChildAAndChildB',
                'expected' => 'child B',
            ],
            'Config set in child B; also set in non-direct grandchild A, child B should win'                      => [
                'name'     => 'expectValueFromChildBTestAlsoInGrandChildA',
                'expected' => 'child B',
            ],
            'Config set in child B - no overrules'                                                                => [
                'name'     => 'expectValueFromChildBTest',
                'expected' => 'child B',
            ],
            'Config set in grandchild A ruleset - no overrules'                                                   => [
                'name'     => 'expectValueFromGrandChildATest',
                'expected' => 'grandchild A',
            ],
            'Config set in grandchild B ruleset - no overrules'                                                   => [
                'name'     => 'expectValueFromGrandChildBTest',
                'expected' => 'grandchild B',
            ],
        ];
    }
}
