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

namespace NetBulletin\Data\Database;

use MongoDB\Client as MongoClient;
use NetBulletin\ErrorLogger;
use NetBulletin\ApiResponse;
use NetBulletin\Data\DatabaseStructure;
use NetBulletin\Configs\Configs;

/**
 * Class MongoDBDriver
 * 
 * The database abstraction driver for MongoDB.
 */
class MongoDBDriver implements DatabaseStructure {
    /**
     * The client object.
     *
     * @var object
     */
    private $client = null;

    /**
     * Application configurations object instance.
     *
     * @var object
     */
    private $configs;

    /**
     * The database object.
     *
     * @var object
     */
    private $database;

    /**
     * The total queries executed.
     *
     * @var integer
     */
    private int $totalQueries = 0;

    /**
     * The last query executed.
     *
     * @var string
     */
    private $lastQuery;

    /**
     * Constructor that sets up this class.
     */
    public function __construct() {
        $this->configs = Configs::getInstance();
    }

    /**
     * Establishes a connection to the database.
     *
     * @return void
     */
    public function connect() {
        if ($this->client == null) {
            try {
                $this->client = new MongoClient($this->configs->MONGODB_URI);
                $this->database = $this->client->selectDatabase($this->configs->MONGODB_DATABASE);
            } catch (MongoDBException $e) {
                $this->handleError($e);
            }
        }
    }

    /**
     * Closes the database connection.
     *
     * @return void
     */
    public function close() {
        $this->client = null;
    }

    /**
     * Finds multiple records for the specified table and conditions.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @return array found items array
     */
    public function find($table, $conditions = []) {
        try {
            $collection = $this->database->selectCollection($table);
            return count($conditions) > 0 ? $collection->find($conditions['filter'], $conditions['options'])->toArray() : $collection->find()->toArray();
        } catch (MongoDBException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Finds a single record for the specified table and conditions.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @return object record object instance
     */
    public function findOne($table, $conditions = []) {
        try {
            $collection = $this->database->selectCollection($table);
            return count($conditions) > 0 ? $collection->findOne($conditions['filter'], $conditions['options']) : $collection->findOne();
        } catch (MongoDBException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Deletes records for the table based on the conditions.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @return void
     */
    public function delete($table, $conditions = []) {
        try {
            $collection = $this->database->selectCollection($table);
            $collection->deleteMany($conditions['filter']);
        } catch (MongoDBException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Deletes a single record for the table based on the conditions.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @return void
     */
    public function deleteOne($table, $conditions = []) {
        try {
            $collection = $this->database->selectCollection($table);
            $collection->deleteOne($conditions['filter']);
        } catch (MongoDBException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Inserts multiple records into the specified table.
     *
     * @param string $table the table name
     * @param array $data data collection
     * @return int[] collection of inserted ids
     */
    public function insert($table, $data) {
        try {
            $collection = $this->database->selectCollection($table);
            $result = $collection->insertMany($data);
            return $result->getInsertedIds();
        } catch (MongoDBException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Inserts a single record into the specified table.
     *
     * @param string $table the table name
     * @param array $data data collection
     * @return void
     */
    public function insertOne($table, $data) {
        try {
            $collection = $this->database->selectCollection($table);
            $result = $collection->insertOne($data);
            return $result->getInsertedId();
        } catch (MongoDBException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Updates multiple records in the specified table.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @param array $data data collection
     * @return void
     */
    public function update($table, $conditions, $data) {
        try {
            $collection = $this->database->selectCollection($table);
            $collection->updateMany($conditions['filter'], $data, $conditions['options']);
        } catch (MongoDBException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Updates a single record in the specified table.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @param array $data data collection
     * @return void
     */
    public function updateOne($table, $conditions, $data) {
        try {
            $collection = $this->database->selectCollection($table);
            $collection->updateOne($conditions['filter'], $data, $conditions['options']);
        } catch (MongoDBException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Returns the total documents in the given table
     *
     * @param string $table the table name
     * @return int
     */
    public function getTotalDocuments($table) {
        try {
            $collection = $this->database->selectCollection($table);
            return $collection->countDocuments();
        } catch(MongoDBException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Returns the total documents for the given conditions.
     *
     * @param string $table the table name
     * @param array $conditions optional conditions
     * @return int
     */
    public function countDocuments($table, $conditions = []) {
        try {
            $collection = $this->database->selectCollection($table);
            return $collection->countDocuments($conditions['filter'] ?? []);
        } catch (MongoDBException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Handles any errors.
     *
     * @param MongoDBException $e the exception object instance
     * @return void
     */
    private function handleError(MongoDBException $e) {
        ErrorLogger::log('Database Exception', object([
            'message' => $e->getMessage(),
            'datetime' => time(),
            'exception' => object([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ])
        ]));

        ApiResponse::error('An error occured while processing the database request.');
    }
}