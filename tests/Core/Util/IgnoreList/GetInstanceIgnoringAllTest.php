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
 * Test getInstanceIgnoringAll() works.
 *
 * @covers PHP_CodeSniffer\Util\IgnoreList::getInstanceIgnoringAll
 */
final class GetInstanceIgnoringAllTest extends TestCase
{


    /**
     * Test getInstanceIgnoringAll() works.
     *
     * @return void
     */
    public function testGetInstanceIgnoringAllWorks()
    {
        $ignoreList = IgnoreList::getInstanceIgnoringAll();
        $this->assertInstanceOf(IgnoreList::class, $ignoreList);
        $this->assertTrue($ignoreList->isIgnored('Anything'));
    }
}
