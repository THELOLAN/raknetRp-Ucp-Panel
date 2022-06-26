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

$number = isset ( $_POST['number'] ) ? $_POST['number'] : null;
$number = (int)$number;
$number = ltrim($number, '0');

$ids = isset ( $_POST['uid'] ) ? $_POST['uid'] : null;
$ids = (int)$ids;

$player = $db->super_query("SELECT `Online`, `DonateMREAL` FROM `members` WHERE `member_id` = '{$uid}' LIMIT 1");
$query = $db->super_query("SELECT `Pnumber` FROM `members` WHERE `Pnumber` = '{$number}' LIMIT 1");


foreach (count_chars($number, 1) as $i => $val) {

	if ( $val == 2 ) {
		$money = $player['DonateMREAL']-50;
		$price = 50;
	}
	elseif ( $val == 3 ) {
		$money = $player['DonateMREAL']-60;
		$price = 60;
	}
	elseif ( $val == 4 ) {
		$money = $player['DonateMREAL']-70;
		$price = 70;
	}
	elseif ( $val == 5 ) {
		$money = $player['DonateMREAL']-80;
		$price = 80;
	}
	elseif ( $val == 6 ) {
		$money = $player['DonateMREAL']-90;
		$price = 90;
	}
	elseif ( $val == 7 ) {
		$money = $player['DonateMREAL']-100;
		$price = 100;
	}
	elseif ( $val == 8 ) {
		$money = $player['DonateMREAL']-110;
		$price = 110;
	}
	else {
		$money = $player['DonateMREAL']-40;
		$price = 40;
	}

}

if ( $number == "" ) echo "<div class=\"alert alert-danger\">Заполните все поля!</div>";
elseif ( strlen ( $number ) < 4 || strlen ( $number ) > 8 ) echo "<div class=\"alert alert-danger\">Номер телефона не может быть меньше 4 и больше 8 цифр</div>";
elseif ( $player['DonateMREAL'] < $price ) echo "<div class=\"alert alert-danger\">На вашем аккаунте не хватает средств!<br />Стоимость данного номера составляет: {$price} руб.</div>";
elseif ( $ids != $uid ) echo "<div class=\"alert alert-danger\">Анука не шали!</div>";
elseif ( $player['Online'] >= 1 ) echo "<div class=\"alert alert-danger\">Ваш персонаж находится в игре!</div>";
elseif ( $number == $query['Pnumber'] ) echo "<div class=\"alert alert-danger\">Данный номер уже кем то используется!</div>";
else {

	//$db->query("UPDATE `members` SET `Pnumber` = '{$number}', `DonateMREAL` = '{$money}' WHERE `member_id` = '{$uid}'");
	echo "<div class=\"alert alert-success\">Данный номер свободен, его стоимость составляет: {$price} руб.</div>";

}
$db->close();