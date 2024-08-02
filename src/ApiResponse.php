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
  * Class ApiResponse
  *
  * Handles all the communication between the API and the front end.
  */
 class ApiResponse {
    /**
     * Send a success response.
     *
     * @param mixed $data the data to send
     * @param integer $statusCode the HTTP status code (default: 200)
     * @return void
     */
    public static function success($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);

        exit;
    }

    /**
     * Send an error response.
     *
     * @param string $message the error message
     * @param integer $statusCode the HTTP status code (default: 500)
     * @param mixed $errors additionial error details (default: null)
     * @return void
     */
    public static function error($message, $statusCode = 500, $errors = null) {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        echo json_encode([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ]);

        exit;
    }
 }