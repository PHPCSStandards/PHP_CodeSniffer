<?php
/**
 * Tests for overriding the value of a PHP ini setting by passing a new value via a ruleset.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Ruleset;

use PHP_CodeSniffer\Exceptions\DeepExitException;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Tests handling of attempts to override an (un)changeable PHP ini setting by passing a new value via a ruleset.
 *
 * @covers \PHP_CodeSniffer\Ruleset::processRuleset
 */
final class ProcessRulesetIniSetTest extends TestCase
{

    /**
     * The name of the current ini setting under test.
     *
     * @var string
     */
    private $currentOption;

    /**
     * Store the original value of the ini setting under test, so the system can be restored to its
     * original state in the tearDown() method.
     *
     * @var string|false
     */
    private $originalValue;


    /**
     * Reset the ini value which was potentially changed via the test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        if (is_string($this->originalValue) === true) {
            @ini_set($this->currentOption, $this->originalValue);
        }
    }


    /**
     * Test that when an ini value is set in a custom ruleset and can be set at runtime, PHPCS sets it correctly.
     *
     * @return void
     */
    public function testIniValueIsUpdated()
    {
        $this->currentOption = 'precision';
        $expected            = '10';

        $this->originalValue = ini_get($this->currentOption);
        $this->assertNotFalse($this->originalValue, "Test is broken: the {$this->currentOption} ini directive does not exist");

        new Ruleset(new ConfigDouble(['.', '--standard=' . __DIR__ . '/IniSetSuccessTest.xml']));

        $this->assertSame($expected, ini_get($this->currentOption));
    }


    /**
     * Test that when an ini value is set in a custom ruleset and can NOT be set at runtime, PHPCS reports this.
     *
     * @param string $standard The standard to use for the test.
     * @param string $option   The name of the ini option.
     * @param mixed  $expected The value to expect the ini option to be set to if it could have been changed.
     *
     * @dataProvider dataIniValueCannotBeUpdatedAtRuntime
     *
     * @return void
     */
    public function testIniValueCannotBeUpdatedAtRuntime($standard, $option, $expected)
    {
        $this->currentOption = $option;
        $this->originalValue = ini_get($option);

        if ($this->originalValue === $expected) {
            $this->markTestSkipped(
                'Skipping as original ini value on the system on which the test is run, is the same as the intended "new" value.'
            );
        }

        $this->assertNotFalse($this->originalValue, "Test is broken: the $option ini directive does not exist");

        $this->expectException(DeepExitException::class);
        $this->expectExceptionMessage("ERROR: Ini option \"$option\" cannot be changed at runtime.");

        new Ruleset(new ConfigDouble(["--standard=$standard"]));

        // Make sure the value didn't get set.
        $this->assertNotSame($expected, ini_get($option), 'Setting the ini value should not have worked, the test is broken');
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function dataIniValueCannotBeUpdatedAtRuntime()
    {
        return [
            // Using Core directives available PHP cross-version to prevent the tests failing
            // on an unavailable directive or due to an extension not being available.
            'php.ini only option: expose_php'       => [
                'standard' => __DIR__ . '/IniSetFailIniOnlyTest.xml',
                'option'   => 'expose_php',
                'expected' => '0',
            ],
            'INI_PERDIR option: short_open_tag'     => [
                'standard' => __DIR__ . '/IniSetFailIniPerDirTest.xml',
                'option'   => 'short_open_tag',
                'expected' => '1',
            ],
            'INI_SYSTEM option: realpath_cache_ttl' => [
                'standard' => __DIR__ . '/IniSetFailIniSystemTest.xml',
                'option'   => 'realpath_cache_ttl',
                'expected' => '200',
            ],
        ];
    }
}
