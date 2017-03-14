<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Parser;

use EPS\PhpUri\Exception\ParserException;
use EPS\PhpUri\Parser\Parser;
use EPS\PhpUri\Uri;
use EPS\PhpUri\UriAuthority;
use PHPUnit\Framework\TestCase;

abstract class AbstractParserTest extends TestCase
{
    /**
     * @var Parser
     */
    protected $parser;

    abstract public function getParser(): Parser;

    protected function setUp()
    {
        parent::setUp();

        $this->parser = $this->getParser();
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
    public function itShouldEncodeValuesBeforeBuidlingAnObject()
    {
        $encodedUri = 'http://example.com/some/path%5B0%5D';
        $expectedUri = new Uri(
            'http',
            new UriAuthority(
                null,
                null,
                'example.com'
            ),
            '/some/path[0]'
        );
        $actualUri = $this->parser->parseUri($encodedUri);

        static::assertEquals($expectedUri, $actualUri);
    }
}
