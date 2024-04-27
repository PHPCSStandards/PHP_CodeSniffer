<?php
/**
 * Check PHPDoc Types for PHP-FIG PSR-5.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

namespace PHP_CodeSniffer\Standards\PSR5\Sniffs\Commenting;

use PHP_CodeSniffer\Standards\Generic\Sniffs\Commenting\PHPDocTypesSniff as SniffBase;

/**
 * Check PHPDoc Types for PHP-FIG PSR-5.
 */
class PHPDocTypesSniff extends SniffBase
{

    /**
     * Check named classes and functions, and class variables and constants are documented.
     *
     * @var boolean
     */
    public $checkHasDocBlocks = true;

    /**
     * Check doc blocks, if present, contain appropriate type tags.
     *
     * @var boolean
     */
    public $checkHasTags = true;

    /**
     * Check there are no misplaced type tags--doesn't check for misplaced var tags.
     *
     * @var boolean
     */
    public $checkTagsNotMisplaced = true;

    /**
     * Check PHPDoc types and native types match--isn't aware of class heirarchies from other files, or global constants.
     *
     * @var boolean
     */
    public $checkTypeMatch = true;

    /**
     * Check built-in types are lower case, and short forms are used.
     *
     * @var boolean
     */
    public $checkTypeStyle = true;

    /**
     * Check the types used conform to the PHP-FIG PSR-5 standard.
     *
     * @var boolean
     */
    public $checkTypePhpFig = true;

    /**
     * Check pass by reference and splat usage matches for param tags.
     *
     * @var boolean
     */
    public $checkPassSplat = true;

}//end class
