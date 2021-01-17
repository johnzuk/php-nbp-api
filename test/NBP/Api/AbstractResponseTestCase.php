<?php

namespace NBP\Tests\NBP\Api;

use Http\Client\Common\HttpMethodsClientInterface;
use NBP\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractResponseTestCase extends TestCase
{
    /** @var HttpMethodsClientInterface|MockObject */
    protected $client;

    protected function prepareGetMockRequest(string $path): void
    {
        $this
            ->client
            ->method('get')
            ->with($path)
            ->willReturn($this->createResponse());
    }

    protected function setUpClient(): MockObject
    {
        $this->client = $this->createMock(HttpMethodsClientInterface::class);

        $client = $this->createMock(Client::class);
        $client->method('getHttpClient')->willReturn($this->client);

        return $client;
    }

    protected function createResponse(): MockObject
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('getContents')->willReturn('{"table": "table"}');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getHeaderLine')->willReturn('application/json');
        $response->method('getBody')->willReturn($stream);

        return $response;
    }
}
