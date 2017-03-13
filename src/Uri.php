<?php
declare(strict_types = 1);

namespace EPS\PhpUri;

final class Uri
{
    /**
     * @var string
     */
    private $scheme;

    /**
     * @var UriAuthority
     */
    private $authority;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $query;

    /**
     * @var array
     */
    private $queryParts;

    /**
     * @var string
     */
    private $fragment;

    /**
     * @param string $scheme
     * @param UriAuthority $authority
     * @param string $path
     * @param string $query
     * @param string $fragment
     */
    public function __construct(
        string $scheme = null,
        UriAuthority $authority = null,
        string $path = null,
        string $query = null,
        string $fragment = null
    ) {
        $this->scheme = $scheme !== null ? rawurlencode($scheme) : null;
        $this->authority = $authority;
        $this->path = $this->encodePath($path);
        $this->query = $this->encodeQuery($query);
        $this->fragment = $fragment !== null ? rawurlencode($fragment) : null;
    }

    /**
     * @return string
     */
    public function getScheme(): ?string
    {
        return $this->scheme;
    }

    /**
     * @return UriAuthority
     */
    public function getAuthority(): UriAuthority
    {
        return $this->authority;
    }

    /**
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getFragment(): ?string
    {
        return $this->fragment;
    }

    private function encodePath(string $path = null): ?string
    {
        if ($path === null) {
            return null;
        }

        return implode('/', array_map('rawurlencode', explode('/', $path)));
    }

    private function encodeQuery(string $query = null)
    {
        if ($query === null) {
            $this->queryParts = [];
            return null;
        }

        parse_str($query, $output);
        $this->queryParts = $output;

        return http_build_query($output);
    }
}
