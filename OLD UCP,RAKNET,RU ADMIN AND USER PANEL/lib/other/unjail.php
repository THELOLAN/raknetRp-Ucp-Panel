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

$query = $db->super_query("SELECT `Online`, `JailedTime`, `DonateMREAL` FROM `members` WHERE `member_id` = '{$number}' LIMIT 1");

$money = $query['DonateMREAL']-200;

if ( $query['DonateMREAL'] <= 199 ) echo "<div class=\"alert alert-danger\">На вашем аккаунте не хватает средств!</div>";
elseif ( $number != $uid ) echo "<div class=\"alert alert-danger\">Анука не шали!</div>";
elseif ( $query['Online'] >= 1 ) echo "<div class=\"alert alert-danger\">Ваш персонаж находится в игре!</div>";
elseif ( $query['JailedTime'] != 0 ) { 
	
	$db->query("UPDATE `members` SET `JailedTime` = '0', `DonateMREAL` = '{$money}', `WantedPoints` = '0', `Cuffed` = '0', `MestoJail` = '0', `posX` = '1742.3113', `posY` = '-1860.0815', `posZ` = '13.5792', `pint` = '0', `pvir` = '0' WHERE `member_id` = '{$number}'");
	$db->query("INSERT INTO `rshop` (`userid`, `name`, `time`, `item`) VALUES ('{$number}', '{$sname}', '" . time() . "', '2')");
	$db->query("DELETE FROM `police` WHERE `userid` = '{$number}'");
	echo "<div class=\"alert alert-info\">Поздравляем ваш персонаж чист перед законом!</div>";
	
} 
else echo "<div class=\"alert alert-danger\">Вы уже чисты перед законом!</div>";
$db->close();