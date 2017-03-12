<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\AggregatedValidator;
use EPS\PhpUri\Validator\Validator;
use PHPUnit\Framework\TestCase;

class AggregatedValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldRunValidationOnAllValidators()
    {
        $inputUri = 'http://example.com';
        $aggregatedValidator = new AggregatedValidator([
            $this->createFakeValidator(true),
            $this->createFakeValidator(true),
            $this->createFakeValidator(true)
        ]);
        $actualResult = $aggregatedValidator->validate($inputUri);

        static::assertTrue($actualResult);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenOneOfValidatorsThrow()
    {
        $inputUri = 'http://example.com';

        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage("URI validation failed for string $inputUri: String is malformed");

        $failingValidator = $this->createValidatorMock();
        $aggregatedValidator = new AggregatedValidator([
            $this->createFakeValidator(true),
            $failingValidator
        ]);

        $failingValidator->expects(static::once())
            ->method('validate')
            ->with($inputUri)
            ->willThrowException(new \Exception('String is malformed'));

        $aggregatedValidator->validate($inputUri);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenAtLeastOneValidatorReturnedFalse()
    {
        $inputUri = 'http://example.com';

        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage("URI validation failed for string $inputUri");

        $aggregatedValidator = new AggregatedValidator([
            $this->createFakeValidator(true),
            $this->createFakeValidator(false),
            $this->createFakeValidator(true)
        ]);

        $aggregatedValidator->validate($inputUri);
    }

    private function createFakeValidator(bool $shouldValidate): Validator
    {
        return new class($shouldValidate) implements Validator
        {
            private $shouldValidate;

            public function __construct(bool $shouldValidate)
            {
                $this->shouldValidate = $shouldValidate;
            }

            public function validate(string $uriCandidate): bool
            {
                return $this->shouldValidate;
            }
        };
    }

    private function createValidatorMock()
    {
        return $this->createMock(Validator::class);
    }
}
