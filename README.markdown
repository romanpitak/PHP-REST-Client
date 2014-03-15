PHP REST Client
===============
(c) 2014 Roman Piták, http://pitak.net <roman@pitak.net>

Representational state transfer PHP client library.

Basic Usage
-----------
	<?php

	$client = new Client('http://api.example.com/v2/'); // Use the client to store general settings

	$request = $client->newRequest('hello-world.json'); // Returns a Request object

	$response = $request->getResponse(); // Returns a Response object

	$content = $response->getParsedResponse(); // Returns the response body as a string

	?>

