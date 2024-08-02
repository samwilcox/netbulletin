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
 * Interface DatabaseStructure
 * 
 * Interface for all database classes to implement.
 */
interface DatabaseStructure {
    /**
     * Establishes a connection to the database.
     *
     * @return void
     */
    public function connect();

    /**
     * Closes the database connection.
     *
     * @return void
     */
    public function close();

    /**
     * Finds multiple records for the specified table and conditions.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @return array found items array
     */
    public function find($table, $conditions = []);

    /**
     * Finds a single record for the specified table and conditions.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @return object record object instance
     */
    public function findOne($table, $conditions = []);

    /**
     * Deletes records for the table based on the conditions.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @return void
     */
    public function delete($table, $conditions = []);

    /**
     * Deletes a single record for the table based on the conditions.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @return void
     */
    public function deleteOne($table, $conditions = []);

    /**
     * Inserts multiple records into the specified table.
     *
     * @param string $table the table name
     * @param array $data data collection
     * @return void
     */
    public function insert($table, $data);

    /**
     * Inserts a single record into the specified table.
     *
     * @param string $table the table name
     * @param array $data data collection
     * @return void
     */
    public function insertOne($table, $data);

    /**
     * Updates multiple records in the specified table.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @param array $data data collection
     * @return void
     */
    public function update($table, $conditions, $data);

    /**
     * Updates a single record in the specified table.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @param array $data data collection
     * @return void
     */
    public function updateOne($table, $conditions, $data);

    /**
     * Returns the last ID that was inserted into the database.
     *
     * @return string|int
     */
    public function getLastInsertId();

    /**
     * Returns the total documents in the given table
     *
     * @param string $table the table name
     * @return int
     */
    public function getTotalDocuments($table);

    /**
     * Returns the total documents for the given conditions.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @return int
     */
    public function countDocuments($table, $conditions = []);
}