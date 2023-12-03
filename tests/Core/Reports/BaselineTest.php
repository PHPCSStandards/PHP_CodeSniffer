<?php
/**
 * Tests for the Baseline report file
 *
 * @author    Frank Dekker <fdekker@123inkt.nl>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Reports;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Reports\Baseline;
use PHP_CodeSniffer\Util;
use PHPUnit\Framework\TestCase;

/**
 * Testcases for the baseline report output file
 *
 * @coversDefaultClass \PHP_CodeSniffer\Reports\Baseline
 */
class BaselineTest extends TestCase
{


    /**
     * Test that generation is skipped when there are no errors
     *
     * @covers ::generateFileReport
     * @return void
     */
    public function testGenerateFileReportEmptyShouldReturnFalse()
    {
        $report = new Baseline();
        static::assertFalse($report->generateFileReport(['errors' => 0, 'warnings' => 0], new MockFile([])));

    }//end testGenerateFileReportEmptyShouldReturnFalse()


    /**
     * Test the generation of a single error message
     *
     * @covers ::generateFileReport
     * @return void
     */
    public function testGenerateFileReportShouldPrintReport()
    {
        $reportData = [
            'filename' => '/test/foobar.txt',
            'errors'   => 1,
            'warnings' => 0,
            'messages' => [5 => [[['source' => 'MySniff']]]],
        ];

        $tokens    = [
            [
                'content' => 'foobar',
                'line'    => 5,
            ],
        ];
        $signature = Util\CodeSignature::createSignature($tokens, 5);

        $file = new MockFile($tokens);

        $report = new Baseline();
        ob_start();
        static::assertTrue($report->generateFileReport($reportData, $file));
        $result = ob_get_clean();
        static::assertSame('<violation file="/test/foobar.txt" sniff="MySniff" signature="'.$signature.'"/>'.PHP_EOL, $result);

    }//end testGenerateFileReportShouldPrintReport()


    /**
     * Test the generation of the complete file
     *
     * @covers ::generate
     * @return void
     */
    public function testGenerate()
    {
        $expected  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".PHP_EOL;
        $expected .= "<phpcs-baseline version=\"".Config::VERSION."\">";
        $expected .= "<violation file=\"/test/foobar.txt\" sniff=\"MySniff\"/>".PHP_EOL;
        $expected .= "</phpcs-baseline>".PHP_EOL;

        $report = new Baseline();
        ob_start();
        $report->generate('<violation file="/test/foobar.txt" sniff="MySniff"/>', 1, 1, 0, 1);
        $result = ob_get_clean();
        static::assertSame($expected, $result);

    }//end testGenerate()


}//end class
