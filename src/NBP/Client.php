<?php

declare(strict_types=1);

namespace NBP;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use NBP\Api\GoldPrice;
use NBP\Api\Rates;
use NBP\Api\Tables;
use NBP\HttpClient\Builder;
use NBP\HttpClient\Plugin\Api;
use NBP\HttpClient\Plugin\NBPExceptionThrower;

class Client
{
    public const DATE_FORMAT = 'Y-m-d';

    private const API_URL = 'http://api.nbp.pl/';

    /**
     * @var Builder
     */
    protected $httpClientBuilder;

    public function __construct(Builder $httpClientBuilder = null)
    {
        $this->httpClientBuilder = $httpClientBuilder ?: new Builder();
        $this->httpClientBuilder->addPlugin(new NBPExceptionThrower());
        $this->httpClientBuilder->addPlugin(new AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri(self::API_URL)));
        $this->httpClientBuilder->addPlugin(new Api());
        $this->httpClientBuilder->addPlugin(new HeaderDefaultsPlugin([
            'Accept' => 'application/json',
            'User-Agent' => 'nbp-api (https://github.com/johnzuk/php-nbp-api)',
        ]));
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->httpClientBuilder->getHttpClient();
    }

    public function tables(): Tables
    {
        return new Tables($this);
    }

    public function rates(): Rates
    {
        return new Rates($this);
    }

    public function goldPrice(): GoldPrice
    {
        return new GoldPrice($this);
    }
}
