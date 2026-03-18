<?php
/**
 * Tests for the handling of properties being set via the ruleset.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Ruleset;

use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHP_CodeSniffer\Tests\Core\Ruleset\AbstractRulesetTestCase;

/**
 * Test the handling of an array property value using the PHPCS < 4.0 format set via the ruleset.
 *
 * @covers \PHP_CodeSniffer\Ruleset::setSniffProperty
 */
final class PropertyTypeHandlingOldArrayFormatTest extends AbstractRulesetTestCase
{


    /**
     * Verify an error is thrown when an array property is set from the ruleset using a comma-separated string.
     *
     * Support for this format was (soft) deprecated in PHPCS 3.3.0 and removed in PHPCS 4.0.0.
     *
     * @return void
     */
    public function testUsingOldSchoolArrayFormatThrowsError()
    {
        $regex  = '`^(';
        $regex .= 'ERROR: Passing an array of values to a property using a comma-separated string\R';
        $regex .= 'is no longer supported since PHP_CodeSniffer 4\.0\.0\.\R';
        $regex .= 'The unsupported syntax was used for property "expectsOldSchool(?:EmptyArray|ArrayWith(?:Extended|Only)?(?:KeysAnd)?Values)"\R';
        $regex .= 'for sniff "';
        $regex .= '(?:\./tests/Core/Ruleset/Fixtures/TestStandard/Sniffs/SetProperty/PropertyTypeHandlingOldArrayFormatSniff\.php|TestStandard\.SetProperty\.PropertyTypeHandlingOldArrayFormat)';
        $regex .= '"\.\R';
        $regex .= 'Pass array values via <element \[key="\.\.\." \]value="\.\.\."> nodes instead\.\R';
        $regex .= '){14}\R$`';

        $this->expectRuntimeExceptionRegex($regex);

        // Set up the ruleset.
        $standard = __DIR__ . '/PropertyTypeHandlingOldArrayFormatTest.xml';
        $config   = new ConfigDouble(["--standard=$standard"]);
        new Ruleset($config);
    }
}
