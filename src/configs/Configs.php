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

 use NetBulletin\Helpers\UtilityHelper;
 use NetBulletin\Data\CacheFactory;

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
     * Cache object instance.
     *
     * @var object
     */
    private $cache;

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
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Populates the environmental variables.
     *
     * @return void
     */
    public function populateEnv() {
        $env = UtilityHelper::getEnvVars();

        foreach ($env as $key => $value) {
            $this->configs[$key] = $value;
        }
    }

    /**
     * Populates the settings from both the env and the database.
     *
     * @return void
     */
    public function populateSettings() {
        $this->cache = CacheFactory::getInstance();

        $data = $this->cache->get('configs');

        if (is_array($data) && !empty($data)) {
            foreach ($data as $record) {
                switch ($record->dataType) {
                    case 'bool':
                        $this->configs[$record->name] = $record->value == 'true' ? true : false;
                        break;
                    case 'int':
                        $this->configs[$record->name] = (int) $record->value;
                        break;
                    case 'serialized':
                        $this->configs[$record->name] = \strlen($record->value) > 0 ? \unserialize($record->value) : null;
                        break;
                    case 'json':
                        $this->configs[$record->name] = \strlen($record->value) > 0 ? \json_decode($record->value) : null;
                        break;
                    case 'string':
                        $this->configs[$record->name] = (string) $record->value;
                        break;
                    default:
                        $this->configs[$record->name] = $record->value;
                }
            }
        }
    }

    /**
     * Returns the value of the given key.
     *
     * @param string $key
     * @return mixed key value
     */
    public function __get($key) {
        if (array_key_exists($key, $this->configs)) return $this->configs[$key];
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