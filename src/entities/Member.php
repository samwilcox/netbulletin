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

 namespace NetBulletin\Entities;

 use NetBulletin\Data\CacheFactory;
 use NetBulletin\Helpers\CookieHelper;
 use NetBulletin\Configs\Configs;

 /**
  * Class Member
  *
  * Entity that models a member.
  */
 class Member {
    /**
     * The cache object instance.
     *
     * @var object
     */
    private $cache;

    /**
     * The application configurations object instance.
     *
     * @var object
     */
    private $configs;

    /**
     * The member identifier.
     *
     * @var string
     */
    private $id;

    /**
     * The member's display name.
     *
     * @var string
     */
    private $displayName;

    /**
     * The member's email address.
     *
     * @var string
     */
    private $emailAddress;

    /**
     * The theme identifier.
     *
     * @var string
     */
    private $themeId;

    /**
     * The theme folder.
     *
     * @var string
     */
    private $themeFolder;

    /**
     * The localization identifier.
     *
     * @var string
     */
    private $localizationId;

    /**
     * Boolean representing whether user is signed in.
     *
     * @var boolean
     */
    private $signedIn = false;

    /**
     * The time zone string.
     *
     * @var string
     */
    private $timeZone;

    /**
     * Constructor that sets up this class.
     */
    public function __construct() {
        $this->cache = CacheFactory::getInstance();
        $this->configs = Configs::getInstance();
    }

    /**
     * Initializes this entity object instance.
     *
     * @param object $params parameters object instance
     * @return void
     */
    public function initialize($params) {
        if (property_exists($params, 'memberId')) {
            $this->id = $params->memberId;
        }

        $validData = false;
        $found = false;

        if (property_exists($params, 'memberId') && $params->memberId != 'guest') {
            $validData = true;
        } elseif (property_exists($params, 'email')) {
            $validData = true;
            $this->emailAddress = $params->email;
        }

        $data = $this->cache->get('installedthemes');

        if ($validData) {
            $data = $this->cache->get('users');

            foreach ($data as $record) {
                if ($record->id == $this->id || $record->emailAddress == $this->emailAddress) {
                    $found = true;

                    $this->id = $record->id;
                    $this->displayName = $record->displayName;
                    $this->emailAddress = $record->emailAddress;
                    $this->themeId = $record->themeId;
                    $this->localizationId = $record->localizationId;
                    $this->timeZone = $record->timeZone;
                    break;
                }
            }
        }

        if (!$found) {
            if (CookieHelper::exists('NetBulletin_LocalizationID')) {
                $this->localizationId = CookieHelper::getCookie('NetBulletin_LocalizationID');
            } else {
                $this->localizationId = $this->configs->defaultLocalizationId;
            }

            if (CookieHelper::exists('NetBulletin_ThemeID')) {
                $this->themeId = CookieHelper::getCookie('NetBulletin_ThemeID');
            } else {
                $this->themeId = $this->configs->defaultThemeId;
            }

            $this->id = 'guest';
            $this->displayName = 'Guest';
        }
    
        foreach ($data as $record) {
            if ($record->id == $this->themeId) {
                $this->themeFolder = $record->folder;
                break;
            }
        }
    }

    /**
     * Gets the member identifier.
     *
     * @return string the member identifier string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the member identifier.
     *
     * @param string $id the member identifier string
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Gets the member's display name.
     *
     * @return string the member's display name
     */
    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * Sets the member's display name.
     *
     * @param string $displayName the member display name
     * @return void
     */
    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
    }

    /**
     * Gets the member's email address.
     *
     * @return string the member's email address
     */
    public function getEmailAddress() {
        return $this->emailAddress;
    }

    /**
     * Sets the member's email address.
     *
     * @param string $emailAddress the member's email address
     * @return void
     */
    public function setEmailAddress($emailAddress) {
        $this->emailAddress = $emailAddress;
    }

    /**
     * Gets the member's theme identifier string.
     *
     * @return string the member's theme identifier string
     */
    public function getThemeId() {
        return $this->themeId;
    }

    /**
     * Sets the member's theme identifier string.
     *
     * @param string $themeId the theme identifier string
     * @return void
     */
    public function setThemeId($themeId) {
        $this->themeId = $themeId;
    }

    /**
     * Gets the member's localization identifier string.
     *
     * @return string member's localization identifier string
     */
    public function getLocalizationId() {
        return $this->localizationId;
    }

    /**
     * Sets the member's localization identifier string.
     *
     * @param string $localizationId the localization identifier string.
     * @return void
     */
    public function setLocalizationId($localizationId) {
        $this->localizationId = $localizationId;
    }

    /**
     * Returns whether the user is signed in.
     *
     * @return boolean true if signed in, false if not signed in
     */
    public function isSignedIn() {
        return $this->signedIn;
    }

    /**
     * Sets whether the user is signed in.
     *
     * @param boolean $signedIn true if signed in, false if not signed in
     * @return void
     */
    public function setSignedIn($signedIn) {
        $this->signedIn = $signedIn;
    }

    /**
     * Returns the timezone string.
     *
     * @return string the timezone string
     */
    public function getTimeZone() {
        return $this->timeZone;
    }

    /**
     * Sets the timezone string.
     *
     * @return string string
     */
    public function setTimeZone($timeZone) {
        $this->timeZone = $timeZone;
    }

    /**
     * Gets the theme folder.
     *
     * @return string the theme folder
     */
    public function getThemeFolder() {
        return $this->themeFolder;
    }

    /**
     * Sets the theme folder.
     *
     * @param string $themeFolder the theme folder
     * @return void
     */
    public function setThemeFolder($themeFolder) {
        $this->themeFolder = $themeFolder;
    }
 }