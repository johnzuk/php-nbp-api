<?php
namespace NBP\Api;

/**
 * Class GoldPrice
 * @package NBP\Api
 */
class GoldPrice extends AbstractApi
{
    /**
     * @return array|string
     */
    public function price()
    {
        return $this->get('cenyzlota');
    }

    /**
     * @param int $topCount
     * @return array|string
     */
    public function last($topCount)
    {
        return $this->get('cenyzlota/last/'.$topCount);
    }

    /**
     * @param \DateTime $date
     * @return array|string
     */
    public function date(\DateTime $date)
    {
        return $this->get('cenyzlota/'.$date->format("Y-m-d"));
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array|string
     */
    public function betweenDate(\DateTime $startDate, \DateTime $endDate)
    {
        return $this->get('cenyzlota/'.$startDate->format("Y-m-d").'/'.$endDate->format('Y-m-d'));
    }
}
