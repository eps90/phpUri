<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Factory;

use EPS\PhpUri\Factory\StringBasedUriFactory;
use EPS\PhpUri\Parser\Parser;
use EPS\PhpUri\Uri;
use EPS\PhpUri\UriAuthority;
use EPS\PhpUri\Validator\Validator;
use PHPUnit\Framework\TestCase;

class StringBasedUriFactoryTest extends TestCase
{
    /**
     * @var StringBasedUriFactory
     */
    private $factory;

    /**
     * @var Parser|\PHPUnit_Framework_MockObject_MockObject
     */
    private $parser;

    /**
     * @var Validator|\PHPUnit_Framework_MockObject_MockObject
     */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->validator = $this->createMock(Validator::class);
        $this->parser = $this->createMock(Parser::class);
        $this->factory = new StringBasedUriFactory($this->validator, $this->parser);
    }

    /**
     * @test
     * @dataProvider invalidInputProvider
     */
    public function itShouldNotAcceptOtherValuesThanString($invalidInput)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->factory->createUri($invalidInput);
    }

    /**
     * @test
     */
    public function itShouldValidateAndParseString()
    {
        $inputUri = 'http://example.com';
        $this->validator->expects(static::once())
            ->method('validate')
            ->with($inputUri)
            ->willReturn(true);
        $parsedUri = new Uri('http', new UriAuthority(null, null, 'example.com'));
        $this->parser->expects(static::once())
            ->method('parseUri')
            ->with($inputUri)
            ->willReturn($parsedUri);

        $actualResult = $this->factory->createUri($inputUri);

        static::assertEquals($parsedUri, $actualResult);
    }

    public function invalidInputProvider()
    {
        return [
            [['arrays' => 'are not welcome']],
            [null],
            [true],
            [123]
        ];
    }
}
