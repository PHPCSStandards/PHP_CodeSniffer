<?php
/**
 * Double of the filter class that will accept every file. Used in the FileList tests.
 *
 * @copyright 2025 PHPCSStandards Contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Files\FileList;

use PHP_CodeSniffer\Filters\Filter;
use ReturnTypeWillChange;

final class FilterDouble extends Filter
{


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
