<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests;

use EPS\PhpUri\UriAuthority;
use PHPUnit\Framework\TestCase;

class UriAuthorityTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldEncodeQueryParts()
    {
        $authority = new UriAuthority(
            '[u]ser',
            'pa[s]sword',
            'e[x]ample.com',
            8080
        );

        static::assertEquals('%5Bu%5Dser', $authority->getUsername());
        static::assertEquals('pa%5Bs%5Dsword', $authority->getPassword());
        static::assertEquals('e%5Bx%5Dample.com', $authority->getHost());
    }

    /**
     * @test
     */
    public function itShouldNotEncodeNullValues()
    {
        $authority = new UriAuthority(
            null,
            null,
            null,
            null
        );

        static::assertNull($authority->getUsername());
        static::assertNull($authority->getPassword());
        static::assertNull($authority->getHost());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToBeCastedToJson()
    {
        $uri = new UriAuthority(
            'some_user',
            'some_pass',
            'some.host.com',
            9876
        );

        $expectedJson = json_encode([
            'user' => 'some_user',
            'pass' => 'some_pass',
            'host' => 'some.host.com',
            'port' => 9876
        ]);
        $actualJson = json_encode($uri);

        static::assertJsonStringEqualsJsonString($expectedJson, $actualJson);
    }

    /**
     * @test
     */
    public function itShouldNotIncludeNullValuesInOutputJson()
    {
        $uri = new UriAuthority(
            null,
            null,
            'some.host.com'
        );

        $expectedJson = json_encode([
            'host' => 'some.host.com'
        ]);
        $actualJson = json_encode($uri);

        static::assertJsonStringEqualsJsonString($expectedJson, $actualJson);
    }
}
