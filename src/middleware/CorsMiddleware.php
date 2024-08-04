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

 namespace NetBulletin\Middleware;

 use NetBulletin\Middleware\MiddlewareStructure;
 use NetBulletin\Http\Request;
 use NetBulletin\ApiResponse;

 /**
  * Class SessionMiddleware
  *
  * Middleware service for managing user sessions.
  */
 class CorsMiddleware implements MiddlewareStructure {
    /**
     * Singleton instance object.
     *
     * @var object
     */
    private static $instance;

    /**
     * Prevent cloning of the instance.
     *
     * @return void
     */
    public function __clone() {}

    /**
     * Prevent unserializing of the instance.
     */
    public function __wakeup() {}

    /**
     * Returns a singleton instance.
     *
     * @return object
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Middleware for handling CORS.
     *
     * @param Request $request the request object
     * @param callable $next the next middleware to execute
     * @return void
     */
    public function handle(Request $request, callable $next) {
        header('Access-Control-Allow-Origin: *'); 
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

        // Got to handle the preflight request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 200 OK');
            exit();
        }

        return $next($request);
    }
 }