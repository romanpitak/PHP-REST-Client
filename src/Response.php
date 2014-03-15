<?php
/**
 * Response
 *
 * @author Roman Piták <roman@pitak.net>
 * @package romanpitak/php-rest-client
 *
 */

namespace RestClient;

/**
 * Class Response
 */
class Response implements IResponse {

	/** @var  resource */
	private $curlResource;

	/** @var string */
	private $returnedTransfer = '';

	/** @var object $info */
	private $info;

	/** @var array */
	private $headers = array();

	/** @var string  */
	private $parsedResponse = '';

	/** @var array  */
	private $config = array();


	/**
	 *
	 * @param array $curlResource
	 * @throws ResponseException
	 */
	public function __construct($curlResource) {

		$this->curlResource = $curlResource;

		// execute
		$this->returnedTransfer = curl_exec($this->curlResource);
		if (false === $this->returnedTransfer) {
			throw new ResponseException(sprintf("CURL ERROR #%s: %s", $this->getCurlErrorNumber(), $this->getCurlError()));
		}
		$this->info = (object)curl_getinfo($this->curlResource);

		// parse response
		$token = "\n";
		strtok($this->returnedTransfer, $token);
		while (0 < strlen(trim($line = strtok($token)))) {
			list($key, $value) = explode(':', $line, 2);
			$key = trim(strtolower(str_replace('-', '_', $key)));
			$value = trim($value);
			if (empty($this->headers[$key]))
				$this->headers[$key] = $value;
			elseif (is_array($this->headers[$key]))
				$this->headers[$key][] = $value;
			else
				$this->headers[$key] = array($this->headers[$key], $value);
		}
		$this->parsedResponse = strtok("");

	}

	/*
	 * ========== IResponse ==========
	 */

	public function getReturnedTransfer() {
		return $this->returnedTransfer;
	}

	public function getParsedResponse() {
		return $this->parsedResponse;
	}

	public function getInfo() {
		return $this->info;
	}

	public function getCurlError() {
		return curl_error($this->curlResource);
	}

	public function getCurlErrorNumber() {
		return curl_errno($this->curlResource);
	}

}