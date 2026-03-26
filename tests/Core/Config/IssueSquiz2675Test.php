<?php
/**
 * Tests for the \PHP_CodeSniffer\Config.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Config;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Tests\Core\Config\AbstractRealConfigTestCase;

/**
 * Tests that multiple consecutively created instances of the Config class with the same configuration will have the same settings.
 *
 * @link https://github.com/squizlabs/PHP_CodeSniffer/issues/2675
 *
 * @coversNothing
 */
final class IssueSquiz2675Test extends AbstractRealConfigTestCase
{


    /**
     * Tests that multiple consecutively created instances of the Config class with the same configuration will have the same settings.
     *
     * @return void
     */
    public function testIssueSquiz2675()
    {
        $configA = new Config(['--tab-width=4']);

        $this->assertSame(4, $configA->tabWidth, 'Tab width not correctly set when Config is first created');

        $configB = new Config(['--tab-width=4']);

        $this->assertSame(4, $configB->tabWidth, 'Tab width not correctly set when Config is created a second time');
    }
}
