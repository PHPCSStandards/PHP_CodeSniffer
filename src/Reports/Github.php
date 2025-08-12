<?php
/**
 * GitHub annotations report for PHP_CodeSniffer.
 *
 * @author    Nico Hiort af Ornäs <firstname@warpspeed.solutions>
 * @author    Brian Henry <BrianHenryIE@gmail.com>
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Reports;

use PHP_CodeSniffer\Files\File;

class Github implements Report
{


    /**
     * Escapes a message for GitHub Actions annotation syntax.
     *
     * @param string $message The message to escape.
     *
     * @return string The escaped message.
     */
    private function escapeMessage($message)
    {
        // Replace problematic characters: ::, %, and newlines.
        $message = str_replace('::', ':', $message);
        $message = str_replace('%', '%25', $message);
        $message = str_replace("\r", '%0D', $message);
        $message = str_replace("\n", '%0A', $message);
        return $message;

    }//end escapeMessage()


    /**
     * Generate a partial report for a single processed file.
     *
     * @param array                 $report      Prepared report data.
     * @param \PHP_CodeSniffer\File $phpcsFile   The file being reported on.
     * @param bool                  $showSources Show sources?
     * @param int                   $width       Maximum allowed line width.
     *
     * @return bool
     */
    public function generateFileReport($report, File $phpcsFile, $showSources=false, $width=80)
    {
        if ($report['errors'] === 0 && $report['warnings'] === 0) {
            return false;
        }

        $output = '';

        foreach ($report['messages'] as $line => $lineErrors) {
            foreach ($lineErrors as $column => $colErrors) {
                foreach ($colErrors as $error) {
                    $type     = strtolower($error['type']);
                    $filename = $report['filename'];
                    $log      = $this->escapeMessage($error['message']).'%0A%0A'.$this->escapeMessage($error['source']);

                    $output .= "::{$type} file={$filename},line={$line},col={$column}::{$log}".PHP_EOL;
                }
            }
        }

        echo $output;
        return true;

    }//end generateFileReport()


    /**
     * Generates a report with lines parsable by GitHub Actions.
     *
     * @param string $cachedData    Any partial report data from generateFileReport.
     * @param int    $totalFiles    Total number of files processed during the run.
     * @param int    $totalErrors   Total number of errors found during the run.
     * @param int    $totalWarnings Total number of warnings found during the run.
     * @param int    $totalFixable  Total number of problems that can be fixed.
     * @param bool   $showSources   Show sources?
     * @param int    $width         Maximum allowed line width.
     * @param bool   $interactive   Are we running in interactive mode?
     * @param bool   $toScreen      Is the report being printed to screen?
     *
     * @return void
     */
    public function generate(
        $cachedData,
        $totalFiles,
        $totalErrors,
        $totalWarnings,
        $totalFixable,
        $showSources=false,
        $width=80,
        $interactive=false,
        $toScreen=true
    ) {
        if ($toScreen === true && $cachedData !== '') {
            echo "PHP_CodeSniffer Report: $totalErrors errors, $totalWarnings warnings, $totalFixable fixable".PHP_EOL;
            echo $cachedData;
        }

    }//end generate()


}//end class
