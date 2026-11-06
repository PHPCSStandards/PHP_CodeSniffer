<?php
/**
 * Tests for the in-memory API of the Cache class.
 *
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\Cache;

use PHP_CodeSniffer\Util\Cache;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Cache::get(), Cache::set() and Cache::getSize().
 *
 * {@internal These tests need to run in separate processes as the Cache class uses static
 * properties for the in-memory store and the cache file path.}
 *
 * @covers \PHP_CodeSniffer\Util\Cache::get
 * @covers \PHP_CodeSniffer\Util\Cache::set
 * @covers \PHP_CodeSniffer\Util\Cache::getSize
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
final class GetSetGetSizeTest extends TestCase
{


    /**
     * Test Cache::get().
     *
     * @param array<string, mixed> $pairsToSet Key/value pairs to set before calling get().
     * @param string|null          $getKey     Key to retrieve. NULL returns the whole store.
     * @param mixed                $expected   Expected return value.
     *
     * @dataProvider dataGet
     *
     * @return void
     */
    public function testGet($pairsToSet, $getKey, $expected)
    {
        foreach ($pairsToSet as $key => $value) {
            Cache::set($key, $value);
        }

        $this->assertSame($expected, Cache::get($getKey));
    }


    /**
     * Data provider.
     *
     * @see testGet()
     *
     * @return array<string, array<string, mixed>>
     */
    public static function dataGet()
    {
        $fileEntry = [
            'hash'                => 'abc',
            'errors'              => [],
            'warnings'            => [],
            'metrics'             => [],
            'errorCount'          => 0,
            'warningCount'        => 0,
            'fixableErrorCount'   => 0,
            'fixableWarningCount' => 0,
            'numTokens'           => 3,
        ];

        return [
            'missing key'                          => [
                'pairsToSet' => [],
                'getKey'     => 'missing',
                'expected'   => false,
            ],
            'existing key, string value'           => [
                'pairsToSet' => ['k' => 'value'],
                'getKey'     => 'k',
                'expected'   => 'value',
            ],
            'existing key, integer value'          => [
                'pairsToSet' => ['k' => 42],
                'getKey'     => 'k',
                'expected'   => 42,
            ],
            'existing key, LocalFile-shaped array' => [
                'pairsToSet' => ['/tmp/file.php' => $fileEntry],
                'getKey'     => '/tmp/file.php',
                'expected'   => $fileEntry,
            ],
            'null key returns the whole store'     => [
                'pairsToSet' => ['k' => 'value'],
                'getKey'     => null,
                'expected'   => ['k' => 'value'],
            ],
        ];
    }


    /**
     * Test Cache::set().
     *
     * @param array<int, array{0: string|null, 1: mixed}> $sets     Ordered set() calls.
     * @param string                                      $getKey   Key to retrieve afterwards.
     * @param mixed                                       $expected Expected return value from get().
     *
     * @dataProvider dataSet
     *
     * @return void
     */
    public function testSet($sets, $getKey, $expected)
    {
        foreach ($sets as $set) {
            Cache::set($set[0], $set[1]);
        }

        $this->assertSame($expected, Cache::get($getKey));
    }


    /**
     * Data provider.
     *
     * @see testSet()
     *
     * @return array<string, array<string, mixed>>
     */
    public static function dataSet()
    {
        return [
            'set a key'                            => [
                'sets'     => [
                    [
                        'path',
                        'payload',
                    ],
                ],
                'getKey'   => 'path',
                'expected' => 'payload',
            ],
            'overwrite a key'                      => [
                'sets'     => [
                    [
                        'path',
                        'first',
                    ],
                    [
                        'path',
                        'second',
                    ],
                ],
                'getKey'   => 'path',
                'expected' => 'second',
            ],
            'replace entire store removes old key' => [
                'sets'     => [
                    [
                        'old',
                        1,
                    ],
                    [
                        null,
                        ['new' => 2],
                    ],
                ],
                'getKey'   => 'old',
                'expected' => false,
            ],
            'replace entire store keeps new key'   => [
                'sets'     => [
                    [
                        'old',
                        1,
                    ],
                    [
                        null,
                        ['new' => 2],
                    ],
                ],
                'getKey'   => 'new',
                'expected' => 2,
            ],
        ];
    }


    /**
     * Test Cache::getSize().
     *
     * @param array<string, mixed>|null $replaceWhole If not null, passed to set(null, $replaceWhole).
     * @param array<string, mixed>      $pairsToSet   Key/value pairs to set afterwards.
     * @param int                       $expected     Expected getSize() return value.
     *
     * @dataProvider dataGetSize
     *
     * @return void
     */
    public function testGetSize($replaceWhole, $pairsToSet, $expected)
    {
        if ($replaceWhole !== null) {
            Cache::set(null, $replaceWhole);
        }

        foreach ($pairsToSet as $key => $value) {
            Cache::set($key, $value);
        }

        $this->assertSame($expected, Cache::getSize());
    }


    /**
     * Data provider.
     *
     * @see testGetSize()
     *
     * @return array<string, array<string, mixed>>
     */
    public static function dataGetSize()
    {
        return [
            'empty store'                          => [
                'replaceWhole' => null,
                'pairsToSet'   => [],
                'expected'     => -1,
            ],
            'one key, no config slot'              => [
                'replaceWhole' => null,
                'pairsToSet'   => ['a' => 1],
                'expected'     => 0,
            ],
            'two keys, no config slot'             => [
                'replaceWhole' => null,
                'pairsToSet'   => [
                    'a' => 1,
                    'b' => 2,
                ],
                'expected'     => 1,
            ],
            'planted config plus two file entries' => [
                'replaceWhole' => [
                    'config' => ['phpVersion' => 1],
                    'a'      => 1,
                    'b'      => 2,
                ],
                'pairsToSet'   => [],
                'expected'     => 2,
            ],
        ];
    }
}
