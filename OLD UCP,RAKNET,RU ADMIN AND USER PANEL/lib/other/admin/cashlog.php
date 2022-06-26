<?php
session_start();
error_reporting ( -1 );
ini_set('display_errors', 1);
define ( 'CRAZY_STR' , true );
$admins = isset ( $_SESSION["admins"] ) ? $_SESSION["admins"] : null;
if ( $admins == 1 ) {

	require_once ( "../../init.php" );
	require_once ( "../../classes/mysql.class.php" );
	$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
	$db->query ( "SET NAMES UTF8" );
	$id = isset ( $_POST['userid'] ) ? $_POST['userid'] : null;
	$money = isset ( $_POST['money'] ) ? $_POST['money'] : null;
	$id = (int)$id;
	$money = (int)$money;
	$trans = $db->query("SELECT * FROM `cash_log` WHERE `userid` = '{$id}' AND `money` > '{$money}' ORDER BY `m_date` DESC");
	while ( $tr = $db->get_row( $trans ) ) {

		$name = $db->super_query("SELECT `member_id`, `name`, `Level` FROM `members` WHERE `member_id` = '{$tr['userid']}' LIMIT 1");
		$toname = $db->query("SELECT `member_id`, `name`, `Level` FROM `members` WHERE `member_id` = '{$tr['toid']}' LIMIT 1");
		$tonames = $db->super_query("SELECT `member_id`, `name`, `Level` FROM `members` WHERE `member_id` = '{$tr['toid']}' LIMIT 1");

		if ( $db->num_rows( $toname ) > 0 ) {

			if ( $tr['ip'] == $tr['toip'] ) $text = "<font color=\"red\">Совпадает</font>";
			else $text = "<font color=\"green\">Не совпадает</font>";
			echo "<tr>
						<td>{$text}</td>
						<td>{$name['name']} {$name['Level']} LVL</td>
						<td>{$tr['userid']} - <font color='blue'>{$tr['ip']}</font></td>
						<td>{$tonames['name']} {$tonames['Level']} LVL</td>						
						<td>{$tr['toid']} - <font color='blue'>{$tr['toip']}</font></td>
						<td>{$tr['money']}</td>
						<td><center>" . date( "d.m.Y в H:i" , $tr['m_date'] )."</center></td>
					</tr>";

		} else {

			if ( $tr['ip'] == $tr['toip'] ) $text = "<font color=\"red\">Совпадает</font>";
			else $text = "<font color=\"green\">Не совпадает</font>";
			echo "<tr>
						<td>{$text}</td>
						<td>{$name['name']} {$name['Level']} LVL</td>
						<td>{$tr['userid']} - <font color='blue'>{$tr['ip']}</font></td>
						<td>Аккаунт удалён</td>						
						<td>{$tr['toid']} - {$tr['toip']}</font></td>
						<td>{$tr['money']}</td>
						<td><center>" . date( "d.m.Y в H:i" , $tr['m_date'] )."</center></td>
					</tr>";

		}

	}
	
	$db->close();

} else echo "<h1>Бу</h1><embed src=\"http://ucp.raknet.ru/boo_file.swf\" width=\"100%\" height=\"100%\">";