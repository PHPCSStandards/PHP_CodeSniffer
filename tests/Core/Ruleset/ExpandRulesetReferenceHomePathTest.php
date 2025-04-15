<?php
/**
 * Test the Ruleset::expandRulesetReference() method.
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
 * Test home path handling in the Ruleset::expandRulesetReference() method.
 *
 * @covers \PHP_CodeSniffer\Ruleset::expandRulesetReference
 */
final class ExpandRulesetReferenceHomePathTest extends AbstractRulesetTestCase
{

    /**
     * Original value of the user's home path environment variable.
     *
     * @var string|false Path or false is the `HOME` environment variable is not available.
     */
    private static $homepath = false;


    /**
     * Store the user's home path.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        self::$homepath = getenv('HOME');

    }//end setUpBeforeClass()


    /**
     * Restore the user's home path environment variable in case the test changed it or created it.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        if (is_string(self::$homepath) === true) {
            putenv('HOME='.self::$homepath);
        } else {
            // Remove the environment variable as it didn't exist before.
            putenv('HOME');
        }

    }//end tearDownAfterClass()


    /**
     * Set the home path to an alternative location.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $fakeHomePath = __DIR__.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'FakeHomePath';
        putenv("HOME=$fakeHomePath");

    }//end setUp()


    /**
     * Verify that a sniff reference with the magic "home path" placeholder gets expanded correctly
     * and finds sniffs if the path exists underneath the "home path".
     *
     * @return void
     */
    public function testHomePathRefGetsExpandedAndFindsSniff()
    {
        // Set up the ruleset.
        $standard = __DIR__.'/ExpandRulesetReferenceHomePathTest.xml';
        $config   = new ConfigDouble(["--standard=$standard"]);
        $ruleset  = new Ruleset($config);

        $expected = ['MyStandard.Category.Valid' => 'FakeHomePath\\MyStandard\\Sniffs\\Category\\ValidSniff'];

        $this->assertSame($expected, $ruleset->sniffCodes);

    }//end testHomePathRefGetsExpandedAndFindsSniff()


    /**
     * Verify that a sniff reference with the magic "home path" placeholder gets expanded correctly
     * and still fails to find sniffs if the path doesn't exists underneath the "home path".
     *
     * @return void
     */
    public function testHomePathRefGetsExpandedAndThrowsExceptionWhenPathIsInvalid()
    {
        // Set up the ruleset.
        $standard = __DIR__.'/ExpandRulesetReferenceHomePathFailTest.xml';
        $config   = new ConfigDouble(["--standard=$standard"]);

        $exceptionMessage  = 'ERROR: Referenced sniff "~/src/MyStandard/Sniffs/DoesntExist/" does not exist.'.PHP_EOL;
        $exceptionMessage .= 'ERROR: No sniffs were registered.'.PHP_EOL.PHP_EOL;
        $this->expectRuntimeExceptionMessage($exceptionMessage);

        new Ruleset($config);

    }//end testHomePathRefGetsExpandedAndThrowsExceptionWhenPathIsInvalid()


}//end class
