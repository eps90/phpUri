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
}
