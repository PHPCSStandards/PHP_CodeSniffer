<?php
/**
 * Mock generator class.
 *
 * @copyright 2024 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Generators\Fixtures;

use DOMElement;
use PHP_CodeSniffer\Generators\Generator;

class MockGenerator extends Generator
{

    /**
     * Process the documentation for a single sniff.
     *
     * @param \DOMElement $doc The DOMElement object for the sniff.
     *
     * @return void
     */
    protected function processSniff(DOMElement $doc)
    {
        echo $this->getTitle($doc), PHP_EOL;
    }
}
