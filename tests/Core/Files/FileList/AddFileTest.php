<?php
/**
 * Tests for the \PHP_CodeSniffer\Files\FileList::addFile method.
 *
 * @copyright 2025 PHPCSStandards Contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Files\FileList;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Files\FileList;

/**
 * Tests for the \PHP_CodeSniffer\Files\FileList::addFile method.
 *
 * @covers \PHP_CodeSniffer\Files\FileList::addFile
 */
final class AddFileTest extends AbstractFileListTestCase
{

    /**
     * The FileList object.
     *
     * @var \PHP_CodeSniffer\Files\FileList
     */
    private $fileList;


    /**
     * Initialize the FileList object.
     *
     * @return void
     */
    protected function setUp(): void
    {
        self::$config->files = [];
        $this->fileList      = new FileList(self::$config, self::$ruleset);

    }


    /**
     * Test adding a file to the list.
     *
     * @param string      $fileName   The name of the file to add.
     * @param object|null $fileObject An optional file object to add instead of creating a new one.
     *
     * @dataProvider dataAddFile
     *
     * @return void
     */
    public function testAddFile($fileName, $fileObject = null)
    {
        $this->assertCount(0, $this->fileList);

        $this->fileList->addFile($fileName, $fileObject);

        $fileListArray = iterator_to_array($this->fileList);

        $this->assertCount(1, $this->fileList, 'File count mismatch');
        $this->assertArrayHasKey($fileName, $fileListArray, 'File not found in list');

        if (isset($fileObject) === true) {
            $this->assertSame($fileObject, $fileListArray[$fileName], 'File object mismatch');
        } else {
            $this->assertInstanceOf(
                File::class,
                $fileListArray[$fileName],
                'File object not found in list'
            );
        }

    }


    /**
     * Data provider for testAddFile.
     *
     * @return array<string, array<string, string|object>>
     */
    public static function dataAddFile()
    {
        self::setUpBeforeClass();

        return [
            'Regular file'                  => [
                'fileName' => 'test1.php',
            ],
            'STDIN'                         => [
                'fileName' => 'STDIN',
            ],
            'Regular file with file object' => [
                'fileName'   => 'test1.php',
                'fileObject' => new File('test1.php', self::$ruleset, self::$config),
            ],
        ];

    }


    /**
     * Test that it is not possible to add the same file twice.
     *
     * @return void
     */
    public function testAddFileShouldNotAddTheSameFileTwice()
    {
        $file1         = 'test1.php';
        $file2         = 'test2.php';
        $expectedFiles = [
            $file1,
            $file2,
        ];

        // Add $file1 once.
        $this->fileList->addFile($file1);
        $this->assertCount(1, $this->fileList);
        $this->assertSame([$file1], array_keys(iterator_to_array($this->fileList)));

        // Try to add $file1 again. Should be ignored.
        $this->fileList->addFile($file1);
        $this->assertCount(1, $this->fileList);
        $this->assertSame([$file1], array_keys(iterator_to_array($this->fileList)));

        // Add $file2. Should be added.
        $this->fileList->addFile($file2);
        $this->assertCount(2, $this->fileList);
        $this->assertSame($expectedFiles, array_keys(iterator_to_array($this->fileList)));

    }


}
