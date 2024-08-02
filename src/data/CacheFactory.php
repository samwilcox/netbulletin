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

namespace NetBulletin\Data;

use NetBulletin\Configs;
use NetBulletin\Data\Cache\NoCacheDriver;

/**
 * Class CacheFactory
 * 
 * Builds cache driver object instances.
 */
class CacheFactory {
    /**
     * Singleton instance object.
     *
     * @var object
     */
    private static $instance;

    /**
     * Application configurations object instance.
     *
     * @var object
     */
    private static $configs;

    /**
     * Prevent cloning of the instance.
     *
     * @return void
     */
    private function __clone() {}

    /**
     * Prevent unserializing of the instance.
     */
    private function __wakeup() {}

    /**
     * Constructor that sets up this class.
     */
    public function __construct() {
        self::$configs = Configs::getInstance();
    }

    /**
     * Returns a singleton instance.
     *
     * @return object
     */
    public static function getInstance() {
        if (self::$instance === null) {
            if (self::$configs->CACHE) {
                self::$instance = new NoCacheDriver();
            } else {
                switch (self::$configs->CACHE_METHOD) {
                    case 'nocache':
                        self::$instance = new NoCacheDriver();
                        break;
                    default:
                    throw new InvalidArgumentException('Unsupported database cache driver.');
                }
            }
        }

        return self::$instance;
    }
}