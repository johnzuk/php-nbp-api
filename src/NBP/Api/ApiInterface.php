<?php
namespace NBP\Api;

use NBP\Client;

/**
 * Interface ApiInterface
 * @package NBP\Api
 */
interface ApiInterface
{
    CONST DATE_FORMAT = 'Y-m-d';

    /**
     * ApiInterface constructor.
     * @param Client $client
     */
    public function __construct(Client $client);
}
