<?php
namespace NBP\HttpClient\Message;

use NBP\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;

class ResponseMediator
{
    public static function getContent(ResponseInterface $response): array
    {
        if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
            $content = json_decode($response->getBody()->getContents(), true);

            if (JSON_ERROR_NONE === json_last_error()) {
                return $content;
            }
        }

        throw new BadResponseException('Invalid response exception. Expected json object format');
    }
}
