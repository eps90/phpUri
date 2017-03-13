<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator;

use EPS\PhpUri\Exception\ValidatorException;

final class Rfc2396Validator implements Validator
{
    /**
     * {@inheritdoc}
     */
    public function validate(string $uriCandidate): bool
    {
        if (filter_var($uriCandidate, FILTER_VALIDATE_URL) === false) {
            throw ValidatorException::validationFailed($uriCandidate);
        }

        return true;
    }
}
