<?php
/**
 * +------------------------------------------------------------------------+
 * | BSD Licence                                                            |
 * +------------------------------------------------------------------------+
 * | This software is available to you under the BSD license,               |
 * | available in the LICENSE file accompanying this software.              |
 * | You may obtain a copy of the License at                                |
 * |                                                                        |
 * | http://matrix.squiz.net/developer/tools/php_cs/licence                 |
 * |                                                                        |
 * | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS    |
 * | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT      |
 * | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR  |
 * | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT   |
 * | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,  |
 * | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT       |
 * | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,  |
 * | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY  |
 * | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT    |
 * | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE  |
 * | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.   |
 * +------------------------------------------------------------------------+
 * | Copyright (c), 2006 Squiz Pty Ltd (ABN 77 084 670 600).                |
 * | All rights reserved.                                                   |
 * +------------------------------------------------------------------------+
 *
 * @package  PHP_CodeSniffer
 * @category CommentParser
 * @author   Squiz Pty Ltd
 */

require_once 'PHP/CodeSniffer/CommentParser/AbstractParser.php';
require_once 'PHP/CodeSniffer/CommentParser/PairElement.php';

/**
 * Parses class member comments.
 *
 * @package  PHP_CodeSniffer
 * @category CommentParser
 * @author   Squiz Pty Ltd
 */
class PHP_CodeSniffer_CommentParser_MemberCommentParser extends PHP_CodeSniffer_CommentParser_AbstractParser
{

    /**
     * Represents a \@var tag in a member comment.
     *
     * @var PHP_CodeSniffer_CommentParser_PairElement
     */
    private $_var = null;


    /**
     * Parses Var tags.
     *
     * @param array $tokens The tokens that represent this tag.
     *
     * @return PHP_CodeSniffer_CommentParser_PairElement
     */
    protected function parseVar($tokens)
    {
        $this->_var = new PHP_CodeSniffer_CommentParser_PairElement($this->previousElement, $tokens, 'var');
        return $this->_var;

    }//end parseVar()


    /**
     * Returns the var tag found in the member comment.
     *
     * @return PHP_CodeSniffer_CommentParser_PairElement
     */
    public function getVar()
    {
        return $this->_var;

    }//end getVar()


    /**
     * Returns the allowed tags for this parser.
     *
     * @return array
     */
    protected function getAllowedTags()
    {
        return array(
                'var' => true,
               );

    }//end getAllowedTags()


}//end class


?>
