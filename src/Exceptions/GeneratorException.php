<?php
/**
 * An exception thrown by PHP_CodeSniffer when it encounters an error in the XML document being processed
 * by one of the documentation Generators.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Exceptions;

use DomainException;

class GeneratorException extends DomainException
{

}
