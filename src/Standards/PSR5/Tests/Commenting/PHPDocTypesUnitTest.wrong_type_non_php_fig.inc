<?php
/**
 * A collection of types not conforming to PHP-FIG PSR-5 for testing
 *
 * This file should have no errors when checked with either PHPStan or Psalm (but a warning about an unused var).
 * But all should give errors when checked with the PHPDoc types sniff with checkTypePhpFig enabled.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

/**
 * A collection of types not conforming to PHP-FIG PSR-5 for testing
 */
class NonPhpFig
{

    /**
     * Non-PHP-FIG compliant variable
     *
     * @var ?int
     */
    public ?int $v = 0;


    /**
     * Non-PHP-FIG compliant parameter and return
     *
     * @param ?int $p
     *
     * @return ?int
     */
    public function f(?int $p): ?int
    {
        return $p;

    }//end f()


}//end class

/**
 * Non-PHP-FIG compliant variable (not class variable)
 *
 * @var ?int
 */
$v2 = 0;
