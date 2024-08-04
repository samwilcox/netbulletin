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
 use NetBulletin\Middleware\LocalizationMiddleware;
 use NetBulletin\Entities\Member;
 use NetBulletin\Entities\Session;

 /**
  * Class EntityFactory
  *
  * Factory for building various entity objects.
  */
 class EntityFactory {
    /**
     * Creates a brand new entity object using the given parameters.
     *
     * @param object $params parameters object instance
     * @return object resulting entity object
     */
    public static function create($params) {
        $localization = LocalizationMiddleware::getInstance();

        if (!isset($params) || !isset($params->type)) {
            throw new InvalidParameterException($localization->get('errors', 'entityCreateInvalidParameter'));
        }

        switch ($params->type) {
            case 'member':
                return self::createMemberObject($params);
                break;
            case 'session':
                return self::createSessionObject($params);
                break;
        }
    }

    /**
     * Creates a new member entity object instance.
     *
     * @param object $params the parameters object instance
     * @return object resulting entity object instance
     */
    private static function createMemberObject($params) {
        $obj = new Member();
        $obj->initialize($params);
        return $obj;
    }

    /**
     * Creates a new session entity object instance.
     *
     * @param object $params the parameters object instance
     * @return object resulting entity object instance
     */
    private static function createSessionObject($params) {
        $obj = new Session();
        $obj->initialize($params);
        return $obj;
    }
 }