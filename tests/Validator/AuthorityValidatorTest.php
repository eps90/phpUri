<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\AuthorityValidator;
use PHPUnit\Framework\TestCase;

class AuthorityValidatorTest extends TestCase
{
    /**
     * @var AuthorityValidator
     */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->validator = new AuthorityValidator();
    }

    /**
     * @test
     */
    public function itShouldReturnTrueForValidAuthority()
    {
        $validAuthorityUri = 'http://user:pass@example.com';

        $actualResult = $this->validator->validate($validAuthorityUri);
        static::assertTrue($actualResult);
    }

    /**
     * @test
     */
    public function itShouldThrowOnInvalidAuthority()
    {
        $this->expectException(ValidatorException::class);

        $invalidAuthorityUri = 'http:// invalid host';
        $this->validator->validate($invalidAuthorityUri);
    }

    /**
     * @test
     */
    public function itShouldReturnTrueForEmptyAuthority()
    {
        $validFileUri = 'file:///etc/hosts';
        $actualResult = $this->validator->validate($validFileUri);

        static::assertTrue($actualResult);
    }
}
