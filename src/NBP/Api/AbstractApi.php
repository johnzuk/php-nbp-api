<?php
namespace NBP\Api;

use NBP\Client;
use NBP\HttpClient\Message\ResponseMediator;

class AbstractApi implements ApiInterface
{
    protected const LAST = 'last';
    protected const TODAY = 'today';

    private const REQUEST_DELIMITER = '/';
    protected const PREFIX = '';

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function get(array $params): array
    {
        $response = $this->client->getHttpClient()->get(implode(self::REQUEST_DELIMITER, $params));

        return ResponseMediator::getContent($response);
    }
}
