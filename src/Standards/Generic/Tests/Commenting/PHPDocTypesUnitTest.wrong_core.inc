<?php
/**
 * A collection of invalid code for testing
 *
 * All type annotations should give an error in one of PHPStan or Psalm, except wrong param order.
 * And all should give errors or warnings when checked with the PHPDoc types sniff, regardless of settings.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

/**
 * A collection of invalid code for testing
 *
 * @property int< PHPDoc class property type missing or malformed
 * @property int  PHPDoc class property name missing or malformed
 */
class CoreErrors
{

    /**
     * PHPDoc var type missing or malformed
     *
     * @var @
     */
    public int $varTypeMalformed;


    /**
     * Function parameter issues
     *
     * @param int< $p1 PHPDoc function parameter type missing or malformed
     * @param int      PHPDoc function parameter name missing or malformed
     * @param int  $p4 PHPDoc function parameter order wrong
     * @param int  $p3
     * @param int  $p3 PHPDoc function parameter repeated
     * @param int  $p5 PHPDoc function parameter doesn't exist
     *
     * @return void
     */
    public function functionParameterIssues(int $p1, int $p2, int $p3, int $p4): void
    {

    }//end functionParameterIssues()


    /**
     * PHPDoc multiple function @return tags--Put in one tag, seperated by vertical bars |
     *
     * @return int
     * @return null
     */
    public function multipleReturns(): ?int
    {
        return 0;

    }//end multipleReturns()


    /**
     * PHPDoc function return type missing or malformed
     *
     * @return
     */
    public function returnMalformed(): void
    {

    }//end returnMalformed()


    /**
     * Template issues
     *
     * @template @      PHPDoc template name missing or malformed
     * @template T of @ PHPDoc template type missing or malformed
     * @return   void
     */
    public function templateIssues(): void
    {

    }//end templateIssues()


}//end class

/**
 * PHPDoc var type missing or malformed (not class var)
 *
 * @var @
 */
$varTypeMalformed2 = 0;
