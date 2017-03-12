<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Parser;

use EPS\PhpUri\Exception\ParserException;
use EPS\PhpUri\Uri;
use EPS\PhpUri\UriAuthority;

final class PhpBuiltInParser implements Parser
{
    /**
     * {@inheritdoc}
     */
    public function parseUri(string $uri): Uri
    {
        $parsedUri = parse_url($uri);

        if ($parsedUri === false) {
            throw ParserException::cannotParseUrl($uri);
        }

        return new Uri(
            $parsedUri['scheme'] ?? null,
            new UriAuthority(
                $parsedUri['user'] ?? null,
                $parsedUri['pass'] ?? null,
                $parsedUri['host'] ?? null,
                $parsedUri['port'] ?? null
            ),
            $parsedUri['path'] ?? null,
            $parsedUri['query'] ?? null,
            $parsedUri['fragment'] ?? null
        );
    }
}
