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

use NetBulletin\Data\CacheStructure;
use NetBulletin\Data\Cache\DataCache;
use NetBulletin\Data\DatabaseFactory;
use NetBulletin\ErrorLogger;
use NetBulletin\ApiResponse;

/**
 * Class NoCacheDriver
 * 
 * Implements the cache structure interface for no caching.
 * This class basically pulls data straight from the database.
 */
class NoCacheDriver extends DataCache implements CacheStructure {
    /**
     * Collection that holds all the cached data.
     *
     * @var array
     */
    private $cache = [];

    /**
     * Database object instance.
     *
     * @var object
     */
    private $db;

    /**
     * Builds the initial cache.
     *
     * @return void
     */
    public function build() {
        $this->db = DatabaseFactory::getInstance();
        $this->db->connect();

        foreach ($this->tables as $table) {
            try {
                $data = $this->db->find($table);
                $this->cache[$table] = $data;
            } catch (\Exception $e) {
                $this->handleError($e);
            }
        }
    }

    /**
     * Updates the given table.
     *
     * @param string $table the table name
     * @return void
     */
    public function update($table) {
        try {
            $data = $this->db->find($table);
            $this->cache[$table] = $data;
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }

    /**
     * Updates all the tables in the given collection.
     *
     * @param array $tables the collection of tables to update
     * @return void
     */
    public function updateAll($tables) {
        foreach ($tables as $table) {
            $this->update($table);
        }
    }

    /**
     * Returns the data for the given table.
     *
     * @param string $table the table name
     * @return array data for table
     */
    public function get($table) {
        if (isset($this->cache[$table])) {
            return $this->cache[$table];
        } else {
            $this->update($table);
            return $this->cache[$table];
        }
    }

    /**
     * Returns the data for all the given tables in the given collection.
     *
     * @param array $tables collection of tables to get data for
     * @return array data for tables
     */
    public function getAll($tables) {
        $result = [];

        foreach ($tables as $table) {
            $result[$table] = $this->get($table);
        }

        return $result;
    }

    /**
     * Handles any errors.
     *
     * @param \Exception $e the exception object instance
     * @return void
     */
    private function handleError(\Exception $e) {
        ErrorLogger::log('Cache Exception', [
            'message' => $e->getMessage(),
            'datetime' => time(),
            'exception' => [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]
        ]);

        ApiResponse::error('An error occured while processing the cache request.');
    }
}