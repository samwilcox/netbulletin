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

// error_reporting(E_ALL);
// ini_set('display_errors', true);
error_reporting(0);

require_once '../vendor/autoload.php';

use NetBulletin\App;

$app = new App();
$app->run();