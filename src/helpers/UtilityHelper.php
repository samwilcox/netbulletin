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

use Ramsey\Uuid\Uuid;
use NetBulletin\Helpers\FileHelper;
use NetBulletin\Exceptions\IOException;

/**
 * Class UtilityHelper
 * 
 * Contains various utility and misc helper methods.
 */
class UtilityHelper {
    /**
     * Returns the listing of environmental variables from our .env file.
     *
     * @return array collection of environmental variable keys
     */
    public static function getEnvVars() {
        if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.env')) {
            throw new \RuntimeException('The .env file does not exist.');
        }

        $env = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.env');

        if ($env === false) {
            throw new \RuntimeException('Failed to parse the .env file.');
        }

        return $env;
    }

    /**
     * Generates an unqiue ID for the database.
     *
     * @return string unique ID
     */
    public static function generateId() {
        return Uuid::uuid4()->toString();
    }

    /**
     * Helper that gets the string before a given character.
     *
     * @param string $string the string to get the string from
     * @param string $character the character needle
     * @return string the string before the given character
     */
    public static function getStringBeforeCharacter($string, $character) {
        $pos = strpos($string, $character);

        if ($pos === false) {
            return $string;
        }

        return substr($string, 0, $pos);
    }

    /**
     * Returns the list of folders in the given directory.
     *
     * @param string $directory the directory name
     * @return array collection of folders
     */
    public static function getFolders($directory) {
        if (!is_dir($directory)) {
            throw new IOException('The given directory to retrieve folders for is not a directory.');
        }

        $items = scandir($directory);
        $folders = [];

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $fullPath = $directory . DIRECTORY_SEPARATOR . $item;

            if (is_dir($fullPath)) {
                $folders[] = $fullPath;
            }
        }
    }

    /**
     * Returns the user's user agent string.
     *
     * @return string the user agent string
     */
    public static function getUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    }

    /**
     * Returns the user's IP address.
     *
     * @return string the users ip address
     */
    public static function getIpAddress() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Returns the user's hostname.
     *
     * @return string hostname string
     */
    public static function getHostname() {
        return gethostname();
    }
}