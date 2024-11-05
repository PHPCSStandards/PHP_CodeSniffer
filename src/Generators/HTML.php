<?php
/**
 * A doc generator that outputs documentation in one big HTML file.
 *
 * Output is in one large HTML file and is designed for you to style with
 * your own stylesheet. It contains a table of contents at the top with anchors
 * to each sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Generators;

use DOMDocument;
use DOMNode;
use PHP_CodeSniffer\Config;

class HTML extends Generator
{

    /**
     * Stylesheet for the HTML output.
     *
     * @var string
     */
    const STYLESHEET = '<style>
        body {
            background-color: #FFFFFF;
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
            color: #000000;
        }

        h1 {
            color: #666666;
            font-size: 20px;
            font-weight: bold;
            margin-top: 0px;
            background-color: #E6E7E8;
            padding: 20px;
            border: 1px solid #BBBBBB;
        }

        h2 {
            color: #00A5E3;
            font-size: 16px;
            font-weight: normal;
            margin-top: 50px;
        }

        .code-comparison {
            width: 100%;
        }

        .code-comparison td {
            border: 1px solid #CCCCCC;
        }

        .code-comparison-title, .code-comparison-code {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000000;
            vertical-align: top;
            padding: 4px;
            width: 50%;
            background-color: #F1F1F1;
            line-height: 15px;
        }

        .code-comparison-code {
            font-family: Courier;
            background-color: #F9F9F9;
        }

        .code-comparison-highlight {
            background-color: #DDF1F7;
            border: 1px solid #00A5E3;
            line-height: 15px;
        }

        .tag-line {
            text-align: center;
            width: 100%;
            margin-top: 30px;
            font-size: 12px;
        }

        .tag-line a {
            color: #000000;
        }
    </style>';


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
            echo $this->getFormattedToc();
            echo $content;
            echo $this->getFormattedFooter();
        }

    }//end generate()


    /**
     * Print the header of the HTML page.
     *
     * @deprecated 3.12.0 Use HTML::getFormattedHeader() instead.
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
     * Format the header of the HTML page.
     *
     * @since 3.12.0 Replaces the deprecated HTML::printHeader() method.
     *
     * @return string
     */
    protected function getFormattedHeader()
    {
        $standard = $this->ruleset->name;
        $output   = '<html>'.PHP_EOL;
        $output  .= ' <head>'.PHP_EOL;
        $output  .= "  <title>$standard Coding Standards</title>".PHP_EOL;
        $output  .= '  '.str_replace("\n", PHP_EOL, self::STYLESHEET).PHP_EOL;
        $output  .= ' </head>'.PHP_EOL;
        $output  .= ' <body>'.PHP_EOL;
        $output  .= "  <h1>$standard Coding Standards</h1>".PHP_EOL;

        return $output;

    }//end getFormattedHeader()


    /**
     * Print the table of contents for the standard.
     *
     * @deprecated 3.12.0 Use HTML::getFormattedToc() instead.
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    protected function printToc()
    {
        echo $this->getFormattedToc();

    }//end printToc()


    /**
     * Format the table of contents for the standard.
     *
     * The TOC is just an unordered list of bookmarks to sniffs on the page.
     *
     * @since 3.12.0 Replaces the deprecated HTML::printToc() method.
     *
     * @return string
     */
    protected function getFormattedToc()
    {
        // Only show a TOC when there are two or more docs to display.
        if (count($this->docFiles) < 2) {
            return '';
        }

        $output  = '  <h2>Table of Contents</h2>'.PHP_EOL;
        $output .= '  <ul class="toc">'.PHP_EOL;

        foreach ($this->docFiles as $file) {
            $doc = new DOMDocument();
            $doc->load($file);
            $documentation = $doc->getElementsByTagName('documentation')->item(0);
            $title         = $this->getTitle($documentation);
            $output       .= '   <li><a href="#'.str_replace(' ', '-', $title).'">'.$title.'</a></li>'.PHP_EOL;
        }

        $output .= '  </ul>'.PHP_EOL;

        return $output;

    }//end getFormattedToc()


    /**
     * Print the footer of the HTML page.
     *
     * @deprecated 3.12.0 Use HTML::getFormattedFooter() instead.
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
     * Format the footer of the HTML page.
     *
     * @since 3.12.0 Replaces the deprecated HTML::printFooter() method.
     *
     * @return string
     */
    protected function getFormattedFooter()
    {
        // Turn off errors so we don't get timezone warnings if people
        // don't have their timezone set.
        $errorLevel = error_reporting(0);
        $output     = '  <div class="tag-line">';
        $output    .= 'Documentation generated on '.date('r');
        $output    .= ' by <a href="https://github.com/PHPCSStandards/PHP_CodeSniffer">PHP_CodeSniffer '.Config::VERSION.'</a>';
        $output    .= '</div>'.PHP_EOL;
        error_reporting($errorLevel);

        $output .= ' </body>'.PHP_EOL;
        $output .= '</html>'.PHP_EOL;

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
    public function processSniff(DOMNode $doc)
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
            echo '  <a name="'.str_replace(' ', '-', $title).'" />'.PHP_EOL;
            echo '  <h2>'.$title.'</h2>'.PHP_EOL;
            echo $content;
        }

    }//end processSniff()


    /**
     * Print a text block found in a standard.
     *
     * @param \DOMNode $node The DOMNode object for the text block.
     *
     * @deprecated 3.12.0 Use HTML::getFormattedTextBlock() instead.
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
     * @since 3.12.0 Replaces the deprecated HTML::printTextBlock() method.
     *
     * @return string
     */
    protected function getFormattedTextBlock(DOMNode $node)
    {
        $content = trim($node->nodeValue);
        $content = htmlspecialchars($content, (ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401));

        // Allow only em tags.
        $content = str_replace('&lt;em&gt;', '<em>', $content);
        $content = str_replace('&lt;/em&gt;', '</em>', $content);

        $nodeLines = explode("\n", $content);
        $lineCount = count($nodeLines);
        $lines     = [];

        for ($i = 0; $i < $lineCount; $i++) {
            $currentLine = trim($nodeLines[$i]);

            if (isset($nodeLines[($i + 1)]) === false) {
                // We're at the end of the text, just add the line.
                $lines[] = $currentLine;
            } else {
                $nextLine = trim($nodeLines[($i + 1)]);
                if ($nextLine === '') {
                    // Next line is a blank line, end the paragraph and start a new one.
                    // Also skip over the blank line.
                    $lines[] = $currentLine.'</p>'.PHP_EOL.'  <p class="text">';
                    ++$i;
                } else {
                    // Next line is not blank, so just add a line break.
                    $lines[] = $currentLine.'<br/>'.PHP_EOL;
                }
            }
        }

        return '  <p class="text">'.implode('', $lines).'</p>'.PHP_EOL;

    }//end getFormattedTextBlock()


    /**
     * Print a code comparison block found in a standard.
     *
     * @param \DOMNode $node The DOMNode object for the code comparison block.
     *
     * @deprecated 3.12.0 Use HTML::getFormattedCodeComparisonBlock() instead.
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
     * @since 3.12.0 Replaces the deprecated HTML::printCodeComparisonBlock() method.
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
        $first      = str_replace('<?php', '&lt;?php', $first);
        $first      = str_replace("\n", '</br>', $first);
        $first      = str_replace(' ', '&nbsp;', $first);
        $first      = str_replace('<em>', '<span class="code-comparison-highlight">', $first);
        $first      = str_replace('</em>', '</span>', $first);

        $secondTitle = trim($secondCodeElm->getAttribute('title'));
        $secondTitle = str_replace('  ', '&nbsp;&nbsp;', $secondTitle);
        $second      = trim($secondCodeElm->nodeValue);
        $second      = str_replace('<?php', '&lt;?php', $second);
        $second      = str_replace("\n", '</br>', $second);
        $second      = str_replace(' ', '&nbsp;', $second);
        $second      = str_replace('<em>', '<span class="code-comparison-highlight">', $second);
        $second      = str_replace('</em>', '</span>', $second);

        $output  = '  <table class="code-comparison">'.PHP_EOL;
        $output .= '   <tr>'.PHP_EOL;
        $output .= "    <td class=\"code-comparison-title\">$firstTitle</td>".PHP_EOL;
        $output .= "    <td class=\"code-comparison-title\">$secondTitle</td>".PHP_EOL;
        $output .= '   </tr>'.PHP_EOL;
        $output .= '   <tr>'.PHP_EOL;
        $output .= "    <td class=\"code-comparison-code\">$first</td>".PHP_EOL;
        $output .= "    <td class=\"code-comparison-code\">$second</td>".PHP_EOL;
        $output .= '   </tr>'.PHP_EOL;
        $output .= '  </table>'.PHP_EOL;

        return $output;

    }//end getFormattedCodeComparisonBlock()


}//end class
