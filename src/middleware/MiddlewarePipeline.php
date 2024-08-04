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

 use NetBulletin\Http\Request;
 use NetBulletin\Http\Response;

 /**
  * Class MiddlewarePipeline
  *
  * The middleware pipeline handling.
  */
 class MiddlewarePipeline {
    /**
     * Middleware collection.
     *
     * @var array
     */
    private $middleware = [];

    /**
     * Constructor that sets up this class.
     *
     * @param array $middleware the middleware collection
     */
    public function __construct(array $middleware) {
        $this->middleware = $middleware;
    }

    /**
     * Process the middleware.
     *
     * @param Request $request the request object instance
     * @param callable $coreHandler the core handler object
     * @return void
     */
    public function process(Request $request, callable $coreHandler) {
        $handler = $coreHandler;

        foreach (array_reverse($this->middleware) as $middleware) {
            $handler = function($request) use ($middleware, $handler) {
                return $middleware->handle($request, $handler);
            };
        }

        return $handler($request);
    }
 }