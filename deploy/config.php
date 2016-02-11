<?php

define('DB_TYPE', 'mysql');
// define('DB_HOST', 'www.soaalarm.nl');
// define('DB_USERNAME', 'soaalarm');
// define('DB_PASSWORD', 'DavThoJu');
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'soaalarm');
define('TABLE_PREFIX', 'soaCMS_');
define('WB_PATH', dirname(__FILE__));
define('URLREWRITE', true);

/* Environmental Variables */

switch ( $_SERVER['SERVER_ADDR'] ) {
    // local
   	case '::1' : define('WB_URL', 'http://localhost'); define('LOCATION', 'local');break;
    // live
    case '195.20.9.77' : define('WB_URL', 'http://www.soaalarm.nl'); define('LOCATION', 'live');break;
}
define('ADMIN_PATH', WB_PATH.'/admin');
define('ADMIN_URL', WB_URL.'/admin');
define('ASSETS_URL', WB_URL.'/templates/assets');
require_once(WB_PATH.'/framework/initialize.php');
?>