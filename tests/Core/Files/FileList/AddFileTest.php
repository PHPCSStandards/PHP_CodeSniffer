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
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;

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
     * @before
     *
     * @return void
     */
    protected function initializeFileList()
    {
        self::$config->files = [];
        $this->fileList      = new FileList(self::$config, self::$ruleset);

    }//end initializeFileList()


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
    public function testAddFile($fileName, $fileObject=null)
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
                'PHP_CodeSniffer\Files\File',
                $fileListArray[$fileName],
                'File object not found in list'
            );
        }

    }//end testAddFile()


    /**
     * Data provider for testAddFile.
     *
     * @return array<string, array<string, string|object>>
     */
    public static function dataAddFile()
    {
        self::initializeConfigAndRuleset();

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

    }//end dataAddFile()


}//end class
