<?php
session_start();
error_reporting ( 0 );
ini_set( 'display_errors', 0 );
define ( 'CRAZY_STR' , true );

require_once ( "../../init.php" );
require_once ( "../../classes/mysql.class.php" );
require_once ( "../../classes/func.global.php" );

$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
$db->query ( "SET NAMES UTF8" );
	
$skinid = isset ( $_POST['skinid'] ) ? $_POST['skinid'] : null;
$skinid = (int)$skinid;

$db->close();