<?php
/**
 * Base class for testing output sent to STDERR.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core;

use PHP_CodeSniffer\Tests\Core\StatusWriterTestHelper;
use PHPUnit\Framework\TestCase;

abstract class AbstractWriterTestCase extends TestCase
{
    use StatusWriterTestHelper;

}
