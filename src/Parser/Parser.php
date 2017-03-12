<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Parser;

use EPS\PhpUri\Uri;

interface Parser
{
    /**
     * Returns an URI object with parsed URI parts.
     *
     * @param string $uri
     * @return Uri
     * @throws \EPS\PhpUri\Exception\ParserException
     */
    public function parseUri(string $uri): Uri;
}
