<?php
namespace NBP\Api;

/**
 * Class Rates
 * @package NBP\Api
 */
class Rates extends AbstractApi
{
    /**
     * @param string $table
     * @param string $code
     * @return array|string
     */
    public function code($table, $code)
    {
        return $this->get('exchangerates/rates/'.$table.'/'.$code);
    }

    /**
     * @param string $table
     * @param string $code
     * @param int $topCount
     * @return array|string
     */
    public function last($table, $code, $topCount)
    {
        return $this->get('exchangerates/rates/'.$table.'/'.$code.'/last/'.$topCount);
    }

    /**
     * @param string $table
     * @param string $code
     * @return array|string
     */
    public function today($table, $code)
    {
        return $this->get('exchangerates/rates/'.$table.'/'.$code.'/today/');
    }

    /**
     * @param string $table
     * @param string $code
     * @param \DateTime $date
     * @return array|string
     */
    public function date($table, $code, \DateTime $date)
    {
        return $this->get('exchangerates/rates/'.$table.'/'.$code.'/'.$date->format('Y-m-d'));
    }

    /**
     * @param string $table
     * @param string $code
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array|string
     */
    public function betweenDate($table, $code, \DateTime $startDate, \DateTime $endDate)
    {
        return $this->get(
            'exchangerates/rates/'.$table.
            '/'.$code.'/'.
            $startDate->format('Y-m-d').'/'.
            $endDate->format('Y-m-d')
        );
    }
}
