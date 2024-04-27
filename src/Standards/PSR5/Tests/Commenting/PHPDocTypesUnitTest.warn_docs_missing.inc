<?php
/**
 * A collection code with missing PHPDoc blocks for testing
 *
 * This file should have no errors when checked with either PHPStan or Psalm.
 * But all should give warnings when checked with the PHPDoc types sniff with checkHasDocBlocks enabled.
 *
 * @author    James Calder <jeg+accounts.github@cloudy.kiwi.nz>
 * @copyright 2024 Otago Polytechnic
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 *            CC BY-SA 4.0 or later
 */

declare(strict_types=1);

// PHPDoc class is not documented.
class DocsMissing
{

    // PHPDoc function is not documented.
    public function funNotDoc(int $p): void
    {

    }//end funNotDoc()

    // PHPDoc variable or constant is not documented.
    public int $v1 = 0;

}//end class
