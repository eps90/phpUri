<?php
declare(strict_types = 1);

namespace EPS\PhpUri;

final class UriAuthority
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @param string $username
     * @param string $password
     * @param string $host
     * @param int $port
     */
    public function __construct(?string $username, ?string $password, ?string $host, ?int $port)
    {
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): ?int
    {
        return $this->port;
    }
}
