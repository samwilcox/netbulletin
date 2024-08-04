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

 use NetBulletin\Exceptions\InvalidParameterException;
 use NetBulletin\Services\LocalizationService;
 use NetBulletin\Configs\Configs;
 use NetBulletin\Data\DatabaseFactory;
 use NetBulletin\Helpers\UtilityHelper;
 use NetBulletin\Data\CacheFactory;
 use NetBulletin\Helpers\CookieHelper;

 /**
  * Class Session
  *
  * Entity that models a session.
  */
 class Session {
    /**
     * The localization object instance.
     *
     * @var object
     */
    private $localization;

    /**
     * The application settings object instance.
     *
     * @var object
     */
    private $configs;

    /**
     * The database object instance.
     *
     * @var object
     */
    private $db;

    /**
     * The data cache object instance.
     *
     * @var object
     */
    private $cache;

    /**
     * The session identifier.
     *
     * @var string
     */
    private $id;

    /**
     * The user identifier string.
     *
     * @var string
     */
    private $userId;

    /**
     * The token string.
     *
     * @var string
     */
    private $token;

    /**
     * The user's current location.
     *
     * @var string
     */
    private $location;

    /**
     * The expiration timestamp.
     *
     * @var int
     */
    private $expires;

    /**
     * The user's last click timestamp.
     *
     * @var int
     */
    private $lastClick;

    /**
     * The user's IP address.
     *
     * @var string
     */
    private $ipAddress;

    /**
     * The user's hostname.
     *
     * @var string
     */
    private $hostname;

    /**
     * The user's user agent string.
     *
     * @var string
     */
    private $userAgent;

    /**
     * Bot object instance.
     *
     * @var object
     */
    private $bot;

    /**
     * Flag indicating whether to show user in active users listing.
     *
     * @var boolean
     */
    private $display;

    /**
     * Flag indicating whether the user has admin permissions.
     *
     * @var boolean
     */
    private $admin;

    /**
     * Constructor that sets up this class.
     */
    public function __construct() {
        $this->localization = LocalizationService::getInstance();
        $this->configs = Configs::getInstance();
        $this->db = DatabaseFactory::getInstance();
        $this->cache = CacheFactory::getInstance();
    }

    /**
     * Initializes this entity.
     *
     * @param object $params parameters object instance
     * @return void
     */
    public function initialize($params) {
        if (!property_exists($params, 'sessionId')) {
            throw new InvalidParameterException($this->localization->get('errors', 'sessionEntityInvalidParameter'));
        }

        $this->id = $params->sessionId;
    }

    /**
     * Gets the session identifier string.
     *
     * @return string the session identifier string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the session identifier string.
     *
     * @param string $id the session identifier string
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Gets the user identifier string.
     *
     * @return string the user identifier string
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * Sets the user identifier string.
     *
     * @param string $userId the user identifier string
     * @return void
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * Gets the token.
     *
     * @return string the token value
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Sets the token.
     *
     * @param string $token the token value
     * @return void
     */
    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * Gets the user's location.
     *
     * @return string the user's location string
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * Sets the user's location.
     *
     * @param string $location the user's location string
     * @return void
     */
    public function setLocation($location) {
        $this->location = $location;
    }

    /**
     * Gets the expiration timestamp.
     *
     * @return int the expiration timestamp
     */
    public function getExpires() {
        return $this->expires;
    }

    /**
     * Sets the expiration timestamp.
     *
     * @param int $expires the expiration timestamp
     * @return void
     */
    public function setExpires($expires) {
        $this->expires = $expires;
    }

    /**
     * Gets the user's last click timestamp.
     *
     * @return int the last click timestamp
     */
    public function getLastClick() {
        return $this->lastClick;
    }

    /**
     * Sets the user's last click timestamp.
     *
     * @param int $lastClick the last click timestamp
     * @return void
     */
    public function setLastClick($lastClick) {
        $this->lastClick = $lastClick;
    }

    /**
     * Gets the user's ip address.
     *
     * @return string the user's ip address
     */
    public function getIpAddress() {
        return $this->ipAddress;
    }

    /**
     * Sets the user's ip address.
     *
     * @param string $ipAddress the user's ip address
     * @return void
     */
    public function setIpAddress($ipAddress) {
        $this->ipAddress = $ipAddress;
    }

    /**
     * Gets the user's hostname.
     *
     * @return string the user's hostname
     */
    public function getHostname() {
        return $this->hostname;
    }

    /**
     * Sets the user's hostname.
     *
     * @param string $hostname the user's hostname
     * @return void
     */
    public function setHostname($hostname) {
        $this->hostname = $hostname;
    }

    /**
     * Gets the user's user agent string.
     *
     * @return string the user agent string
     */
    public function getUserAgent() {
        return $this->userAgent;
    }

    /**
     * Sets the user's user agent string.
     *
     * @param string $userAgent the user agent string
     * @return void
     */
    public function setUserAgent($userAgent) {
        $this->userAgent = $userAgent;
    }

    /**
     * Gets the bot object instance.
     *
     * @return object bot object instance
     */
    public function getBot() {
        return $this->bot;
    }

    /**
     * Sets the bot object instance.
     *
     * @param object $bot the bot object instance
     * @return void
     */
    public function setBot($bot) {
        $this->bot = $bot;
    }

    /**
     * Gets the display flag.
     *
     * @return boolean true to display on active users list, false otherwise
     */
    public function getDisplay() {
        return $this->display;
    }

    /**
     * Sets the display flag.
     *
     * @param boolean $display true to display on active users list, false otherwise
     * @return void
     */
    public function setDisplay($display) {
        $this->display = $display;
    }

    /**
     * Gets flag indicating if user is an admin.
     *
     * @return boolean true if an admin, false otherwise
     */
    public function isAdmin() {
        return $this->admin;
    }

    /**
     * Sets the flag indicating if user is an admin.
     *
     * @param boolean $admin true if an admin, false otherwise
     * @return void
     */
    public function setAdmin($admin) {
        $this->admin = $admin;
    }

    /**
     * Creates a mew session in the database.
     *
     * @param boolean $member true if member, false otherwise
     * @return string the resulting id
     */
    public function create($member = false) {
        $this->setExpires(time() + ($this->configs->session_duration_seconds * 60));
        $this->setLastClick(time());
        $this->setLocation($_SERVER['REQUEST_URI']);

        if (!$member) {
            $this->setUserId('guest');
            $this->setDisplay(false);
            $this->setAdmin(false);
            unset($_SESSION['NetBulletin_MemberToken']);
        }

        $newId = $this->db->insertOne('sessions', [
            'id' => $this->getId(),
            'userId' => $this->getUserId(),
            'token' => $this->getToken(),
            'location' => $this->getLocation(),
            'expires' => $this->getExpires(),
            'lastClick' => $this->getLastClick(),
            'ipAddress' => $this->getIpAddress(),
            'hostname' => $this->getHostname(),
            'userAgent' => $this->getUserAgent(),
            'bot' => \serialize($this->getBot()),
            'display' => $this->getDisplay() ? 1 : 0,
            'admin' => $this->isAdmin() ? 1 : 0
        ]);

        $this->cache->update('sessions');

        return $newId;
    }

    /**
     * Updates the session in the database.
     *
     * @param boolean $member true if member, false otherwise
     * @return string the resulting id
     */
    public function update($member = false) {
        $this->setExpires(time() + ($this->configs->session_duration_seconds * 60));
        $this->setLastClick(time());
        $this->setLocation($_SERVER['REQUEST_URI']);

        if (!$member) {
            $this->setUserId('guest');
            $this->setDisplay(false);
            $this->setAdmin(false);
            unset($_SESSION['NetBulletin_MemberToken']);
        }

        $newId = $this->db->updateOne('sessions', ['id' => $this->getId()], [
            'expires' => $this->getExpires(),
            'lastClick' => $this->getLastClick(),
            'location' => $this->getLocation(),
            'display' => $this->getDisplay() ? 1 : 0
        ]);

        $this->cache->update('sessions');

        return $newId;
    }

    /**
     * Destroys the current session.
     *
     * @return void
     */
    public function destroy() {
        CookieHelper::deleteCookie('NetBulletin_MemberToken');

        session_unset();
        session_destroy();

        if (CookieHelper::exists(session_name())) CookieHelper::deleteCookie(session_name(), true);

        $this->db->deleteOne('sessions', ['id' => $this->getId()]);
        $this->cache->update('sessions');

        unset($_SESSION['NetBulletin_MemberToken']);
    }
 } 