<?php
namespace NBP\Api;

use DateTimeImmutable;
use NBP\Client;

class GoldPrice extends AbstractApi
{
    protected const PREFIX = '/cenyzlota';

    public function price(): array
    {
        return $this->get([
            self::PREFIX,
        ]);
    }

    public function last(int $topCount): array
    {
        return $this->get([
            self::PREFIX,
            self::LAST,
            $topCount,
        ]);
    }

    public function today(): array
    {
        return $this->get([
            self::PREFIX,
            self::TODAY,
        ]);
    }

    public function date(DateTimeImmutable $date): array
    {
        return $this->get([
            self::PREFIX,
            $date->format(Client::DATE_FORMAT),
        ]);
    }

    public function betweenDate(DateTimeImmutable $startDate, DateTimeImmutable $endDate): array
    {
        return $this->get([
            self::PREFIX,
            $startDate->format(Client::DATE_FORMAT),
            $endDate->format(Client::DATE_FORMAT),
        ]);
    }
}
