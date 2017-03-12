<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Parser;

use EPS\PhpUri\Exception\ParserException;
use EPS\PhpUri\Parser\PhpBuiltInParser;
use EPS\PhpUri\Uri;
use EPS\PhpUri\UriAuthority;
use PHPUnit\Framework\TestCase;

class PhpBuiltInParserTest extends TestCase
{
    /**
     * @var PhpBuiltInParser
     */
    private $parser;

    protected function setUp()
    {
        parent::setUp();

        $this->parser = new PhpBuiltInParser();
    }

    /**
     * @test
     */
    public function itShouldCreateAnUriObjectWithParsedElements()
    {
        $inputUri = 'http://user:password@example.com:8081/path?query=1#some-fragment';
        $expectedOutput = new Uri(
            'http',
            new UriAuthority(
                'user',
                'password',
                'example.com',
                8081
            ),
            '/path',
            'query=1',
            'some-fragment'
        );
        $actualOutput = $this->parser->parseUri($inputUri);

        static::assertEquals($expectedOutput, $actualOutput);
    }

    /**
     * @test
     */
    public function itShouldConstructUriFromIncompleteData()
    {
        $inputUri = 'https://example.com';
        $expectedOutput = new Uri(
            'https',
            new UriAuthority(null, null, 'example.com', null),
            null,
            null,
            null
        );
        $actualOutput = $this->parser->parseUri($inputUri);

        static::assertEquals($expectedOutput, $actualOutput);
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionOnStringThatCannotBeParsed()
    {
        $this->expectException(ParserException::class);

        $invalidUri = 'http://';
        $this->parser->parseUri($invalidUri);
    }
}
