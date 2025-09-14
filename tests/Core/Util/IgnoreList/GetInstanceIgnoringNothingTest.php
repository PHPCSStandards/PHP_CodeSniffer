<?php
/**
 * Tests for the IgnoreList class.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\IgnoreList;

use PHP_CodeSniffer\Util\IgnoreList;
use PHPUnit\Framework\TestCase;

/**
 * Test getInstanceIgnoringNothing() works.
 *
 * @covers PHP_CodeSniffer\Util\IgnoreList::getInstanceIgnoringNothing
 */
final class GetInstanceIgnoringNothingTest extends TestCase
{


    /**
     * Test getInstanceIgnoringNothing() works.
     *
     * @return void
     */
    public function testGetInstanceIgnoringNothingWorks()
    {
        $ignoreList = IgnoreList::getInstanceIgnoringNothing();
        $this->assertInstanceOf(IgnoreList::class, $ignoreList);
        $this->assertFalse($ignoreList->isIgnored('Anything'));
    }
}
