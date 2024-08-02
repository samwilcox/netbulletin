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

namespace NetBulletin\Models;

use NetBulletin\Data\CacheFactory;

/**
 * Class User
 * 
 * This class models the user.
 */
class User {
    /**
     * Cache object instance.
     *
     * @var object
     */
    private static $cache;

    /**
     * Initializes this class.
     *
     * @return void
     */
    public static function initialize() {
        self::$cache = new CacheFactory();
    }

    /**
     * Returns all the user data.
     *
     * @return array
     */
    public static function all() {
        return self::$cache->get('users');
    }
}