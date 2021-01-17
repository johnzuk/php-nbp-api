<?php
namespace NBP\Api;

use DateTimeImmutable;
use NBP\Client;

class Tables extends AbstractApi
{
    protected const PREFIX = '/exchangerates/tables';

    public function table(string $table): array
    {
        return $this->get([
            self::PREFIX,
            $table,
        ]);
    }

    public function last(string $table, int $topCount): array
    {
        return $this->get([
            self::PREFIX,
            $table,
            self::LAST,
            $topCount,
        ]);
    }

    public function today(string $table): array
    {
        return $this->get([
            self::PREFIX,
             $table,
            self::TODAY,
        ]);
    }

    public function date(string $table, DateTimeImmutable $date): array
    {
        return $this->get([
            self::PREFIX,
            $table,
            $date->format(Client::DATE_FORMAT)
        ]);
    }

    public function betweenDate(string $table, DateTimeImmutable $startDate, DateTimeImmutable $endDate): array
    {
        return $this->get([
            self::PREFIX,
            $table,
            $startDate->format(Client::DATE_FORMAT),
            $endDate->format(Client::DATE_FORMAT),
        ]);
    }
}
