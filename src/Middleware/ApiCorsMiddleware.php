<?php

declare(strict_types=1);

namespace App\Middleware;

use Cake\Http\Response;
use Cake\Http\ServerRequest;

/**
 * Ensures CORS headers are present on every /api/v1/ response, including
 * exception/error responses that bypass controller beforeFilter.
 */
class ApiCorsMiddleware
{
    /**
     * @param \Cake\Http\ServerRequest $request The request.
     * @param \Cake\Http\Response $response The response.
     * @param callable $next Next middleware.
     * @return \Cake\Http\Response
     */
    public function __invoke(ServerRequest $request, Response $response, $next)
    {
        if (!$this->isApiRequest($request)) {
            return $next($request, $response);
        }

        if (strtoupper($request->getMethod()) === 'OPTIONS') {
            return $this->withCorsHeaders(
                $response
                    ->withStatus(200)
                    ->withType('application/json')
                    ->withStringBody('{"success":true}')
            );
        }

        $response = $next($request, $response);

        return $this->withCorsHeaders($response);
    }

    private function isApiRequest(ServerRequest $request): bool
    {
        $path = $request->getUri()->getPath();

        return strpos($path, '/api/v1/') !== false;
    }

    private function withCorsHeaders(Response $response): Response
    {
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}
