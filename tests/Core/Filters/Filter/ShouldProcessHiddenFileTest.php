<?php
/**
 * Tests for the \PHP_CodeSniffer\Filters\Filter class.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Filters\Filter;

use PHP_CodeSniffer\Filters\Filter;
use PHP_CodeSniffer\Tests\Core\Filters\AbstractFilterTestCase;
use RecursiveArrayIterator;

/**
 * Tests handling of hidden files.
 *
 * @covers \PHP_CodeSniffer\Filters\Filter
 */
final class ShouldProcessHiddenFileTest extends AbstractFilterTestCase
{


    /**
     * Verify that if a hidden is explicitly requested for scan, it is accepted.
     *
     * @return void
     */
    public function testHiddenFileIsAcceptedWhenExplicitlyRequested()
    {
        $hiddenFile = self::getBaseDir() . '/.config.php';

        $fakeDI = new RecursiveArrayIterator([$hiddenFile]);
        $filter = new Filter($fakeDI, $hiddenFile, self::$config, self::$ruleset);

        $this->assertSame([$hiddenFile], $this->getFilteredResultsAsArray($filter));
    }


    /**
     * Verify that when (recursively) scanning a directory, hidden files are filtered out.
     *
     * @return void
     */
    public function testHiddenFileIsRejectedWhenRecursingDirectory()
    {
        $baseDir      = self::getBaseDir();
        $fakeFileList = [
            $baseDir . '/.config.php',
            $baseDir . '/autoload.php',
            $baseDir . '/scripts',
            $baseDir . '/scripts/.script-config.php',
        ];
        $fakeDI       = new RecursiveArrayIterator($fakeFileList);
        $filter       = new Filter($fakeDI, self::getBaseDir(), self::$config, self::$ruleset);

        $expectedOutput = [
            $baseDir . '/autoload.php',
            $baseDir . '/scripts',
        ];

        $this->assertSame($expectedOutput, $this->getFilteredResultsAsArray($filter));
    }
}
