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
 * Test isIgnored() and set().
 *
 * @covers PHP_CodeSniffer\Util\IgnoreList::isIgnored
 * @covers PHP_CodeSniffer\Util\IgnoreList::set
 */
final class CheckAndSetTest extends TestCase
{


    /**
     * Test isIgnored() and set().
     *
     * @param array<string, bool> $toSet   Associative array of $code => $ignore to pass to set().
     * @param array<string, bool> $toCheck Associative array of $code => $expect to pass to isIgnored().
     *
     * @return void
     *
     * @dataProvider dataCheckAndSet
     */
    public function testCheckAndSet($toSet, $toCheck)
    {
        $ignoreList = IgnoreList::getNewInstanceFrom(null);
        foreach ($toSet as $code => $ignore) {
            $this->assertSame($ignoreList, $ignoreList->set($code, $ignore), 'Set method returned $this');
        }

        foreach ($toCheck as $code => $expect) {
            $this->assertSame($expect, $ignoreList->isIgnored($code), "$code is ignored");
        }
    }


    /**
     * Data provider.
     *
     * @see testCheckAndSet()
     *
     * @return array<string, array<array<string, bool>>>
     */
    public static function dataCheckAndSet()
    {
        return [
            'set a code'                                                                       => [
                'toSet'   => ['Standard.Category.Sniff.Code' => true],
                'toCheck' => [
                    'Standard.Category.Sniff.Code'      => true,
                    'Standard.Category.Sniff.OtherCode' => false,
                    'Standard.Category.OtherSniff.Code' => false,
                    'Standard.OtherCategory.Sniff.Code' => false,
                    'OtherStandard.Category.Sniff.Code' => false,
                ],
            ],
            'set a sniff'                                                                      => [
                'toSet'   => ['Standard.Category.Sniff' => true],
                'toCheck' => [
                    'Standard.Category.Sniff.Code'      => true,
                    'Standard.Category.Sniff.OtherCode' => true,
                    'Standard.Category.OtherSniff.Code' => false,
                    'Standard.OtherCategory.Sniff.Code' => false,
                    'OtherStandard.Category.Sniff.Code' => false,
                ],
            ],
            'set a category'                                                                   => [
                'toSet'   => ['Standard.Category' => true],
                'toCheck' => [
                    'Standard.Category.Sniff.Code'      => true,
                    'Standard.Category.Sniff.OtherCode' => true,
                    'Standard.Category.OtherSniff.Code' => true,
                    'Standard.OtherCategory.Sniff.Code' => false,
                    'OtherStandard.Category.Sniff.Code' => false,
                ],
            ],
            'set a standard'                                                                   => [
                'toSet'   => ['Standard' => true],
                'toCheck' => [
                    'Standard.Category.Sniff.Code'      => true,
                    'Standard.Category.Sniff.OtherCode' => true,
                    'Standard.Category.OtherSniff.Code' => true,
                    'Standard.OtherCategory.Sniff.Code' => true,
                    'OtherStandard.Category.Sniff.Code' => false,
                ],
            ],
            'set a standard, unignore a sniff in it'                                           => [
                'toSet'   => [
                    'Standard'                => true,
                    'Standard.Category.Sniff' => false,
                ],
                'toCheck' => [
                    'Standard.Category.Sniff.Code'      => false,
                    'Standard.Category.Sniff.OtherCode' => false,
                    'Standard.Category.OtherSniff.Code' => true,
                    'Standard.OtherCategory.Sniff.Code' => true,
                    'OtherStandard.Category.Sniff.Code' => false,
                ],
            ],
            'set a standard, unignore a category in it, ignore a sniff in that'                => [
                'toSet'   => [
                    'Standard'                => true,
                    'Standard.Category'       => false,
                    'Standard.Category.Sniff' => true,
                ],
                'toCheck' => [
                    'Standard.Category.Sniff.Code'      => true,
                    'Standard.Category.Sniff.OtherCode' => true,
                    'Standard.Category.OtherSniff.Code' => false,
                    'Standard.OtherCategory.Sniff.Code' => true,
                    'OtherStandard.Category.Sniff.Code' => false,
                ],
            ],
            'ignore some sniffs, then override some of those by unignoring the whole category' => [
                'toSet'   => [
                    'Standard.Category1.Sniff1' => true,
                    'Standard.Category1.Sniff2' => true,
                    'Standard.Category2.Sniff1' => true,
                    'Standard.Category2.Sniff2' => true,
                    'Standard.Category1'        => false,
                ],
                'toCheck' => [
                    'Standard.Category1.Sniff1' => false,
                    'Standard.Category1.Sniff2' => false,
                    'Standard.Category2.Sniff1' => true,
                    'Standard.Category2.Sniff2' => true,
                ],
            ],
        ];
    }
}
