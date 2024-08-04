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

namespace NetBulletin\Helpers;

/**
 * Class IncomingHelper
 * 
 * Helper methods for getting incoming data.
 */
class IncomingHelper {
    /**
     * Retrieves and sanitizes GET data.
     *
     * @param string $key the key of the GET parameter to retrieve
     * @param string $filter the filtr to apply (e.g., FILTER_SANITIZE_STRING)
     * @return mixed the sanitized GET parameter value
     */
    public static function get($key, $filter = FILTER_SANITIZE_STRING) {
        return isset($_GET[$key]) ? filter_var($_GET[$key], $filter) : null;
    }

    /**
     * Retrieves and sanitizes POST data.
     *
     * @param string $key the key of the POST parameter to retrieve
     * @param string $filter the filtr to apply (e.g., FILTER_SANITIZE_STRING)
     * @return mixed the sanitized POST parameter value
     */
    public static function post($key, $filter = FILTER_SANITIZE_STRING) {
        return isset($_POST[$key]) ? filter_var($_POST[$key], $filter) : null;
    }

    /**
     * Retrieves and sanitizes all GET data.
     *
     * @param array $filters associative array of keys and filters to apply
     * @return array sanitized GET parameters
     */
    public static function getAll(array $filters = []) {
        $sanitizedData = [];

        foreach ($filters as $key => $filter) {
            $sanitizedData[$key] = self::get($key, $filter);
        }

        return $sanitizedData;
    }

    /**
     * Retrieves and sanitizes all POST data.
     *
     * @param array $filters associative array of keys and filters to apply
     * @return array sanitized POST parameters
     */
    public static function postAll(array $filters = []) {
        $sanitizedData = [];

        foreach ($filters as $key => $filter) {
            $sanitizedData[$key] = self::post($key, $filter);
        }

        return $sanitizedData;
    }
} 