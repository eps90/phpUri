<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\Patterns\Rfc3986;

final class SchemeValidator implements Validator
{
    /**
     * {@inheritdoc}
     */
    public function validate(string $uriCandidate): bool
    {
        if (!preg_match(Rfc3986::URI_UNPACK_PATTERN, $uriCandidate, $matches)) {
            throw ValidatorException::invalidScheme($uriCandidate);
        }

        $scheme = $matches[2];
        $schemeRegex = '/^' . Rfc3986::SCHEME . '$/';

        $validated = preg_match($schemeRegex, $scheme) > 0;
        if (!$validated) {
            throw ValidatorException::invalidScheme($uriCandidate);
        }

        return true;
    }
}
