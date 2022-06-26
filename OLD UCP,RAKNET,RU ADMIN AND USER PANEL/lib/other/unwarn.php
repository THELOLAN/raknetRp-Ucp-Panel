<?php
session_start();
error_reporting ( 0 );
ini_set( 'display_errors', 0 );
define ( 'CRAZY_STR' , true );

require_once ( "../init.php" );
require_once ( "../classes/mysql.class.php" );
require_once ( "../classes/func.global.php" );
$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
$db->query ( "SET NAMES UTF8" );

$number = isset ( $_POST['uid'] ) ? $_POST['uid'] : null;
$number = (int)$number;

$query = $db->super_query("SELECT `Online`, `Warns`, `DonateMREAL` FROM `members` WHERE `member_id` = '{$number}' LIMIT 1");

$money = $query['DonateMREAL']-300;
$warn = $query['Warns']-1;

if ( $query['DonateMREAL'] <= 299 ) echo "<div class=\"alert alert-danger\">На вашем аккаунте не хватает средств!</div>";
elseif ( $number != $uid ) echo "<div class=\"alert alert-danger\">Анука не шали!</div>";
elseif ( $query['Online'] >= 1 ) echo "<div class=\"alert alert-danger\">Ваш персонаж находится в игре!</div>";
elseif ( $query['Warns'] != 0 ) { 
	
	switch ( $query['Warns'] ) {
	
		case 1: $warns = "15"; break;
		case 2: $warns = "30"; break;
		case 3: $warns = "45"; break;
		
	}
	$db->query("UPDATE `members` SET `WarnsNumeric` = '{$warns}', `Warns` = '{$warn}', `DonateMREAL` = '{$money}' WHERE `member_id` = '{$number}'");
	$db->query("INSERT INTO `rshop` (`userid`, `name`, `time`, `item`) VALUES ('{$number}', '{$sname}', '" . time() . "', '4')");
	echo "<div class=\"alert alert-info\">С вас было снято 1 предупреждение!</div>";
	
}
else echo "<div class=\"alert alert-danger\">На вашем аккаунте нет предупреждений!</div>";
$db->close();