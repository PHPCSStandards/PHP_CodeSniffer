<?php
/**
 * Tests for the \PHP_CodeSniffer\Files\File::getDeclarationName method.
 *
 * @author    Juliette Reinders Folmer <phpcs_nospam@adviesenzo.nl>
 * @copyright 2025 PHPCSStandards Contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\File;

use PHP_CodeSniffer\Tests\Core\AbstractMethodTestCase;

/**
 * Tests for the \PHP_CodeSniffer\Files\File:getDeclarationName method.
 *
 * @covers \PHP_CodeSniffer\Files\File::getDeclarationName
 */
final class GetDeclarationNameParseError1Test extends AbstractMethodTestCase
{


    /**
     * Test receiving an empty string in case of a parse error.
     *
     * @return void
     */
    public function testGetDeclarationName()
    {
        $target = $this->getTargetToken('/* testLiveCoding */', T_FUNCTION);
        $result = self::$phpcsFile->getDeclarationName($target);
        $this->assertSame('', $result);

    }//end testGetDeclarationName()


}//end class
