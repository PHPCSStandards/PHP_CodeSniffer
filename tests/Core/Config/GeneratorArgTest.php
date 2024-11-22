<?php
/**
 * Tests for the \PHP_CodeSniffer\Config --generator argument.
 *
 * @license https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
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
     * Ensure that the generator property is set when the parameter is passed.
     *
     * @param string $generatorName Generator name.
     *
     * @return       void
     * @dataProvider dataGeneratorNames
     */
    public function testGenerators($generatorName)
    {
        $config = new ConfigDouble(["--generator=$generatorName"]);

        $this->assertSame($generatorName, $config->generator);

    }//end testGenerators()


    /**
     * Data provider for testGenerators().
     *
     * @return array<int, array<string>>
     * @see    self::testGenerators()
     */
    public static function dataGeneratorNames()
    {
        return [
            ['Text'],
            ['HTML'],
            ['Markdown'],
        ];

    }//end dataGeneratorNames()


    /**
     * Ensure that only the first argument is processed and others are ignored.
     *
     * @return void
     */
    public function testOnlySetOnce()
    {
        $config = new ConfigDouble(
            [
                "--generator=Text",
                "--generator=HTML",
                "--generator=InvalidGenerator",
            ]
        );

        $this->assertSame('Text', $config->generator);

    }//end testOnlySetOnce()


}//end class
