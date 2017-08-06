<?php
namespace NBP;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\HttpClient;
use Http\Discovery\UriFactoryDiscovery;
use NBP\Api\GoldPrice;
use NBP\Api\Rates;
use NBP\Api\Tables;
use NBP\HttpClient\Builder;
use NBP\HttpClient\Plugin\Api;
use NBP\HttpClient\Plugin\NBPExceptionThrower;

/**
 * Class Client
 * @package NBP
 */
class Client
{
    /**
     * @var Builder
     */
    protected $httpClientBuilder;

    /**
     * Client constructor.
     * @param Builder|null $httpClientBuilder
     */
    public function __construct(Builder $httpClientBuilder = null)
    {
        $this->httpClientBuilder = $httpClientBuilder ?: new Builder();
        $this->httpClientBuilder->addPlugin(new NBPExceptionThrower());
        $this->httpClientBuilder->addPlugin(new Api());
        $this->httpClientBuilder->addPlugin(new HeaderDefaultsPlugin([
            'Accept' => 'application/json',
            'User-Agent' => 'nbp-api (https://github.com/johnzuk/php-nbp-api)',
        ]));

        $this->setUrl('http://api.nbp.pl/');
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->httpClientBuilder->removePlugin(AddHostPlugin::class);
        $this->httpClientBuilder->addPlugin(new AddHostPlugin(UriFactoryDiscovery::find()->createUri($url)));

        return $this;
    }

    /**
     * Create a Gitlab\Client using an url.
     *
     * @param string $url
     *
     * @return Client
     */
    public static function create($url)
    {
        $client = new self();
        $client->setUrl($url);

        return $client;
    }

    /**
     * Create a Gitlab\Client using an HttpClient.
     *
     * @param HttpClient $httpClient
     *
     * @return Client
     */
    public static function createWithHttpClient(HttpClient $httpClient)
    {
        $builder = new Builder($httpClient);
        return new self($builder);
    }

    /**
     * @return HttpMethodsClient
     */
    public function getHttpClient()
    {
        return $this->httpClientBuilder->getHttpClient();
    }

    /**
     * @return Tables
     */
    public function tables()
    {
        return new Tables($this);
    }

    /**
     * @return Rates
     */
    public function rates()
    {
        return new Rates($this);
    }

    /**
     * @return GoldPrice
     */
    public function goldPrice()
    {
        return new GoldPrice($this);
    }
}
