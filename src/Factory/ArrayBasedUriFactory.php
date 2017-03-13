<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Factory;

use EPS\PhpUri\Uri;
use EPS\PhpUri\UriAuthority;

final class ArrayBasedUriFactory implements UriFactory
{
    /**
     * {@inheritdoc}
     */
    public function createUri($uriArray): Uri
    {
        return new Uri(
            $uriArray['scheme'] ?? null,
            new UriAuthority(
                $uriArray['authority']['user'] ?? null,
                $uriArray['authority']['pass'] ?? null,
                $uriArray['authority']['host'] ?? null,
                $uriArray['authority']['port'] ?? null
            ),
            $uriArray['path'] ?? null,
            $uriArray['query'] ?? null,
            $uriArray['fragment'] ?? null
        );
    }
}
