# PHP REST Client

[![Latest Stable Version](https://img.shields.io/packagist/v/romanpitak/php-rest-client.svg)](https://packagist.org/packages/romanpitak/php-rest-client)
[![Total Downloads](https://img.shields.io/packagist/dt/romanpitak/php-rest-client.svg)](https://packagist.org/packages/romanpitak/php-rest-client)
[![License](https://img.shields.io/packagist/l/romanpitak/php-rest-client.svg)](https://packagist.org/packages/romanpitak/php-rest-client)
[![Code Climate](https://codeclimate.com/github/romanpitak/PHP-REST-Client/badges/gpa.svg)](https://codeclimate.com/github/romanpitak/PHP-REST-Client)
[![Codacy Badge](https://www.codacy.com/project/badge/ef4f59187cd74edaaac0714bd5aebabd)](https://www.codacy.com/public/roman/PHP-REST-Client)

(c) 2014-2015 Roman Piták, http://pitak.net <roman@pitak.net>

Representational state transfer PHP client library.

## Installation

The best way to install is to use the [Composer](https://getcomposer.org/) dependency manager.

```
php composer.phar require romanpitak/php-rest-client
```

## Basic Usage

```php
$client = new Client('https://raw.githubusercontent.com/romanpitak');

$request = $client->newRequest('/PHP-REST-Client/master/README.md');

$response = $request->getResponse();

echo $response->getParsedResponse();
```
