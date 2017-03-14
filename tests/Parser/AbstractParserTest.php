<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Parser;

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
    public function itShouldEncodeValuesBeforeBuildingAnObject()
    {
        $encodedUri = 'http://u%5Bs%5Der:pa%5Bss%5Dword@%5Be%5Dxample.com/some/path%5B0%5D?q%5B0%5D=1&q%5B1%5D=2';
        $expectedUri = new Uri(
            'http',
            new UriAuthority(
                'u[s]er',
                'pa[ss]word',
                '[e]xample.com'
            ),
            '/some/path[0]',
            'q[0]=1&q[1]=2'
        );
        $actualUri = $this->parser->parseUri($encodedUri);

        static::assertEquals($expectedUri, $actualUri);
    }

    /**
     * @test
     */
    public function itShouldParseAuthorityPartWithoutPassword()
    {
        $inputUri = 'http://user@example.com/some/path';
        $expectedUri = new Uri(
            'http',
            new UriAuthority(
                'user',
                null,
                'example.com'
            ),
            '/some/path'
        );
        $actualUri = $this->parser->parseUri($inputUri);

        static::assertEquals($expectedUri, $actualUri);
    }
}
