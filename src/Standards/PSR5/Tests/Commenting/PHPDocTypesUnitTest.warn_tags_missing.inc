<?php
/**
 * A collection code with missing PHPDoc tags for testing
 *
 * This file should have no errors when checked with either PHPStan or Psalm.
 * But all should give warnings when checked with the PHPDoc types sniff with checkHasTags enabled.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

declare(strict_types=1);

/**
 * A collection code with missing PHPDoc tags for testing
 */
class TagsMissing
{

    /**
     * PHPDoc function parameter $p not documented and missing function @return tag
     */
    public function funMissingParamRet(int $p): int
    {
        return $p;

    }//end funMissingParamRet()

    /**
     * PHPDoc missing @var tag
     */
    public int $v2 = 0;

}//end class
