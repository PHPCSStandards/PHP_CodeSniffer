<?php
/**
 * Tests that handling of Internal errors in combination with sniff selection.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Files\File;

use PHP_CodeSniffer\Files\DummyFile;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Tests that handling of Internal errors in combination with sniff selection.
 *
 * @covers \PHP_CodeSniffer\Files\File::addMessage
 */
final class AddMessageSelectiveInternalHandlingTest extends TestCase
{


    /**
     * Verify that if an Internal code is silenced from the ruleset, it will stay silenced, independently of sniff selection.
     *
     * @param string $sniffs  Sniff selection.
     * @param string $exclude Sniff exclusions.
     *
     * @dataProvider dataSniffSelection
     *
     * @return void
     */
    public function testRulesetIgnoredInternalErrorIsIgnored($sniffs, $exclude)
    {
        $phpcsFile = $this->getPhpcsFile($sniffs, $exclude);

        $added = $phpcsFile->addError('No code found', 0, 'Internal.NoCodeFound');
        $this->assertFalse($added);
    }


    /**
     * Verify that if an Internal code is NOT silenced from the ruleset, sniff selection doesn't silence it.
     *
     * @param string $sniffs  Sniff selection.
     * @param string $exclude Sniff exclusions.
     *
     * @dataProvider dataSniffSelection
     *
     * @return void
     */
    public function testOtherInternalErrorIsNotIgnored($sniffs, $exclude)
    {
        $phpcsFile = $this->getPhpcsFile($sniffs, $exclude);

        $added = $phpcsFile->addError('Some other error', 0, 'Internal.SomeError');
        $this->assertTrue($added);
    }


    /**
     * Data provider.
     *
     * @see testA()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataSniffSelection()
    {
        return [
            'Ruleset only, no CLI selection'  => [
                'sniffs'  => '',
                'exclude' => '',
            ],
            'Ruleset + CLI sniffs selection'  => [
                'sniffs'  => 'Generic.Files.ByteOrderMark,Generic.PHP.DisallowShortOpenTag',
                'exclude' => '',
            ],
            'Ruleset + CLI exclude selection' => [
                'sniffs'  => '',
                'exclude' => 'Generic.Files.ByteOrderMark,Generic.PHP.DisallowShortOpenTag',
            ],
        ];
    }


    /**
     * Test Helper to get a File object for use in these tests.
     *
     * @param string $sniffs  Sniff selection.
     * @param string $exclude Sniff exclusions.
     *
     * @return \PHP_CodeSniffer\Files\DummyFile
     */
    private function getPhpcsFile($sniffs, $exclude)
    {
        // Set up the ruleset.
        $standard = __DIR__ . '/AddMessageSelectiveInternalHandlingTest.xml';
        $args     = ["--standard=$standard"];

        if (empty($sniffs) === false) {
            $args[] = "--sniffs=$sniffs";
        }

        if (empty($exclude) === false) {
            $args[] = "--exclude=$exclude";
        }

        $config  = new ConfigDouble($args);
        $ruleset = new Ruleset($config);

        $content   = '<?php ' . "\necho 'hello!';\n";
        $phpcsFile = new DummyFile($content, $ruleset, $config);
        $phpcsFile->parse();

        return $phpcsFile;
    }
}
