<?php

require_once 'vendor/autoload.php';

$client = new \NBP\Client();
var_dump($client->tables()->table('A'));
