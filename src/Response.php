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

	/**
	 *
	 * @param resource $curlResource
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
		$line = strtok($this->returnedTransfer, $token);

		if (stripos($line, ' 100 Continue') !== false && stripos($line, 'HTTP') === 0) {
			while (0 < strlen(trim($line = strtok($token)))) { }
			strtok($token); // also slip next HTTP TAG
		}

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

    /**
     * Return the raw curl_exec() output
     *
     * @return string
     */
	public function getReturnedTransfer() {
		return $this->returnedTransfer;
	}

    /**
     * Return the response body
     *
     * @return string
     */
	public function getParsedResponse() {
		return $this->parsedResponse;
	}

    /**
     * (object)curl_getinfo()
     *
     * @return object
     */
	public function getInfo() {
		return $this->info;
	}

    /**
     * Return a string containing the last error for the current session
     *
     * @return string
     */
	public function getCurlError() {
		return curl_error($this->curlResource);
	}

    /**
     * Return the last error number
     *
     * @return int
     */
	public function getCurlErrorNumber() {
		return curl_errno($this->curlResource);
	}

    /**
     * Get the header key.
     *
     * Get the header key, or the whole header, if the key is null.
     *
     * @param string $key
     * @return mixed
     */
	public function getHeader($key = null) {
		if ($key === null) {
			$this->headers;
		} else if (isset($this->headers[$key])) {
			return $this->headers[$key];
		}
		return null;
	}
}
