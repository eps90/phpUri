<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Formatter;

use EPS\PhpUri\Formatter\SimpleFormatter;
use EPS\PhpUri\Uri;
use EPS\PhpUri\UriAuthority;
use PHPUnit\Framework\TestCase;

class SimpleFormatterTest extends TestCase
{
    /**
     * @var SimpleFormatter
     */
    private $formatter;

    protected function setUp()
    {
        parent::setUp();

        $this->formatter = new SimpleFormatter();
    }

    /**
     * @test
     */
    public function itShouldBeAbleToBuildUriAsString()
    {
        $uri = new Uri(
            'http',
            new UriAuthority(
                'user',
                'pass',
                'example.com',
                8081
            ),
            '/some/path',
            'some_query_param=value&some_query_param2=value2',
            'fragment'
        );
        $expectedUri = 'http://user:pass@example.com:8081/some/path?some_query_param=value&some_query_param2=value2#fragment';
        $actualUri = $this->formatter->format($uri);

        static::assertEquals($expectedUri, $actualUri);
    }

    /**
     * @test
     * @dataProvider missingUriPartsProvider
     */
    public function itShouldBeAbleToBuildUriAsStringFromIncompleteUriObject(Uri $uri, string $expectedUri)
    {
        $actualUri = $this->formatter->format($uri);

        static::assertEquals($expectedUri, $actualUri);
    }

    public function missingUriPartsProvider()
    {
        return [
            'mixed' => [
                'uri' => new Uri(
                    'http',
                    new UriAuthority(
                        null,
                        null,
                        'example.com',
                        8081
                    ),
                    '/some/path',
                    'some_query_param=value&some_query_param2=value2',
                    null
                ),
                'expected' => 'http://example.com:8081/some/path?some_query_param=value&some_query_param2=value2'
            ],
            'authority_no_scheme' => [
                'uri' => new Uri(
                    null,
                    new UriAuthority(
                        'user',
                        'pass',
                        'example.com',
                        8081
                    ),
                    '/some/path',
                    'some_query_param=1',
                    'fragment'
                ),
                'expected' => '//user:pass@example.com:8081/some/path?some_query_param=1#fragment'
            ],
            'empty_auth' => [
                'uri' => new Uri(
                    'mailto',
                    new UriAuthority(null, null, null, null),
                    '/some/path',
                    'some_query_param=1',
                    'fragment'
                ),
                'expected' => 'mailto:/some/path?some_query_param=1#fragment'
            ],
            'no_leading_slash_in_path' => [
                'uri' => new Uri(
                    'http',
                    new UriAuthority(
                        'user',
                        'pass',
                        'example.com',
                        8081
                    ),
                    'some/path',
                    'some_query_param=1',
                    'fragment'
                ),
                'expected' => 'http://user:pass@example.com:8081/some/path?some_query_param=1#fragment'
            ],
            'no_port' => [
                'uri' => new Uri(
                    'http',
                    new UriAuthority(
                        'user',
                        'pass',
                        'example.com',
                        null
                    ),
                    '/some/path',
                    'some_query_param=1',
                    'fragment'
                ),
                'expected' => 'http://user:pass@example.com/some/path?some_query_param=1#fragment'
            ],
            'decoded' => [
                'uri' => new Uri(
                    'http',
                    new UriAuthority(
                        '[u]ser',
                        'pa[s]ss',
                        'exa[m]mple.com',
                        8081
                    ),
                    '/some/path[0]',
                    'some_query_param[0]=1',
                    'fragment'
                ),
                'expected' => 'http://%5Bu%5Dser:pa%5Bs%5Dss@exa%5Bm%5Dmple.com:8081/some/path%5B0%5D?some_query_param%5B0%5D=1#fragment'
            ]
        ];
    }
}
