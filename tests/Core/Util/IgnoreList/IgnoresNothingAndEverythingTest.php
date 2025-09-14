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
 * Test ignoresNothing() and ignoresEverything().
 *
 * @covers PHP_CodeSniffer\Util\IgnoreList::ignoresNothing
 * @covers PHP_CodeSniffer\Util\IgnoreList::ignoresEverything
 */
final class IgnoresNothingAndEverythingTest extends TestCase
{


    /**
     * Test ignoresNothing() and ignoresEverything().
     *
     * @param \PHP_CodeSniffer\Util\IgnoreList $ignoreList              IgnoreList to test.
     * @param bool                             $expectIgnoresNothing    Expected return value from ignoresNothing().
     * @param bool                             $expectIgnoresEverything Expected return value from ignoresEverything().
     *
     * @return void
     *
     * @dataProvider dataIgnoresNothingAndEverything
     */
    public function testIgnoresNothingAndEverything($ignoreList, $expectIgnoresNothing, $expectIgnoresEverything)
    {
        $this->assertSame($expectIgnoresNothing, $ignoreList->ignoresNothing(), 'Ignores nothing');
        $this->assertSame($expectIgnoresEverything, $ignoreList->ignoresEverything(), 'Ignores everything');
    }


    /**
     * Data provider.
     *
     * @see testIgnoresNothingAndEverything()
     *
     * @return array<string, array<\PHP_CodeSniffer\Util\IgnoreList|bool>>
     */
    public static function dataIgnoresNothingAndEverything()
    {
        return [
            'fresh list'                                                                  => [
                'ignoreList'              => IgnoreList::getNewInstanceFrom(null),
                'expectIgnoresNothing'    => true,
                'expectIgnoresEverything' => false,
            ],
            'list from getInstanceIgnoringNothing'                                        => [
                'ignoreList'              => IgnoreList::getInstanceIgnoringNothing(),
                'expectIgnoresNothing'    => true,
                'expectIgnoresEverything' => false,
            ],
            'list from getInstanceIgnoringAll'                                            => [
                'ignoreList'              => IgnoreList::getInstanceIgnoringAll(),
                'expectIgnoresNothing'    => false,
                'expectIgnoresEverything' => true,
            ],
            'list from getInstanceIgnoringNothing, something set to false'                => [
                'ignoreList'              => IgnoreList::getInstanceIgnoringNothing()->set('Foo.Bar', false),
                'expectIgnoresNothing'    => true,
                'expectIgnoresEverything' => false,
            ],
            'list from getInstanceIgnoringNothing, something set to true'                 => [
                'ignoreList'              => IgnoreList::getInstanceIgnoringNothing()->set('Foo.Bar', true),
                'expectIgnoresNothing'    => false,
                'expectIgnoresEverything' => false,
            ],
            'list from getInstanceIgnoringAll, something set to false'                    => [
                'ignoreList'              => IgnoreList::getInstanceIgnoringAll()->set('Foo.Bar', false),
                'expectIgnoresNothing'    => false,
                'expectIgnoresEverything' => false,
            ],
            'list from getInstanceIgnoringAll, something set to true'                     => [
                'ignoreList'              => IgnoreList::getInstanceIgnoringAll()->set('Foo.Bar', true),
                'expectIgnoresNothing'    => false,
                'expectIgnoresEverything' => true,
            ],
            'list from getInstanceIgnoringNothing, something set to true then overridden' => [
                'ignoreList'              => IgnoreList::getInstanceIgnoringNothing()->set('Foo.Bar', true)->set('Foo', false),
                'expectIgnoresNothing'    => true,
                'expectIgnoresEverything' => false,
            ],
            'list from getInstanceIgnoringAll, something set to false then overridden'    => [
                'ignoreList'              => IgnoreList::getInstanceIgnoringAll()->set('Foo.Bar', false)->set('Foo', true),
                'expectIgnoresNothing'    => false,
                'expectIgnoresEverything' => true,
            ],
        ];
    }
}
