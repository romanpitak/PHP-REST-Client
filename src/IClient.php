<?php
/**
 * IClient
 *
 * @author Roman Piták <roman@pitak.net>
 * @package romanpitak/php-rest-client
 *
 */

namespace RestClient;

/**
 * Interface IClient
 */
interface IClient {

    const BASE_URL_KEY = IRequest::BASE_URL_KEY;
    const CURL_OPTIONS_KEY = IRequest::CURL_OPTIONS_KEY;
    const HEADERS_KEY = IRequest::HEADERS_KEY;
    const METHOD_KEY = IRequest::METHOD_KEY;
    const PASSWORD_KEY = IRequest::PASSWORD_KEY;
    const DATA_KEY = IRequest::DATA_KEY;
    const USER_AGENT_KEY = IRequest::USER_AGENT_KEY;
    const USERNAME_KEY = IRequest::USERNAME_KEY;

    /**
     * @param string $url
     * @param string $method
     * @param string $data
     * @param array $headers
     * @return IRequest
     */
    public function newRequest($url, $method = 'GET', $data = null, $headers = array());

    /**
     * Get the configuration key of the client (request).
     *
     * @param string $key
     * @param mixed $default Default value to return if no value is set.
     * @return mixed Config value.
     */
    public function getOption($key, $default = null);

    /**
     * Set configuration parameter.
     *
     * @param string $key Configuration key
     * @param string $value Value
     */
    public function setOption($key, $value);

    /**
     * Merge the current configuration array with the $config array provided.
     *
     * @param array $config Configuration array to be merged with the current configuration.
     * @return array Current configuration array after the merge.
     */
    public function setConfig($config);
}
