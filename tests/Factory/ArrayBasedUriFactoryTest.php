<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Factory;

use EPS\PhpUri\Factory\ArrayBasedUriFactory;
use EPS\PhpUri\Uri;
use EPS\PhpUri\UriAuthority;
use PHPUnit\Framework\TestCase;

class ArrayBasedUriFactoryTest extends TestCase
{
    /**
     * @var ArrayBasedUriFactory
     */
    private $factory;

    protected function setUp()
    {
        parent::setUp();

        $this->factory = new ArrayBasedUriFactory();
    }

    /**
     * @test
     */
    public function itShouldBuildUriFromArrayParameters()
    {
        $inputUriParts = [
            'scheme' => 'http',
            'authority' => [
                'user' => 'some_user',
                'pass' => 'some_pass',
                'host' => 'host.com',
                'port' => 8787
            ],
            'path' => '/some_path',
            'query' => 'q=1&w=2',
            'query_parts' => [
                'q' => '1',
                'w' => '2'
            ],
            'fragment' => 'someFragment'
        ];

        $expectedUri = new Uri(
            'http',
            new UriAuthority(
                'some_user',
                'some_pass',
                'host.com',
                8787
            ),
            '/some_path',
            'q=1&w=2',
            'someFragment'
        );
        $actualUri = $this->factory->createUri($inputUriParts);

        static::assertEquals($expectedUri, $actualUri);
    }

    /**
     * @test
     */
    public function itShouldCreateUriFromIncompleteData()
    {
        $inputParts = [
            'scheme' => 'mailto',
            'path' => 'john.kowalsky'
        ];
        $expectedUri = new Uri(
            'mailto',
            new UriAuthority(),
            'john.kowalsky'
        );
        $actualUri = $this->factory->createUri($inputParts);

        static::assertEquals($expectedUri, $actualUri);
    }
}
