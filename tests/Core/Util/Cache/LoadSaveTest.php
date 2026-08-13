<?php
/**
 * Tests for Cache::load() and Cache::save().
 *
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\Cache;

use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHP_CodeSniffer\Util\Cache;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Cache::load() and Cache::save().
 *
 * {@internal These tests need to run in separate processes as the Cache class uses static
 * properties for the in-memory store and the cache file path.}
 *
 * @covers \PHP_CodeSniffer\Util\Cache::load
 * @covers \PHP_CodeSniffer\Util\Cache::save
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
final class LoadSaveTest extends TestCase
{

    /**
     * Fixture file used as a scanned path.
     *
     * @var string
     */
    private const FIXTURE_A = __DIR__ . '/Fixtures/file-a.inc';

    /**
     * Second fixture file, nested so it shares an ancestor with FIXTURE_A.
     *
     * @var string
     */
    private const FIXTURE_B = __DIR__ . '/Fixtures/nested/file-b.inc';

    /**
     * Expected keys in the config block written by load().
     *
     * @var array<string>
     */
    private const CONFIG_KEYS = [
        'phpVersion',
        'phpExtensions',
        'tabWidth',
        'encoding',
        'recordErrors',
        'annotations',
        'configData',
        'codeHash',
        'rulesetHash',
    ];

    /**
     * Original XDG_CACHE_HOME value, or false if it was unset.
     *
     * @var string|false
     */
    private static $originalXdgCacheHome = false;

    /**
     * Temp files created during a test, deleted in tearDown().
     *
     * @var array<string>
     */
    private $createdFiles = [];

    /**
     * Temp directories created during a test, deleted in tearDown().
     *
     * @var array<string>
     */
    private $createdDirs = [];


    /**
     * Remember XDG_CACHE_HOME so tests can change it.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        self::$originalXdgCacheHome = getenv('XDG_CACHE_HOME');
    }


    /**
     * Restore XDG_CACHE_HOME after the class.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        self::restoreXdgCacheHome();
    }


    /**
     * Reset per-test bookkeeping.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->createdFiles = [];
        $this->createdDirs  = [];
    }


    /**
     * Delete temp files/dirs and restore XDG_CACHE_HOME.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        foreach ($this->createdFiles as $file) {
            if (is_string($file) === true && file_exists($file) === true) {
                @unlink($file);
            }
        }

        $dirs = array_reverse($this->createdDirs);
        foreach ($dirs as $dir) {
            if (is_string($dir) === true && is_dir($dir) === true) {
                @rmdir($dir);
            }
        }

        self::restoreXdgCacheHome();
    }


    /**
     * load() on a missing explicit cache file stamps config and has no file entries.
     *
     * @return void
     */
    public function testLoadMissingExplicitCacheFileStampsConfig()
    {
        $cacheFile = $this->explicitCacheFile();
        $this->assertCacheFileDoesNotExist($cacheFile);

        list($config, $ruleset) = $this->createConfigAndRuleset(
            [
                self::FIXTURE_A,
                '--standard=PSR1',
                '--cache=' . $cacheFile,
            ]
        );

        Cache::load($ruleset, $config);

        $this->assertFalse(Cache::get('any'));
        $this->assertSame(0, Cache::getSize());

        $cachedConfig = Cache::get('config');
        $this->assertIsArray($cachedConfig);
        $this->assertSame(self::CONFIG_KEYS, array_keys($cachedConfig));
    }


    /**
     * load() + set() + save() + load() round-trips a file entry through an explicit cache file.
     *
     * @return void
     */
    public function testLoadSetSaveLoadRoundTripsExplicitCacheFile()
    {
        $cacheFile = $this->explicitCacheFile();
        $payload   = $this->sampleFileEntry();

        list($config, $ruleset) = $this->createConfigAndRuleset(
            [
                self::FIXTURE_A,
                '--standard=PSR1',
                '--cache=' . $cacheFile,
            ]
        );

        Cache::load($ruleset, $config);
        Cache::set(self::FIXTURE_A, $payload);
        Cache::save();

        $this->assertFileExists($cacheFile);

        Cache::load($ruleset, $config);

        $this->assertSame($payload, Cache::get(self::FIXTURE_A));
        $this->assertSame(1, Cache::getSize());
    }


    /**
     * Create a ConfigDouble and Ruleset from CLI arguments.
     *
     * @param array<string> $cliArgs Arguments as they would appear after the script name.
     *
     * @return array{0: \PHP_CodeSniffer\Tests\ConfigDouble, 1: \PHP_CodeSniffer\Ruleset}
     */
    private function createConfigAndRuleset(array $cliArgs)
    {
        $config  = new ConfigDouble($cliArgs);
        $ruleset = new Ruleset($config);

        return [$config, $ruleset];
    }


    /**
     * Return a unique cache file path under the system temp directory and track it for cleanup.
     *
     * @return string
     */
    private function explicitCacheFile()
    {
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'phpcs-cache-test-' . uniqid('', true) . '.cache';
        $this->createdFiles[] = $path;

        return $path;
    }


    /**
     * Return a LocalFile-shaped cache payload.
     *
     * @return array<string, mixed>
     */
    private function sampleFileEntry()
    {
        return [
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
    }


    /**
     * Assert a file does not exist in a PHPUnit 8-compatible way.
     *
     * @param string $path Path to check.
     *
     * @return void
     */
    private function assertCacheFileDoesNotExist($path)
    {
        if (method_exists($this, 'assertFileDoesNotExist') === true) {
            $this->assertFileDoesNotExist($path);
        } else {
            $this->assertFileNotExists($path);
        }
    }


    /**
     * Restore XDG_CACHE_HOME to the value captured in setUpBeforeClass().
     *
     * @return void
     */
    private static function restoreXdgCacheHome()
    {
        if (is_string(self::$originalXdgCacheHome) === true) {
            putenv('XDG_CACHE_HOME=' . self::$originalXdgCacheHome);
        } else {
            putenv('XDG_CACHE_HOME');
        }
    }

}
