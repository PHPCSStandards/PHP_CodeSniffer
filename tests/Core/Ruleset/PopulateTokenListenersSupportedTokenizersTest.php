<?php
/**
 * Test the Ruleset::populateTokenListeners() method.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Ruleset;

use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHP_CodeSniffer\Tests\Core\Ruleset\AbstractRulesetTestCase;

/**
 * Test the Ruleset::populateTokenListeners() method shows a deprecation notice for sniffs supporting JS and/or CSS tokenizers.
 *
 * @covers \PHP_CodeSniffer\Ruleset::populateTokenListeners
 */
final class PopulateTokenListenersSupportedTokenizersTest extends AbstractRulesetTestCase
{


    /**
     * Verify that a deprecation notice is shown if a non-deprecated sniff supports the JS/CSS tokenizer(s).
     *
     * Additionally, this test verifies that:
     * - No deprecation notice is thrown if the complete sniff is deprecated.
     * - No deprecation notice is thrown when the sniff _also_ supports PHP.
     * - No deprecation notice is thrown when no tokenizers are supported (not sure why anyone would do that, but :shrug:).
     *
     * @return void
     */
    public function testDeprecatedTokenizersTriggerDeprecationNotice()
    {
        // Set up the ruleset.
        $standard = __DIR__.'/PopulateTokenListenersSupportedTokenizersTest.xml';
        $config   = new ConfigDouble(["--standard=$standard"]);

        // Using different expectations per OS as the order in which files are gathered differs per OS.
        if (stripos(PHP_OS, 'WIN') === 0) {
            $expected  = 'DEPRECATED: Scanning CSS/JS files is deprecated and support will be removed in PHP_CodeSniffer 4.0.'.PHP_EOL;
            $expected .= 'The TestStandard.SupportedTokenizers.ListensForCSSAndJS sniff is listening for CSS, JS.'.PHP_EOL;
            $expected .= 'DEPRECATED: Scanning CSS/JS files is deprecated and support will be removed in PHP_CodeSniffer 4.0.'.PHP_EOL;
            $expected .= 'The TestStandard.SupportedTokenizers.ListensForCSSAndUnrecognized sniff is listening for CSS, Unrecognized.'.PHP_EOL;
            $expected .= 'DEPRECATED: Scanning CSS/JS files is deprecated and support will be removed in PHP_CodeSniffer 4.0.'.PHP_EOL;
            $expected .= 'The TestStandard.SupportedTokenizers.ListensForCSS sniff is listening for CSS.'.PHP_EOL;
            $expected .= 'DEPRECATED: Scanning CSS/JS files is deprecated and support will be removed in PHP_CodeSniffer 4.0.'.PHP_EOL;
            $expected .= 'The TestStandard.SupportedTokenizers.ListensForJS sniff is listening for JS.'.PHP_EOL;
            $expected .= 'DEPRECATED: Support for custom tokenizers will be removed in PHP_CodeSniffer 4.0.'.PHP_EOL;
            $expected .= 'The TestStandard.SupportedTokenizers.ListensForUnrecognizedTokenizers sniff is listening for SCSS, TypeScript.'.PHP_EOL.PHP_EOL;
        } else {
            $expected  = 'DEPRECATED: Scanning CSS/JS files is deprecated and support will be removed in PHP_CodeSniffer 4.0.'.PHP_EOL;
            $expected .= 'The TestStandard.SupportedTokenizers.ListensForJS sniff is listening for JS.'.PHP_EOL;
            $expected .= 'DEPRECATED: Scanning CSS/JS files is deprecated and support will be removed in PHP_CodeSniffer 4.0.'.PHP_EOL;
            $expected .= 'The TestStandard.SupportedTokenizers.ListensForCSSAndJS sniff is listening for CSS, JS.'.PHP_EOL;
            $expected .= 'DEPRECATED: Scanning CSS/JS files is deprecated and support will be removed in PHP_CodeSniffer 4.0.'.PHP_EOL;
            $expected .= 'The TestStandard.SupportedTokenizers.ListensForCSSAndUnrecognized sniff is listening for CSS, Unrecognized.'.PHP_EOL;
            $expected .= 'DEPRECATED: Scanning CSS/JS files is deprecated and support will be removed in PHP_CodeSniffer 4.0.'.PHP_EOL;
            $expected .= 'The TestStandard.SupportedTokenizers.ListensForCSS sniff is listening for CSS.'.PHP_EOL;
            $expected .= 'DEPRECATED: Support for custom tokenizers will be removed in PHP_CodeSniffer 4.0.'.PHP_EOL;
            $expected .= 'The TestStandard.SupportedTokenizers.ListensForUnrecognizedTokenizers sniff is listening for SCSS, TypeScript.'.PHP_EOL.PHP_EOL;
        }//end if

        $this->expectOutputString($expected);

        new Ruleset($config);

    }//end testDeprecatedTokenizersTriggerDeprecationNotice()


}//end class
