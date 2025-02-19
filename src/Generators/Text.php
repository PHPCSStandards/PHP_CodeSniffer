<?php
/**
 * A doc generator that outputs text-based documentation.
 *
 * Output is designed to be displayed in a terminal and is wrapped to 100 characters.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Generators;

use DOMElement;
use DOMNode;

class Text extends Generator
{


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
            echo $this->getFormattedTitle($doc), $content;
        }

    }//end processSniff()


    /**
     * Prints the title area for a single sniff.
     *
     * @param \DOMNode $doc The DOMNode object for the sniff.
     *                      It represents the "documentation" tag in the XML
     *                      standard file.
     *
     * @deprecated 3.12.0 Use Text::getFormattedTitle() instead.
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    protected function printTitle(DOMNode $doc)
    {
        echo $this->getFormattedTitle($doc);

    }//end printTitle()


    /**
     * Format the title area for a single sniff.
     *
     * @param \DOMNode $doc The DOMNode object for the sniff.
     *                      It represents the "documentation" tag in the XML
     *                      standard file.
     *
     * @since 3.12.0 Replaces the deprecated Text::printTitle() method.
     *
     * @return string
     */
    protected function getFormattedTitle(DOMNode $doc)
    {
        $title        = $this->getTitle($doc);
        $standard     = $this->ruleset->name;
        $displayTitle = "$standard CODING STANDARD: $title";
        $titleLength  = strlen($displayTitle);

        $output  = PHP_EOL;
        $output .= str_repeat('-', ($titleLength + 4));
        $output .= strtoupper(PHP_EOL."| $displayTitle |".PHP_EOL);
        $output .= str_repeat('-', ($titleLength + 4));
        $output .= PHP_EOL.PHP_EOL;

        return $output;

    }//end getFormattedTitle()


    /**
     * Print a text block found in a standard.
     *
     * @param \DOMNode $node The DOMNode object for the text block.
     *
     * @deprecated 3.12.0 Use Text::getFormattedTextBlock() instead.
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
     * @since 3.12.0 Replaces the deprecated Text::printTextBlock() method.
     *
     * @return string
     */
    protected function getFormattedTextBlock(DOMNode $node)
    {
        $text = $node->nodeValue;
        if (empty($text) === true) {
            return '';
        }

        $text = trim($text);
        $text = str_replace(['<em>', '</em>'], '*', $text);

        $nodeLines = explode("\n", $text);
        $nodeLines = array_map('trim', $nodeLines);
        $text      = implode(PHP_EOL, $nodeLines);

        return wordwrap($text, 100, PHP_EOL).PHP_EOL.PHP_EOL;

    }//end getFormattedTextBlock()


    /**
     * Print a code comparison block found in a standard.
     *
     * @param \DOMNode $node The DOMNode object for the code comparison block.
     *
     * @deprecated 3.12.0 Use Text::getFormattedCodeComparisonBlock() instead.
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
     * @since 3.12.0 Replaces the deprecated Text::printCodeComparisonBlock() method.
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

        $firstTitleLines = $this->codeTitleToLines($firstCodeElm);
        $firstLines      = $this->codeToLines($firstCodeElm);

        $secondTitleLines = $this->codeTitleToLines($secondCodeElm);
        $secondLines      = $this->codeToLines($secondCodeElm);

        $titleRow = '';
        if ($firstTitleLines !== [] || $secondTitleLines !== []) {
            $maxTitleLines = max(count($firstTitleLines), count($secondTitleLines));
            for ($i = 0; $i < $maxTitleLines; $i++) {
                if (isset($firstTitleLines[$i]) === true) {
                    $firstLineText = $firstTitleLines[$i];
                } else {
                    $firstLineText = '';
                }

                if (isset($secondTitleLines[$i]) === true) {
                    $secondLineText = $secondTitleLines[$i];
                } else {
                    $secondLineText = '';
                }

                $titleRow .= '| ';
                $titleRow .= $firstLineText.str_repeat(' ', (46 - strlen($firstLineText)));
                $titleRow .= ' | ';
                $titleRow .= $secondLineText.str_repeat(' ', (47 - strlen($secondLineText)));
                $titleRow .= ' |'.PHP_EOL;
            }//end for

            $titleRow .= str_repeat('-', 100).PHP_EOL;
        }//end if

        $codeRow = '';
        if ($firstLines !== [] || $secondLines !== []) {
            $maxCodeLines = max(count($firstLines), count($secondLines));
            for ($i = 0; $i < $maxCodeLines; $i++) {
                if (isset($firstLines[$i]) === true) {
                    $firstLineText = $firstLines[$i];
                } else {
                    $firstLineText = '';
                }

                if (isset($secondLines[$i]) === true) {
                    $secondLineText = $secondLines[$i];
                } else {
                    $secondLineText = '';
                }

                $codeRow .= '| ';
                $codeRow .= $firstLineText.str_repeat(' ', max(0, (47 - strlen($firstLineText))));
                $codeRow .= '| ';
                $codeRow .= $secondLineText.str_repeat(' ', max(0, (48 - strlen($secondLineText))));
                $codeRow .= '|'.PHP_EOL;
            }//end for

            $codeRow .= str_repeat('-', 100).PHP_EOL.PHP_EOL;
        }//end if

        $output = '';
        if ($titleRow !== '' || $codeRow !== '') {
            $output  = str_repeat('-', 41);
            $output .= ' CODE COMPARISON ';
            $output .= str_repeat('-', 42).PHP_EOL;
            $output .= $titleRow;
            $output .= $codeRow;
        }

        return $output;

    }//end getFormattedCodeComparisonBlock()


    /**
     * Retrieve a code block title and split it into lines for use in an ASCII table.
     *
     * @param \DOMElement $codeElm The DOMElement object for a code block.
     *
     * @since 3.12.0
     *
     * @return array<string>
     */
    private function codeTitleToLines(DOMElement $codeElm)
    {
        $title = trim($codeElm->getAttribute('title'));
        if ($title === '') {
            return [];
        }

        $titleLines = [];
        $tempTitle  = '';
        $words      = explode(' ', $title);

        foreach ($words as $word) {
            if (strlen($tempTitle.$word) >= 45) {
                if (strlen($tempTitle.$word) === 45) {
                    // Adding the extra space will push us to the edge
                    // so we are done.
                    $titleLines[] = $tempTitle.$word;
                    $tempTitle    = '';
                } else if (strlen($tempTitle.$word) === 46) {
                    // We are already at the edge, so we are done.
                    $titleLines[] = $tempTitle.$word;
                    $tempTitle    = '';
                } else {
                    $titleLines[] = $tempTitle;
                    $tempTitle    = $word.' ';
                }
            } else {
                $tempTitle .= $word.' ';
            }
        }//end foreach

        if ($tempTitle !== '') {
            $titleLines[] = $tempTitle;
        }

        return $titleLines;

    }//end codeTitleToLines()


    /**
     * Retrieve a code block contents and split it into lines for use in an ASCII table.
     *
     * @param \DOMElement $codeElm The DOMElement object for a code block.
     *
     * @since 3.12.0
     *
     * @return array<string>
     */
    private function codeToLines(DOMElement $codeElm)
    {
        $code = trim($codeElm->nodeValue);
        if ($code === '') {
            return [];
        }

        $code = str_replace(['<em>', '</em>'], '', $code);
        return explode("\n", $code);

    }//end codeToLines()


}//end class
