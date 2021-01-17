<?php

namespace NBP\Tests\NBP\Api;

use DateTimeImmutable;
use NBP\Api\GoldPrice;
use NBP\Client;

class GoldPriceTest extends AbstractResponseTestCase
{
    /** @var GoldPrice */
    private $goldPrice;

    public function setUp(): void
    {
        /** @var Client $client */
        $client = $this->setUpClient();

        $this->goldPrice = new GoldPrice($client);
    }

    public function testPriceWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/cenyzlota');
        self::assertSame(['table' => 'table'], $this->goldPrice->price());
    }

    public function testLastWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/cenyzlota/last/5');
        self::assertSame(['table' => 'table'], $this->goldPrice->last(5));
    }

    public function testTodayWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/cenyzlota/today');
        self::assertSame(['table' => 'table'], $this->goldPrice->today());
    }

    public function testDateWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/cenyzlota/2000-01-01');
        self::assertSame(['table' => 'table'], $this->goldPrice->date(new DateTimeImmutable('2000-01-01')));
    }

    public function testBetweenDateWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/cenyzlota/2000-01-01/2000-02-01');
        self::assertSame(['table' => 'table'], $this->goldPrice->betweenDate(new DateTimeImmutable('2000-01-01'), new DateTimeImmutable('2000-02-01')));
    }
}
