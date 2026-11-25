<?php
/**
 * Tests for the \PHP_CodeSniffer\Reports\Full class.
 *
 * @author  Bartosz Dziewoński <dziewonski@fastmail.fm>
 * @license https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Reports;

use PHPUnit\Framework\TestCase;
use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Reports\Full;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Util\Common;

/**
 * Tests for the \PHP_CodeSniffer\Reports\Full class.
 *
 * @covers \PHP_CodeSniffer\Reports\Full
 */
final class FullTest extends TestCase
{


    /**
     * Test generating a full PHPCS report.
     *
     * @param string $reportData Prepared report data.
     * @param string $expected   Expected function output.
     *
     * @dataProvider dataGenerateFileReport
     *
     * @return void
     */
    public function testGenerateFileReport($reportData, $expected)
    {
        $reportClass = new Full();
        $config      = new Config();
        $phpcsFile   = new File('', new Ruleset($config), $config);

        ob_start();
        $result = $reportClass->generateFileReport(
            $reportData,
            $phpcsFile
        );
        $this->assertTrue($result);
        $generatedReport = ob_get_contents();
        ob_end_clean();

        // For readability of the output in the test data, omit color codes.
        // Their behavior is covered by their own unit tests.
        $generatedReport = Common::stripColors($generatedReport);

        $this->assertSame(
            str_replace("\n", PHP_EOL, trim($expected)),
            trim($generatedReport)
        );

    }//end testGenerateFileReport()


    /**
     * Data provider.
     *
     * @see testGenerateFileReport()
     *
     * @return array<string, array<string, mixed>>
     */
    public static function dataGenerateFileReport()
    {
        return [
            'Simple output' => [
                'reportData' => [
                    'filename' => 'simple.php',
                    'errors'   => 6,
                    'warnings' => 0,
                    'fixable'  => 4,
                    'messages' => [
                        1 => [
                            1 => [
                                0 => [
                                    'message'  => 'The PHP open tag does not have a corresponding PHP close tag',
                                    'source'   => 'Generic.PHP.ClosingPHPTag.NotFound',
                                    'severity' => 5,
                                    'fixable'  => false,
                                    'type'     => 'ERROR',
                                ],
                                1 => [
                                    'message'  => 'Missing required strict_types declaration',
                                    'source'   => 'Generic.PHP.RequireStrictTypes.MissingDeclaration',
                                    'severity' => 5,
                                    'fixable'  => false,
                                    'type'     => 'ERROR',
                                ],
                            ],
                        ],
                        3 => [
                            1 => [
                                0 => [
                                    'message'  => 'Tabs must be used to indent lines; spaces are not allowed',
                                    'source'   => 'Generic.WhiteSpace.DisallowSpaceIndent.SpacesUsed',
                                    'severity' => 5,
                                    'fixable'  => true,
                                    'type'     => 'ERROR',
                                ],
                            ],
                        ],
                        4 => [
                            1 => [
                                0 => [
                                    'message'  => 'Tabs must be used to indent lines; spaces are not allowed',
                                    'source'   => 'Generic.WhiteSpace.DisallowSpaceIndent.SpacesUsed',
                                    'severity' => 5,
                                    'fixable'  => true,
                                    'type'     => 'ERROR',
                                ],
                            ],
                        ],
                        5 => [
                            1 => [
                                0 => [
                                    'message'  => 'Spaces must be used to indent lines; tabs are not allowed',
                                    'source'   => 'Generic.WhiteSpace.DisallowTabIndent.TabsUsed',
                                    'severity' => 5,
                                    'fixable'  => true,
                                    'type'     => 'ERROR',
                                ],
                            ],
                            5 => [
                                0 => [
                                    'message'  => 'File must not end with a newline character',
                                    'source'   => 'Generic.Files.EndFileNoNewline.Found',
                                    'severity' => 5,
                                    'fixable'  => true,
                                    'type'     => 'ERROR',
                                ],
                            ],
                        ],
                    ],
                ],
                'expected'   => <<<EOF
FILE: simple.php
------------------------------------------------------------------------------
FOUND 6 ERRORS AFFECTING 4 LINES
------------------------------------------------------------------------------
 1 | ERROR | [ ] The PHP open tag does not have a corresponding PHP close tag
 1 | ERROR | [ ] Missing required strict_types declaration
 3 | ERROR | [x] Tabs must be used to indent lines; spaces are not allowed
 4 | ERROR | [x] Tabs must be used to indent lines; spaces are not allowed
 5 | ERROR | [x] Spaces must be used to indent lines; tabs are not allowed
 5 | ERROR | [x] File must not end with a newline character
------------------------------------------------------------------------------
PHPCBF CAN FIX THE 4 MARKED SNIFF VIOLATIONS AUTOMATICALLY
------------------------------------------------------------------------------
EOF
                ,
            ],
        ];

    }//end dataGenerateFileReport()


}//end class
