<?php
/**
 * Double of the filter class that will accept every file. Used in the FileList tests.
 *
 * @copyright 2019-2025 PHPCSStandards Contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Files\FileList;

use RecursiveFilterIterator;
use ReturnTypeWillChange;

class FilterDouble extends RecursiveFilterIterator
{


    /**
     * Constructs a filter.
     *
     * @param \RecursiveIterator $iterator The iterator we are using to get file paths.
     *
     * @return void
     */
    public function __construct($iterator)
    {
        parent::__construct($iterator);

    }//end __construct()


    /**
     * Accepts every file.
     *
     * @return true
     */
    #[ReturnTypeWillChange]
    public function accept()
    {
        return true;

    }//end accept()


}//end class
