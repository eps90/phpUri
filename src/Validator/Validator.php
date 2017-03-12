<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator;

interface Validator
{
    /**
     * Determines whether given string is a valid URI or not.
     * Returns true when URI can be parsed, false when URI is invalid.
     *
     * @param string $uriCandidate
     * @return bool
     * @throws \EPS\PhpUri\Exception\ValidatorException
     */
    public function validate(string $uriCandidate): bool;
}
