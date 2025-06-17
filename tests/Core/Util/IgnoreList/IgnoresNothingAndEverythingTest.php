<?php
/**
 * Tests for the IgnoreList class.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
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

    }//end testIgnoresNothingAndEverything()


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
                IgnoreList::getNewInstanceFrom(null),
                true,
                false,
            ],
            'list from getInstanceIgnoringNothing'                                        => [
                IgnoreList::getInstanceIgnoringNothing(),
                true,
                false,
            ],
            'list from getInstanceIgnoringAll'                                            => [
                IgnoreList::getInstanceIgnoringAll(),
                false,
                true,
            ],
            'list from getInstanceIgnoringNothing, something set to false'                => [
                IgnoreList::getInstanceIgnoringNothing()->set('Foo.Bar', false),
                true,
                false,
            ],
            'list from getInstanceIgnoringNothing, something set to true'                 => [
                IgnoreList::getInstanceIgnoringNothing()->set('Foo.Bar', true),
                false,
                false,
            ],
            'list from getInstanceIgnoringAll, something set to false'                    => [
                IgnoreList::getInstanceIgnoringAll()->set('Foo.Bar', false),
                false,
                false,
            ],
            'list from getInstanceIgnoringAll, something set to true'                     => [
                IgnoreList::getInstanceIgnoringAll()->set('Foo.Bar', true),
                false,
                true,
            ],
            'list from getInstanceIgnoringNothing, something set to true then overridden' => [
                IgnoreList::getInstanceIgnoringNothing()->set('Foo.Bar', true)->set('Foo', false),
                true,
                false,
            ],
            'list from getInstanceIgnoringAll, something set to false then overridden'    => [
                IgnoreList::getInstanceIgnoringAll()->set('Foo.Bar', false)->set('Foo', true),
                false,
                true,
            ],
        ];

    }//end dataIgnoresNothingAndEverything()


}//end class
