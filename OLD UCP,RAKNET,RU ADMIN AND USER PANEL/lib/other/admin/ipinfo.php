<?php
session_start();
error_reporting ( 0 );
ini_set('display_errors', 0);
define ( 'CRAZY_STR' , true );
$admins = isset ( $_SESSION["admins"] ) ? $_SESSION["admins"] : null;
if ( $admins == 1 ) {

	$info = "";
	require_once ( "../../init.php" );
	require_once ( "../../classes/mysql.class.php" );
	$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
	$db->query ( "SET NAMES UTF8" );
	$ip = isset ( $_POST['ipinfo'] ) ? $_POST['ipinfo'] : null;
	$ip = $db->safesql($ip);
	$query = $db->query("SELECT * FROM `smember_log` WHERE `ip` LIKE '%{$ip}%' ORDER BY `id` DESC");
	while ( $string = $db->get_row( $query ) ) $info .= "<tr><td>{$string['id']}</td><td>{$string['name']}</td><td>{$string['userid']}</td><td>{$string['browser']}</td><td>{$string['ip']}</td><td>" . date( "d.m.Y в H:i" , $string['time'] ) . "</td></tr>";
	echo "<div class=\"row\">
				<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
					<div class=\"table-responsive\" style=\"height: 700px; overflow: auto;\">
						<table class=\"table text-center\">
							<thead>
								<tr>
									<th><center>Номер авторизации</center></th>
									<th><center>Имя пользователя</center></th>
									<th><center>Номер аккаунта</center></th>
									<th><center>Клиент</center></th>
									<th><center>IP</center></th>
									<th><center>Дата входа</center></th>
								</tr>
							</thead>
							<tbody>
								{$info}
							</tbody>
						</table>
					</div>
				</div>
			</div>";
	$db->close();

} else echo "<h1>Бу</h1><embed src=\"http://ucp.raknet.ru/boo_file.swf\" width=\"100%\" height=\"100%\">";