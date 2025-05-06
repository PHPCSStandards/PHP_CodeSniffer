<?php
/**
 * Exit codes.
 *
 * Note: The "missing" exit codes 8 and 32 are reserved for future use.
 *
 * ---------------------------------------------------------------------------------------------
 * This class is intended for internal use only and is not part of the public API.
 * This also means that it has no promise of backward compatibility. Use at your own risk.
 * ---------------------------------------------------------------------------------------------
 *
 * @internal
 *
 * @copyright 2025 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Util;

final class ExitCode
{

    /**
     * Exit code to indicate no issues were found in the code under scan; or a non-scan request succeeded.
     *
     * @var int
     */
    public const OKAY = 0;

    /**
     * Exit code to indicate auto-fixable issues were found.
     *
     * @var int
     */
    public const FIXABLE = 1;

    /**
     * Exit code to indicate issues were found, which are not auto-fixable.
     *
     * @var int
     */
    public const NON_FIXABLE = 2;

    /**
     * [CBF only] Exit code to indicate a file failed to fix.
     *
     * Typically, this is caused by a fixer conflict between sniffs.
     *
     * @var int
     */
    public const FAILED_TO_FIX = 4;

    /**
     * Exit code to indicate PHP_CodeSniffer ran into a problem while processing the request.
     *
     * Examples of when this code should be used:
     * - Invalid CLI flag used.
     * - Blocking errors in the ruleset file(s).
     * - A dependency required to generate a report not being available, like git for the gitblame report.
     *
     * @var int
     */
    public const PROCESS_ERROR = 16;

    /**
     * Exit code to indicate the requirements to run PHP_CodeSniffer are not met.
     *
     * This exit code is here purely for documentation purposes.
     * This exit code should only be used in the requirements check (`requirements.php` file), but that
     * file can't use the constant as it would block _this_ file from using modern PHP.
     *
     * {@internal The code in the requirements.php file and below should always stay in sync!}
     *
     * @var int
     */
    public const REQUIREMENTS_NOT_MET = 64;


}//end class
