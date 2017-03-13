<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\FragmentValidator;
use PHPUnit\Framework\TestCase;

class FragmentValidatorTest extends TestCase
{
    /**
     * @var FragmentValidator
     */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->validator = new FragmentValidator();
    }

    /**
     * @test
     */
    public function itShouldReturnTrueForValidFragment()
    {
        $validUri = 'http://example.com/some/path#Fragment';
        $actualResult = $this->validator->validate($validUri);

        static::assertTrue($actualResult);
    }

    /**
     * @test
     */
    public function itShouldThrowOnInvalidFragmentInUri()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessageRegExp('/Invalid fragment/');

        $invalidUri = 'http://example.com/some/path/#Fragment[0]';
        $this->validator->validate($invalidUri);
    }

    /**
     * @test
     */
    public function itShouldBeValidForEmptyFragment()
    {
        $validUri = 'http://example.com/some/path';
        $actualResult = $this->validator->validate($validUri);

        static::assertTrue($actualResult);
    }
}
