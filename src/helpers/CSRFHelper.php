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

 use NetBulletin\Configs\Configs;
 use NetBulletin\ApiResponse;
 use NetBulletin\Middleware\LocalizationMiddleware;
 use NetBulletin\Helpers\UtilityHelper;

 /**
  * Class CSRFHelper
  *
  * Helper methods to help protect against CSRF (cross-site request forgery)
  * attacks.
  */
 class CSRFHelper {
    /**
     * Validates the given CSRF token.
     *
     * @param string $token the CSRF token string
     * @return void
     */
    public static function validateToken($token) {
        $configs = Configs::getInstance();
        $localization = LocalizationMiddleware::getInstance();

        if ($configs->csrfEnabled) {
            if (!isset($_SESSION['NetBulletin_CSRF_Token'])) {
                ApiResponse::error($localization->get('errors', 'csrfTokenMissing'), 500);
            }
    
            $tokenFromSession = $_SESSION['NetBulletin_CSRF_Token'];
    
            if ($configs->csrfOnetimeTokens) {
                unset($_SESSION['NetBulletin_CSRF_Token']);
            } else {
                unset($_SESSION['NetBulletin_CSRF_Token_Exists']);
            }

            if ($configs->csrfOriginCheck && \sha1(UtilityHelper::getIpAddress() . UtilityHelper::getUserAgent()) != substr(base64_decode($tokenFromSession), 10, 40)) {
                ApiResponse::error($localization->get('errors', 'csrfOriginError'), 500);
            }

            if ($token != $tokenFromSession) {
                ApiResponse::error($localization->get('errors', 'csrfTokenDoesNotMatch'), 500);
            }

            if ($configs->csrfExpirationSeconds != 0) {
                if (intval(substr(base64_decode($tokenFromSession), 0, 10)) + $configs->csrfExpirationSeconds < time()) {
                    ApiResponse::error($localization->get('errors', 'csrfTokenExpired'), 500);
                }
            }
        }
    }

    /**
     * Returns a CSRF security token string.
     *
     * @return string CSRF token string
     */
    public static function get() {
        $configs = Configs::getInstance();
        $extraProtection = $configs->csrfOriginCheck ? \sha1(UtilityHelper::getIpAddress() . UtilityHelper::getUserAgent()) : '';
        $token = '';
    
        if ($configs->csrfOnetimeTokens) {
            $token = base64_encode(time() . $extraProtection . self::randomizeString(32));
            $_SESSION['NetBulletin_CSRF_Token'] = $token;
            unset($_SESSION['NetBulletin_CSRF_Token_Exists']);
        } else {
            if (isset($_SESSION['NetBulletin_CSRF_Token'])) {
                $token =$_SESSION['NetBulletin_CSRF_Token'];
            } else {
                $token = base64_encode(time() . $extraProtection . self::randomizeString(32));
                $_SESSION['NetBulletin_CSRF_Token'] = $token;
                $_SESSION['NetBulletin_CSRF_Token_Exists'] = true;
            }
        }

        return $token;
    }

    /**
     * Helper that returns a randomized string of the given length.
     *
     * @param int $length the length of the string to return
     * @return string randomized string
     */
    private static function randomizeString($length) {
        $configs = Configs::getInstance();
        $seed = strlen($configs->csrfSeed) > 0 ? $configs->csrfSeed : 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijqlmnopqrtsuvwxyz0123456789';
        $max = strlen($seed) - 1;
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $seed[intval(mt_rand(0.0, $max))];
        }

        return $string;
    }
 }