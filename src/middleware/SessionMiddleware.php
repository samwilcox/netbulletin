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
 class SessionMiddleware implements MiddlewareStructure {
    /**
     * Singleton instance object.
     *
     * @var object
     */
    private static $instance;

    /**
     * Collection of parameters for this class.
     *
     * @var object
     */
    private static $params;

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
            self::initialize();
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Initializes this class properties.
     *
     * @return void
     */
    private static function initialize() {
        self::$params = (object) [
            'duration' => 15,
            'ipMatch' => false,
            'lifetime' => 0,
            'session' => null
        ];

        self::garbageCollection();
    }

    /**
     * Middleware for handling user sessions.
     *
     * @param Request $request the request object
     * @param callable $next the next middleware to execute
     * @return void
     */
    public function handle(Request $request, callable $next) {
        $this->manage();
        $request->method = $_SERVER['REQUEST_METHOD'];

        return $next($request);
    }

    /**
     * Manages all the user sessions.
     *
     * @return void
     */
    public function manage() {
        
    }

    /**
     * Performs garbage collection of expires sessions.
     *
     * @return void
     */
    private static function garbageCollection() {

    }
 }