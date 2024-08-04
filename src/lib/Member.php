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

 namespace NetBulletin\Lib;

 use NetBulletin\Data\CacheFactory;
 use NetBulletin\Entities\EntityFactory;

 /**
  * Class Member
  *
  * Handles requests for member information.
  */
 class Member {
    /**
     * Singleton instance object.
     *
     * @var object
     */
    private static $instance;

    /**
     * The member object instance.
     *
     * @var object
     */
    private $member;

    /**
     * Configurations object instance.
     *
     * @var object
     */
    private $configs;

    /**
     * The data cache object instance.
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
     * Initializes this class properties.
     *
     * @return void
     */
    public function initialize() {
        $this->cache = CacheFactory::getInstance();
        $this->configs = new \stdClass();
        $memberId = 'guest';
        $memberObj = null;

        if (isset($_SESSION['NetBulletin_MemberToken'])) {
            if (($memberObj = $this->getMemberByToken($_SESSION['NetBulletin_MemberToken'])) != null) {
                $signedIn = true;
                $memberId = $memberObj->getId();
                $this->member = $memberObj;
            }
        } else {
            $memberObj = EntityFactory::create((object)['type' => 'member', 'memberId' => 'guest']);
            $this->member = $memberObj;
        }

        $this->configs->themeId = $memberObj->getThemeId();
        $this->configs->themeFolder = $memberObj->getThemeFolder();
        $this->initializeConfigs();
    }

    /**
     * Initializes the member configurations.
     *
     * @return void
     */
    private function initializeConfigs() {
        $data = $this->cache->getAll(['themes' => 'installedthemes', 'localization' => 'installedlocalizations']);

        foreach ($data->themes as $theme) {
            if ($theme->id == $this->member->getThemeId()) {
                $folder = $theme->folder;
                $imagesetFolder = $theme->imagesetFolder;
                break;
            }
        }

        foreach ($data->localization as $local) {
            if ($local->id == $this->member->getLocalizationId()) {
                $localizationFolder = $local->folder;
                break;
            }
        }

        $seperator = DIRECTORY_SEPARATOR;
        $this->configs->imagesetFolder = $imagesetFolder;
        $this->configs->localizationPath = '..' . $seperator . 'localization' . $seperator . $localizationFolder . $seperator;

        \date_default_timezone_set($this->member->getTimeZone());
    }

    /**
     * Returns a new member entity object based on the given token.
     *
     * @param string $token the token to search for
     * @return object|null member entity object; null if token does not exist
     */
    private function getMemberByToken($token) {
        $data = $this->cache->get('memberdevices');

        foreach ($data as $record) {
            if ($record->token == $token) {
                return EntityFactory::create((object)['type' => 'member', 'memberId' => $record->userId]);
            }
        }

        return null;
    }

    /**
     * Returns whether the member is signed in.
     *
     * @return boolean true if signed in, false if not
     */
    public function signedIn() {
        return $this->member->isSignedIn();
    }

    /**
     * Returns the localization path.
     *
     * @return string the localization path
     */
    public function localizationPath() {
        return $this->configs->localizationPath;
    }

    /**
     * Returns the theme identifier.
     *
     * @return string the theme identifier
     */
    public function themeId() {
        return $this->configs->themeId;
    }

    /**
     * Returns the theme folder.
     *
     * @return string the theme folder
     */
    public function themeFolder() {
        return $this->configs->themeFolder;
    }
 }