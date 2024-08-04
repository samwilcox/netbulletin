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

 namespace NetBulletin\Exceptions;

 /**
  * Class IOException
  *
  * An exception that represents an input/output exception.
  */
 class IOException extends \Exception {
    /**
     * Constructor that sets up this exception.
     *
     * @param string $message the exception message
     */
    public function __construct($message) {
        parent::__construct($message);
    }
 }