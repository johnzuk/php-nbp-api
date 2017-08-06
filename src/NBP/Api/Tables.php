<?php
namespace NBP\Api;

/**
 * Class Tables
 * @package NBP\Api
 */
class Tables extends AbstractApi
{
    /**
     * @param string $table
     * @return array|string
     */
    public function table($table)
    {
        return $this->get('exchangerates/tables/'.$table.'/');
    }

    /**
     * @param string $table
     * @param int $topCount
     * @return array|string
     */
    public function last($table, $topCount)
    {
        return $this->get('exchangerates/tables/'.$table.'/last/'.$topCount);
    }

    /**
     * @param string $table
     * @return array|string
     */
    public function today($table)
    {
        return $this->get('exchangerates/tables/'.$table.'/today');
    }

    /**
     * @param string $table
     * @param \DateTime $date
     * @return array|string
     */
    public function date($table, \DateTime $date)
    {
        return $this->get('exchangerates/tables/'.$table.'/'.$date->format('Y-m-d'));
    }

    /**
     * @param string $table
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array|string
     */
    public function betweenDate($table, \DateTime $startDate, \DateTime $endDate)
    {
        return $this->get(
            'exchangerates/tables/'.$table.'/'.
            $startDate->format('Y-m-d').'/'.
            $endDate->format('Y-m-d')
        );
    }
}