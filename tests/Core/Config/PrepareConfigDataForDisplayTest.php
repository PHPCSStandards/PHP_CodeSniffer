<?php
/**
 * Tests for the Config::prepareConfigDataForDisplay() method.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Config;

use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Config::prepareConfigDataForDisplay() method.
 *
 * @covers \PHP_CodeSniffer\Config::prepareConfigDataForDisplay
 * @covers \PHP_CodeSniffer\Config::printConfigData
 */
final class PrepareConfigDataForDisplayTest extends TestCase
{


    /**
     * Verify that the config data is prepared for display correctly.
     *
     * - The method always returns a string.
     * - Config data is sorted based on the keys.
     * - The display formatting takes the length of the keys into account correctly.
     *
     * @param array<int|string, scalar> $data     The Config data.
     * @param string                    $expected Expected formatted string.
     *
     * @dataProvider dataPrepareConfigDataForDisplay
     *
     * @return void
     */
    public function testPrepareConfigDataForDisplay($data, $expected)
    {
        $config = new ConfigDouble();
        $actual = $config->prepareConfigDataForDisplay($data);

        $this->assertSame($expected, $actual);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, array<int|string, scalar>|string>>
     */
    public static function dataPrepareConfigDataForDisplay()
    {
        // phpcs:disable Squiz.Strings.ConcatenationSpacing.PaddingFound -- Readability is more important.
        return [
            'No config data'                                               => [
                'data'     => [],
                'expected' => '',
            ],
            'Only one config item'                                         => [
                'data'     => [
                    'colors' => '1',
                ],
                'expected' => 'colors: 1' . PHP_EOL,
            ],
            'Data with keys of varying length in non-alphabetically order' => [
                'data'     => [
                    'tab_width'             => '2',
                    'encoding'              => 'utf-8',
                    'ignore_errors_on_exit' => '1',
                    'default_standard'      => 'PSR12',
                ],
                'expected' => 'default_standard:      PSR12' . PHP_EOL
                    . 'encoding:              utf-8' . PHP_EOL
                    . 'ignore_errors_on_exit: 1' . PHP_EOL
                    . 'tab_width:             2' . PHP_EOL,
            ],
            'Invalid config data: no keys'                                 => [
                'data'     => [
                    '1',
                    '2',
                ],
                'expected' => '0: 1' . PHP_EOL . '1: 2' . PHP_EOL,
            ],
            'Unexpected, but handled, data with non-string scalar values'  => [
                'data'     => [
                    'encoding'              => 'utf-8',
                    'ignore_errors_on_exit' => true,
                    'tab_width'             => 2,
                ],
                'expected' => 'encoding:              utf-8' . PHP_EOL
                    . 'ignore_errors_on_exit: 1' . PHP_EOL
                    . 'tab_width:             2' . PHP_EOL,
            ],
        ];
        // phpcs:enable
    }


    /**
     * Perfunctory test for the deprecated Config::printConfigData() method.
     *
     * @return void
     */
    public function testPrintConfigData()
    {
        $this->expectOutputString('');

        $config = new ConfigDouble();
        $config->printConfigData([]);
    }
}
