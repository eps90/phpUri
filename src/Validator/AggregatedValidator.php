<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator;

use EPS\PhpUri\Exception\ValidatorException;

final class AggregatedValidator implements Validator
{
    /**
     * @var Validator[]
     */
    private $validators;

    public function __construct(array $validators)
    {
        $this->validators = [];
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
    }

    public function addValidator(Validator $validator): void
    {
        $this->validators[] = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(string $uriCandidate): bool
    {
        $results = array_map(
            function (Validator $validator) use ($uriCandidate) {
                return $this->processValidator($validator, $uriCandidate);
            },
            $this->validators
        );

        $failedValidations = array_filter($results, function (bool $result) { return $result === false; });
        if (empty($failedValidations)) {
            return true;
        }

        throw ValidatorException::validationFailed($uriCandidate);
    }

    private function processValidator(Validator $validator, string $uriCandidate)
    {
        try {
            return $validator->validate($uriCandidate);
        } catch (\Throwable $exception) {
            throw ValidatorException::validationFailed($uriCandidate, $exception);
        }
    }
}
