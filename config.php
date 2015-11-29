<?php

define('DSN', 'mysql:host=localhost;dbname=kidslife_db;charset=utf8');
define('DB_USER','kajitack');
define('DB_PASSWORD','jkjfai38tkd12');

define('SITE_NAME','');
define('SITE_URL', 'http://192.168.100.150/');

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
// error_reporting(0);
ini_set( 'display_errors', 1 );

session_set_cookie_params(0, '');
