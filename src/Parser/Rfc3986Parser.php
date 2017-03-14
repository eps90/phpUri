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
        $authority = $this->encode($matches[4] ??  null);
        $authorityParsed = $this->parseAuthority(
            $this->encode($authority ?? null)
        );
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

        $userAndPass = $matches[1] ?? null;
        $host = $matches[2];
        $portWithColon = $matches[5] ?? null;

        list($user, $pass) = $this->parseUserAndPass($userAndPass);

        if ($portWithColon !== null) {
            $port = (int)ltrim($portWithColon, ':');
        } else {
            $port = null;
        }

        return new UriAuthority($user, $pass, $host, $port);
    }

    private function parseUserAndPass(string $userAndPass = null)
    {
        $result = array_fill(0, 2, null);
        if ($userAndPass !== null) {
            return array_replace($result, array_filter(explode(':', $userAndPass)));
        }
        return $result;
    }
}