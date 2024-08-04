<?php

/**
 * NET BULLETIN
 * 
 * By Sam Wilcox <sam@netbulletin.net>
 * https://www.netbulletin.net
 * 
 * This software is released under the MIT license.
 * To view more details, visit:
 * https://license.netbulletin.net
 */

 namespace NetBulletin\Http;

 /**
  * Class Request
  *
  * Handles the incoming data.
  */
 class Request {
    /**
     * The headers collection.
     *
     * @var array
     */
    public $headers;

    /**
     * The body of the request.
     *
     * @var string
     */
    public $body;

    /**
     * The request URI.
     *
     * @var string
     */
    public $uri;

    /**
     * The request method.
     *
     * @var string
     */
    public $method;

    /**
     * Constructor that sets up this class.
     *
     * @param array $headers the headers collection
     * @param string $body the body of the request
     * @param string $uri the request URI
     * @param string $method the request method
     */
    public function __construct($headers = [], $body = '', $uri = '/', $method = 'GET') {
        $this->headers = $headers;
        $this->body = $body;
        $this->uri = $uri;
        $this->method = $method;
    }
 }