PHP REST Client
===============
(c) 2014 Roman Piták <roman@pitak.net>

Representational state transfer PHP client library.

Basic Usage
-----------
	<?php

	$client = new Client('http://api.example.com/v2/'); // Use the client to sore general settings

	$request = $client->newRequest('hello-world.json'); // Returns a Request object

	$response = $request->getResponse(); // Returns a Response object

	$content = $response->getParsedResponse(); // Returns the response body as a string

	?>

TODO
----
encoding post data (now it is only possible to send an already encoded string)

response decoding (json -> array etc.)

License
-------

Copyright (c) 2014 Roman Piták <roman@pitak.net>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
