<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\Patterns\Rfc3986;

final class FragmentValidator implements Validator
{

    /**
     * {@inheritdoc}
     */
    public function validate(string $uriCandidate): bool
    {
        preg_match(Rfc3986::URI_UNPACK_PATTERN, $uriCandidate, $matches);

        $fragment = $matches[9] ?? null;

        if (!empty($fragment)) {
            $fragmentRegex = '/^(' . Rfc3986::FRAGMENT . ')$/';
            $fragmentMatches = preg_match($fragmentRegex, $fragment, $matches) > 0;
            $noSpaces = strpos($fragment, ' ') === false;

            if (!($noSpaces && $fragmentMatches)) {
                throw ValidatorException::invalidFragment($uriCandidate);
            }
        }

        return true;
    }
}
