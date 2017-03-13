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
}
