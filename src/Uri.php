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
        ?string $scheme,
        UriAuthority $authority,
        ?string $path,
        ?string $query,
        ?string $fragment
    ) {
        $this->scheme = $scheme;
        $this->authority = $authority;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
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
}
