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

use NetBulletin\Lib\Member;

/**
 * Class Setting
 * 
 * This class models the interaction for handling settings.
 */
class Setting {
    /**
     * Cache object instance.
     *
     * @var object
     */
    private static $cache;

    /**
     * Returns the details regarding the current set theme.
     *
     * @return array theme data collection
     */
    public static function theme() {
        $member = Member::getInstance();
        $themeId = $member->themeId();
        $themeFolder = $member->themeFolder();

        return ['themeId' => $themeId, 'themeFolder' => $themeFolder];
    }
}