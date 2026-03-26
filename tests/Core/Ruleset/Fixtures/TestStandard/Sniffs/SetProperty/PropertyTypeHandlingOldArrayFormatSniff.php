<?php
/**
 * Test fixture.
 *
 * @see \PHP_CodeSniffer\Tests\Core\Ruleset\PropertyTypeHandlingOldArrayFormatTest
 */

namespace Fixtures\TestStandard\Sniffs\SetProperty;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class PropertyTypeHandlingOldArrayFormatSniff implements Sniff
{

    /**
     * Used to verify that array properties passed as a string is no longer supported since PHPCS 4.0.0.
     *
     * @var array<mixed>
     */
    public $expectsOldSchoolArrayWithOnlyValues;

    /**
     * Used to verify that array properties passed as a string is no longer supported since PHPCS 4.0.0.
     *
     * @var array<string, mixed>
     */
    public $expectsOldSchoolArrayWithKeysAndValues;

    /**
     * Used to verify that array properties passed as a string is no longer supported since PHPCS 4.0.0.
     *
     * @var array<string, mixed>
     */
    public $expectsOldSchoolArrayWithExtendedValues;

    /**
     * Used to verify that array properties passed as a string is no longer supported since PHPCS 4.0.0.
     *
     * @var array<string, mixed>
     */
    public $expectsOldSchoolArrayWithExtendedKeysAndValues;

    /**
     * Used to verify that array properties passed as a string is no longer supported since PHPCS 4.0.0.
     *
     * @var array<mixed>
     */
    public $expectsOldSchoolEmptyArray;

    public function register()
    {
        return [T_ECHO];
    }

    public function process(File $phpcsFile, int $stackPtr)
    {
        // Do something.
    }
}
