<?php
/**
 * A doc generator that outputs documentation in Markdown format.
 *
 * @author    Stefano Kowalke <blueduck@gmx.net>
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2014 Arroba IT
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Generators;

use DOMDocument;
use DOMNode;
use PHP_CodeSniffer\Config;

class Markdown extends Generator
{


    /**
     * Generates the documentation for a standard.
     *
     * @return void
     * @see    processSniff()
     */
    public function generate()
    {
        if (empty($this->docFiles) === true) {
            return;
        }

        ob_start();
        foreach ($this->docFiles as $file) {
            $doc = new DOMDocument();
            $doc->load($file);
            $documentation = $doc->getElementsByTagName('documentation')->item(0);
            $this->processSniff($documentation);
        }

        $content = ob_get_contents();
        ob_end_clean();

        if (trim($content) !== '') {
            echo $this->getFormattedHeader();
            echo $content;
            echo $this->getFormattedFooter();
        }

    }//end generate()


    /**
     * Print the markdown header.
     *
     * @deprecated 3.12.0 Use Markdown::getFormattedHeader() instead.
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    protected function printHeader()
    {
        echo $this->getFormattedHeader();

    }//end printHeader()


    /**
     * Format the markdown header.
     *
     * @since 3.12.0 Replaces the deprecated Markdown::printHeader() method.
     *
     * @return string
     */
    protected function getFormattedHeader()
    {
        $standard = $this->ruleset->name;

        return "# $standard Coding Standard".PHP_EOL;

    }//end getFormattedHeader()


    /**
     * Print the markdown footer.
     *
     * @deprecated 3.12.0 Use Markdown::getFormattedFooter() instead.
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    protected function printFooter()
    {
        echo $this->getFormattedFooter();

    }//end printFooter()


    /**
     * Format the markdown footer.
     *
     * @since 3.12.0 Replaces the deprecated Markdown::printFooter() method.
     *
     * @return string
     */
    protected function getFormattedFooter()
    {
        // Turn off errors so we don't get timezone warnings if people
        // don't have their timezone set.
        $errorLevel = error_reporting(0);
        $output     = PHP_EOL.'Documentation generated on '.date('r');
        $output    .= ' by [PHP_CodeSniffer '.Config::VERSION.'](https://github.com/PHPCSStandards/PHP_CodeSniffer)'.PHP_EOL;
        error_reporting($errorLevel);

        return $output;

    }//end getFormattedFooter()


    /**
     * Process the documentation for a single sniff.
     *
     * @param \DOMNode $doc The DOMNode object for the sniff.
     *                      It represents the "documentation" tag in the XML
     *                      standard file.
     *
     * @return void
     */
    protected function processSniff(DOMNode $doc)
    {
        $content = '';
        foreach ($doc->childNodes as $node) {
            if ($node->nodeName === 'standard') {
                $content .= $this->getFormattedTextBlock($node);
            } else if ($node->nodeName === 'code_comparison') {
                $content .= $this->getFormattedCodeComparisonBlock($node);
            }
        }

        if (trim($content) !== '') {
            $title = $this->getTitle($doc);
            echo PHP_EOL."## $title".PHP_EOL.PHP_EOL;
            echo $content;
        }

    }//end processSniff()


    /**
     * Print a text block found in a standard.
     *
     * @param \DOMNode $node The DOMNode object for the text block.
     *
     * @deprecated 3.12.0 Use Markdown::getFormattedTextBlock() instead.
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    protected function printTextBlock(DOMNode $node)
    {
        echo $this->getFormattedTextBlock($node);

    }//end printTextBlock()


    /**
     * Format a text block found in a standard.
     *
     * @param \DOMNode $node The DOMNode object for the text block.
     *
     * @since 3.12.0 Replaces the deprecated Markdown::printTextBlock() method.
     *
     * @return string
     */
    protected function getFormattedTextBlock(DOMNode $node)
    {
        $content = trim($node->nodeValue);
        $content = htmlspecialchars($content, (ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401));
        $content = str_replace('&lt;em&gt;', '*', $content);
        $content = str_replace('&lt;/em&gt;', '*', $content);

        $nodeLines = explode("\n", $content);
        $lineCount = count($nodeLines);
        $lines     = [];

        for ($i = 0; $i < $lineCount; $i++) {
            $currentLine = trim($nodeLines[$i]);
            if ($currentLine === '') {
                // The text contained a blank line. Respect this.
                $lines[] = '';
                continue;
            }

            // Check if the _next_ line is blank.
            if (isset($nodeLines[($i + 1)]) === false
                || trim($nodeLines[($i + 1)]) === ''
            ) {
                // Next line is blank, just add the line.
                $lines[] = $currentLine;
            } else {
                // Ensure that line breaks are respected in markdown.
                $lines[] = $currentLine.'  ';
            }
        }

        return implode(PHP_EOL, $lines).PHP_EOL;

    }//end getFormattedTextBlock()


    /**
     * Print a code comparison block found in a standard.
     *
     * @param \DOMNode $node The DOMNode object for the code comparison block.
     *
     * @deprecated 3.12.0 Use Markdown::getFormattedCodeComparisonBlock() instead.
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    protected function printCodeComparisonBlock(DOMNode $node)
    {
        echo $this->getFormattedCodeComparisonBlock($node);

    }//end printCodeComparisonBlock()


    /**
     * Format a code comparison block found in a standard.
     *
     * @param \DOMNode $node The DOMNode object for the code comparison block.
     *
     * @since 3.12.0 Replaces the deprecated Markdown::printCodeComparisonBlock() method.
     *
     * @return string
     */
    protected function getFormattedCodeComparisonBlock(DOMNode $node)
    {
        $codeBlocks    = $node->getElementsByTagName('code');
        $firstCodeElm  = $codeBlocks->item(0);
        $secondCodeElm = $codeBlocks->item(1);

        if (isset($firstCodeElm, $secondCodeElm) === false) {
            // Missing at least one code block.
            return '';
        }

        $firstTitle = trim($firstCodeElm->getAttribute('title'));
        $firstTitle = str_replace('  ', '&nbsp;&nbsp;', $firstTitle);
        $first      = trim($firstCodeElm->nodeValue);
        $first      = str_replace("\n", PHP_EOL.'    ', $first);
        $first      = str_replace('<em>', '', $first);
        $first      = str_replace('</em>', '', $first);

        $secondTitle = trim($secondCodeElm->getAttribute('title'));
        $secondTitle = str_replace('  ', '&nbsp;&nbsp;', $secondTitle);
        $second      = trim($secondCodeElm->nodeValue);
        $second      = str_replace("\n", PHP_EOL.'    ', $second);
        $second      = str_replace('<em>', '', $second);
        $second      = str_replace('</em>', '', $second);

        $output  = '  <table>'.PHP_EOL;
        $output .= '   <tr>'.PHP_EOL;
        $output .= "    <th>$firstTitle</th>".PHP_EOL;
        $output .= "    <th>$secondTitle</th>".PHP_EOL;
        $output .= '   </tr>'.PHP_EOL;
        $output .= '   <tr>'.PHP_EOL;
        $output .= '<td>'.PHP_EOL.PHP_EOL;
        $output .= "    $first".PHP_EOL.PHP_EOL;
        $output .= '</td>'.PHP_EOL;
        $output .= '<td>'.PHP_EOL.PHP_EOL;
        $output .= "    $second".PHP_EOL.PHP_EOL;
        $output .= '</td>'.PHP_EOL;
        $output .= '   </tr>'.PHP_EOL;
        $output .= '  </table>'.PHP_EOL;

        return $output;

    }//end getFormattedCodeComparisonBlock()


}//end class
