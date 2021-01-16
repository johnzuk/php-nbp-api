<?php
namespace NBP\Api;

use NBP\Client;

interface ApiInterface
{
    public function __construct(Client $client);
}
