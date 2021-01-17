<?php

namespace NBP\Tests\NBP\HttpClient\Plugin;

use Http\Client\Promise\HttpFulfilledPromise;
use NBP\Exception\BadRequestException;
use NBP\Exception\NotFoundException;
use NBP\Exception\TimeLimitExceededException;
use NBP\HttpClient\Plugin\NBPExceptionThrower;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class NBPExceptionThrowerTest extends TestCase
{
    public function testHandleRequestWillThrowNotFoundExceptionWhenStatusCodeIsEqualTo404(): void
    {
        $this->expectException(NotFoundException::class);

        $request = new Request('GET', 'https://example.com/api/foo', ['Content-Type' => 'application/json']);

        $verify = function (RequestInterface $request) {
            $this->assertEquals('https://example.com/api/foo', $request->getUri()->__toString());

            return new HttpFulfilledPromise(new Response(404));
        };

        $plugin = new NBPExceptionThrower();
        $plugin->handleRequest($request, $verify, static function() {});
    }

    public function testHandleRequestWillThrowBarRequestExceptionWhenStatusCodeIsEqualTo400(): void
    {
        $this->expectException(BadRequestException::class);

        $request = new Request('GET', 'https://example.com/api/foo', ['Content-Type' => 'application/json']);

        $verify = function (RequestInterface $request) {
            $this->assertEquals('https://example.com/api/foo', $request->getUri()->__toString());

            return new HttpFulfilledPromise(new Response(400));
        };

        $plugin = new NBPExceptionThrower();
        $plugin->handleRequest($request, $verify, static function() {});
    }

    public function testHandleRequestWillThrowTimeLimitExceededExceptionWhenStatusCodeIsEqualTo400AndLimitPresent(): void
    {
        $this->expectException(TimeLimitExceededException::class);

        $request = new Request('GET', 'https://example.com/api/foo', ['Content-Type' => 'application/json']);

        $verify = function (RequestInterface $request) {
            $this->assertEquals('https://example.com/api/foo', $request->getUri()->__toString());
            $body = $this->createMock(StreamInterface::class);
            $body->method('getContents')->willReturn('Przekroczony limit 93 dni');

            $response = $this->createMock(ResponseInterface::class);
            $response->method('getStatusCode')->willReturn(400);
            $response->method('getBody')->willReturn($body);

            return new HttpFulfilledPromise($response);
        };

        $plugin = new NBPExceptionThrower();
        $plugin->handleRequest($request, $verify, static function() {});
    }

    public function testHandleRequestWillReturnProperResponseWhenNoInvalidStatusCode(): void
    {
        $request = new Request('GET', 'https://example.com/api/foo', ['Content-Type' => 'application/json']);

        $verify = function (RequestInterface $request) {
            $this->assertEquals('https://example.com/api/foo', $request->getUri()->__toString());

            return new HttpFulfilledPromise(new Response(201));
        };

        $plugin = new NBPExceptionThrower();
        $response = $plugin->handleRequest($request, $verify, static function() {});

        $response->then(static function(ResponseInterface $response): ResponseInterface {
            static::assertSame(201, $response->getStatusCode());
            return $response;
        });
    }
}
