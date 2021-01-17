<?php

namespace NBP\Tests\NBP\HttpClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use NBP\HttpClient\Builder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    public function testBuilderWillCreateClientInstance(): void
    {
        $builder = new Builder();
        self::assertInstanceOf(HttpMethodsClient::class, $builder->getHttpClient());
    }

    public function testBuilderWillNotCreateNewInstanceWhenNoChangesDone(): void
    {
        $builder = new Builder();
        $client = $builder->getHttpClient();

        self::assertSame($client, $builder->getHttpClient());
    }

    public function testBuilderWillCreateNewInstanceWhenPluginAdded(): void
    {
        $builder = new Builder();
        $client = $builder->getHttpClient();
        /** @var Plugin|MockObject $plugin */
        $plugin = $this->createMock(Plugin::class);
        $builder->addPlugin($plugin);

        self::assertNotSame($client, $builder->getHttpClient());
    }
}
