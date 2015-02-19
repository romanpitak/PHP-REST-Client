<?php
/**
 * Request
 *
 * @author Roman Piták <roman@pitak.net>
 * @package romanpitak/php-rest-client
 *
 */

namespace RestClient;

/**
 * Class Request
 */
class Request implements IRequest {

    /** @var array Configuration */
    private $config = array();

    /** @var array Default configuration */
    private $defaultConfig = array(
        self::HEADERS_KEY => array(),
        self::CURL_OPTIONS_KEY => array(),
        self::USER_AGENT_KEY => 'Rest Client http://pitak.net',
        self::BASE_URL_KEY => null,
        self::METHOD_KEY => 'GET',
        self::USERNAME_KEY => null,
        self::PASSWORD_KEY => null
    );

    /** @var Response */
    private $response = null;

    /** @var resource Curl resource */
    private $curlResource = null;


    /**
     * @param array $config
     */
    public function __construct($config = array()) {
        $this->setConfig(self::configArrayMergeRecursive($this->defaultConfig, $config));
    }


    /*
     * ========== Execution ==========
     */

    /**
     * Invalidate response
     *
     * Called from the configuration changes.
     *
     */
    private function invalidateResponse() {
        $this->response = null;
    }

    /**
     *    Check response validity
     *
     * If nothing changed since the last response build, the response should be valid.
     * Calls to the setOption and setConfig invalidate the response.
     *
     * @return bool
     */
    private function responseIsValid() {
        return ($this->response instanceof Response);
    }

    /**
     * Did I already create the curl resource?
     *
     * @return bool
     */
    private function curlResourceIsValid() {
        return (!is_null($this->curlResource));
    }

    /**
     * Curl resource service (factory)
     *
     * @param bool $forceNew
     * @return resource
     */
    private function getCurlResource($forceNew = false) {

        if ((true === $forceNew) || (!$this->curlResourceIsValid())) {
            $this->curlResource = curl_init();
        }

        return $this->curlResource;

    }

    /**
     * Build the response object.
     *
     * Builds the response object based on current request configuration.
     *
     * @return Response
     * @throws RequestException
     */
    private function buildResponse() {

        $curlOptions = $this->getBasicCurlOptions();
        $this->addRequestAuth($curlOptions);
        $this->addRequestHeaders($curlOptions);
        $this->addRequestMethod($curlOptions);

        // push options into the resource
        $curlResource = $this->getCurlResource();
        if (!curl_setopt_array($curlResource, $curlOptions)) {
            throw new RequestException('Invalid cURL options');
        }

        // create response
        $response = new Response($curlResource);
        return $response;
    }

    /**
     * Create basic curl options
     *
     * @return array Curl options
     */
    private function getBasicCurlOptions() {
        $curlOptions = $this->getOption(self::CURL_OPTIONS_KEY, array());
        $curlOptions[CURLOPT_HEADER] = true;
        $curlOptions[CURLOPT_RETURNTRANSFER] = true;
        $curlOptions[CURLOPT_USERAGENT] = $this->getOption(self::USER_AGENT_KEY);
        $curlOptions[CURLOPT_URL] = $this->getOption(self::BASE_URL_KEY);
        return $curlOptions;
    }

    /**
     * Add authentication to curl options
     *
     * @param array &$curlOptions
     */
    private function addRequestAuth(&$curlOptions) {
        $username = $this->getOption(self::USERNAME_KEY);
        $password = $this->getOption(self::PASSWORD_KEY);
        if ((!is_null($username)) && (!is_null($password))) {
            $curlOptions[CURLOPT_USERPWD] = sprintf("%s:%s", $username, $password);
        }
    }

    /**
     * Add headers to curl options
     *
     * @param array &$curlOptions
     */
    private function addRequestHeaders(&$curlOptions) {
        // cURL HTTP headers
        $headers = $this->getOption(self::HEADERS_KEY, array());
        // Turn off the Expect header to stop HTTP 100 Continue responses.
        // Response parsing was not handling these headers.
        $curlOptions[CURLOPT_HTTPHEADER][] = "Expect:";
        if (0 < count($headers)) {
            $curlOptions[CURLOPT_HTTPHEADER] = array();
            foreach ($headers as $key => $value) {
                $curlOptions[CURLOPT_HTTPHEADER][] = sprintf("%s:%s", $key, $value);
            }
        }
    }

    /**
     * Add Method to curl options
     *
     * @param array &$curlOptions
     */
    private function addRequestMethod(&$curlOptions) {
        $method = strtoupper($this->getOption(self::METHOD_KEY, 'GET'));
        switch ($method) {
            case 'GET':
                break;
            case 'POST':
                $curlOptions[CURLOPT_POST] = true;
                $curlOptions[CURLOPT_POSTFIELDS] = $this->getOption(self::DATA_KEY, array());
                break;
            default:
                $curlOptions[CURLOPT_CUSTOMREQUEST] = $method;
                $curlOptions[CURLOPT_POSTFIELDS] = $this->getOption(self::DATA_KEY, array());
        }
    }

    /*
     * ========== IRequest ==========
     */

    /**
     * Get the configuration key of the client (request).
     *
     * @param string $key
     * @param mixed $default Default value to return if no value is set.
     * @return mixed Config value.
     */
    public function getOption($key, $default = null) {
        return (isset($this->config[$key]) ? $this->config[$key] : $default);
    }

    /**
     * Returns the response object based on current request configuration.
     *
     * @return IResponse
     * @throws RequestException
     * @throws ResponseException
     */
    public function getResponse() {

        if (!$this->responseIsValid()) {
            $this->response = $this->buildResponse();
        }

        return $this->response;
    }

    /**
     * Merge the current configuration array with the $config array provided.
     *
     * @param array $config Configuration array to be merged with the current configuration.
     * @return array Current configuration array after the merge.
     */
    public function setConfig($config) {
        $this->config = self::configArrayMergeRecursive($this->config, $config);
        $this->invalidateResponse();
        return $this->config;
    }

    /**
     * Set configuration parameter.
     *
     * @param string $key Configuration key
     * @param mixed $value Value
     */
    public function setOption($key, $value) {
        $this->invalidateResponse();
        $this->config[$key] = $value;
    }

    /*
     * ========== Helpers ==========
     */

    /**
     * Merge 2 arrays.
     *
     * A more suitable replacement for array_merge_recursive.
     * Treats all arrays as associative (Does not append numeric keys).
     *
     * @param $array1
     * @param $array2
     * @return array
     */
    private static function configArrayMergeRecursive($array1, $array2) {
        if (is_array($array1) && is_array($array2)) {
            foreach ($array2 as $key => $value) {
                if (isset($array1[$key])) {
                    $array1[$key] = self::configArrayMergeRecursive($array1[$key], $array2[$key]);
                } else {
                    $array1[$key] = $value;
                }
            }
        } else {
            $array1 = $array2;
        }
        return $array1;
    }

}
