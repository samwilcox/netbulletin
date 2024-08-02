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

 namespace NetBulletin\Controller;

 use NetBulletin\Models\User;
 use NetBulletin\ApiResponse;

 /**
  * Class UserController 
  *
  * Handles user-related actions such as retrieving and displaying user data.
  */
 class UserController {
    /**
     * Constructor that sets up this class.
     */
    public function __construct() {
        User::initialize();
    }

    /**
     * Index of the users controller.
     *
     * @return void
     */
    public function index() {
        $users = User::all();
        ApiResponse::success($users);
    }
 }