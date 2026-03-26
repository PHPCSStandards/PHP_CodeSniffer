<?php
/**
 * Test the Ruleset::expandSniffDirectory() method.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Ruleset;

use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHP_CodeSniffer\Tests\Core\Ruleset\AbstractRulesetTestCase;

/**
 * Test handling of sniffs not following the PHPCS naming conventions in the Ruleset::populateTokenListeners() method.
 *
 * @covers \PHP_CodeSniffer\Ruleset::populateTokenListeners
 */
final class PopulateTokenListenersNamingConventionsTest extends AbstractRulesetTestCase
{


    /**
     * Verify a warning is shown for sniffs not complying with the PHPCS naming conventions.
     *
     * Including sniffs which do not comply with the PHPCS naming conventions is soft deprecated since
     * PHPCS 3.12.0, hard deprecated since PHPCS 3.13.0 and support has been removed in PHPCS 4.0.0.
     *
     * @return void
     */
    public function testBrokenNamingConventions()
    {
        $expectedMessage  = 'ERROR: The sniff BrokenNamingConventions\\Sniffs\\MissingCategoryDirSniff does not comply';
        $expectedMessage .= ' with the PHP_CodeSniffer naming conventions.' . PHP_EOL;
        $expectedMessage .= 'Contact the sniff author to fix the sniff.' . PHP_EOL;
        $expectedMessage .= 'ERROR: The sniff NoNamespaceSniff does not comply with the PHP_CodeSniffer naming conventions.' . PHP_EOL;
        $expectedMessage .= 'Contact the sniff author to fix the sniff.' . PHP_EOL;
        $expectedMessage .= 'ERROR: The sniff Sniffs\PartialNamespaceSniff does not comply with the PHP_CodeSniffer naming conventions.' . PHP_EOL;
        $expectedMessage .= 'Contact the sniff author to fix the sniff.' . PHP_EOL;
        $expectedMessage .= 'ERROR: The sniff BrokenNamingConventions\Sniffs\Category\Sniff does not comply';
        $expectedMessage .= ' with the PHP_CodeSniffer naming conventions.' . PHP_EOL;
        $expectedMessage .= 'Contact the sniff author to fix the sniff.' . PHP_EOL;
        $expectedMessage .= 'ERROR: The sniff BrokenNamingConventions\Sniffs\Sniffs\CategoryCalledSniffsSniff does not';
        $expectedMessage .= ' comply with the PHP_CodeSniffer naming conventions.' . PHP_EOL;
        $expectedMessage .= 'Contact the sniff author to fix the sniff.' . PHP_EOL;
        $expectedMessage .= 'ERROR: The sniff BrokenNamingConventions\Sniffs\Category\SubDir\TooDeeplyNestedSniff';
        $expectedMessage .= ' does not comply with the PHP_CodeSniffer naming conventions.' . PHP_EOL;
        $expectedMessage .= 'Contact the sniff author to fix the sniff.' . PHP_EOL . PHP_EOL;

        $this->expectRuntimeExceptionMessage($expectedMessage);

        // Set up the ruleset.
        $standard = __DIR__ . '/PopulateTokenListenersNamingConventionsTest.xml';
        $config   = new ConfigDouble(["--standard=$standard"]);
        $ruleset  = new Ruleset($config);

        // The "Generic.PHP.BacktickOperator" sniff is the only valid sniff.
        $expectedSniffCodes = [
            'Generic.PHP.BacktickOperator' => 'PHP_CodeSniffer\\Standards\\Generic\\Sniffs\\PHP\\BacktickOperatorSniff',
        ];

        // This assertion will only take effect for PHPUnit 10+.
        $this->assertSame($expectedSniffCodes, $ruleset->sniffCodes, 'Registered sniffs do not match expectation');
    }
}
