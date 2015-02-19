<?php
/**
 * IRequest
 *
 * @author Roman Piták <roman@pitak.net>
 * @package romanpitak/php-rest-client
 *
 */

namespace RestClient;

/**
 * Interface IRequest
 */
interface IRequest {

    const BASE_URL_KEY = 'base_url';
    const CURL_OPTIONS_KEY = 'curl_options';
    const HEADERS_KEY = 'headers';
    const METHOD_KEY = 'method';
    const PASSWORD_KEY = 'password';
    const DATA_KEY = 'data';
    const USER_AGENT_KEY = 'user_agent';
    const USERNAME_KEY = 'username';

    /**
     * Get the configuration key of the client (request).
     *
     * @param string $key
     * @param mixed $default Default value to return if no value is set.
     * @return mixed Config value.
     */
    public function getOption($key, $default = null);

    /**
     * Returns the response object based on current request configuration.
     *
     * @return IResponse
     * @throws RequestException
     * @throws ResponseException
     */
    public function getResponse();

    /*
     * ========== Setters ==========
     */

    /**
     * Merge the current configuration array with the $config array provided.
     *
     * @param array $config Configuration array to be merged with the current configuration.
     * @return array Current configuration array after the merge.
     */
    public function setConfig($config);

    /**
     * Set configuration parameter.
     *
     * @param string $key Configuration key
     * @param mixed $value Value
     */
    public function setOption($key, $value);
}
