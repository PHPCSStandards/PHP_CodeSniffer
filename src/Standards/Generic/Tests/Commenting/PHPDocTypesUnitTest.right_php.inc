<?php
/**
 * A collection of valid PHP for testing
 *
 * This file should have no errors when checked with either PHPStan or Psalm (but a warning about an unused var).
 * And no errors when checked with the PHPDoc types sniff, regardless of setting.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

namespace PHP_CodeSniffer\Standards\Generic\Tests\Commenting;

use stdClass as myStdClass, Exception;
use PHP_CodeSniffer\Standards\Generic\Tests\Commenting\ {PHPDocTypesUnitTest};

?>
<?php

/**
 * A parent class
 */
class PhpValidParent
{
}//end class

/**
 * An interface
 */
interface PhpValidInterface
{
}//end interface

/**
 * A trait
 */
trait PhpValidTrait
{
}

/**
 * A collection of valid PHP for testing
 */
class PhpValid extends PhpValidParent implements PhpValidInterface
{
    use PhpValidTrait;

    /**
     * Multiline type
     *
     * @var integer
     *      | boolean
     */
    public int|bool $v2 = 0;


    /**
     * Namespaces recognised
     *
     * @param \PHP_CodeSniffer\Standards\Generic\Tests\Commenting\PhpValid $x
     *
     * @return void
     */
    public function namespaces(PhpValid $x): void
    {

    }//end namespaces()


    /**
     * Uses recognised
     *
     * @param \stdClass $x
     *
     * @return void
     */
    public function uses(myStdClass $x): void
    {

    }//end uses()


    /**
     * Parents recognised
     *
     * @param PhpValid $x
     *
     * @return void
     */
    public function parents(PhpValidParent $x): void
    {

    }//end parents()


    /**
     * Interfaces recognised
     *
     * @param PhpValid $x
     *
     * @return void
     */
    public function interfaces(PhpValidInterface $x): void
    {

    }//end interfaces()


    /**
     * Function templates recognised
     *
     * @param T2 $x
     *
     * @template T2 of int
     * @return   void
     */
    public function functionTemplates(int $x): void
    {

    }//end functionTemplates()


}//end class

/**
 * Another valid class
 *
 * @template T of int
 */
class PhpValid2
{


    /**
     * Class templates recognised
     *
     * @param T $x
     *
     * @return void
     */
    public function classTemplates(int $x): void
    {

    }//end classTemplates()


}//end class

// Ignore things that don't concern us.
$x = 0;
