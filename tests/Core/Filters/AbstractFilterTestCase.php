<?php
/**
 * Tests for the \PHP_CodeSniffer\Filters\GitModified class.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2023 PHPCSStandards Contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Filters;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Filters\Filter;
use PHP_CodeSniffer\Ruleset;
use PHPUnit\Framework\TestCase;
use RecursiveIteratorIterator;

/**
 * Base functionality and utilities for testing Filter classes.
 */
abstract class AbstractFilterTestCase extends TestCase
{

    /**
     * The Config object.
     *
     * @var \PHP_CodeSniffer\Config
     */
    protected static $config;

    /**
     * The Ruleset object.
     *
     * @var \PHP_CodeSniffer\Ruleset
     */
    protected static $ruleset;


    /**
     * Initialize the config and ruleset objects.
     *
     * @beforeClass
     *
     * @return void
     */
    public static function initializeConfigAndRuleset()
    {
        self::$config  = new Config(['--standard=PSR1', '--report-width=80']);
        self::$ruleset = new Ruleset(self::$config);

    }//end initializeConfigAndRuleset()


    /**
     * Retrieve an array of files which were accepted by a filter.
     *
     * @param \PHP_CodeSniffer\Filters\Filter $filter The Filter object under test.
     *
     * @return array<string>
     */
    protected function getFilteredResultsAsArray(Filter $filter)
    {
        $iterator = new RecursiveIteratorIterator($filter);
        $files    = [];
        foreach ($iterator as $file) {
            $files[] = $file;
        }

        return $files;

    }//end getFilteredResultsAsArray()


    /**
     * Translate Linux paths to Windows paths, when necessary.
     *
     * These type of tests should be able to run and pass on both *nix as well as Windows
     * based dev systems. This method is a helper to allow for this.
     *
     * @param array<string|array> $paths A single or multi-dimensional array containing
     *                                   file paths.
     *
     * @return array<string|array>
     */
    protected static function mapPathsToRuntimeOs(array $paths)
    {
        if (DIRECTORY_SEPARATOR !== '\\') {
            return $paths;
        }

        foreach ($paths as $key => $value) {
            if (is_string($value) === true) {
                $paths[$key] = strtr($value, '/', '\\\\');
            } else if (is_array($value) === true) {
                $paths[$key] = self::mapPathsToRuntimeOs($value);
            }
        }

        return $paths;

    }//end mapPathsToRuntimeOs()


}//end class
