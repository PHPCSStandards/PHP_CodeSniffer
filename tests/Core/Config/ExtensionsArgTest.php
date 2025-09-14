<?php
/**
 * Tests for the \PHP_CodeSniffer\Config --extensions argument.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Config;

use PHP_CodeSniffer\Exceptions\DeepExitException;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the \PHP_CodeSniffer\Config --extensions argument.
 *
 * @covers \PHP_CodeSniffer\Config::processLongArgument
 */
final class ExtensionsArgTest extends TestCase
{


    /**
     * Ensure that the extension property is set when the parameter is passed a valid value.
     *
     * @param string $passedValue Extensions as passed on the command line.
     * @param string $expected    Expected value for the extensions property.
     *
     * @dataProvider dataValidExtensions
     *
     * @return void
     */
    public function testValidExtensions($passedValue, $expected)
    {
        $config = new ConfigDouble(["--extensions=$passedValue"]);

        $this->assertSame($expected, $config->extensions);
    }


    /**
     * Data provider.
     *
     * @see self::testValidExtensions()
     *
     * @return array<string, array<string, string|array<string, string>>>
     */
    public static function dataValidExtensions()
    {
        return [
            // Passing an empty extensions list is not useful, as it will result in no files being scanned,
            // but that's the responsibility of the user.
            'Empty extensions list'                                                          => [
                'passedValue' => '',
                'expected'    => [],
            ],
            'Single extension passed: php'                                                   => [
                'passedValue' => 'php',
                'expected'    => [
                    'php' => 'PHP',
                ],
            ],
            // This would cause PHPCS to scan python files as PHP, which will probably cause very weird scan results,
            // but that's the responsibility of the user.
            'Single extension passed: py'                                                    => [
                'passedValue' => 'py',
                'expected'    => [
                    'py' => 'PHP',
                ],
            ],
            'Multiple extensions passed: php,js,css'                                         => [
                'passedValue' => 'php,js,css',
                'expected'    => [
                    'php' => 'PHP',
                    'js'  => 'PHP',
                    'css' => 'PHP',
                ],
            ],
            // While setting the language is no longer supported, we are being tolerant to the language
            // being set to PHP as that doesn't break anything.
            'Multiple extensions passed, some with language PHP: php,inc/php,phpt/php,js'    => [
                'passedValue' => 'php,inc/php,phpt/php,js',
                'expected'    => [
                    'php'  => 'PHP',
                    'inc'  => 'PHP',
                    'phpt' => 'PHP',
                    'js'   => 'PHP',
                ],
            ],
            'File extensions are set case sensitively (and filtering is case sensitive too)' => [
                'passedValue' => 'PHP,php',
                'expected'    => [
                    'PHP' => 'PHP',
                    'php' => 'PHP',
                ],
            ],
        ];
    }


    /**
     * Ensure that only the first argument is processed and others are ignored.
     *
     * @return void
     */
    public function testOnlySetOnce()
    {
        $config = new ConfigDouble(
            [
                '--extensions=php',
                '--extensions=inc,module',
            ]
        );

        $this->assertSame(['php' => 'PHP'], $config->extensions);
    }


    /**
     * Ensure that an exception is thrown for an invalid extension.
     *
     * @param string $passedValue Extensions as passed on the command line.
     *
     * @dataProvider dataInvalidExtensions
     *
     * @return void
     */
    public function testInvalidExtensions($passedValue)
    {
        $message  = 'ERROR: Specifying the tokenizer to use for an extension is no longer supported.' . PHP_EOL;
        $message .= 'PHP_CodeSniffer >= 4.0 only supports scanning PHP files.' . PHP_EOL;
        $message .= 'Received: ' . $passedValue . PHP_EOL . PHP_EOL;

        $this->expectException(DeepExitException::class);
        $this->expectExceptionMessage($message);

        new ConfigDouble(["--extensions={$passedValue}"]);
    }


    /**
     * Data provider.
     *
     * @see self::testInvalidExtensions()
     *
     * @return array<string, array<string, string>>
     */
    public static function dataInvalidExtensions()
    {
        return [
            'Single extension passed with language: py/py'                             => [
                'passedValue' => 'py/py',
            ],
            'Multiple extensions passed, all setting non-PHP language: ts/js,less/css' => [
                'passedValue' => 'ts/js,less/css',
            ],
            'Multiple extensions passed, some with non-PHP language: js/js,phpt/php'   => [
                'passedValue' => 'php,js/js,phpt/php',
            ],
        ];
    }
}
