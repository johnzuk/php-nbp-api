<?php
namespace NBP\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use NBP\Exception\BadRequestException;
use NBP\Exception\NotFoundException;
use NBP\Exception\TimeLimitExceededException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class NBPExceptionThrower implements Plugin
{
    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(static function (ResponseInterface $response): ResponseInterface {
            $statusCode = $response->getStatusCode();

            if ($statusCode >= 400 && $statusCode < 600) {
                $content = $response->getBody()->getContents();

                if ($response->getStatusCode() === 400) {
                    if (stripos($content, 'limit') !== false) {
                        throw new TimeLimitExceededException($content, 400);
                    }

                    throw new BadRequestException($content, 400);
                }

                if ($response->getStatusCode() === 404) {
                    throw new NotFoundException($content, 404);
                }
            }

            return $response;
        });
    }
}
