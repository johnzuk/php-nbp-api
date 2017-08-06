<?php
namespace NBP\Tests;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use NBP\HttpClient\Builder;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Builder
     */
    protected $builder;

    public function setUp()
    {
        $this->builder = new Builder(
            $this->getMock(HttpClient::class),
            $this->getMock(RequestFactory::class)
        );
    }

    public function testHttpClientShouldBeHttpMethodsClient()
    {
        $this->assertInstanceOf(HttpMethodsClient::class, $this->builder->getHttpClient());
    }

    public function testAddPluginShouldInvalidateHttpClient()
    {
        $client = $this->builder->getHttpClient();
        $this->builder->addPlugin($this->getMock(Plugin::class));
        $this->assertNotSame($client, $this->builder->getHttpClient());
    }

    public function testRemovePluginShouldInvalidateHttpClient()
    {
        $this->builder->addPlugin($this->getMock(Plugin::class));
        $client = $this->builder->getHttpClient();
        $this->builder->removePlugin(Plugin::class);
        $this->assertNotSame($client, $this->builder->getHttpClient());
    }
}
