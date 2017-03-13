<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Functional;

use EPS\PhpUri\Silex\SilexApp;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Client;

class ValidateViaHttpTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        parent::setUp();

        $app = new SilexApp();
        $app['debug'] = false;
        unset($app['exception_handler']);

        $this->client = new Client($app);
    }

    /**
     * @test
     */
    public function itShouldReturn200OnSuccessfulValidation()
    {
        $payload = json_encode([
            'uri' => 'http://example.com/some/path'
        ]);
        $response = $this->sendJson($payload);

        static::assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function itShouldReturnUriPartsOnSuccess()
    {
        $payload = json_encode([
            'uri' => 'http://example.com/some/path'
        ]);
        $response = $this->sendJson($payload);

        $expectedResponse = json_encode([
            'scheme' => 'http',
            'authority' => [
                'host' => 'example.com'
            ],
            'path' => '/some/path'
        ]);
        $actualResponse = $response->getContent();

        static::assertJsonStringEqualsJsonString($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldReturn400OnInvalidRequest()
    {
        $invalidPayload = json_encode([
            'invalid_param' => 'http://example.com'
        ]);
        $response = $this->sendJson($invalidPayload);

        $expectedStatus = 400;
        $actualStatus = $response->getStatusCode();

        static::assertEquals($expectedStatus, $actualStatus);
    }

    /**
     * @test
     */
    public function itShouldResponseWithEmptyStringOnBadRequest()
    {
        $invalidPayload = json_encode([
            'invalid_param' => 'http://example.com'
        ]);
        $response = $this->sendJson($invalidPayload);

        static::assertEmpty($response->getContent());
    }

    /**
     * @test
     */
    public function itShouldReturn422StatusOnFailedValidation()
    {
        $invalidUriPayload = json_encode([
            'uri' => 'http:// wrong host'
        ]);
        $response = $this->sendJson($invalidUriPayload);

        $expectedStatus = 422;
        $actualStatus = $response->getStatusCode();

        static::assertEquals($expectedStatus, $actualStatus);
    }

    /**
     * @test
     */
    public function itShouldIncludeValidationFailureReasonInResponse()
    {
        $invalidUriPayload = json_encode([
            'uri' => 'http:// wrong host'
        ]);
        $response = $this->sendJson($invalidUriPayload);

        $expectedMessagePattern = 'Invalid authority';

        static::assertContains($expectedMessagePattern, $response->getContent());
    }

    private function sendJson(string $uriPayload): Response
    {
        $targetUrl = '/uri';
        $this->client->request(
            'GET',
            $targetUrl,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $uriPayload
        );
        return $this->client->getResponse();
    }
}
