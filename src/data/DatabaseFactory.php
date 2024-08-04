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

use NetBulletin\Configs\Configs;
use NetBulletin\Data\Database\MongoDBDriver;

/**
 * Class DatabaseFactory
 * 
 * Builds database driver object instances.
 */
class DatabaseFactory {
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
            self::$configs = Configs::getInstance();

            switch (self::$configs->DATABASE_DRIVER) {
                case 'mongodb':
                    self::$instance = new MongoDBDriver();
                    break;

                default:
                    throw new \InvalidArgumentException('Unsupported database driver.');
            }
        }

        return self::$instance;
    }
}