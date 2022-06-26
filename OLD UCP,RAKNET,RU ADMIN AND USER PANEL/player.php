<?php
session_start();

error_reporting ( -1 );
ini_set( 'display_errors', -1 );
define ( 'CRAZY_STR' , true );

require_once ( "lib/init.php" );
require_once ( "lib/classes/mysql.class.php" );
require_once ( "lib/classes/func.global.php" );
$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
$db->query ( "SET NAMES UTF8" );

echo other::load();

$db->close();