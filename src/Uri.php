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
    public function __construct(string $scheme, UriAuthority $authority, string $path, string $query, string $fragment)
    {
        $this->scheme = $scheme;
        $this->authority = $authority;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }
}
