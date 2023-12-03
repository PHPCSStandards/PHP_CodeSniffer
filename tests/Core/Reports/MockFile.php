<?php

namespace PHP_CodeSniffer\Tests\Core\Reports;

use PHP_CodeSniffer\Files\File;

class MockFile extends File
{

    /**
     * @param array $tokens
     */
    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    } //end __construct()


    /**
     * @return array
     */
    public function getTokens()
    {
        return $this->tokens;
    }//end getTokens()


}//end class
