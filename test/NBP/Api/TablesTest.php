<?php

namespace NBP\Tests\NBP\Api;

use DateTimeImmutable;
use NBP\Api\Tables;
use NBP\Client;

class TablesTest extends AbstractResponseTestCase
{
    /** @var Tables */
    private $tables;

    public function setUp(): void
    {
        /** @var Client $client */
        $client = $this->setUpClient();

        $this->tables = new Tables($client);
    }

    public function testTableWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/exchangerates/tables/A');
        self::assertSame(['table' => 'table'], $this->tables->table('A'));
    }

    public function testLastWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/exchangerates/tables/A/last/5');
        self::assertSame(['table' => 'table'], $this->tables->last('A', 5));
    }

    public function testTodayWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/exchangerates/tables/A/today');
        self::assertSame(['table' => 'table'], $this->tables->today('A'));
    }

    public function testDateWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/exchangerates/tables/A/2000-01-01');
        self::assertSame(['table' => 'table'], $this->tables->date('A', new DateTimeImmutable('2000-01-01')));
    }

    public function testBetweenDateWillReturnActualTable(): void
    {
        $this->prepareGetMockRequest('/exchangerates/tables/A/2000-01-01/2000-02-01');

        self::assertSame(
            ['table' => 'table'],
            $this->tables->betweenDate('A', new DateTimeImmutable('2000-01-01'), new DateTimeImmutable('2000-02-01'))
        );
    }
}
