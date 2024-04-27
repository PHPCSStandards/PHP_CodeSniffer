<?php
/**
 * A collection of misplaced tags for testing
 *
 * These needn't give errors when checked with PHPStan or Psalm.
 * But all should give errors when checked with the PHPDoc types sniff with checkTagsNotMisplaced enabled.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

/**
 * A collection of misplaced tags for testing
 *
 * @param integer $param
 *
 * @return integer
 */
class TagsMisplaced
{

    /**
     * PHPDoc var misplaced tags
     *
     * @param integer $param
     *
     * @property integer $prop
     * @template T of integer
     * @return   integer
     */
    public int $var1MisplacedTags;


    /**
     * Function misplaced tags
     *
     * @property integer $prop
     * @var      integer $var
     */
    public function functionMisplacedTags(): void
    {

    }//end functionMisplacedTags()


}//end class

/**
 * PHPDoc var (not class var) misplaced tags
 *
 * @param integer $param
 *
 * @property integer $prop
 * @template T of integer
 * @return   integer
 */
$var2MisplacedTags = 0;
