<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\Patterns\Rfc3986;

final class PathValidator implements Validator
{

    /**
     * {@inheritdoc}
     */
    public function validate(string $uriCandidate): bool
    {
        if (!preg_match(Rfc3986::URI_UNPACK_PATTERN, $uriCandidate, $matches)) {
            ValidatorException::invalidPath($uriCandidate);
        }

        $path = $matches[5] ?? null;

        if (!empty($path)) {
            $pathRegex = '/^(' . Rfc3986::PATH . ')$/';
            $pathMatches = preg_match($pathRegex, $path, $matches) > 0;
            $noSpaces = strpos($path, ' ') === false;
            if (!($noSpaces && $pathMatches)) {
                throw ValidatorException::invalidPath($uriCandidate);
            }
        }

        return true;
    }
}
