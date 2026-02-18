<?php

declare(strict_types=1);

namespace App\Middleware;

use Cake\Http\Response;
use Cake\Http\ServerRequest;

/**
 * Redirects when the URL has the application base path duplicated (e.g. /cake3app/cake3app/admin/...).
 * Fixes "Controller class Cake3app could not be found" when users hit a doubled path.
 *
 * Uses CakePHP 3.x middleware signature: __invoke(request, response, next).
 */
class FixDuplicateBasePathMiddleware
{
    /**
     * @param \Cake\Http\ServerRequest $request The request.
     * @param \Cake\Http\Response $response The response.
     * @param callable $next Next middleware.
     * @return \Cake\Http\Response
     */
    public function __invoke(ServerRequest $request, Response $response, $next)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        // Detect duplicated segment: /cake3app/cake3app/ -> redirect to /cake3app/
        if (preg_match('#^/([^/]+)/\1/#', $path, $m)) {
            $segment = $m[1];
            $fixedPath = preg_replace('#^/' . preg_quote($segment, '#') . '/' . preg_quote($segment, '#') . '#', '/' . $segment, $path);
            
            // Build absolute URL with scheme, host, fixed path, query string, and fragment
            $scheme = $uri->getScheme();
            $host = $uri->getHost();
            $port = $uri->getPort();
            $query = $uri->getQuery();
            $fragment = $uri->getFragment();
            
            $redirectUrl = $scheme . '://' . $host;
            if ($port && (($scheme === 'http' && $port !== 80) || ($scheme === 'https' && $port !== 443))) {
                $redirectUrl .= ':' . $port;
            }
            $redirectUrl .= $fixedPath;
            if ($query) {
                $redirectUrl .= '?' . $query;
            }
            if ($fragment) {
                $redirectUrl .= '#' . $fragment;
            }

            return $response->withStatus(302)->withHeader('Location', $redirectUrl);
        }

        return $next($request, $response);
    }
}
