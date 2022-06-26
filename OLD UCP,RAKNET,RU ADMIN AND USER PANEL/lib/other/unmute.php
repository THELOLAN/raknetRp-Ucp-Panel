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

$query = $db->super_query("SELECT `Online`, `MuteTime`, `DonateMREAL` FROM `members` WHERE `member_id` = '{$number}' LIMIT 1");

$money = $query['DonateMREAL']-20;

if ( $query['DonateMREAL'] <= 19 ) echo "<div class=\"alert alert-danger\">На вашем аккаунте не хватает средств!</div>";
elseif ( $number != $uid ) echo "<div class=\"alert alert-danger\">Анука не шали!</div>";
elseif ( $query['Online'] >= 1 ) echo "<div class=\"alert alert-danger\">Ваш персонаж находится в игре!</div>";
elseif ( $query['MuteTime'] != 0 ) { 
	
	$db->query("UPDATE `members` SET `MuteTime` = '0', `DonateMREAL` = '{$money}' WHERE `member_id` = '{$number}'");
	$db->query("INSERT INTO `rshop` (`userid`, `name`, `time`, `item`) VALUES ('{$number}', '{$sname}', '" . time() . "', '3')");
	echo "<div class=\"alert alert-info\">Поздравляем ваш персонаж снова может говорить!</div>";
	
} 
else echo "<div class=\"alert alert-danger\">На вашем аккаунте нет блокировки чата!</div>";
$db->close();