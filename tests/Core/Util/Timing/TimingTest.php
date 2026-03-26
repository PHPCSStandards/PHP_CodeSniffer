<?php
/**
 * Tests for the \PHP_CodeSniffer\Util\Timing class.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\Timing;

use PHP_CodeSniffer\Tests\Core\StatusWriterTestHelper;
use PHP_CodeSniffer\Util\Timing;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the \PHP_CodeSniffer\Util\Timing class.
 *
 * {@internal These tests need to run in separate processes as the Timing class uses static properties
 * to keep track of the start time and whether or not the runtime has been printed and these
 * can't be unset/reset once set.}
 *
 * @covers \PHP_CodeSniffer\Util\Timing
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
final class TimingTest extends TestCase
{
    use StatusWriterTestHelper;


    /**
     * Verify that getDuration() returns 0 when the timer wasn't started.
     *
     * @return void
     */
    public function testGetDurationWithoutStartReturnsZero()
    {
        $this->assertSame(0, Timing::getDuration());
    }


    /**
     * Verify that getDuration() returns the time in milliseconds.
     *
     * @return void
     */
    public function testGetDurationWithStartReturnsMilliseconds()
    {
        Timing::startTiming();
        usleep(1500);
        $duration = Timing::getDuration();

        $this->assertIsFloat($duration);
    }


    /**
     * Verify that getDurationSince() returns the time in milliseconds.
     *
     * @return void
     */
    public function testGetDurationSinceReturnsMilliseconds()
    {
        $startTime = microtime(true);
        usleep(1500);
        $duration = Timing::getDurationSince($startTime);

        $this->assertIsFloat($duration);
    }


    /**
     * Verify that printRunTime() doesn't print anything if the timer wasn't started.
     *
     * @return void
     */
    public function testTimeIsNotPrintedIfTimerWasNeverStarted()
    {
        $this->expectNoStdoutOutput();

        Timing::printRunTime();

        $this->assertStderrOutputSameString('');
    }


    /**
     * Verify that printRunTime() doesn't print anything if the timer wasn't started.
     *
     * @return void
     */
    public function testTimeIsNotPrintedIfTimerWasNeverStartedEvenWhenForced()
    {
        $this->expectNoStdoutOutput();

        Timing::printRunTime(true);

        $this->assertStderrOutputSameString('');
    }


    /**
     * Verify that printRunTime() when called multiple times only prints the runtime information once.
     *
     * @return void
     */
    public function testTimeIsPrintedOnlyOnce()
    {
        $this->expectNoStdoutOutput();

        Timing::startTiming();
        usleep(2000);
        Timing::printRunTime();
        Timing::printRunTime();
        Timing::printRunTime();

        $regex = '`^Time: [0-9]+ms; Memory: [0-9\.]+MB' . PHP_EOL . '$`';
        $this->assertStderrOutputMatchesRegex($regex);
    }


    /**
     * Verify that printRunTime() when called multiple times prints the runtime information multiple times if forced.
     *
     * @return void
     */
    public function testTimeIsPrintedMultipleTimesOnlyIfForced()
    {
        $this->expectNoStdoutOutput();

        Timing::startTiming();
        usleep(2000);
        Timing::printRunTime(true);
        Timing::printRunTime(true);
        Timing::printRunTime(true);

        $regex = '`^(Time: [0-9]+ms; Memory: [0-9\.]+MB' . PHP_EOL . '){3}$`';
        $this->assertStderrOutputMatchesRegex($regex);
    }
}
