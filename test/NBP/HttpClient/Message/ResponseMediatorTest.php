<?php

namespace NBP\Tests\NBP\HttpClient\Message;

use NBP\Exception\BadResponseException;
use NBP\HttpClient\Message\ResponseMediator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseMediatorTest extends TestCase
{
    public function testGetContentThrowBadResponseExceptionWhenJsonContentHeaderMissing(): void
    {
        $this->expectException(BadResponseException::class);
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getHeaderLine')->willReturn('text/html');

        ResponseMediator::getContent($response);
    }

    public function testGetContentThrowBadResponseExceptionWhenContentContainsInvalidJsonObject(): void
    {
        $this->expectException(BadResponseException::class);

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('getContents')->willReturn('invalid json');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getHeaderLine')->willReturn('application/json');
        $response->method('getBody')->willReturn($stream);

        ResponseMediator::getContent($response);
    }

    public function testGetContentWillReturnArrayRepresentationOfJsonResponseContent(): void
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('getContents')->willReturn('{"test": "valid"}');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getHeaderLine')->willReturn('application/json');
        $response->method('getBody')->willReturn($stream);

        self::assertSame(['test' => 'valid'], ResponseMediator::getContent($response));
    }
}
