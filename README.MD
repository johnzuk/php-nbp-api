A PHP wrapper to be used with [NBP (Narodowy Bank Polski) API](http://api.nbp.pl/).
==============

Installation
------------

Via [composer](https://getcomposer.org)

```bash
composer require john_zuk/php-nbp-api php-http/guzzle6-adapter
```

General API Usage
-----------------

```php
$client = \Gitlab\Client::create('http://git.yourdomain.com')
    ->authenticate('your_gitlab_token_here', \Gitlab\Client::AUTH_URL_TOKEN)
;

$project = $client->api('projects')->create('My Project', array(
  'description' => 'This is a project',
  'issues_enabled' => false
));

```