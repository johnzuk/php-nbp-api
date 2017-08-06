<?php
namespace NBP\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use NBP\Exception\BarRequestException;
use NBP\Exception\NotFoundException;
use NBP\Exception\TimeLimitExceededException;
use NBP\HttpClient\Message\ResponseMediator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class NBPExceptionThrower
 * @package NBP\HttpClient\Plugin
 */
class NBPExceptionThrower implements Plugin
{
    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first)
    {
        return $next($request)->then(function (ResponseInterface $response) {
            if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 600) {
                $content = ResponseMediator::getContent($response);

                if ($response->getStatusCode() === 400) {
                    if (stripos($content, 'limit') !== false) {
                        throw new TimeLimitExceededException($content, 400);
                    }

                    throw new BarRequestException($content, 400);
                }

                if ($response->getStatusCode() === 404) {
                    throw new NotFoundException($content, 404);
                }
            }

            return $response;
        });
    }
}
