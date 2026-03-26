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
 * Tests handling of files without extension.
 *
 * @covers \PHP_CodeSniffer\Filters\Filter
 */
final class ShouldProcessFileWithoutExtensionTest extends AbstractFilterTestCase
{


    /**
     * Verify that if a file without file extension is explicitly requested for scan, it is accepted.
     *
     * @return void
     */
    public function testFileWithoutExtensionIsAcceptedWhenExplicitlyRequested()
    {
        $fileWithoutExt = self::getBaseDir() . '/bin/phpcs';

        $fakeDI = new RecursiveArrayIterator([$fileWithoutExt]);
        $filter = new Filter($fakeDI, $fileWithoutExt, self::$config, self::$ruleset);

        $this->assertSame([$fileWithoutExt], $this->getFilteredResultsAsArray($filter));
    }


    /**
     * Verify that when (recursively) scanning a directory, files without extension are filtered out.
     *
     * @return void
     */
    public function testFileWithoutExtensionIsRejectedWhenRecursingDirectory()
    {
        $baseDir      = self::getBaseDir();
        $fakeFileList = [
            $baseDir . '/autoload.php',
            $baseDir . '/bin',
            $baseDir . '/bin/phpcs',
            $baseDir . '/scripts',
            $baseDir . '/scripts/build-phar.php',
        ];
        $fakeDI       = new RecursiveArrayIterator($fakeFileList);
        $filter       = new Filter($fakeDI, self::getBaseDir(), self::$config, self::$ruleset);

        $expectedOutput = [
            $baseDir . '/autoload.php',
            $baseDir . '/bin',
            $baseDir . '/scripts',
            $baseDir . '/scripts/build-phar.php',
        ];

        $this->assertSame($expectedOutput, $this->getFilteredResultsAsArray($filter));
    }
}
