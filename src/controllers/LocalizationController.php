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

 namespace NetBulletin\Controllers;

 use NetBulletin\Models\Localization;
 use NetBulletin\ApiResponse;

 /**
  * Class LocalizationController 
  *
  * Handles localization transmissions.
  */
 class LocalizationController {
    /**
     * Constructor that sets up this class.
     */
    public function __construct() {
        Localization::initialize();
    }

    /**
     * Returns the entire localization collection.
     *
     * @return void
     */
    public function index() {
        $localization = Localization::all();
        ApiReponse::success($localization);
    }

    /**
     * Returns the entire category localization collection.
     *
     * @return void
     */
    public function category() {
        $localization = Localization::category();
        
        if ($localization !== false) {
            return ApiResponse::success($localization);
        }

        return ApiResponse::error('Localization category not found.', 500);
    }

    /**
     * Returns the localization for the given string identifier.
     *
     * @return void
     */
    public function stringId() {
        $stringId = Localization::stringId();

        if ($stringId !== false) {
            return ApiResponse::success($stringId);
        }

        return ApiResponse::error('Either localization category was not found or the string identifier was not found.', 500);
    }
 }