<?php
/**
 * Helper methods for testing output sent to STDERR.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core;

use PHP_CodeSniffer\Util\Writers\StatusWriter;
use ReflectionProperty;

trait StatusWriterTestHelper
{

    /**
     * Stream to capture the output.
     *
     * @var resource
     */
    private $stream;


    /**
     * Redirect the StatusWriter output from STDERR to memory.
     *
     * If the setUp() method is overloaded, call the redirectStatusWriterOutputToStream() method from your own setUp().
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->redirectStatusWriterOutputToStream();
    }


    /**
     * Reset all static properties on the StatusWriter class.
     *
     * If the tearDown() method is overloaded, call the resetStatusWriterProperties() method from your own tearDown().
     *
     * @return void
     */
    protected function tearDown(): void
    {
        $this->resetStatusWriterProperties();
    }


    /**
     * Redirect the output from STDERR to memory.
     *
     * This method should typically be called from within the setUp() method of the test using this trait.
     *
     * @return void
     */
    protected function redirectStatusWriterOutputToStream(): void
    {
        $stream = fopen('php://memory', 'rw');

        if ($stream === false) {
            return;
        }

        $this->stream = $stream;

        $streamProperty = new ReflectionProperty(StatusWriter::class, 'stream');
        (PHP_VERSION_ID < 80100) && $streamProperty->setAccessible(true);
        $streamProperty->setValue(null, $this->stream);
        (PHP_VERSION_ID < 80100) && $streamProperty->setAccessible(false);
    }


    /**
     * Reset static property.
     *
     * This method should typically be called from within the tearDown() method of the test using this trait.
     *
     * @return void
     */
    protected function resetStatusWriterStream(): void
    {
        // Reset the static property to its default.
        $streamProperty = new ReflectionProperty(StatusWriter::class, 'stream');
        (PHP_VERSION_ID < 80100) && $streamProperty->setAccessible(true);
        $streamProperty->setValue(null, STDERR);
        (PHP_VERSION_ID < 80100) && $streamProperty->setAccessible(false);
    }


    /**
     * Reset all static properties on the StatusWriter class.
     *
     * @return void
     */
    protected function resetStatusWriterProperties(): void
    {
        while (StatusWriter::isPaused() === true) {
            StatusWriter::resume();
        }

        $this->resetStatusWriterStream();
    }


    /**
     * Assert that no output was sent to STDOUT.
     *
     * @return void
     */
    public function expectNoStdoutOutput()
    {
        $this->expectOutputString('');
    }


    /**
     * Verify output sent to STDERR is the same as expected output.
     *
     * @param string $expected The expected STDERR output.
     *
     * @return void
     */
    public function assertStderrOutputSameString($expected)
    {
        fseek($this->stream, 0);
        $output = stream_get_contents($this->stream);

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }


    /**
     * Verify output sent to STDERR complies with an expected regex pattern.
     *
     * @param string $regex The regular expression to use to verify the STDERR output complies with expectations.
     *
     * @return void
     */
    public function assertStderrOutputMatchesRegex($regex)
    {
        fseek($this->stream, 0);
        $output = stream_get_contents($this->stream);

        $this->assertIsString($output);

        if (method_exists($this, 'assertMatchesRegularExpression') === true) {
            $this->assertMatchesRegularExpression($regex, $output);
        } else {
            // PHPUnit < 9.1.0.
            $this->assertRegExp($regex, $output);
        }
    }
}
