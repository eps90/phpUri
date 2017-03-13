<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Silex;

use EPS\PhpUri\Exception\ValidatorException;
use EPS\PhpUri\Factory\ArrayBasedUriFactory;
use EPS\PhpUri\Factory\StringBasedUriFactory;
use EPS\PhpUri\Formatter\UriFormatter;
use EPS\PhpUri\Parser\PhpBuiltInParser;
use EPS\PhpUri\Validator\Rfc3986Validator;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SilexApp extends Application
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->configureApp();
    }

    private function configureApp()
    {
        $app = $this;

        $app->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }
        });
        $app->get('/uri', function (Request $request) use ($app) {
            $requestedUri = $request->request->get('uri');

            if ($requestedUri === null) {
                return new Response('', Response::HTTP_BAD_REQUEST);
            }

            try {
                // @todo inject with Pimple
                $factory = new StringBasedUriFactory(
                    new Rfc3986Validator(),
                    new PhpBuiltInParser()
                );
                $uri = $factory->createUri($requestedUri);

                return $app->json($uri);
            } catch (ValidatorException $exception) {
                return $app->json($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });
        $app->post('/uri', function (Request $request) use ($app) {
            $requestedParts = $request->request->all();
            if (empty($requestedParts)) {
                return new Response('', Response::HTTP_BAD_REQUEST);
            }

            // @todo inject with Pimple
            $factory = new ArrayBasedUriFactory();
            $uri = $factory->createUri($requestedParts);

            $formatter = new UriFormatter();
            $uriFormatted = $formatter->format($uri);

            $responseContent = [
                'uri' => $uriFormatted
            ];

            return $app->json($responseContent, Response::HTTP_CREATED);
        });
        $app->error(function (\Throwable $error, Request $request, $code) {
            if ($code !== 0) {
                $status = $code;
            } else {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            }
            return new Response('', $status);
        });
    }
}
