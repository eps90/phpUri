<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\PathValidator;
use PHPUnit\Framework\TestCase;

class PathValidatorTest extends TestCase
{
    /**
     * @var PathValidator
     */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->validator = new PathValidator();
    }

    /**
     * @test
     */
    public function itShouldReturnTrueForValidPath()
    {
        $validUri = 'http://example.com/some/path';
        $actualResult = $this->validator->validate($validUri);

        static::assertTrue($actualResult);
    }

    /**
     * @test
     */
    public function itShouldThrowForInvalidPath()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessageRegExp('/Invalid path/');

        $invalidUri = 'http://example.com///';
        $this->validator->validate($invalidUri);
    }

    /**
     * @test
     */
    public function itShouldBeValidForEmptyPath()
    {
        $validUri = 'http://example.com';
        $actualResult = $this->validator->validate($validUri);

        static::assertTrue($actualResult);
    }
}
