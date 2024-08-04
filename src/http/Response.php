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
  * Class Response
  *
  * Handles the response out.
  */
 class Response {
    /**
     * The body of the response.
     *
     * @var string
     */
    public $body;

    /**
     * The HTTP status code.
     *
     * @var int
     */
    public $statusCode;

    /**
     * Constructor that sets up this class.
     *
     * @param string $body the body of the response
     * @param integer $statusCode the status code
     */
    public function __construct($body, $statusCode = 200) {
        $this->body = $body;
        $this->statusCode = $statusCode;
    }
 }