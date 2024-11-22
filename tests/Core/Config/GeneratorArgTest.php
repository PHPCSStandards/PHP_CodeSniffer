<?php
/**
 * Tests for the \PHP_CodeSniffer\Config --generator argument.
 *
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Config;

use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the \PHP_CodeSniffer\Config --generator argument.
 *
 * @covers \PHP_CodeSniffer\Config::processLongArgument
 */
final class GeneratorArgTest extends TestCase
{


    /**
     * Ensure that the generator property is set when the parameter is passed a valid value.
     *
     * @param string $generatorName Generator name.
     *
     * @dataProvider dataValidGeneratorNames
     *
     * @return void
     */
    public function testValidGenerators($generatorName)
    {
        $config = new ConfigDouble(["--generator=$generatorName"]);

        $this->assertSame($generatorName, $config->generator);

    }//end testValidGenerators()


    /**
     * Data provider for testValidGenerators().
     *
     * @see self::testValidGenerators()
     *
     * @return array<int, array<string>>
     */
    public static function dataValidGeneratorNames()
    {
        return [
            ['Text'],
            ['HTML'],
            ['Markdown'],
        ];

    }//end dataValidGeneratorNames()


    /**
     * Ensure that only the first argument is processed and others are ignored.
     *
     * @return void
     */
    public function testOnlySetOnce()
    {
        $config = new ConfigDouble(
            [
                '--generator=Text',
                '--generator=HTML',
                '--generator=InvalidGenerator',
            ]
        );

        $this->assertSame('Text', $config->generator);

    }//end testOnlySetOnce()


    /**
     * Ensure that an exception is thrown for an invalid generator.
     *
     * @param string $generatorName Generator name.
     *
     * @dataProvider dataInvalidGeneratorNames
     *
     * @return void
     */
    public function testInvalidGenerator($generatorName)
    {
        $exception = 'PHP_CodeSniffer\Exceptions\DeepExitException';
        $message   = 'ERROR: "'.$generatorName.'" is not a valid generator. Valid options are: Text, HTML, and Markdown.';

        if (method_exists($this, 'expectException') === true) {
            // PHPUnit 5+.
            $this->expectException($exception);
            $this->expectExceptionMessage($message);
        } else {
            // PHPUnit 4.
            $this->setExpectedException($exception, $message);
        }

        new ConfigDouble(["--generator={$generatorName}"]);

    }//end testInvalidGenerator()


    /**
     * Data provider for testInvalidGenerator().
     *
     * @see self::testInvalidGenerator()
     *
     * @return array<int, array<string>>
     */
    public static function dataInvalidGeneratorNames()
    {
        return [
            ['InvalidGenerator'],
            ['Text,HTML'],
            ['TEXT'],
            [''],
        ];

    }//end dataInvalidGeneratorNames()


}//end class
