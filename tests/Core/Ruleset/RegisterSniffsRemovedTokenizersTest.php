<?php
/**
 * Test the Ruleset::registerSniffs() method.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Ruleset;

use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHP_CodeSniffer\Tests\Core\Ruleset\AbstractRulesetTestCase;

/**
 * Test the Ruleset::registerSniffs() method shows a warning for sniffs expecting the removed JS and/or CSS tokenizers.
 *
 * @covers \PHP_CodeSniffer\Ruleset::registerSniffs
 */
final class RegisterSniffsRemovedTokenizersTest extends AbstractRulesetTestCase
{

    /**
     * The Config object.
     *
     * @var \PHP_CodeSniffer\Config
     */
    private static $config;


    /**
     * Initialize the config and ruleset objects for this test.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        // Set up the ruleset.
        $standard     = __DIR__ . '/RegisterSniffsRemovedTokenizersTest.xml';
        self::$config = new ConfigDouble(["--standard=$standard"]);
    }


    /**
     * Verify that an error is shown if a non-deprecated sniff supports the JS/CSS tokenizer(s).
     *
     * Additionally, this test verifies that:
     * - No error is thrown if the sniff is deprecated.
     * - No error is thrown when the sniff _also_ supports PHP.
     * - No error is thrown when no tokenizers are supported (not sure why anyone would do that, but :shrug:).
     *
     * {@internal The test uses a data provider to verify the messages as the _order_ of the messages depends
     * on the OS on which the tests are run (order in which files are retrieved), which makes the order within the
     * complete message too unpredictable to test in one go.}
     *
     * @param string $expected The expected message output in regex format.
     *
     * @dataProvider dataUnsupportedTokenizersTriggerError
     *
     * @return void
     */
    public function testUnsupportedTokenizersTriggerError($expected)
    {
        $this->expectRuntimeExceptionRegex($expected);

        new Ruleset(self::$config);
    }


    /**
     * Data provider.
     *
     * @see testUnsupportedTokenizersTriggerError()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataUnsupportedTokenizersTriggerError()
    {
        $message  = '`ERROR: Support for scanning files other than PHP, like CSS/JS files, has been removed in PHP_CodeSniffer 4\.0\.\R';
        $message .= 'The %1$s sniff is listening for %2$s\.\R`';

        return [
            'Listens for CSS'                            => [
                'expected' => sprintf($message, 'TestStandard.SupportedTokenizers.ListensForCSS', 'CSS'),
            ],
            'Listens for JS'                             => [
                'expected' => sprintf($message, 'TestStandard.SupportedTokenizers.ListensForJS', 'JS'),
            ],
            'Listens for both CSS and JS'                => [
                'expected' => sprintf($message, 'TestStandard.SupportedTokenizers.ListensForCSSAndJS', 'CSS, JS'),
            ],
            'Listens for CSS and something unrecognized' => [
                'expected' => sprintf($message, 'TestStandard.SupportedTokenizers.ListensForCSSAndUnrecognized', 'CSS, Unrecognized'),
            ],
            'Listens for only unrecognized tokenizers'   => [
                'expected' => sprintf($message, 'TestStandard.SupportedTokenizers.ListensForUnrecognizedTokenizers', 'SCSS, TypeScript'),
            ],
        ];
    }
}
