<?php

/**
 * Class containing a simple style error that phpcbf cannot fix, and another that it can fix.
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\EndToEnd\Fixtures;

// The brace on the following line should be on a line by itself. This can be fixed with phpcbf.
class ClassWithTwoStyleErrors {
} // This comment does not belong here, according to PSR12. This cannot be fixed with phpcbf.
