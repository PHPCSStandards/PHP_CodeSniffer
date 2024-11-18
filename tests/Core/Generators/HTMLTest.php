<?php
/**
 * Tests the HTML documentation generation.
 *
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Generators;

use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHP_CodeSniffer\Tests\Core\Generators\Fixtures\HTMLDouble;
use PHPUnit\Framework\TestCase;

/**
 * Test the HTML documentation generation.
 *
 * @covers \PHP_CodeSniffer\Generators\HTML
 * @group  Windows
 */
final class HTMLTest extends TestCase
{


    /**
     * Test the generated docs.
     *
     * @param string $standard       The standard to use for the test.
     * @param string $pathToExpected Path to a file containing the expected function output.
     *
     * @dataProvider dataDocs
     *
     * @return void
     */
    public function testDocs($standard, $pathToExpected)
    {
        // Set up the ruleset.
        $config  = new ConfigDouble(["--standard=$standard"]);
        $ruleset = new Ruleset($config);

        $expected = file_get_contents($pathToExpected);
        $this->assertNotFalse($expected, 'Output expectation file could not be found');

        // Make the test OS independent.
        $expected = str_replace("\n", PHP_EOL, $expected);
        $this->expectOutputString($expected);

        $generator = new HTMLDouble($ruleset);
        $generator->generate();

    }//end testDocs()


    /**
     * Data provider.
     *
     * @return array<string, array<string, string>>
     */
    public static function dataDocs()
    {
        return [
            'Standard without docs'            => [
                'standard'       => __DIR__.'/NoDocsTest.xml',
                'pathToExpected' => __DIR__.'/Expectations/ExpectedOutputEmpty.txt',
            ],
            'Standard with one doc file'       => [
                'standard'       => __DIR__.'/OneDocTest.xml',
                'pathToExpected' => __DIR__.'/Expectations/ExpectedOutputOneDoc.html',
            ],
            'Standard with multiple doc files' => [
                'standard'       => __DIR__.'/StructureDocsTest.xml',
                'pathToExpected' => __DIR__.'/Expectations/ExpectedOutputStructureDocs.html',
            ],
        ];

    }//end dataDocs()


    /**
     * Test the generated footer.
     *
     * @return void
     */
    public function testFooter()
    {
        // Set up the ruleset.
        $standard = __DIR__.'/OneDocTest.xml';
        $config   = new ConfigDouble(["--standard=$standard"]);
        $ruleset  = new Ruleset($config);

        $regex  = '`^  <div class="tag-line">';
        $regex .= 'Documentation generated on [A-Z][a-z]{2}, [0-9]{2} [A-Z][a-z]{2} 20[0-9]{2} [0-2][0-9](?::[0-5][0-9]){2} [+-][0-9]{4}';
        $regex .= ' by <a href="https://github\.com/PHPCSStandards/PHP_CodeSniffer">PHP_CodeSniffer [3-9]\.[0-9]+.[0-9]+</a>';
        $regex .= '</div>\R </body>\R</html>\R$`';
        $this->expectOutputRegex($regex);

        $generator = new HTMLDouble($ruleset);
        $generator->printRealFooter();

    }//end testFooter()


    /**
     * Safeguard that the footer logic doesn't permanently change the error level.
     *
     * @runInSeparateProcess
     * @preserveGlobalState  disabled
     *
     * @return void
     */
    public function testFooterResetsErrorReportingToOriginalSetting()
    {
        $expected = error_reporting();

        // Set up the ruleset.
        $standard = __DIR__.'/OneDocTest.xml';
        $config   = new ConfigDouble(["--standard=$standard"]);
        $ruleset  = new Ruleset($config);

        // We know there will be output, but we're not interested in the output for this test.
        ob_start();
        $generator = new HTMLDouble($ruleset);
        $generator->printRealFooter();
        ob_end_clean();

        $this->assertSame($expected, error_reporting());

    }//end testFooterResetsErrorReportingToOriginalSetting()


    /**
     * Safeguard that users won't see a PHP warning about the timezone not being set when calling date().
     *
     * The warning we don't want to see is:
     *   "date(): It is not safe to rely on the system's timezone settings. You are *required* to use
     *    the date.timezone setting or the date_default_timezone_set() function. In case you used any of
     *    those methods and you are still getting this warning, you most likely misspelled the timezone
     *    identifier. We selected the timezone 'UTC' for now, but please set date.timezone to select
     *    your timezone."
     *
     * JRF: Based on my tests, the warning only occurs on PHP < 7.0, but never a bad thing to safeguard this
     * on a wider range of PHP versions.
     *
     * Note: as of PHP 8.2, PHP no longer accepts an empty string as timezone and will use `UTC` instead,
     * so the warning on calling date() in the code itself would not display anyway.
     *
     * @requires PHP < 8.2
     *
     * @doesNotPerformAssertions
     *
     * @return void
     */
    public function testFooterDoesntThrowWarningOnMissingTimezone()
    {
        $originalIni = @ini_set('date.timezone', '');

        // Set up the ruleset.
        $standard = __DIR__.'/OneDocTest.xml';
        $config   = new ConfigDouble(["--standard=$standard"]);
        $ruleset  = new Ruleset($config);

        // We know there will be output, but we're not interested in the output for this test.
        ob_start();
        $generator = new HTMLDouble($ruleset);
        $generator->printRealFooter();
        ob_end_clean();

        // Reset the timezone to its original state.
        ini_set('date.timezone', $originalIni);

    }//end testFooterDoesntThrowWarningOnMissingTimezone()


}//end class
