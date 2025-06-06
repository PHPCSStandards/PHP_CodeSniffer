<?php
/**
 * Tests for the \PHP_CodeSniffer\Filters\Filter::accept method.
 *
 * @author    Willington Vega <wvega@wvega.com>
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2019 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Filters\Filter;

use PHP_CodeSniffer\Filters\Filter;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHP_CodeSniffer\Tests\Core\Filters\AbstractFilterTestCase;
use RecursiveArrayIterator;

/**
 * Tests for the \PHP_CodeSniffer\Filters\Filter::accept method.
 *
 * @covers \PHP_CodeSniffer\Filters\Filter
 * @group  Windows
 */
final class AcceptTest extends AbstractFilterTestCase
{


    /**
     * Initialize the config and ruleset objects based on the `AcceptTest.xml` ruleset file.
     *
     * @beforeClass
     *
     * @return void
     */
    public static function initializeConfigAndRuleset()
    {
        $standard      = __DIR__.'/'.basename(__FILE__, '.php').'.xml';
        self::$config  = new ConfigDouble(["--standard=$standard", '--ignore=*/somethingelse/*']);
        self::$ruleset = new Ruleset(self::$config);

    }//end initializeConfigAndRuleset()


    /**
     * Test filtering a file list for excluded paths.
     *
     * @param array<string> $inputPaths     List of file paths to be filtered.
     * @param array<string> $expectedOutput Expected filtering result.
     * @param bool          $localFiles     Value of the Config class "local" setting (default: false).
     *
     * @dataProvider dataExcludePatterns
     *
     * @return void
     */
    public function testExcludePatterns($inputPaths, $expectedOutput, $localFiles=false)
    {
        $fakeDI = new RecursiveArrayIterator($inputPaths);
        $filter = new Filter($fakeDI, '/', self::$config, self::$ruleset);

        self::$config->local = false;

        if ($localFiles === true) {
            self::$config->local = true;
        }

        $this->assertSame($expectedOutput, $this->getFilteredResultsAsArray($filter));

    }//end testExcludePatterns()


    /**
     * Data provider.
     *
     * @see testExcludePatterns
     *
     * @return array<string, array<string, array<string>>>
     */
    public static function dataExcludePatterns()
    {
        $testCases = [
            // Test top-level exclude patterns.
            'Non-sniff specific path based excludes from ruleset and command line are respected and don\'t filter out too much' => [
                'inputPaths'     => [
                    '/path/to/src/Main.php',
                    '/path/to/src/Something/Main.php',
                    '/path/to/src/Somethingelse/Main.php',
                    '/path/to/src/SomethingelseEvenLonger/Main.php',
                    '/path/to/src/Other/Main.php',
                ],
                'expectedOutput' => [
                    '/path/to/src/Main.php',
                    '/path/to/src/SomethingelseEvenLonger/Main.php',
                ],
            ],

            // Test ignoring standard/sniff specific exclude patterns.
            'Filter should not act on standard/sniff specific exclude patterns'                                                 => [
                'inputPaths'     => [
                    '/path/to/src/generic-project/Main.php',
                    '/path/to/src/generic/Main.php',
                    '/path/to/src/anything-generic/Main.php',
                ],
                'expectedOutput' => [
                    '/path/to/src/generic-project/Main.php',
                    '/path/to/src/generic/Main.php',
                    '/path/to/src/anything-generic/Main.php',
                ],
            ],
            'Filter should exclude files without an extension, using unsupported extension and starting with a dot'             => [
                'inputPaths'     => [
                    '/path/to/src/Main.php',
                    '/path/to/src/.hiddenfile',
                    '/path/to/src/NoExtension',
                    '/path/to/src/UnsupportedExtension.txt',
                    '/path/to/src/UnsupportedExtension.php.bak',
                ],
                'expectedOutput' => [
                    '/path/to/src/Main.php',
                ],
            ],
            'Filter should ignore duplicate files'                                                                              => [
                'inputPaths'     => [
                    __FILE__,
                    __FILE__,
                    '/path/to/src/Main.php',
                ],
                'expectedOutput' => [
                    __FILE__,
                    '/path/to/src/Main.php',
                ],
            ],
            'Filter should work for relative exclude patterns'                                                                  => [
                'inputPaths'     => [
                    'src/Main.php',
                    'src/AnotherDir/File.php',
                ],
                'expectedOutput' => [
                    'src/Main.php',
                ],
            ],

            // Uses real directories to test code that calls is_dir().
            'Filter should handle directories'                                                                                  => [
                'inputPaths'     => [
                    self::getBaseDir().'/src/Generators',
                    self::getBaseDir().'/src/Standards',
                ],
                'expectedOutput' => [
                    self::getBaseDir().'/src/Standards',
                ],
            ],
            'Filter should ignore directories when --local is used'                                                             => [
                'inputPaths'     => [
                    'src/Main.php',
                    self::getBaseDir().'/src/Generators',
                    self::getBaseDir().'/src/Standards',
                ],
                'expectedOutput' => [
                    'src/Main.php',
                ],
                'localFiles'     => true,
            ],
        ];

        // Allow these tests to work on Windows as well.
        return self::mapPathsToRuntimeOs($testCases);

    }//end dataExcludePatterns()


}//end class
