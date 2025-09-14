<?php
/**
 * Tests for overriding the value of a PHP ini setting using CLI arguments.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Config;

use PHP_CodeSniffer\Exceptions\DeepExitException;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Tests for overriding the value of a PHP ini setting using CLI arguments.
 *
 * @covers \PHP_CodeSniffer\Config::processShortArgument
 */
final class IniSetTest extends TestCase
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
     * Verify that when an ini option is passed on the command-line and the value is the current value of the option
     * and can be set at runtime, PHPCS does not throw an exception.
     *
     * @return void
     */
    public function testIniValueHandlingWhenValueIsAlreadyCorrect()
    {
        $this->currentOption = 'precision';
        $this->originalValue = ini_get($this->currentOption);

        $this->assertNotFalse($this->originalValue, "Test is broken: the {$this->currentOption} ini directive does not exist");

        new ConfigDouble(['-d', "{$this->currentOption}={$this->originalValue}"]);

        $this->assertSame($this->originalValue, ini_get($this->currentOption));
    }


    /**
     * Verify that when an ini option is passed on the command-line without a value and can be set at runtime, PHPCS sets it correctly.
     *
     * @requires extension mbstring
     *
     * @return void
     */
    public function testIniValueIsUpdatedToTrueWhenNoValuePassed()
    {
        $this->currentOption = 'precision';
        // Set the expectation as the string equivalent to "true" as ini_get() will return a string value.
        $expected = '1';

        $this->originalValue = ini_get($this->currentOption);

        if ($this->originalValue === $expected) {
            $this->markTestSkipped(
                'Skipping as original ini value on the system on which the test is run, is the same as the intended "new" value.'
            );
        }

        $this->assertNotFalse($this->originalValue, "Test is broken: the {$this->currentOption} ini directive does not exist");

        new ConfigDouble(['-d', $this->currentOption]);

        $this->assertSame($expected, ini_get($this->currentOption));
    }


    /**
     * Test that when an ini value for a Core directive is passed on the command-line and can be set at runtime,
     * PHPCS sets it correctly.
     *
     * @param string $option           The name of the ini option.
     * @param string $newValue         The value to set the ini option to.
     * @param string $alternativeValue Alternative value if the newValue would happen to coincide with the original value.
     *
     * @dataProvider dataIniValueIsUpdated
     *
     * @return void
     */
    public function testIniValueIsUpdated($option, $newValue, $alternativeValue)
    {
        $this->currentOption = $option;
        $this->originalValue = ini_get($option);

        if ($this->originalValue === $newValue) {
            $newValue = $alternativeValue;
        }

        $this->assertNotFalse($this->originalValue, "Test is broken: the $option ini directive does not exist");

        new ConfigDouble(['-d', "$option=$newValue"]);

        $this->assertSame($newValue, ini_get($option));
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string>>
     */
    public static function dataIniValueIsUpdated()
    {
        return [
            // Core directive, default value is 14.
            'INI_ALL option: precision' => [
                'option'           => 'precision',
                'newValue'         => '10',
                'alternativeValue' => '20',
            ],
        ];
    }


    /**
     * Test that when an INI_ALL value for an optional extension is passed on the command-line and can be set at runtime,
     * PHPCS sets it correctly.
     *
     * This is tested in a separate method as the BCMath extension may not be available (which would cause the test to fail).
     *
     * @requires extension bcmath
     *
     * @return void
     */
    public function testIniValueIsUpdatedWhenOptionalBcmathExtensionIsAvailable()
    {
        // Default value for the bcmath.scale ini setting is 0.
        $this->currentOption = 'bcmath.scale';
        $newValue            = '10';

        $this->originalValue = ini_get($this->currentOption);
        if ($this->originalValue === $newValue) {
            $newValue = '20';
        }

        $this->assertNotFalse($this->originalValue, "Test is broken: the {$this->currentOption} ini directive does not exist");

        new ConfigDouble(['-d', "{$this->currentOption}=$newValue"]);

        $this->assertSame($newValue, ini_get($this->currentOption));
    }


    /**
     * Test that when an ini value is passed on the command-line and can be set at runtime, PHPCS sets it correctly.
     *
     * There are only two `INI_USER` options in PHP. The first `tidy.clean_output` cannot be used for this test
     * as PHPUnit will send headers before this test runs.
     * So `sqlite3.defensive` is the only option we can test with, but this option was an INI_SYSTEM setting
     * prior to PHP 8.2, so we can only test it on PHP 8.2 and higher.
     *
     * It's also unfortunate that it is a boolean option, which makes distinguising "set to false" and
     * "not set" difficult.
     *
     * @requires PHP 8.2
     * @requires extension sqlite3
     *
     * @return void
     */
    public function testIniValueIsUpdatedWhenOptionalSqllite3ExtensionIsAvailable()
    {
        // Default value for the sqlite3.defensive ini setting is 1.
        $this->currentOption = 'sqlite3.defensive';
        $newValue            = '0';

        $this->originalValue = ini_get($this->currentOption);
        if ($this->originalValue === $newValue) {
            $newValue = '1';
        }

        $this->assertNotFalse($this->originalValue, "Test is broken: the {$this->currentOption} ini directive does not exist");

        new ConfigDouble(['-d', "{$this->currentOption}=$newValue"]);

        $this->assertSame($newValue, ini_get($this->currentOption));
    }


    /**
     * Test that when an ini value is for a disabled extension, PHPCS will silently ignore the ini setting.
     *
     * @return void
     */
    public function testIniValueIsSilentlyIgnoredWhenOptionalExtensionIsNotAvailable()
    {
        if (extension_loaded('mysqli') === true) {
            $this->markTestSkipped(
                'Skipping as this test needs the MySqli extension to *not* be available.'
            );
        }

        $this->currentOption = 'mysqli.default_port';
        $newValue            = '1234';

        $this->originalValue = ini_get($this->currentOption);
        $this->assertFalse($this->originalValue, "Test is broken: the {$this->currentOption} ini directive exists");

        new ConfigDouble(['-d', "{$this->currentOption}=$newValue"]);

        $this->assertFalse(ini_get($this->currentOption), 'This should be impossible: an option for a disabled extension cannot be set');
    }


    /**
     * Test that when an ini value is not known to PHP, PHPCS will silently ignore the ini setting.
     *
     * @return void
     */
    public function testIniValueIsSilentlyIgnoredForUnknownIniName()
    {
        $this->currentOption = 'some.ini_which_doesnt_exist';
        $newValue            = '1234';

        $this->originalValue = ini_get($this->currentOption);
        $this->assertFalse($this->originalValue, "Test is broken: the {$this->currentOption} ini directive exists");

        new ConfigDouble(['-d', "{$this->currentOption}=$newValue"]);

        $this->assertFalse(ini_get($this->currentOption), 'This should be impossible: an option which isn\'t known to PHP cannot be set');
    }


    /**
     * Test that when an ini value is passed on the command-line and can NOT be set at runtime, PHPCS reports this.
     *
     * @param string $option           The name of the ini option.
     * @param string $newValue         The value to set the ini option to.
     * @param string $alternativeValue Alternative value in case the ini option is currently set to the $newValue.
     *
     * @dataProvider dataIniValueCannotBeUpdatedAtRuntime
     *
     * @return void
     */
    public function testIniValueCannotBeUpdatedAtRuntime($option, $newValue, $alternativeValue = '')
    {
        $this->expectException(DeepExitException::class);
        $this->expectExceptionMessage("ERROR: Ini option \"$option\" cannot be changed at runtime.");

        $this->currentOption = $option;
        $this->originalValue = ini_get($option);
        $this->assertNotFalse($this->originalValue, "Test is broken: the $option ini directive does not exist");

        if ($this->originalValue === $newValue) {
            $newValue = $alternativeValue;
        }

        new ConfigDouble(['-d', "$option=$newValue"]);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string>>
     */
    public static function dataIniValueCannotBeUpdatedAtRuntime()
    {
        return [
            // Using Core directives available PHP cross-version to prevent the tests failing
            // on an unavailable directive or due to an extension not being available.
            'php.ini only option: expose_php'          => [
                'option'           => 'expose_php',
                'newValue'         => '0',
                'alternativeValue' => '1',
            ],
            'INI_PERDIR option: short_open_tag (bool)' => [
                'option'           => 'short_open_tag',
                'newValue'         => '1',
                'alternativeValue' => '0',
            ],
            'INI_PERDIR option: max_input_vars (int)'  => [
                'option'           => 'max_input_vars',
                'newValue'         => '345',
                'alternativeValue' => '543',
            ],
            'INI_SYSTEM option: realpath_cache_ttl'    => [
                'option'           => 'realpath_cache_ttl',
                'newValue'         => '150',
                'alternativeValue' => '300',
            ],
        ];
    }
}
