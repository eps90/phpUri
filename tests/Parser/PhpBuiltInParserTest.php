<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Parser;

use EPS\PhpUri\Exception\ParserException;
use EPS\PhpUri\Parser\Parser;
use EPS\PhpUri\Parser\PhpBuiltInParser;

class PhpBuiltInParserTest extends AbstractParserTest
{
    public function getParser(): Parser
    {
        return new PhpBuiltInParser();
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
