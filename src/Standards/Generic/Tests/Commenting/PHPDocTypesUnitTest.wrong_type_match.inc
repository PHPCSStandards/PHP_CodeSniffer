<?php
/**
 * A collection of mismatched types for testing
 *
 * All type annotations give an error in both PHPStan and Psalm.
 * And all should give errors when checked with the PHPDoc types sniff with checkTypeMatch enabled.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

/**
 * A collection of mismatched types for testing
 */
class TypeMismatch
{

    /**
     * PHPDoc var type mismatch
     *
     * @var string
     */
    public int $varTypeMismatch;


    /**
     * PHPDoc function type mismatch
     *
     * @param string $p
     *
     * @return string
     */
    public function funTypeMismatch(int $p): int
    {
        return 0;

    }//end funTypeMismatch()


}//end class
