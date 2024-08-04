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

 use NetBulletin\ApiResponse;
 use NetBulletin\Models\Setting;

 /**
  * Class SettingController 
  *
  * Handles the application setting requests.
  */
 class SettingController {
    /**
     * Returns the information for the current set theme.
     *
     * @return void
     */
    public function theme() {
        $themeData = Setting::theme();
        ApiResponse::success($themeData);
    }
 }