<?php
/**
 * Tests for reading multiline doc comment types.
 *
 * @copyright 2026 PHPCSStandards and contributors
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/HEAD/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\Util\DocComment;

use PHP_CodeSniffer\Files\DummyFile;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Tests\ConfigDouble;
use PHP_CodeSniffer\Util\DocComment;
use PHPUnit\Framework\TestCase;

/**
 * Tests for reading multiline doc comment types.
 *
 * @covers \PHP_CodeSniffer\Util\DocComment::getMultilineType
 */
final class GetMultilineTypeTest extends TestCase
{


    /**
     * Test type boundaries, nested brackets and quoted strings.
     *
     * @param string      $content  The tag content.
     * @param string|null $expected The expected type.
     *
     * @dataProvider dataMultilineTypes
     *
     * @return void
     */
    public function testMultilineTypes($content, $expected)
    {
        $config            = new ConfigDouble();
        $config->standards = ['Generic'];
        $config->sniffs    = ['Generic.PHP.LowerCaseConstant'];
        $ruleset           = new Ruleset($config);
        $file = new DummyFile("<?php\n/**\n * @var " . $content . "\n */", $ruleset, $config);
        $file->process();
        $string = $file->findNext(T_DOC_COMMENT_STRING, 0);

        $this->assertSame($expected, DocComment::getMultilineType($file, $string));
    }


    /**
     * Data provider.
     *
     * @return array<string, array<string|null>>
     */
    public static function dataMultilineTypes()
    {
        return [
            'Single line'                                => [
                'integer Description.',
                null,
            ],
            'Single line shape with wrapped description' => [
                "array{id: integer} Description\n * on another line.",
                null,
            ],
            'Nested types and trailing description'      => [
                "array{\n * id: integer, values: array<string, integer|string>\n * } Description.",
                'array{ id: integer, values: array<string, integer|string> }',
            ],
            'Quoted brackets'                            => [
                "array{\n * marker: '}', other: \"<\"\n * }",
                'array{ marker: \'}\', other: "<" }',
            ],
            'Escaped quote'                              => [
                "array{\n * marker: 'it\\'s }'\n * }",
                "array{ marker: 'it\\'s }' }",
            ],
            'Legacy array arrow'                         => [
                "array(\n * integer => string\n * )",
                'array( integer => string )',
            ],
            'Array suffix and union'                     => [
                "array{\n * id: integer\n * }[]|null Description.",
                'array{ id: integer }[]|null',
            ],
            'Incomplete type before another tag'         => [
                "array{\n * id: integer\n * @see Example }",
                null,
            ],
            'Incomplete type before comment closer'      => [
                "array{\n * id: integer",
                null,
            ],
            'Mismatched brackets'                        => [
                "array{\n * id: integer\n * >",
                null,
            ],
        ];
    }
}
