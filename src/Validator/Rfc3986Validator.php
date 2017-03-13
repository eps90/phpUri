<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator;

final class Rfc3986Validator implements Validator
{
    /**
     * {@inheritdoc}
     */
    public function validate(string $uriCandidate): bool
    {
        $partsValidator = new AggregatedValidator([
            new SchemeValidator(),
            new AuthorityValidator(),
            new PathValidator(),
            new QueryValidator(),
            new FragmentValidator()
        ]);

        return $partsValidator->validate($uriCandidate);
    }
}
