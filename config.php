<?php
date_default_timezone_set('America/Sao_Paulo');

define("CI_STATUS", "production"); // development | testing | production

/* App Config */
define("APP_PATH", "/");
define("APP_URL", "https://".$_SERVER['HTTP_HOST'].APP_PATH."/");
define("ADMIN_PATH", "https://admin.your-site.com.br/");
define("APP_ADMIN", '/admin');

/* Files */
define("THUMBNAIL", APP_PATH."/assets/php/image.php");

/* Dirs */
define("UPLOADS", APP_ADMIN."/uploads");

/* Database Config */
define("DB_HOSTNAME", "localhost");

define("DB_USERNAME", "db_username");
define("DB_PASSWORD", "user_password");
define("DB_DATABASE", "db_name");

define("DB_DBDRIVER", "mysqli");
define("DB_DBPREFIX", "panamerico_");

