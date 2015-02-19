<?php
/**
 * IResponse
 *
 * @author Roman Piták <roman@pitak.net>
 * @package romanpitak/php-rest-client
 *
 */

namespace RestClient;

/**
 * Interface IResponse
 */
interface IResponse {

    /**
     * Return the raw curl_exec() output
     *
     * @return string
     */
    public function getReturnedTransfer();

    /**
     * Return the response body
     *
     * @return string
     */
    public function getParsedResponse();

    /**
     * (object)curl_getinfo()
     *
     * @return object
     */
    public function getInfo();

    /**
     * Return a string containing the last error for the current session
     *
     * @return string
     */
    public function getCurlError();

    /**
     * Return the last error number
     *
     * @return int
     */
    public function getCurlErrorNumber();


    /**
     * Get the header key.
     *
     * Get the header key, or the whole header, if the key is null.
     *
     * @param string $key
     * @return mixed
     */
    public function getHeader($key = null);
}
