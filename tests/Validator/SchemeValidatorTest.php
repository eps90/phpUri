<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\SchemeValidator;
use PHPUnit\Framework\TestCase;

class SchemeValidatorTest extends TestCase
{
    /**
     * @var SchemeValidator
     */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->validator = new SchemeValidator();
    }

    /**
     * @test
     */
    public function itShouldValidateWhenSchemeIsValid()
    {
        $uriWithValidScheme = 'http://example.com';
        $actualResult = $this->validator->validate($uriWithValidScheme);

        static::assertTrue($actualResult);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenSchemeIsNotPresent()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessageRegExp('/Invalid scheme/');

        $invalidUri = 'example.com';
        $this->validator->validate($invalidUri);
    }

    /**
     * @test
     */
    public function itShouldThrowOnInvalidScheme()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessageRegExp('/Invalid scheme/');

        $invalidUri = '222ht://example.com';
        $this->validator->validate($invalidUri);
    }
}
