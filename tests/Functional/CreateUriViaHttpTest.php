<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Tests\Functional;

use EPS\PhpUri\Silex\SilexApp;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Client;

class CreateUriViaHttpTest extends TestCase
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
    public function itShouldRespondWith201OnUriCreation()
    {
        $payload = json_encode([
            'scheme' => 'http',
            'authority' => [
                'host' => 'example.com'
            ],
            'path' => '/some/path'
        ]);

        $response = $this->sendJson($payload);

        $expectedStatus = 201;
        $actualStatus = $response->getStatusCode();

        static::assertEquals($expectedStatus, $actualStatus);
    }

    /**
     * @test
     */
    public function itShouldReturnUriConstructedFromParts()
    {
        $payload = json_encode([
            'scheme' => 'http',
            'authority' => [
                'host' => 'example.com'
            ],
            'path' => '/some/path'
        ]);

        $response = $this->sendJson($payload);

        $expectedUri = json_encode('http://example.com/some/path');
        $actualStatus = $response->getContent();

        static::assertEquals($expectedUri, $actualStatus);
    }

    /**
     * @test
     */
    public function itShouldSend400OnEmptyRequest()
    {
        $response = $this->sendJson('');

        $expectedStatus = 400;
        $actualStatus = $response->getStatusCode();

        static::assertEquals($expectedStatus, $actualStatus);
    }

    private function sendJson(string $uriPayload): Response
    {
        $targetUrl = '/uri';
        $this->client->request(
            'POST',
            $targetUrl,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $uriPayload
        );
        return $this->client->getResponse();
    }
}
