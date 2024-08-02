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

error_reporting( E_ALL );
ini_set( 'display_errors', true );

require_once '../vendor/autoload.php';

use NetBulletin\Controllers\UserController;

// Allow cross-origin resource sharing
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Define all our routes
if ($uri == '/api/users' && $method == 'GET') {
    $controller = new UserController();
    $controller->index;
}