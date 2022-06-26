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

$query = $db->super_query("SELECT `Online`, `DonateMREAL` FROM `members` WHERE `member_id` = '{$number}' LIMIT 1");
$banlog = $db->super_query("SELECT * FROM `banlog` WHERE `tid` = '{$number}' ORDER BY `banlog`.`id` DESC LIMIT 1");

$money = $query['DonateMREAL']-600;

if ( $query['DonateMREAL'] <= 599 ) echo "<div class=\"alert alert-danger\">На вашем аккаунте не хватает средств!</div>";
elseif ( $number != $uid ) echo "<div class=\"alert alert-danger\">Анука не шали!</div>";
elseif ( $query['Online'] >= 1 ) echo "<div class=\"alert alert-danger\">Ваш персонаж находится в игре!</div>";
elseif ( time() < $banlog['udate'] )
{ 
	$db->query("UPDATE `members` SET `DonateMREAL` = '{$money}' WHERE `member_id` = '{$number}'");
	$db->query("UPDATE `banlog` SET `udate` = '" . time() . "' WHERE `tid` = '{$number}'");
	$db->query("INSERT INTO `unbanlog` (`aid`, `tid`, `unblocktime`, `blocktime`) VALUES ('0', '{$number}', '" . time() . "', '0')");
	$db->query("INSERT INTO `rshop` (`userid`, `name`, `time`, `item`) VALUES ('{$number}', '{$sname}', '" . time() . "', '1')");
	echo "<div class=\"alert alert-info\">Вы были разблокированы!</div>";
}
else echo "<div class=\"alert alert-danger\">На вашем аккаунте нет блокировок!</div>";
$db->close();