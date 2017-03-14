<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Parser;

use EPS\PhpUri\Exception\ParserException;
use EPS\PhpUri\Parser\Parser;
use EPS\PhpUri\Parser\Rfc3986Parser;

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
}
