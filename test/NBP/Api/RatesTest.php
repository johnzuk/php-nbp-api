<?php

namespace NBP\Tests\NBP\Api;

use DateTimeImmutable;
use NBP\Api\Rates;
use NBP\Client;

class RatesTest extends AbstractResponseTestCase
{
    /** @var Rates */
    private $rates;

    public function setUp(): void
    {
        /** @var Client $client */
        $client = $this->setUpClient();

        $this->rates = new Rates($client);
    }

    public function testCodeWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/exchangerates/rates/A/USD');
        self::assertSame(['table' => 'table'], $this->rates->code('A', 'USD'));
    }

    public function testLastWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/exchangerates/rates/A/USD/last/5');
        self::assertSame(['table' => 'table'], $this->rates->last('A', 'USD', 5));
    }

    public function testTodayWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/exchangerates/rates/A/USD/today');
        self::assertSame(['table' => 'table'], $this->rates->today('A', 'USD'));
    }

    public function testDateWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/exchangerates/rates/A/USD/2000-01-01');
        self::assertSame(['table' => 'table'], $this->rates->date('A', 'USD', new DateTimeImmutable('2000-01-01')));
    }

    public function testBetweenDateWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/exchangerates/rates/A/USD/2000-01-01/2000-02-01');
        self::assertSame(
            ['table' => 'table'],
            $this->rates->betweenDate('A', 'USD', new DateTimeImmutable('2000-01-01'), new DateTimeImmutable('2000-02-01'))
        );
    }
}
