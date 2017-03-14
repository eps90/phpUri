<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Parser;

use EPS\PhpUri\Exception\ParserException;
use EPS\PhpUri\Parser\Parser;
use EPS\PhpUri\Parser\Rfc3986Parser;
use EPS\PhpUri\Uri;
use EPS\PhpUri\UriAuthority;

class Rfc3986ParserTest extends AbstractParserTest
{
    public function getParser(): Parser
    {
        return new Rfc3986Parser();
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionOnStringThatCannotBeParsed()
    {
        $this->expectException(ParserException::class);

        $invalidUri = 'http';
        $this->parser->parseUri($invalidUri);
    }

    /**
     * @test
     * @see https://tools.ietf.org/html/rfc3986#section-3.2
     */
    public function itShouldParseUriWithEmptyAuthority()
    {
        $validUriString = 'http://';
        $expectedUri = new Uri(
            'http',
            new UriAuthority()
        );
        $actualUri = $this->parser->parseUri($validUriString);

        static::assertEquals($expectedUri, $actualUri);
    }
}
