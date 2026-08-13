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
     * load() drops file entries when the on-disk config block cannot match this run.
     *
     * @return void
     */
    public function testLoadClearsEntriesWhenPlantedConfigDoesNotMatch()
    {
        $cacheFile = $this->explicitCacheFile();
        $planted   = [
            'config'  => ['phpVersion' => 0],
            'dummy'   => ['hash' => 'stale'],
        ];

        $bytes = file_put_contents($cacheFile, json_encode($planted));
        $this->assertNotFalse($bytes, 'Failed to write planted cache file');

        list($config, $ruleset) = $this->createConfigAndRuleset(
            [
                self::FIXTURE_A,
                '--standard=PSR1',
                '--cache=' . $cacheFile,
            ]
        );

        Cache::load($ruleset, $config);

        $this->assertFalse(Cache::get('dummy'));
        $cachedConfig = Cache::get('config');
        $this->assertIsArray($cachedConfig);
        $this->assertNotSame(['phpVersion' => 0], $cachedConfig);
        $this->assertArrayHasKey('phpVersion', $cachedConfig);
        $this->assertNotSame(0, $cachedConfig['phpVersion']);
    }


    /**
     * load() keeps file entries when the on-disk config was produced by the same inputs.
     *
     * @return void
     */
    public function testLoadKeepsEntriesWhenConfigMatches()
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

        Cache::load($ruleset, $config);

        $this->assertSame($payload, Cache::get(self::FIXTURE_A));
    }


    /**
     * When XDG_CACHE_HOME is a directory, save() writes phpcs.*.cache there.
     *
     * @return void
     */
    public function testSaveUsesXdgCacheHomeWhenItIsADirectory()
    {
        $xdgDir = $this->createTestCacheDir();
        putenv('XDG_CACHE_HOME=' . $xdgDir);

        $before = glob($xdgDir . DIRECTORY_SEPARATOR . 'phpcs.*.cache');
        if (is_array($before) === false) {
            $before = [];
        }

        list($config, $ruleset) = $this->createConfigAndRuleset(
            [
                self::FIXTURE_A,
                '--standard=PSR1',
            ]
        );

        Cache::load($ruleset, $config);
        Cache::set(self::FIXTURE_A, $this->sampleFileEntry());
        Cache::save();

        $created = $this->newCacheFilesIn($xdgDir, $before);
        $this->createdFiles = array_merge($this->createdFiles, $created);

        $this->assertCount(1, $created);
        $this->assertDoubleHashCacheFileName($created[0]);
        $this->assertSame($this->sampleFileEntry(), Cache::get(self::FIXTURE_A));
    }


    /**
     * When XDG_CACHE_HOME is unset, save() writes under the system temp directory.
     *
     * @return void
     */
    public function testSaveUsesSystemTempWhenXdgCacheHomeIsUnset()
    {
        putenv('XDG_CACHE_HOME');

        $tempDir = sys_get_temp_dir();
        $before  = glob($tempDir . DIRECTORY_SEPARATOR . 'phpcs.*.cache');
        if (is_array($before) === false) {
            $before = [];
        }

        list($config, $ruleset) = $this->createConfigAndRuleset(
            [
                self::FIXTURE_A,
                '--standard=PSR1',
            ]
        );

        Cache::load($ruleset, $config);
        Cache::set(self::FIXTURE_A, $this->sampleFileEntry());
        Cache::save();

        $created = $this->newCacheFilesIn($tempDir, $before);
        $this->createdFiles = array_merge($this->createdFiles, $created);

        $this->assertCount(1, $created);
        $this->assertDoubleHashCacheFileName($created[0]);
    }


    /**
     * When XDG_CACHE_HOME is not a directory, save() writes under the system temp directory.
     *
     * @return void
     */
    public function testSaveUsesSystemTempWhenXdgCacheHomeIsNotADirectory()
    {
        putenv('XDG_CACHE_HOME=' . sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'phpcs-xdg-missing-' . uniqid('', true));

        $tempDir = sys_get_temp_dir();
        $before  = glob($tempDir . DIRECTORY_SEPARATOR . 'phpcs.*.cache');
        if (is_array($before) === false) {
            $before = [];
        }

        list($config, $ruleset) = $this->createConfigAndRuleset(
            [
                self::FIXTURE_A,
                '--standard=PSR1',
            ]
        );

        Cache::load($ruleset, $config);
        Cache::set(self::FIXTURE_A, $this->sampleFileEntry());
        Cache::save();

        $created = $this->newCacheFilesIn($tempDir, $before);
        $this->createdFiles = array_merge($this->createdFiles, $created);

        $this->assertCount(1, $created);
        $this->assertDoubleHashCacheFileName($created[0]);
    }


    /**
     * Two files that share an ancestor produce a single cache file.
     *
     * @return void
     */
    public function testSaveUsesOneCacheFileForSharedAncestor()
    {
        $xdgDir = $this->createTestCacheDir();
        putenv('XDG_CACHE_HOME=' . $xdgDir);

        $before = glob($xdgDir . DIRECTORY_SEPARATOR . 'phpcs.*.cache');
        if (is_array($before) === false) {
            $before = [];
        }

        list($config, $ruleset) = $this->createConfigAndRuleset(
            [
                self::FIXTURE_A,
                self::FIXTURE_B,
                '--standard=PSR1',
            ]
        );

        Cache::load($ruleset, $config);
        Cache::set(self::FIXTURE_A, $this->sampleFileEntry());
        Cache::save();

        $created = $this->newCacheFilesIn($xdgDir, $before);
        $this->createdFiles = array_merge($this->createdFiles, $created);

        $this->assertCount(1, $created);
        $this->assertDoubleHashCacheFileName($created[0]);
    }


    /**
     * A second load() with the same inputs reuses the auto-path cache file.
     *
     * @return void
     */
    public function testLoadReusesExistingMatchingAutoPathCacheFile()
    {
        $xdgDir = $this->createTestCacheDir();
        putenv('XDG_CACHE_HOME=' . $xdgDir);

        $cliArgs = [
            self::FIXTURE_A,
            '--standard=PSR1',
        ];
        $payload = $this->sampleFileEntry();

        list($config, $ruleset) = $this->createConfigAndRuleset($cliArgs);

        Cache::load($ruleset, $config);
        Cache::set(self::FIXTURE_A, $payload);
        Cache::save();

        $afterFirst = glob($xdgDir . DIRECTORY_SEPARATOR . 'phpcs.*.cache');
        if (is_array($afterFirst) === false) {
            $afterFirst = [];
        }

        $this->createdFiles = array_merge($this->createdFiles, $afterFirst);
        $this->assertCount(1, $afterFirst);

        Cache::load($ruleset, $config);

        $this->assertSame($payload, Cache::get(self::FIXTURE_A));

        $afterSecond = glob($xdgDir . DIRECTORY_SEPARATOR . 'phpcs.*.cache');
        if (is_array($afterSecond) === false) {
            $afterSecond = [];
        }

        $this->assertSame($afterFirst, $afterSecond);
    }


    /**
     * An empty files list uses the fallback phpcs.{cacheHash}.cache name.
     *
     * @return void
     */
    public function testSaveUsesFallbackNameWhenFilesListIsEmpty()
    {
        $xdgDir = $this->createTestCacheDir();
        putenv('XDG_CACHE_HOME=' . $xdgDir);

        $before = glob($xdgDir . DIRECTORY_SEPARATOR . 'phpcs.*.cache');
        if (is_array($before) === false) {
            $before = [];
        }

        list($config, $ruleset) = $this->createConfigAndRuleset(
            [
                '--standard=PSR1',
            ]
        );

        $this->assertSame([], $config->files);

        Cache::load($ruleset, $config);
        Cache::set('marker', $this->sampleFileEntry());
        Cache::save();

        $created = $this->newCacheFilesIn($xdgDir, $before);
        $this->createdFiles = array_merge($this->createdFiles, $created);

        $this->assertCount(1, $created);
        $this->assertSingleHashCacheFileName($created[0]);
        $this->assertSame($this->sampleFileEntry(), Cache::get('marker'));
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


    /**
     * Create a unique directory under the system temp dir and track it for cleanup.
     *
     * @return string
     */
    private function createTestCacheDir()
    {
        $dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'phpcs-cache-xdg-' . uniqid('', true);
        $created = mkdir($dir, 0700);
        $this->assertTrue($created, 'Failed to create test cache directory: ' . $dir);
        $this->createdDirs[] = $dir;

        return $dir;
    }


    /**
     * Return phpcs.*.cache files in $dir that were not in $before.
     *
     * @param string        $dir    Directory to scan.
     * @param array<string> $before Absolute paths from a previous glob.
     *
     * @return array<string>
     */
    private function newCacheFilesIn($dir, array $before)
    {
        $after = glob($dir . DIRECTORY_SEPARATOR . 'phpcs.*.cache');
        if (is_array($after) === false) {
            $after = [];
        }

        return array_values(array_diff($after, $before));
    }


    /**
     * Assert a fallback cache file name: phpcs.{12 hex chars}.cache
     *
     * @param string $path Absolute path.
     *
     * @return void
     */
    private function assertSingleHashCacheFileName($path)
    {
        $this->assertMatchesRegularExpressionOrPreg(
            '/^phpcs\.[a-f0-9]{12}\.cache$/',
            basename($path),
            'Expected phpcs.{cacheHash}.cache, got ' . basename($path)
        );
    }


    /**
     * Assert a shared-location cache file name: phpcs.{12}.{12}.cache
     *
     * @param string $path Absolute path.
     *
     * @return void
     */
    private function assertDoubleHashCacheFileName($path)
    {
        $this->assertMatchesRegularExpressionOrPreg(
            '/^phpcs\.[a-f0-9]{12}\.[a-f0-9]{12}\.cache$/',
            basename($path),
            'Expected phpcs.{fileHash}.{cacheHash}.cache, got ' . basename($path)
        );
    }


    /**
     * Regex assertion compatible with PHPUnit 8 (assertRegExp) and 9+ (assertMatchesRegularExpression).
     *
     * @param string $pattern Regex.
     * @param string $string  Subject.
     * @param string $message Failure message.
     *
     * @return void
     */
    private function assertMatchesRegularExpressionOrPreg($pattern, $string, $message)
    {
        if (method_exists($this, 'assertMatchesRegularExpression') === true) {
            $this->assertMatchesRegularExpression($pattern, $string, $message);
        } else {
            $this->assertRegExp($pattern, $string, $message);
        }
    }

}
