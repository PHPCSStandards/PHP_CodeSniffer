<?php
/**
 * An abstract filter class for checking files and folders against exact matches.
 *
 * Supports both allowed files and blocked files.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Filters;

use PHP_CodeSniffer\Util;

abstract class ExactMatch extends Filter
{

    /**
     * A list of files to exclude.
     *
     * @var array
     */
    private $blockedFiles = null;

    /**
     * A list of files to include.
     *
     * If the allowed files list is empty, only files in the blocked files list will be excluded.
     *
     * @var array
     */
    private $allowedFiles = null;


    /**
     * Check whether the current element of the iterator is acceptable.
     *
     * If a file is both blocked and allowed, it will be deemed unacceptable.
     *
     * @return bool
     */
    public function accept()
    {
        if (parent::accept() === false) {
            return false;
        }

        if ($this->blockedFiles === null) {
            $this->blockedFiles = $this->getBlockedFiles();

            // BC-layer.
            if ($this->blockedFiles === null) {
                $this->blockedFiles = $this->getBlacklist();
            }
        }

        if ($this->allowedFiles === null) {
            $this->allowedFiles = $this->getAllowedFiles();

            // BC-layer.
            if ($this->allowedFiles === null) {
                $this->allowedFiles = $this->getWhitelist();
            }
        }

        $filePath = Util\Common::realpath($this->current());

        // If file is both blocked and allowed, the blocked files list takes precedence.
        if (isset($this->blockedFiles[$filePath]) === true) {
            return false;
        }

        if (empty($this->allowedFiles) === true && empty($this->blockedFiles) === false) {
            // We are only checking a blocked files list, so everything else should be allowed.
            return true;
        }

        return isset($this->allowedFiles[$filePath]);

    }//end accept()


    /**
     * Returns an iterator for the current entry.
     *
     * Ensures that the blocked files list and the allowed files list are preserved so they don't have
     * to be generated each time.
     *
     * @return \RecursiveIterator
     */
    public function getChildren()
    {
        $children = parent::getChildren();
        $children->blockedFiles = $this->blockedFiles;
        $children->allowedFiles = $this->allowedFiles;
        return $children;

    }//end getChildren()


    /**
     * Get a list of file paths to exclude.
     *
     * @deprecated 3.9.0 Overload the `getBlockedFiles()` method instead.
     *                   The `getBlockedFiles()` method will be made abstract and therefore required
     *                   in v4.0 and this method will be removed.
     *                   If both methods are implemented, the new `getBlockedFiles()` method will take precedence.
     *
     * @return array
     */
    abstract protected function getBlacklist();


    /**
     * Get a list of file paths to include.
     *
     * @deprecated 3.9.0 Overload the `getAllowedFiles()` method instead.
     *                   The `getAllowedFiles()` method will be made abstract and therefore required
     *                   in v4.0 and this method will be removed.
     *                   If both methods are implemented, the new `getAllowedFiles()` method will take precedence.
     *
     * @return array
     */
    abstract protected function getWhitelist();


    /**
     * Get a list of file paths to exclude.
     *
     * @since 3.9.0 Replaces the deprecated `getBlacklist()` method.
     *
     * @return array|null
     */
    protected function getBlockedFiles()
    {
        return null;

    }//end getBlockedFiles()


    /**
     * Get a list of file paths to include.
     *
     * @since 3.9.0 Replaces the deprecated `getWhitelist()` method.
     *
     * @return array|null
     */
    protected function getAllowedFiles()
    {
        return null;

    }//end getAllowedFiles()


}//end class
