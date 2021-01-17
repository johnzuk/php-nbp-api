A PHP wrapper to be used with [NBP (Narodowy Bank Polski) API](http://api.nbp.pl/).
==============

Installation
------------

Via [composer](https://getcomposer.org)

```bash
composer require john_zuk/php-nbp-api guzzlehttp/guzzle:^7.2 http-interop/http-factory-guzzle:^1.0
```

Example API Usage
-----------------

```php
require_once 'vendor/autoload.php';

$client = new \NBP\Client();

$usd = $client->rates()->code('a', 'usd');

echo $usd['rates'][0]['mid'];

```

```bach
php doc/example.php
```
