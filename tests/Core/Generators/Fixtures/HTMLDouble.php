<?php
/**
 * Test double for the HTML doc generator.
 *
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Generators\Fixtures;

use PHP_CodeSniffer\Generators\HTML;

class HTMLDouble extends HTML
{

    /**
     * Format the footer of the HTML page without the date or version nr to make the expectation fixtures stable.
     *
     * @return string
     */
    protected function getFormattedFooter()
    {
        $output     = '  <div class="tag-line">';
        $output    .= 'Documentation generated on #REDACTED#';
        $output    .= ' by <a href="https://github.com/PHPCSStandards/PHP_CodeSniffer">PHP_CodeSniffer #VERSION#</a>';
        $output    .= '</div>'.PHP_EOL;
        $output .= ' </body>'.PHP_EOL;
        $output .= '</html>'.PHP_EOL;

        return $output;
    }

    /**
     * Retrieve the _real_ footer of the HTML page.
     *
     * @return string
     */
    public function getRealFooter()
    {
        return parent::getFormattedFooter();
    }
}
