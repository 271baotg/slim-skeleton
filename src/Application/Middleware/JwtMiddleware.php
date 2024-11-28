<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Domain\SecurityException\UnauthorizedException;
use Firebase\JWT\Key;

class JwtMiddleware implements Middleware
{
    // The secret key to sign the JWT, typically stored in an environment variable

    private string $secretKey;
    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function getSecretKey(): string
    {
        return $this->secretKey;
    }
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // Skip the JWT middleware for the excluded paths
        $excludedPaths = ['/auth/login', '/auth/register'];

        if (in_array($request->getUri()->getPath(), $excludedPaths)) {
            return $handler->handle($request);
        }
        error_log('Request Path: ' . $request->getUri()->getPath());

        // Check if the Authorization header is set
        $authHeader = $request->getHeaderLine('Authorization');

        // If Authorization header is not present, return an unauthorized response
        if (!$authHeader) {
            return $this->unauthorizedResponse($request);
        }

        // Extract the token from the Authorization header (Bearer token)
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        } else {
            return $this->unauthorizedResponse($request);
        }

        try {
            // Decode the JWT
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            $request = $request->withAttribute('user', (array) $decoded);
        } catch (\Exception $e) {
            return $this->unauthorizedResponse($request);
        }

        // Proceed with the request handling
        return $handler->handle($request);
    }

    /**
     * Generates an unauthorized response.
     *
     * @param string|null $message
     * @return Response
     */
    private function unauthorizedResponse(Request $request)
    {
        // $response = new \Slim\Psr7\Response();
        // $response->getBody()->write(json_encode(['error' => $message]));

        // return $response
        //     ->withStatus(401)
        //     ->withHeader('Content-Type', 'application/json');

        throw new UnauthorizedException($request);
    }
}
