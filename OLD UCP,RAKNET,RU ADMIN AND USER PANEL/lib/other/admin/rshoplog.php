<?php
session_start();
error_reporting ( -1 );
ini_set( 'display_errors', -1 );
define ( 'CRAZY_STR' , true );
$admins = isset ( $_SESSION["admins"] ) ? $_SESSION["admins"] : null;
if ( $admins == 1 ) {

	require_once ( "../../init.php" );
	require_once ( "../../classes/mysql.class.php" );

	$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
	$db->query ( "SET NAMES UTF8" );
	
	$name = isset ( $_POST['name'] ) ? $_POST['name'] : null;
	$name = $db->safesql( $name );
	$log = "";
	$tables = $db->query("SELECT * FROM `rshop` WHERE `name` = '{$name}'");
	while ( $table = $db->get_row( $tables ) ) {
	
		switch( $table['item'] ) {
		
			case 1: $text = "Разблокировка аккаунта"; break;
			case 2: $text = "Побег из тюрьмы/деморгана"; break;
			case 3: $text = "Разблокировка чата"; break;
			case 4: $text = "Снятие 1 предупреждения"; break;
			case 5: $text = "Удаление из базы данных преступника"; break;
			case 6: $text = "Полное снятие предупреждений"; break;
			case 7: $text = "Покупка номера телефона"; break;
		
		}
	
		$log .= "<tr>
					<td>
						{$table['id']}
					</td>
					<td>
						{$table['userid']}
					</td>
					<td>
						{$table['name']}
					</td>
					<td>
						" . date ( "d.m.Y в H:i" , $table['time'] ) . "
					</td>
					<td>
						{$text}
					</td>
				</tr>";
	}
	echo "<h2>Shop History</h2>
			<div class=\"row\">
				<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
					<div class=\"table-responsive\" style=\"height: 400px; overflow: auto;\">
						<table class=\"table text-center\">
							<thead>
								<tr>
									<th><center>Номер покупки</center></th>
									<th><center>Номер аккаунта</center></th>
									<th><center>Имя игрока</center></th>
									<th><center>Дата покупки</center></th>
									<th><center>Содержимое</center></th>
								</tr>
							</thead>
							<tbody>
								{$log}
							</tbody>
						</table>
					</div>
				</div>
			</div>";
	
	$db->close();

} 
else echo "<h1>Бу</h1><embed src=\"http://ucp.raknet.ru/boo_file.swf\" width=\"100%\" height=\"100%\">";