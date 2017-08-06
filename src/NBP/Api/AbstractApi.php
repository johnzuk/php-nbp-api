<?php
namespace NBP\Api;

use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\StreamFactory;
use NBP\Client;
use NBP\HttpClient\Message\ResponseMediator;

/**
 * Class AbstractApi
 * @package NBP\Api
 */
class AbstractApi implements ApiInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var StreamFactory
     */
    protected $streamFactory;

    /**
     * AbstractApi constructor.
     * @param Client $client
     * @param StreamFactory|null $streamFactory
     */
    public function __construct(Client $client, StreamFactory $streamFactory = null)
    {
        $this->client = $client;
        $this->streamFactory = $streamFactory ?: StreamFactoryDiscovery::find();
    }

    /**
     * @param string $path
     * @param array $requestHeaders
     * @return array|string
     */
    public function get($path, $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->get($path, $requestHeaders);

        return ResponseMediator::getContent($response);
    }
}
