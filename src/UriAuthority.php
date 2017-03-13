<?php
declare(strict_types = 1);

namespace EPS\PhpUri;

final class UriAuthority implements \JsonSerializable
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
    public function __construct(string $username = null, string $password = null, string $host = null, int $port = null)
    {
        $this->username = $username !== null ? rawurlencode($username) : null;
        $this->password = $password !== null ? rawurlencode($password) : null;
        $this->host = $host !== null ? rawurlencode($host) : null;
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

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return array_filter([
            'user' => $this->username,
            'pass' => $this->password,
            'host' => $this->host,
            'port' => $this->port
        ]);
    }
}
