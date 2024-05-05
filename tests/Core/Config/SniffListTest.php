<?php
/**
 * Tests for the \PHP_CodeSniffer\Config --sniffs and --exclude arguments.
 *
 * @author  Dan Wallis <dan@wallis.nz>
 * @license https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Config;

use PHPUnit\Framework\TestCase;
use PHP_CodeSniffer\Tests\ConfigDouble;

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

        $sniffs = [];

        $types = [
            'Standard',
            'Standard.Category',
            'Standard.Category.Sniff.Code',
        ];
        foreach ($types as $value) {
            $sniffs[$value] = $value;
            $sniffs['Standard.Category.Sniff,B'.$value] = 'B'.$value;
            foreach ($types as $extra) {
                $sniffs['A'.$value.',B'.$extra] = 'A'.$value;
            }
        }

        $messageTemplate = 'ERROR: The specified sniff code "%s" is invalid'.PHP_EOL.PHP_EOL;
        foreach ($arguments as $argument) {
            foreach ($sniffs as $input => $output) {
                $data[] = [
                    'argument' => $argument,
                    'value'    => $input,
                    'message'  => sprintf($messageTemplate, $output),
                ];
            }
        }

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
