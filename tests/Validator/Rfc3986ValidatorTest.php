<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\Rfc3986Validator;
use PHPUnit\Framework\TestCase;

class Rfc3986ValidatorTest extends TestCase
{
    /**
     * @var Rfc3986Validator
     */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->validator = new Rfc3986Validator();
    }

    /**
     * @test
     * @dataProvider validUriProvider
     */
    public function itShouldReturnTrueForValidUri(string $uriCandidate)
    {
        $actualResult = $this->validator->validate($uriCandidate);
        static::assertTrue($actualResult, $uriCandidate);
    }

    /**
     * @test
     * @dataProvider invalidUriProvider
     */
    public function itShouldReturnFalseForInvalidUri(string $uriCandidate)
    {
        $this->expectException(ValidatorException::class);

        $actualResult = $this->validator->validate($uriCandidate);
        static::assertFalse($actualResult, $uriCandidate);
    }

    public function validUriProvider()
    {
        return [
            ['http://foo.com/blah_blah'],
            ['http://foo.com/blah_blah/'],
            ['http://foo.com/blah_blah_(wikipedia)'],
            ['http://foo.com/blah_blah_(wikipedia)_(again)'],
            ['http://www.example.com/wpstyle/?p=364'],
            ['https://www.example.com/foo/?bar=baz&inga=42&quux'],
            ['http://✪df.ws/123'],
            ['http://userid:password@example.com:8080'],
            ['http://userid:password@example.com:8080/'],
            ['http://userid@example.com'],
            ['http://userid@example.com/'],
            ['http://userid@example.com:8080'],
            ['http://userid@example.com:8080/'],
            ['http://userid:password@example.com'],
            ['http://userid:password@example.com/'],
            ['http://142.42.1.1/'],
            ['http://142.42.1.1:8080/'],
            ['http://➡.ws/䨹'],
            ['http://⌘.ws'],
            ['http://⌘.ws/'],
            ['http://foo.com/blah_(wikipedia)#cite-1'],
            ['http://foo.com/blah_(wikipedia)_blah#cite-1'],
            ['http://foo.com/unicode_(✪)_in_parens'],
            ['http://foo.com/(something)?after=parens'],
            ['http://☺.damowmow.com/'],
            ['http://code.google.com/events/#&product=browser'],
            ['http://j.mp'],
            ['ftp://foo.bar/baz'],
            ['http://foo.bar/?q=Test%20URL-encoded%20stuff'],
            ['http://مثال.إختبار'],
            ['http://例子.测试'],
            ['http://उदाहरण.परीक्षा'],
            ["http://-.~_!$&'()*+,;=:%40:80%2f::::::@example.com"],
            ['http://1337.net'],
            ['http://a.b-c.de'],
            ['http://223.255.255.254'],
            ['file:///localhost/abc'],
            ['urn:isbn:0451450523'],
            ['urn:example:mammal:monotreme:echidna'],
            ['abc://username:password@example.com:123/path/data?key=value&key2=value2#fragid1'],
            ['http:///a'],
            ['http://0.0.0.0'],
            ['http://10.1.1.1'],
            ['http://10.1.1.0'],
            ['http://10.1.1.255'],
            ['http://224.1.1.1'],
            ['http://1.1.1.1.1'],
            ['http://123.123.123'],
            ['http://3628126748'],
        ];
    }

    public function invalidUriProvider()
    {
        return [
            ['http://foo.bar?q=Spaces should be encoded'],
            ['//'],
            ['//a'],
            ['///a'],
            ['///'],
            ['foo.com'],
            ['http:// shouldfail.com'],
            [':// should fail'],
            ['http://foo.bar/foo(bar)baz quux'],
        ];
    }
}
