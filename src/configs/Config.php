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

 namespace NetBulletin\Configs;

 /**
  * Class Configs
  *
  * Class for managing all the application configurations.
  */
 class Configs {
    /**
     * Singleton instance object.
     *
     * @var object
     */
    private static $instance;

    /**
     * Array collection of application configurations.
     *
     * @var array
     */
    private $configs = [];

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
     * Constructor that sets up this class.
     *
     * @return void
     */
    public function __constructor() {
        $this->populateSettings();
    }

    /**
     * Populates the settings from both the env and the database.
     *
     * @return void
     */
    private function populateSettings() {

    }

    /**
     * Returns the value of the given key.
     *
     * @param string $key
     * @return mixed key value
     */
    public function __get($key) {
        if (array_key_exists($key, $this->configs)) return this->configs[$key];
        return null;
    }

    /**
     * Sets the given key with the given value.
     *
     * @param string $key the key name
     * @param mixed $value the value to set
     */
    public function __set($key, $value) {
        $this->configs[$key] = $value;
    }

    /**
     * Returns whether the given key exists.
     *
     * @param string $key the key name
     * @return boolean true if exists; false otherwise
     */
    public function __isset($key) {
        return array_key_exists($key);
    }
 }