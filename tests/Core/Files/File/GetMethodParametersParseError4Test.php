<?php
/**
 * Tests for the \PHP_CodeSniffer\Files\File::getMethodParameters method.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Files\File;

use PHP_CodeSniffer\Tests\Core\AbstractMethodTestCase;

/**
 * Tests for the \PHP_CodeSniffer\Files\File::getMethodParameters method.
 *
 * @covers \PHP_CodeSniffer\Files\File::getMethodParameters
 */
final class GetMethodParametersParseError4Test extends AbstractMethodTestCase
{


    /**
     * Test receiving an empty array when encountering a specific parse error.
     *
     * @return void
     */
    public function testParseError()
    {
        $target = $this->getTargetToken('/* testParseError */', [T_USE]);
        $result = self::$phpcsFile->getMethodParameters($target);

        $this->assertSame([], $result);
    }
}
