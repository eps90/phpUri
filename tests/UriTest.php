<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests;

use EPS\PhpUri\Uri;
use EPS\PhpUri\UriAuthority;
use PHPUnit\Framework\TestCase;

class UriTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldEncodeInputParameters()
    {
        $uri = new Uri(
            'h[t]tp',
            new UriAuthority(null, null, null, null),
            '/som[e]/p[a]th',
            'q[0]=1&q[2]=2',
            '[f]ragment'
        );

        static::assertEquals('h%5Bt%5Dtp', $uri->getScheme());
        static::assertEquals('/som%5Be%5D/p%5Ba%5Dth', $uri->getPath());
        static::assertEquals('q%5B0%5D=1&q%5B2%5D=2', $uri->getQuery());
        static::assertEquals('%5Bf%5Dragment', $uri->getFragment());
    }

    /**
     * @test
     */
    public function itShouldNotEncodeNullValues()
    {
        $uri = new Uri(
            null,
            new UriAuthority(null, null, null, null),
            null,
            null,
            null
        );

        static::assertNull($uri->getScheme());
        static::assertNull($uri->getFragment());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToBeCastedToJson()
    {
        $uri = new Uri(
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
        $expectedJson = json_encode([
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
        ]);
        $actualJson = json_encode($uri);

        static::assertJsonStringEqualsJsonString($expectedJson, $actualJson);
    }

    /**
     * @test
     */
    public function itShouldNotSerializeNullValues()
    {
        $uri = new Uri(
            'mailto',
            new UriAuthority(),
            'john.kowalsky'
        );
        $expectedJson = json_encode([
            'scheme' => 'mailto',
            'path' => 'john.kowalsky'
        ]);
        $actualJson = json_encode($uri);

        static::assertJsonStringEqualsJsonString($expectedJson, $actualJson);
    }
}
