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

namespace NetBulletin\Data\Cache;

/**
 * Class DataCache
 * 
 * This class holds the properties for the list of tables to
 * cache.
 */
class DataCache {
    /**
     * Collection of tables to cache.
     *
     * @var array
     */
    protected $tables = [];

    /**
     * Constructor that sets up this class.
     */
    public function __construct() {
        $this->tables = [
            'users',
            'configs'
        ];
    }
}