<?php
/**
 * 
 * 
 * @author Roman Piták <roman@pitak.net>
 * 
 */
 
namespace RestClient;

/**
 * Class Client
 * @package RestClient
 */
class Client {

	const BASE_URL_KEY = Request::BASE_URL_KEY;
	const CURL_OPTIONS_KEY = Request::CURL_OPTIONS_KEY;
	const HEADERS_KEY = Request::HEADERS_KEY;
	const METHOD_KEY = Request::METHOD_KEY;
	const PASSWORD_KEY = Request::PASSWORD_KEY;
	const DATA_KEY = Request::DATA_KEY;
	const USER_AGENT_KEY = Request::USER_AGENT_KEY;
	const USERNAME_KEY = Request::USERNAME_KEY;

	private $request;

	public function __construct($config = array()) {
		if (is_string($config)) {
			$config = array(Request::BASE_URL_KEY => $config);
		}
		$this->request = new Request($config);
	}

	/*
	 * ========== New Request ==========
	 */

	/**
	 * @param string $url
	 * @param string $method
	 * @param string $data
	 * @param array $headers
	 * @return Request
	 */
	public function newRequest($url, $method = 'GET', $data = null, $headers = array()) {

		// clone request
		$request = clone $this->request;

		// configure URL
		$baseUrl = rtrim($this->request->getOption(Request::BASE_URL_KEY, ''), '/');
		if ('' != $baseUrl) {
			$url = sprintf("%s/%s", $baseUrl, ltrim($url, '/'));
		}
		$request->setOption(Request::BASE_URL_KEY, $url);

		//throw new Exception($url);

		// method
		$request->setOption(Request::METHOD_KEY, $method);

		// data
		if ((!is_null($data)) && (!empty($data))) {
			$request->setOption(Request::DATA_KEY, $data);
		}

		// headers
		if (!empty($headers)) {
			$request->setOption(Request::HEADERS_KEY, $headers);
		}

		return $request;

	}

	/*
	 * ========== Getters ==========
	 */

	/**
	 * Get the configuration key of the client (request).
	 *
	 * @param string $key
	 * @param mixed $default Default value to return if no value is set.
	 * @return mixed Config value.
	 */
	public function getOption($key, $default = null) {
		return $this->request->getOption($key, $default);
	}

	/*
	 * ========== Setters ==========
	 */

	/**
	 * Set configuration parameter.
	 *
	 * @param string $key Configuration key
	 * @param string $value Value
	 */
	public function setOption($key, $value) {
		$this->request->setOption($key, $value);
	}

	/**
	 * Merge the current configuration array with the $config array provided.
	 *
	 * @param array $config Configuration array to be merged with the current configuration.
	 * @return array Current configuration array after the merge.
	 */
	public function setConfig($config) {
		return $this->request->setConfig($config);
	}

}



