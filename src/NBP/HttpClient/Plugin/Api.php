<?php
namespace NBP\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;

/**
 * Class Api
 * @package NBP\HttpClient\Plugin
 */
class Api implements Plugin
{
    CONST API = '/api/';

    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first)
    {
        $uri = $request->getUri();
        if (substr($uri->getPath(), 0, strlen(self::API)) !== self::API) {
            $request = $request->withUri($uri->withPath(self::API.$uri->getPath()));
        }

        return $next($request);
    }
}
