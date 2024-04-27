<?php
/**
 * A function with mismatched pass by reference and splat for testing
 *
 * These needn't give errors when checked with PHPStan or Psalm.
 * But both should give errors when checked with the PHPDoc types sniff with checkPassSplat enabled.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

/**
 * A function with mismatched pass by reference and splat for testing
 */
class PassSplatMismatch
{


    /**
     * Function parameter issues
     *
     * @param integer ...$p1 PHPDoc function parameter pass by reference or splat mismatch
     * @param integer $p2    PHPDoc function parameter pass by reference or splat mismatch
     *
     * @return void
     */
    public function functionParameterIssues(int $p1, int &$p2): void
    {

    }//end functionParameterIssues()


}//end class
