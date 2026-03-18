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
 * Test getNewInstanceFrom() works.
 *
 * @covers PHP_CodeSniffer\Util\IgnoreList::getNewInstanceFrom
 */
final class GetNewInstanceFromTest extends TestCase
{


    /**
     * Test getNewInstanceFrom() works.
     *
     * @return void
     */
    public function testGetNewInstanceFrom()
    {
        $ignoreList = IgnoreList::getNewInstanceFrom(null);
        $this->assertTrue($ignoreList->ignoresNothing(), 'Passing null returned an instance ignoring nothing');

        $ignoreList->set('Foo.Bar', true);
        $ignoreList2 = IgnoreList::getNewInstanceFrom($ignoreList);
        $this->assertNotSame($ignoreList, $ignoreList2, 'Passing an instance returns a different instance');

        $this->assertTrue($ignoreList2->isIgnored('Foo.Bar'), 'New instance ignores the same as the old one');
    }
}
