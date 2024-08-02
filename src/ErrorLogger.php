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

 namespace NetBulletin;

 /**
  * Class ErrorLogger
  *
  * Logs errors to the database.
  */
 class ErrorLogger {
    /**
     * Logs the message to the database.
     *
     * @param string $message the error message
     * @param array $metadata metadata collection
     * @return void
     */
    public static function log($message, $metadata = null) {

    }
 }