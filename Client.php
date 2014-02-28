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
 * @method mixed getOption(string $key, mixed $default = null)
 * @method void setOption(string $key, mixed $value)
 * @method array setConfig(array $config);
 */
class Client {

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
	 * ========== Overloading ==========
	 */

	public function __call($name, $arguments) {
		return call_user_func_array(array($this->request, $name), $arguments);
	}

}



