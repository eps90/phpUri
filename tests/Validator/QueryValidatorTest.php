<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\QueryValidator;
use PHPUnit\Framework\TestCase;

class QueryValidatorTest extends TestCase
{
    /**
     * @var QueryValidator
     */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->validator = new QueryValidator();
    }

    /**
     * @test
     */
    public function itShouldReturnTrueForValidQuery()
    {
        $query = 'http://example.com/some/path?q=1&q=2';
        $actualResult = $this->validator->validate($query);

        static::assertTrue($actualResult);
    }

    /**
     * @test
     */
    public function itShouldThrowOnInvalidQuery()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessageRegExp('/Invalid query/');

        $query = 'http://example.com/some/path?q[0]=3';
        $this->validator->validate($query);
    }

    /**
     * @test
     */
    public function itShouldBeValidForEmptyQuery()
    {
        $validUri = 'http://example.com/some/path#Fragment';
        $actualResult = $this->validator->validate($validUri);

        static::assertTrue($actualResult);
    }
}
