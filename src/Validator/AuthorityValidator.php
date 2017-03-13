<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\Patterns\Rfc3986;

final class AuthorityValidator implements Validator
{
    /**
     * {@inheritdoc}
     */
    public function validate(string $uriCandidate): bool
    {
        if (!preg_match(Rfc3986::URI_UNPACK_PATTERN, $uriCandidate, $matches)) {
            ValidatorException::invalidAuthority($uriCandidate);
        }

        $authorityPart = $matches[4];

        if (!empty($authorityPart)) {
            $authorityPartRegex =  '/' . Rfc3986::AUTHORITY . '/';
            $authorityResult = preg_match($authorityPartRegex, $authorityPart, $matches) > 0;
            $noSpaces = strpos($authorityPart, ' ') === false;
            if (!($noSpaces && $authorityResult)) {
                throw ValidatorException::invalidAuthority($uriCandidate);
            }
        }

        return true;
    }
}
