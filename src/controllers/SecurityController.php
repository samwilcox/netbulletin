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

 namespace NetBulletin\Controllers;

 use NetBulletin\ApiResponse;
 use NetBulletin\Models\Security;

 /**
  * Class SecurityController 
  *
  * Handles various security related requests.
  */
 class SecurityController {
    /**
     * Constructor that sets up this class.
     */
    public function __construct() {
        Security::initialize();
    }

    /**
     * Returns a CSRF token value.
     *
     * @return void
     */
    public function getCsrfToken() {
        $token = Security::csrf();
        ApiResponse::success($token);
    }
 }