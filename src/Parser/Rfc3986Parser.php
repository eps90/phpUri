<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Parser;

use EPS\PhpUri\Exception\ParserException;
use EPS\PhpUri\Uri;
use EPS\PhpUri\UriAuthority;
use EPS\PhpUri\Validator\Patterns\Rfc3986;

final class Rfc3986Parser implements Parser
{
    /**
     * {@inheritdoc}
     */
    public function parseUri(string $uri): Uri
    {
        if (!preg_match(Rfc3986::URI_UNPACK_PATTERN, $uri, $matches)) {
            throw ParserException::cannotParseUrl($uri);
        }

        $scheme = $this->encode($matches[2] ?? null);
        $authorityParsed = $this->parseAuthority($matches[4] ?? null);
        $path = $this->encode($matches[5] ?? null);
        $query = $this->encode($matches[7] ?? null);
        $fragment = $this->encode($matches[9] ?? null);

        return new Uri(
            $scheme,
            $authorityParsed,
            $path,
            $query,
            $fragment
        );
    }

    private function encode(string $uriPart = null): ?string
    {
        if ($uriPart === null) {
            return null;
        }

        return rawurldecode($uriPart);
    }

    private function parseAuthority(string $authorityString = null)
    {
        if (empty($authorityString)) {
            return new UriAuthority();
        }

        $authorityRegex = '/' . Rfc3986::AUTHORITY . '/';
        preg_match($authorityRegex, $authorityString, $matches);

        $userAndPass = $this->encode($matches[1] ?? null);
        $host = $this->encode($matches[3]);
        $portWithColon = $this->encode($matches[7] ?? null);

        list($user, $pass) = $this->parseUserAndPass($userAndPass);
        $port = $this->parsePortWithColon($portWithColon);

        return new UriAuthority($user, $pass, $host, $port);
    }

    private function parseUserAndPass(string $userAndPass = null): array
    {
        $result = array_fill(0, 2, null);
        if ($userAndPass !== null) {
            return array_replace($result, array_filter(explode(':', $userAndPass)));
        }
        return $result;
    }

    private function parsePortWithColon(string $portWithColon = null): ?int
    {
        if ($portWithColon !== null) {
            return (int)ltrim($portWithColon, ':');
        }

        return null;
    }
}
