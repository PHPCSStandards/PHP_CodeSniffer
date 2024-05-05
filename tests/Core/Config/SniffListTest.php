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
 * @covers \PHP_CodeSniffer\Config::processLongArgument
 */
final class SniffListTest extends TestCase
{


    /**
     * Ensure that the expected error message is returned for invalid arguments.
     *
     * @param string $argument 'sniffs' or 'exclude'.
     * @param string $value    List of sniffs to include / exclude.
     * @param string $message  Expected error message text.
     *
     * @return       void
     * @dataProvider dataInvalidSniffs
     */
    public function testInvalid($argument, $value, $message)
    {
        $config    = new ConfigDouble();
        $exception = 'PHP_CodeSniffer\Exceptions\DeepExitException';

        if (method_exists($this, 'expectException') === true) {
            // PHPUnit 5+.
            $this->expectException($exception);
            $this->expectExceptionMessage($message);
        } else {
            // PHPUnit 4.
            $this->setExpectedException($exception, $message);
        }

        $config->processLongArgument($argument.'='.$value, 0);

    }//end testInvalid()


    /**
     * Data provider for testInvalid().
     *
     * @see    self::testInvalid()
     * @return array
     */
    public static function dataInvalidSniffs()
    {
        $arguments = [
            'sniffs',
            'exclude',
        ];
        $data      = [];

        $messageTemplate = 'ERROR: The specified sniff code "%s" is invalid'.PHP_EOL.PHP_EOL;

        foreach ($arguments as $argument) {
            // A standard is not a valid sniff.
            $data[] = [
                'argument' => $argument,
                'value'    => 'Standard',
                'message'  => sprintf($messageTemplate, 'Standard'),
            ];

            // A category is not a valid sniff.
            $data[] = [
                'argument' => $argument,
                'value'    => 'Standard.Category',
                'message'  => sprintf($messageTemplate, 'Standard.Category'),
            ];

            // An error-code is not a valid sniff.
            $data[] = [
                'argument' => $argument,
                'value'    => 'Standard.Category',
                'message'  => sprintf($messageTemplate, 'Standard.Category'),
            ];

            // Only the first error is reported.
            $data[] = [
                'argument' => $argument,
                'value'    => 'StandardOne,StandardTwo',
                'message'  => sprintf($messageTemplate, 'StandardOne'),
            ];
            $data[] = [
                'argument' => $argument,
                'value'    => 'StandardOne.Category.Sniff,StandardTwo.Category',
                'message'  => sprintf($messageTemplate, 'StandardTwo.Category'),
            ];
        }//end foreach

        return $data;

    }//end dataInvalidSniffs()


    /**
     * Ensure that the valid data does not throw an exception.
     *
     * @param string $argument 'sniffs' or 'exclude'.
     * @param string $value    List of sniffs to include or exclude.
     *
     * @return       void
     * @dataProvider dataValidSniffs
     */
    public function testValid($argument, $value)
    {
        $config = new ConfigDouble();
        $config->processLongArgument($argument.'='.$value, 0);

    }//end testValid()


    /**
     * Data provider for testValid().
     *
     * @see    self::testValid()
     * @return array
     */
    public static function dataValidSniffs()
    {
        $arguments = [
            'sniffs',
            'exclude',
        ];
        $data      = [];

        foreach ($arguments as $argument) {
                $data[] = [
                    'argument' => $argument,
                    'value'    => 'Standard.Category.Sniff',
                ];
        }

        return $data;

    }//end dataValidSniffs()


}//end class
