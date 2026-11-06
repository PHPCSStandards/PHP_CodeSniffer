<?php
/**
 * Tests for the \PHP_CodeSniffer\Config parallel value.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Config;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Tests\Core\Config\AbstractRealConfigTestCase;

/**
 * Tests for the \PHP_CodeSniffer\Config parallel value.
 *
 * @covers \PHP_CodeSniffer\Config::processLongArgument
 * @covers \PHP_CodeSniffer\Config::restoreDefaults
 */
final class ParallelTest extends AbstractRealConfigTestCase
{


    /**
     * Test that parallel defaults to 1 when no value is provided.
     *
     * @return void
     */
    public function testParallelDefault()
    {
        $config = new Config(['--standard=PSR1']);
        $this->assertSame(1, $config->parallel);
    }


    /**
     * Test that parallel can be set from a CLI argument.
     *
     * @return void
     */
    public function testParallelCanBeSetFromCLI()
    {
        $_SERVER['argv'] = [
            'phpcs',
            '--standard=PSR1',
            '--parallel=8',
        ];

        $config = new Config();
        $this->assertSame(8, $config->parallel);
    }


    /**
     * Test that parallel can be set from a CodeSniffer.conf file.
     *
     * @return void
     */
    public function testParallelCanBeSetFromConfFile()
    {
        $this->setStaticConfigProperty('configData', ['parallel' => '4']);

        $config = new Config(['--standard=PSR1']);
        $this->assertSame(4, $config->parallel);
    }


    /**
     * Test that "auto" passed on the CLI resolves to a non-0 positive integer.
     *
     * @return void
     */
    public function testParallelInputHandlingForAutoFromCLI()
    {
        $_SERVER['argv'] = [
            'phpcs',
            '--standard=PSR1',
            '--parallel=auto',
        ];

        $config = new Config();

        // Can't test the exact value as "auto" will resolve differently depending on the machine running the tests.
        $this->assertIsInt($config->parallel);
        $this->assertGreaterThan(0, $config->parallel);
    }


    /**
     * Test that "auto" set in the CodeSniffer.conf file resolves to a non-0 positive integer.
     *
     * @return void
     */
    public function testParallelInputHandlingForAutoFromConfFile()
    {
        $this->setStaticConfigProperty('configData', ['parallel' => 'auto']);

        $config = new Config(['--standard=PSR1']);

        // Can't test the exact value as "auto" will resolve differently depending on the machine running the tests.
        $this->assertIsInt($config->parallel);
        $this->assertGreaterThan(0, $config->parallel);
    }
}
