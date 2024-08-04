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

namespace NetBulletin\Helpers;

/**
 * Class FileHelper
 * 
 * Contains helper methods for dealing with files.
 */
class FileHelper {
    /**
     * Creates a new file with the given content.
     *
     * @param string $filePath the path to the file
     * @param string $content the content to write to the file
     * @return bool returns true on success, false on failure
     */
    public static function createFile(string $filePath, string $content = ''):bool {
        try {
            return self::writeFile($filePath, $content);
        } catch (\Exception $e) {
            self::handleError($e);
        }
    }

    /**
     * Appends content to an existing file.
     *
     * @param string $filePath the path to the file
     * @param string $content the content to append to the file
     * @return boolean returns true on success, false on failure
     */
    public static function appendToFile(string $filePath, string $content): bool {
        try {
            return self::writeFile($filePath, $content, FILE_APPEND);
        } catch (\Exception $e) {
            self::handleError($e);
        }
    }

    /**
     * Deletes a file.
     *
     * @param string $filePath the path to the file
     * @return boolean returns true on success, false on failure
     */
    public static function deleteFile(string $filePath): bool {
        try {
            return unlink($filePath);
        } catch (\Exception $e) {
            self::handleError($e);
        }
    }

    /**
     * Changes the permissions of a file.
     *
     * @param string $filePath the path to the file
     * @param integer $permissions the new permissions (e.g., 0755)
     * @return boolean returns true on success, false on failure
     */
    public static function changePermissions(string $filePath, int $permissions): bool {
        try {
            return chmod($filePath, $permissions);
        } catch (\Exception $e) {
            self::handleError($e);
        }
    }

    /**
     * Reads the content of a file.
     *
     * @param string $filePath the path to the file
     * @return string|false returns the file content or false on failure
     */
    public static function readFile(string $filePath) {
        try {
            return file_get_contents($filePath);
        } catch (\Exception $e) {
            self::handleError($e);
        }
    }

    /**
     * Writes content to a file with optional locking.
     *
     * @param string $filePath the path to the file
     * @param string $content the content to write
     * @param integer $flags optional flags for file_put_contents
     * @return boolean returns true on success, false on failure
     */
    private static function writeFile(string $filePath, string $content, int $flags = 0): bool {
        $mode = ($flags & FILE_APPEND) ? 'ab' : 'wb';
        $fp = fopen($filePath, $mode);

        if ($fp === false) {
            throw new \RuntimeException('Failed to open file for writing.');
        }

        if (flock($fp, LOCK_EX)) {
            $result = fwrite($fp, $content);
            flock($fp, LOCK_UN);
        } else {
            throw new \RuntimeException('Failed to lock file.');
        }

        fclose($fp);

        return $result !== false;
    }

    /**
     * Handles any errors.
     *
     * @param \Exception $e the exception object instance
     * @return void
     */
    private static function handleError(\Exception $e) {
        ErrorLogger::log('File Exception', [
            'message' => $e->getMessage(),
            'datetime' => time(),
            'exception' => [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]
        ]);

        ApiResponse::error('An error occured while processing a file.');
    }
}