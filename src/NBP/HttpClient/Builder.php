<?php
namespace NBP\HttpClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;

/**
 * Class Builder
 * @package NBP\HttpClient
 */
class Builder
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var \Http\Message\MessageFactory
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
     * @var HttpClient
     */
    protected $pluginClient;

    /**
     * Builder constructor.
     * @param HttpClient|null $httpClient
     * @param RequestFactory|null $requestFactory
     */
    public function __construct(
        HttpClient $httpClient = null,
        RequestFactory $requestFactory = null
    ) {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * @return HttpMethodsClient
     */
    public function getHttpClient()
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

    /**
     * @param Plugin $plugin
     */
    public function addPlugin(Plugin $plugin)
    {
        $this->plugins[] = $plugin;
        $this->httpClientModified = true;
    }

    /**
     * @param string $className
     */
    public function removePlugin($className)
    {
        foreach ($this->plugins as $idx => $plugin) {
            if ($plugin instanceof $className) {
                unset($this->plugins[$idx]);
                $this->httpClientModified = true;
            }
        }
    }
}