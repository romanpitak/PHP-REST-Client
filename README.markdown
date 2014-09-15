# PHP REST Client
[![Latest Stable Version](https://poser.pugx.org/romanpitak/php-rest-client/v/stable.svg)](https://packagist.org/packages/romanpitak/php-rest-client) [![Total Downloads](https://poser.pugx.org/romanpitak/php-rest-client/downloads.svg)](https://packagist.org/packages/romanpitak/php-rest-client) [![Latest Unstable Version](https://poser.pugx.org/romanpitak/php-rest-client/v/unstable.svg)](https://packagist.org/packages/romanpitak/php-rest-client) [![License](https://poser.pugx.org/romanpitak/php-rest-client/license.svg)](https://packagist.org/packages/romanpitak/php-rest-client)

(c) 2014 Roman Piták, http://pitak.net <roman@pitak.net>

Representational state transfer PHP client library.

## Basic Usage

```
<?php

$client = new Client('http://api.example.com/v2/'); // Use the client to store general settings

$request = $client->newRequest('hello-world.json'); // Returns a Request object

$response = $request->getResponse(); // Returns a Response object

$content = $response->getParsedResponse(); // Returns the response body as a string
```
