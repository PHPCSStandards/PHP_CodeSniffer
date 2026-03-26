<?php
/**
 * Tests for the \PHP_CodeSniffer\Util\Writers\StatusWriter class.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\Writers;

use PHP_CodeSniffer\Tests\Core\AbstractWriterTestCase;
use PHP_CodeSniffer\Util\Writers\StatusWriter;

/**
 * Tests for the \PHP_CodeSniffer\Util\Writers\StatusWriter class.
 *
 * @covers PHP_CodeSniffer\Util\Writers\StatusWriter
 */
final class StatusWriterTest extends AbstractWriterTestCase
{


    /**
     * Verify output created by the StatusWriter gets sent to stdErr using the default parameter settings.
     *
     * @param string $message  The message to print.
     * @param string $expected Expected output.
     *
     * @dataProvider dataStatusSentToStdErr
     *
     * @return void
     */
    public function testStatusSentToStdErr($message, $expected)
    {
        $this->expectNoStdoutOutput();

        StatusWriter::write($message);

        $this->assertStderrOutputSameString($expected);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|int>>
     */
    public static function dataStatusSentToStdErr()
    {
        return [
            'Default settings'              => [
                'message'  => 'This message should end up in stdErr with no tab indent and 1 new line',
                'expected' => 'This message should end up in stdErr with no tab indent and 1 new line' . PHP_EOL,
            ],
            'empty message prints new line' => [
                'message'  => '',
                'expected' => PHP_EOL,
            ],
        ];
    }


    /**
     * Perfunctory test to verify that the $indent and $newlines parameters are handled correctly.
     *
     * @param string $message  The message to print.
     * @param int    $indent   Indent setting to use for this test.
     * @param int    $newlines New lines setting to use for this test.
     * @param string $expected Expected output.
     *
     * @dataProvider dataStatusSentToStdErrIndentNewlines
     *
     * @return void
     */
    public function testStatusSentToStdErrIndentNewlines($message, $indent, $newlines, $expected)
    {
        $this->expectNoStdoutOutput();

        StatusWriter::write($message, $indent, $newlines);

        $this->assertStderrOutputSameString($expected);
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string, string|int>>
     */
    public static function dataStatusSentToStdErrIndentNewlines()
    {
        return [
            'Default settings'                                         => [
                'message'  => 'This message should end up in stdErr with no tab indent and 1 new line',
                'indent'   => 0,
                'newlines' => 1,
                'expected' => 'This message should end up in stdErr with no tab indent and 1 new line' . PHP_EOL,
            ],
            'no indent, suppress new line'                             => [
                'message'  => 'This message should end up in stdErr with no tab indent and no new line',
                'indent'   => 0,
                'newlines' => 0,
                'expected' => 'This message should end up in stdErr with no tab indent and no new line',
            ],
            '1 indent, default new line'                               => [
                'message'  => 'This message should end up in stdErr with one tab indent and 1 new line',
                'indent'   => 1,
                'newlines' => 1,
                'expected' => "\tThis message should end up in stdErr with one tab indent and 1 new line" . PHP_EOL,
            ],
            '2 indents, suppress new line'                             => [
                'message'  => 'This message should end up in stdErr with two tab indent and no new line',
                'indent'   => 2,
                'newlines' => 0,
                'expected' => "\t\tThis message should end up in stdErr with two tab indent and no new line",
            ],
            '1 indent, double new line'                                => [
                'message'  => 'This message should end up in stdErr with one tab indent and 2 new lines',
                'indent'   => 1,
                'newlines' => 2,
                'expected' => "\tThis message should end up in stdErr with one tab indent and 2 new lines" . PHP_EOL . PHP_EOL,
            ],
            'negative number of indents, negative number of new lines' => [
                'message'  => 'This message should end up in stdErr with no tab indent and no new line',
                'indent'   => -10,
                'newlines' => -2,
                'expected' => 'This message should end up in stdErr with no tab indent and no new line',
            ],
        ];
    }


    /**
     * Verify pausing the StatusWriter prevents output from being sent to stdErr.
     *
     * @return void
     */
    public function testStatusDoesNotGetPrintedWhenPaused()
    {
        $this->expectNoStdoutOutput();

        $message = 'This message should not be printed when the StatusWriter is paused';

        $this->assertFalse(StatusWriter::isPaused());

        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($message);

        $this->assertStderrOutputSameString('');
    }


    /**
     * Verify that output sent while paused is not sent to StdErr, while output sent once the StatusWriter
     * is resumed, does get sent to StdErr.
     *
     * @return void
     */
    public function testStatusDoesGetPrintedWhenPausedAndResumed()
    {
        $this->expectNoStdoutOutput();

        $message = 'This message should not be printed when the StatusWriter is paused';

        $this->assertFalse(StatusWriter::isPaused());

        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($message);

        StatusWriter::resume();
        $this->assertFalse(StatusWriter::isPaused());

        $message  = 'Once the StatusWriter is resumed, messages should be printed again';
        $expected = $message . PHP_EOL;
        StatusWriter::write($message);

        $this->assertStderrOutputSameString($expected);
    }


    /**
     * Verify that forceWrite() ignores whether the StatusWriter is paused.
     *
     * @return void
     */
    public function testStatusDoesGetForcePrintedWhenPaused()
    {
        $this->expectNoStdoutOutput();

        $message  = 'This message should still be force printed when the StatusWriter is paused';
        $expected = $message . PHP_EOL;

        $this->assertFalse(StatusWriter::isPaused());

        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::forceWrite($message);

        $this->assertStderrOutputSameString($expected);
    }


    /**
     * Verify that forceWrite() ignores whether the StatusWriter is paused and resumed.
     *
     * @return void
     */
    public function testStatusDoesGetForcePrintedWhenPausedAndResumed()
    {
        $this->expectNoStdoutOutput();

        $messageA = 'This message should still be force printed when the StatusWriter is paused';
        $expected = $messageA . PHP_EOL;

        $messageB = 'This message should NOT be printed when the StatusWriter is paused';

        $this->assertFalse(StatusWriter::isPaused());

        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::forceWrite($messageA);
        StatusWriter::write($messageB);

        StatusWriter::resume();
        $this->assertFalse(StatusWriter::isPaused());

        $messageC  = 'Once the StatusWriter is resumed, messages should be printed again';
        $expected .= $messageC . PHP_EOL . $messageC . PHP_EOL;

        StatusWriter::write($messageC);
        StatusWriter::forceWrite($messageC);

        $this->assertStderrOutputSameString($expected);
    }


    /**
     * Verify sending new lines to StdErr.
     *
     * @return void
     */
    public function testWriteNewline()
    {
        $this->expectNoStdoutOutput();

        $this->assertFalse(StatusWriter::isPaused());

        // Print new line.
        StatusWriter::writeNewline();

        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        // As the StatusWriter is paused, only the force printed new line should print, the other one should be ignored.
        StatusWriter::writeNewline();
        StatusWriter::forceWriteNewline();

        $this->assertStderrOutputSameString(PHP_EOL . PHP_EOL);
    }


    /**
     * Verify that the StatusWriter only resumes when all previous "pause" calls are rescinded.
     *
     * @return void
     */
    public function testNestedPausing()
    {
        $this->expectNoStdoutOutput();

        $message = 'This message should not be printed when the StatusWriter is paused';

        $this->assertFalse(StatusWriter::isPaused());

        // Pause 1.
        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($message);

        // Pause 2.
        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($message);

        // Pause 3.
        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($message);

        // Resume 3.
        StatusWriter::resume();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($message);

        // Resume 2.
        StatusWriter::resume();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($message);

        // Resume 1.
        StatusWriter::resume();
        $this->assertFalse(StatusWriter::isPaused());

        $message  = 'Once the StatusWriter is resumed, messages should be printed again';
        $expected = $message . PHP_EOL;
        StatusWriter::write($message);

        $this->assertStderrOutputSameString($expected);
    }


    /**
     * Verify that resuming more often than the StatusWriter is paused, won't block future pauses.
     *
     * @return void
     */
    public function testResumingMoreOftenThanPaused()
    {
        $this->expectNoStdoutOutput();

        $messageA = 'This message should not be printed when the StatusWriter is paused';
        $messageB = 'Once the StatusWriter is resumed, messages should be printed again';
        $expected = $messageB . PHP_EOL . $messageB . PHP_EOL;

        $this->assertFalse(StatusWriter::isPaused());

        // Pause 1.
        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($messageA);

        // Pause 2.
        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($messageA);

        // Resume 2.
        StatusWriter::resume();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($messageA);

        // Resume 1.
        StatusWriter::resume();
        $this->assertFalse(StatusWriter::isPaused());

        StatusWriter::write($messageB);

        // Resume too much - this resume should not change the pause counter.
        StatusWriter::resume();
        $this->assertFalse(StatusWriter::isPaused());

        StatusWriter::write($messageB);

        // Pause after "resume too much", still pauses the StatusWriter.
        StatusWriter::pause();
        $this->assertTrue(StatusWriter::isPaused());

        StatusWriter::write($messageA);

        $this->assertStderrOutputSameString($expected);
    }
}
