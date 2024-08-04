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
use NetBulletin\Configs\Configs;
use NetBulletin\Helpers\CSRFHelper;

/**
 * Class Security
 * 
 * This class models the various security related tasks.
 */
class Security {
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

    /**
     * Returns a new CSRF token.
     *
     * @return array token data
     */
    public static function csrf() {
        $configs = Configs::getInstance();

        if ($configs->csrfEnabled) {
            return ['token' => CSRFHelper::get()];
        }

        return ['token' => false];
    }
}