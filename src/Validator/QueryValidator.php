<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\Patterns\Rfc3986;

final class QueryValidator implements Validator
{
    /**
     * {@inheritdoc}
     */
    public function validate(string $uriCandidate): bool
    {
        if (!preg_match(Rfc3986::URI_UNPACK_PATTERN, $uriCandidate, $matches)) {
            ValidatorException::invalidQuery($uriCandidate);
        }

        $query = $matches[7] ?? null;

        if (!empty($query)) {
            $queryRegex = '/^(' . Rfc3986::QUERY . ')$/';
            $queryMatches = preg_match($queryRegex, $query, $matches) > 0;
            $noSpaces = strpos($query, ' ') === false;
            if (!($noSpaces && $queryMatches)) {
                throw ValidatorException::invalidQuery($uriCandidate);
            }
        }

        return true;
    }
}
