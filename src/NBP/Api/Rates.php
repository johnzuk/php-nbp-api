<?php

namespace NBP\Api;

use DateTimeImmutable;
use NBP\Client;

class Rates extends AbstractApi
{
    protected const PREFIX = '/exchangerates/rates';

    public function code(string $table, string $code): array
    {
        return $this->get([
            self::PREFIX,
            $table,
            $code,
        ]);
    }

    public function last(string $table, string $code, int $topCount): array
    {
        return $this->get([
            self::PREFIX,
            $table,
            $code,
            self::LAST,
            $topCount,
        ]);
    }

    public function today(string $table, string $code): array
    {
        return $this->get([
            self::PREFIX,
            $table,
            $code,
            self::TODAY,
        ]);
    }

    public function date(string $table, string $code, DateTimeImmutable $date): array
    {
        return $this->get([
            self::PREFIX,
            $table,
            $code,
            $date->format(Client::DATE_FORMAT),
        ]);
    }

    public function betweenDate(
        string $table,
        string $code,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate
    ): array {
        return $this->get([
            self::PREFIX,
            $table,
            $code,
            $startDate->format(Client::DATE_FORMAT),
            $endDate->format(Client::DATE_FORMAT),
        ]);
    }
}
