<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Factory;

use EPS\PhpUri\Exception\ParserException;
use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Uri;

interface UriFactory
{
    /**
     * Produces an URI object after initial validation and parsing
     *
     * @param mixed $uriCandidate
     * @return Uri
     * @throws ValidatorException On validation errors
     * @throws ParserException On parsing errors
     */
    public function createUri($uriCandidate): Uri;
}
