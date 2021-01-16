<?php
namespace NBP\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

class Api implements Plugin
{
    private CONST API = '/api/';

    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $uri = $request->getUri();
        if (strpos($uri->getPath(), self::API) !== 0) {
            $request = $request->withUri($uri->withPath(self::API . $uri->getPath()));
        }

        return $next($request);
    }
}
