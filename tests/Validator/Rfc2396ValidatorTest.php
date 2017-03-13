<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Validator;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Validator\Rfc2396Validator;
use PHPUnit\Framework\TestCase;

class Rfc2396ValidatorTest extends TestCase
{
    /**
     * @var Rfc2396Validator
     */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->validator = new Rfc2396Validator();
    }

    /**
     * @test
     * @dataProvider validUriProvider
     *
     * @param $inputUri
     */
    public function itShouldReturnTrueForValidUrl($inputUri)
    {
        $actualResult = $this->validator->validate($inputUri);
        static::assertTrue($actualResult);
    }

    /**
     * @test
     * @dataProvider invalidUriProvider
     */
    public function itShouldThrowOnInvalidUri($inputUri)
    {
        $this->expectException(ValidatorException::class);

        $this->validator->validate($inputUri);
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
            ['http://foo.com/blah_(wikipedia)#cite-1'],
            ['http://foo.com/blah_(wikipedia)_blah#cite-1'],
            ['http://foo.com/(something)?after=parens'],
            ['http://code.google.com/events/#&product=browser'],
            ['http://j.mp'],
            ['ftp://foo.bar/baz'],
            ['http://foo.bar/?q=Test%20URL-encoded%20stuff'],
            ["http://-.~_!$&'()*+,;=:%40:80%2f::::::@example.com"],
            ['http://1337.net'],
            ['http://a.b-c.de'],
            ['http://223.255.255.254'],
            ['file:///localhost/abc'],
            ['abc://username:password@example.com:123/path/data?key=value&key2=value2#fragid1'],
            ['http://0.0.0.0'],
            ['http://10.1.1.1'],
            ['http://10.1.1.0'],
            ['http://10.1.1.255'],
            ['http://224.1.1.1'],
            ['http://1.1.1.1.1'],
            ['http://123.123.123'],
            ['http://3628126748']
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
            ['http://✪df.ws/123'],
            ['http://⌘.ws'],
            ['http://⌘.ws/'],
            ['http://foo.com/unicode_(✪)_in_parens'],
            ['http://مثال.إختبار'],
            ['http://例子.测试'],
            ['http://उदाहरण.परीक्षा'],
            ['http://☺.damowmow.com/'],
            ['urn:ISBN:0451450523'],
            ['urn:example:mammal:monotreme:echidna'],
            ['http:///a'],
        ];
    }
}
