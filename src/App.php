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

use NetBulletin\Data\DatabaseFactory;
use NetBulletin\Data\CacheFactory;
use NetBulletin\Http\Request;
use NetBulletin\Http\Response;
use NetBulletin\Configs\Configs;
use NetBulletin\Middleware\MiddlewarePipeline;
use NetBulletin\Middleware\SessionMiddleware;
use NetBulletin\Middleware\LocalizationMiddleware;
use NetBulletin\Middleware\CorsMiddleware;
use NetBulletin\Controllers\UserController;
use NetBulletin\Controllers\LocalizationController;
use NetBulletin\Controllers\SecurityController;
use NetBulletin\Controllers\SettingController;
use NetBulletin\ApiResponse;
use NetBulletin\Lib\Member;

/**
 * Initialization point of Net Bulletin.
 */
class App {
    /**
     * Kicks off Net Bulletin.
     *
     * @return void
     */
    public function run() {
        // Populate the configuration environmental vars
        $configs = Configs::getInstance();
        $configs->populateEnv();

        // Connect to the database
        $db = DatabaseFactory::getInstance();
        $db->connect();

        // Build the initial cache
        $cache = CacheFactory::getInstance();
        $cache->build();

        // Populate the application settings
        $configs->populateSettings();

        // Initialize the member library
        $member = Member::getInstance();
        $member->initialize();

        // Create the request object
        $request = new Request(
            getallheaders(),
            file_get_contents('php://input'),
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD']
        );

        // Define the middleware we are using
        $middleware = [
            SessionMiddleware::getInstance(),
            LocalizationMiddleware::getInstance(),
            CorsMiddleware::getInstance()
        ];

        // Setup our core request handler
        $coreHandler = function($request) {
            $parsedUri = parse_url($request->uri, PHP_URL_PATH);
            $method = $request->method;

            if (preg_match('#/api(/.*)?$#', $parsedUri, $matches)) {
                $route = $matches[0];
            } else {
                $route = '/';
            }

            if ($route == '/api/users' && $method == 'GET') {
                $controller = new UserController();
                return $controller->index();
            } elseif ($route == '/api/localization' && $method == 'GET') {
                $controller = new LocalizationController();
                return $controller->index();
            } elseif ($route == '/api/localization/category' && $method == 'GET') {
                $controller = new LocalizationController();
                return $controller->category();
            } elseif ($route == '/api/localization/stringid' && $method == 'GET') {
                $controller = new LocalizationController();
                return $controller->stringId();
            } elseif ($route == '/api/security/csrftoken' && $method == 'GET') {
                $controller = new SecurityController();
                return $controller->getCsrfToken();
            } elseif ($route == '/api/setting/theme' && $method == 'GET') {
                $controller = new SettingController();
                return $controller->theme();
            }

            ApiResponse::error('Not Found', 404);
        };

        // Create the pipeline and process the request
        $pipeline = new MiddlewarePipeline($middleware);
        $response = $pipeline->process($request, $coreHandler);

        // Close our database connection
        $db->close();
    }
}