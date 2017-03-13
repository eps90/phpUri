<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Formatter;

use EPS\PhpUri\Uri;

final class UriFormatter implements Formatter
{
    /**
     * {@inheritdoc}
     */
    public function format(Uri $uri): string
    {
        $uriParts = [
            'scheme' => $uri->getScheme(),
            'user' => $uri->getAuthority()->getUsername(),
            'pass' => $uri->getAuthority()->getPassword(),
            'host' => $uri->getAuthority()->getHost(),
            'port' => $uri->getAuthority()->getPort(),
            'path' => $uri->getPath(),
            'query' => $uri->getQuery(),
            'fragment' => $uri->getFragment()
        ];

        $result = $this->formatScheme($uriParts);
        $result .= $this->formatAuthority($uriParts);
        $result .= $this->formatPath($uriParts);
        $result .= '?' . $uriParts['query'];
        $result .= $this->formatFragment($uriParts);

        return $result;
    }

    private function formatScheme(array $parts): string
    {
        if (!isset($parts['scheme'])) {
            return '';
        }

        return $parts['scheme'] . ':';
    }

    private function formatAuthority(array $parts): string
    {
        if (!(isset($parts['user'])
            || isset($parts['pass'])
            || isset($parts['host'])
            || isset($parts['port'])
        )) {
            return '';
        }
        $result = '//';
        if (isset($parts['user'])) {
            $result .= $parts['user'];

            if (isset($parts['pass'])) {
                $result .= ':' . $parts['pass'];
            }

            $result .= '@';
        }

        if (isset($parts['host'])) {
            $result .= $parts['host'];
        }

        if (isset($parts['port'])) {
            $result .= ':' . $parts['port'];
        }

        if (isset($parts['path']) && strpos($parts['path'], '/') !== 0) {
            $result .= '/';
        }

        return $result;
    }

    private function formatPath(array $parts): string
    {
        if (!isset($parts['path'])) {
            return '';
        }

        return $parts['path'];
    }

    private function formatFragment(array $parts): string
    {
        if (!isset($parts['fragment'])) {
            return '';
        }

        return '#' . $parts['fragment'];
    }
}
