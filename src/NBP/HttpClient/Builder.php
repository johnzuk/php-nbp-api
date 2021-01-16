<?php
namespace NBP\HttpClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class Builder
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * @var bool
     */
    protected $httpClientModified = true;

    /**
     * @var Plugin[]
     */
    protected $plugins = [];

    /**
     * @var HttpMethodsClientInterface
     */
    protected $pluginClient;

    public function __construct(
        HttpClient $httpClient = null,
        RequestFactoryInterface $requestFactory = null
    ) {
        $this->httpClient = $httpClient ?: Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        if ($this->httpClientModified) {
            $this->httpClientModified = false;

            $this->pluginClient = new HttpMethodsClient(
                new PluginClient($this->httpClient, $this->plugins),
                $this->requestFactory
            );
        }

        return $this->pluginClient;
    }

    public function addPlugin(Plugin $plugin): void
    {
        $this->plugins[] = $plugin;
        $this->httpClientModified = true;
    }
}
