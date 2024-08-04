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

 /**
  * Interface MiddlewareStructure
  *
  * Interface for middleware classes to implement.
  */
 interface MiddlewareStructure {
    /**
     * Undocumented function
     *
     * @param Request $request the request object instance
     * @param callable $next the next item in the chain
     * @return void
     */
    public function handle(Request $request, callable $next);
 }