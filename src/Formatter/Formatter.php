<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Formatter;

use EPS\PhpUri\Uri;

interface Formatter
{
    /**
     * Formats an URI to string
     *
     * @param Uri $uri
     * @return string
     */
    public function format(Uri $uri): string ;
}
