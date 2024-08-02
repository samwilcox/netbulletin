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

/**
 * Interface CacheStructure
 * 
 * Interface for all cache drivers to implement.
 */
interface CacheStructure {
    /**
     * Builds the initial cache.
     *
     * @return void
     */
    public function build();

    /**
     * Updates the given table.
     *
     * @param string $table the table name
     * @return void
     */
    public function update($table);

    /**
     * Updates all the tables in the given collection.
     *
     * @param array $tables the collection of tables to update
     * @return void
     */
    public function updateAll($tables);

    /**
     * Returns the data for the given table.
     *
     * @param string $table the table name
     * @return array data for table
     */
    public function get($table);

    /**
     * Returns the data for all the given tables in the given collection.
     *
     * @param array $tables collection of tables to get data for
     * @return array data for tables
     */
    public function getAll($tables);
}