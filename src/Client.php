<?php
/**
 * Client
 * 
 * @author Roman Piták <roman@pitak.net>
 * @package romanpitak/php-rest-client
 *
 */
 
namespace RestClient;

/**
 * Class Client
 */
class Client implements IClient {

	private $request;

	public function __construct($config = array()) {
		if (is_string($config)) {
			$config = array(self::BASE_URL_KEY => $config);
		}
		$this->request = new Request($config);
	}

	/*
	 * ========== IRequest ==========
	 */

	public function newRequest($url, $method = 'GET', $data = null, $headers = array()) {

		// clone request
		$request = clone $this->request;

		// configure URL
		$baseUrl = rtrim($this->request->getOption(self::BASE_URL_KEY, ''), '/');
		if ('' != $baseUrl) {
			$url = sprintf("%s/%s", $baseUrl, ltrim($url, '/'));
		}
		$request->setOption(self::BASE_URL_KEY, $url);

		//throw new Exception($url);

		// method
		$request->setOption(self::METHOD_KEY, $method);

		// data
		if ((!is_null($data)) && (!empty($data))) {
			$request->setOption(self::DATA_KEY, $data);
		}

		// headers
		if (!empty($headers)) {
			$request->setOption(self::HEADERS_KEY, $headers);
		}

		return $request;

	}

	public function getOption($key, $default = null) {
		return $this->request->getOption($key, $default);
	}

	public function setOption($key, $value) {
		$this->request->setOption($key, $value);
	}

	public function setConfig($config) {
		return $this->request->setConfig($config);
	}

}



