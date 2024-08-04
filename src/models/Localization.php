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

namespace NetBulletin\Models;

use NetBulletin\Middleware\LocalizationMiddleware;
use NetBulletin\Lib\Member;
use NetBulletin\Helpers\FileHelper;
use NetBulletin\Helpers\UtilityHelper;
use NetBulletin\ApiResponse;
use NetBulletin\Helpers\IncomingHelper;

/**
 * Class Localization
 * 
 * This class models the localization.
 */
class Localization {
    /**
     * The localization object instance.
     *
     * @var object
     */
    private static $localization;

    /**
     * Initializes this class.
     *
     * @return void
     */
    public static function initialize() {
        self::$localization = LocalizationMiddleware::getInstance();
    }

    /**
     * Returns the entire localization collection.
     *
     * @return array localization data
     */
    public static function all() {
        $member = Member::getInstance();
        $manifestPath = $member->localizationPath() . 'manifest.json';
        $manifest = json_decode(FileHelper::readFile($manifestPath), true);

        $localizationData = [];

        foreach ($manifest['files'] as $file) {
            $filePath = $member->localizationPath() . $file;

            if (!file_exists($filePath)) {
                continue;
            }

            $thisFile = json_decode(FileHelper::readFile($filePath), true);
            $langKey = UtilityHelper::getStringBeforeCharacter($file, '.');
            $localizationData[$langKey] = $thisFile;
        }

        return $localizationData;
    }

    /**
     * Returns the entire localization for a given category.
     *
     * @return array:boolean localization data, false if category is not found
     */
    public static function category() {
        $category = IncomingHelper::get('category');

        if ($category == null) {
            return false;
        }

        return self::$localization->getCategory($category);
    }

    /**
     * Returns the localization for the given string identifier.
     *
     * @return string|boolean the localization string, false if string ID is not found
     */
    public static function stringId() {
        $category = IncomingHelper::get('category');
        $stringId = IncomingHelper::get('stringId');

        if ($category == null || $stringId == null) {
            return false;
        }

        return self::$localization->get($category, $stringId);
    }

    /**
     * Returns the manifest data for the localization.
     *
     * @return array|boolean the manifest collection, false on errors.
     */
    public static function manifest() {
        $localizationName = IncomingHelper::get('localizationName');
        $member = Member::getInstance();

        if ($localizationName == null) {
            return getManifest($member->localizationPath());
        }

        $found = false;
        $folders = UtilityHelper::getFolders($member->localizationPath());

        foreach ($folders as $folder) {
            if ($folder == $localizationName) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            return false;
        }

        return getManifest($localizationName);
    }

    /**
     * Helper method that returns the manifest for the given localization name.
     *
     * @param string $name the localization name
     * @return mixed manifest data
     */
    private static function getManifest($name) {
        $seperator = DIRECTORY_SEPARATOR;
        $manifestPath = '..' . $seperator . 'localization' . $seperator . $name . $seperator . 'manifest.json';

        if (!file_exists($manifestPath)) {
            return false;
        }

        $manifestData = json_decode(FileHelper::readFile($manifestPath), true);

        return $manifestData;
    }
}