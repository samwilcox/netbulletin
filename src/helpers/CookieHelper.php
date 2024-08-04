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

 use NetBulletin\Configs\Configs;

 /**
  * Class CookieHelper
  *
  * Helper methods for handling cookies.
  */
 class CookieHelper {
    /**
     * Creates a new cookie.
     *
     * @param string $name the cookie name
     * @param mixed $value the cookie value
     * @param int $expires the cookie expiration
     * @return void
     */
    public static function createCookie($name, $value, $expires) {
        $configs = Configs::getInstance();
        setcookie($name, $value, $expires, $configs->COOKIE_PATH, $configs->COOKIE_DOMAIN);
    }

    /**
     * Deletes a cookie.
     *
     * @param string $name the cookie name
     * @param boolean $phpCookie true if a PHP cookie, false otherwise
     * @return void
     */
    public static function deleteCookie($name, $phpCookie = false) {
        \unset($_COOKIE[$name]);
        setcookie($name, '', time() - 3600, $phpCookie ? '' : $configs->COOKIE_PATH, $phpCookie ? '' : $configs->COOKIE_DOMAIN);
    }

    /**
     * Returns the value for the given cookie.
     *
     * @param string $name the cookie name
     * @return mixed|null the cookie value or null if non existent
     */
    public static function getCookie($name) {
        if (self::exists($name)) return $_COOKIE[$name];
        return null;
    }

    /**
     * Returns whether the cookie exists.
     *
     * @param string $name the cookie name
     * @return bool true if exists, false otherwise
     */
    public static function exists($name) {
        return isset($_COOKIE[$name]);
    }
 }