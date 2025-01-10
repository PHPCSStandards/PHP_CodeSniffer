<?php
/**
 * Tests for the \PHP_CodeSniffer\Config --sniffs and --exclude arguments.
 *
 * @author  Dan Wallis <dan@wallis.nz>
 * @license https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Config;

use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the \PHP_CodeSniffer\Config --sniffs and --exclude arguments.
 *
 * @covers \PHP_CodeSniffer\Config::parseSniffCodes
 * @covers \PHP_CodeSniffer\Config::processLongArgument
 */
final class SniffsExcludeArgsTest extends TestCase
{


    /**
     * Ensure that the expected error message is returned for invalid arguments.
     *
     * @param string                $argument   'sniffs' or 'exclude'.
     * @param string                $value      List of sniffs to include / exclude.
     * @param array<string, string> $errors     Sniff code and associated help text.
     * @param string|null           $suggestion Help text shown to end user with correct syntax for argument.
     *
     * @return       void
     * @dataProvider dataInvalidSniffs
     */
    public function testInvalid($argument, $value, $errors, $suggestion)
    {
        $exception = 'PHP_CodeSniffer\Exceptions\DeepExitException';
        $message   = 'ERROR: The --'.$argument.' option only supports sniff codes.'.PHP_EOL;
        $message  .= 'Sniff codes are in the form "Standard.Category.Sniff"'.PHP_EOL;
        $message  .= PHP_EOL;
        $message  .= 'The following problems were detected:'.PHP_EOL;
        $message  .= '* '.implode(PHP_EOL.'* ', $errors).PHP_EOL;

        if ($suggestion !== null) {
            $message .= PHP_EOL;
            $message .= "Perhaps try --$argument=\"$suggestion\" instead.".PHP_EOL;
        }

        $message .= PHP_EOL;
        $message .= 'Run "phpcs --help" for usage information'.PHP_EOL;
        $message .= PHP_EOL;

        if (method_exists($this, 'expectException') === true) {
            // PHPUnit 5+.
            $this->expectException($exception);
            $this->expectExceptionMessage($message);
        } else {
            // PHPUnit 4.
            $this->setExpectedException($exception, $message);
        }

        new ConfigDouble(["--$argument=$value"]);

    }//end testInvalid()


    /**
     * Data provider for testInvalid().
     *
     * @see    self::testInvalid()
     * @return array<string, array<string, string>>
     */
    public static function dataInvalidSniffs()
    {
        $arguments = [
            'sniffs',
            'exclude',
        ];
        $data      = [];

        $messageTemplate = 'ERROR: The specified sniff code "%s" is invalid'.PHP_EOL;

        foreach ($arguments as $argument) {
            // A standard is not a valid sniff.
            $data[$argument.'; standard'] = [
                'argument'   => $argument,
                'value'      => 'Standard',
                'errors'     => [
                    'Standard codes are not supported: Standard',
                ],
                'suggestion' => null,
            ];

            // A category is not a valid sniff.
            $data[$argument.'; category'] = [
                'argument'   => $argument,
                'value'      => 'Standard.Category',
                'errors'     => [
                    'Category codes are not supported: Standard.Category',
                ],
                'suggestion' => null,
            ];

            // An error-code is not a valid sniff.
            $data[$argument.'; error-code'] = [
                'argument'   => $argument,
                'value'      => 'Standard.Category.Sniff.Code',
                'errors'     => [
                    'Message codes are not supported: Standard.Category.Sniff.Code',
                ],
                'suggestion' => 'Standard.Category.Sniff',
            ];

            // Too many dots.
            $data[$argument.'; too many dots'] = [
                'argument'   => $argument,
                'value'      => 'Standard.Category.Sniff.Code.Extra',
                'errors'     => [
                    'Too many parts: Standard.Category.Sniff.Code.Extra',
                ],
                'suggestion' => 'Standard.Category.Sniff',
            ];

            // All errors are reported in one go.
            $data[$argument.'; two errors'] = [
                'argument'   => $argument,
                'value'      => 'StandardOne,StandardTwo',
                'errors'     => [
                    'Standard codes are not supported: StandardOne',
                    'Standard codes are not supported: StandardTwo',
                ],
                'suggestion' => null,
            ];

            // Order of valid/invalid does not impact error reporting.
            $data[$argument.'; valid followed by invalid'] = [
                'argument'   => $argument,
                'value'      => 'StandardOne.Category.Sniff,StandardTwo.Category',
                'errors'     => [
                    'Category codes are not supported: StandardTwo.Category',
                ],
                'suggestion' => 'StandardOne.Category.Sniff',
            ];
            $data[$argument.'; invalid followed by valid'] = [
                'argument'   => $argument,
                'value'      => 'StandardOne.Category,StandardTwo.Category.Sniff',
                'errors'     => [
                    'Category codes are not supported: StandardOne.Category',
                ],
                'suggestion' => 'StandardTwo.Category.Sniff',
            ];
        }//end foreach

        return $data;

    }//end dataInvalidSniffs()


    /**
     * Ensure that the valid data does not throw an exception, and the value is stored.
     *
     * @param string   $argument 'sniffs' or 'exclude'.
     * @param string   $value    List of sniffs to include or exclude.
     * @param string[] $result   Expected sniffs to be set on the Config object.
     *
     * @return       void
     * @dataProvider dataValidSniffs
     */
    public function testValid($argument, $value, $result)
    {
        $config = new ConfigDouble(["--$argument=$value"]);

        $this->assertSame($result, $config->$argument);

    }//end testValid()


    /**
     * Data provider for testValid().
     *
     * @see    self::testValid()
     * @return array<string, array<string, string>>
     */
    public static function dataValidSniffs()
    {
        $arguments = [
            'sniffs',
            'exclude',
        ];
        $data      = [];

        foreach ($arguments as $argument) {
            $data[$argument.'; empty string']     = [
                'argument' => $argument,
                'value'    => '',
                'result'   => [],
            ];
            $data[$argument.'; one valid sniff']  = [
                'argument' => $argument,
                'value'    => 'Standard.Category.Sniff',
                'result'   => ['Standard.Category.Sniff'],
            ];
            $data[$argument.'; two valid sniffs'] = [
                'argument' => $argument,
                'value'    => 'StandardOne.Category.Sniff,StandardTwo.Category.Sniff',
                'result'   => [
                    'StandardOne.Category.Sniff',
                    'StandardTwo.Category.Sniff',
                ],
            ];

            // Rogue commas are quietly ignored.
            $data[$argument.'; one comma alone']  = [
                'argument' => $argument,
                'value'    => ',',
                'result'   => [],
            ];
            $data[$argument.'; two commas alone'] = [
                'argument' => $argument,
                'value'    => ',,',
                'result'   => [],
            ];
            $data[$argument.'; trailing comma']   = [
                'argument' => $argument,
                'value'    => 'Standard.Category.Sniff,',
                'result'   => ['Standard.Category.Sniff'],
            ];
            $data[$argument.'; double comma between sniffs'] = [
                'argument' => $argument,
                'value'    => 'StandardOne.Category.Sniff,,StandardTwo.Category.Sniff',
                'result'   => [
                    'StandardOne.Category.Sniff',
                    'StandardTwo.Category.Sniff',
                ],
            ];
        }//end foreach

        return $data;

    }//end dataValidSniffs()


    /**
     * Ensure that only the first argument is processed and others are ignored.
     *
     * @param string $argument 'sniffs' or 'exclude'.
     *
     * @return       void
     * @dataProvider dataOnlySetOnce
     */
    public function testOnlySetOnce($argument)
    {
        $config = new ConfigDouble(
            [
                "--$argument=StandardOne.Category.Sniff",
                "--$argument=StandardTwo.Category.Sniff",
                "--$argument=Standard.AnotherCategory.Sniff",
            ]
        );

        $this->assertSame(['StandardOne.Category.Sniff'], $config->$argument);

    }//end testOnlySetOnce()


    /**
     * Data provider for testOnlySetOnce().
     *
     * @return array<string, array<string>>
     */
    public static function dataOnlySetOnce()
    {
        return [
            'sniffs'  => ['sniffs'],
            'exclude' => ['exclude'],
        ];

    }//end dataOnlySetOnce()


}//end class
