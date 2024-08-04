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
use NetBulletin\Helpers\IncomingHelper;

/**
 * Class Post
 * 
 * Model for retreiving post content and submitting new posts.
 */
class Post {
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
        self::$cache = CacheFactory::getInstance();
    }
}