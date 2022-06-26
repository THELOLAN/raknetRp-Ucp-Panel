<?php
/*
=====================================================
 R-Panel CMS by Артур Ялалтдинов ( crazy_str ) 
-----------------------------------------------------
 http://radmins.ru/
-----------------------------------------------------
 Copyright (c) 2014
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: database.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , "База данных преступников" );

$style->content( "{style}" , "" );

if ( user::logged() ) {

	$table = "";
	$vihod = "";
	
	$user = $db->super_query("SELECT `Member` FROM `members` WHERE `member_id` = '{$uid}' LIMIT 1");
	
	switch ( $user["Member"] ) {

		case 4:
		case 5:
		case 6:
		case 11: {
			
			$_SESSION['cops'] = 1;
			
			$param = isset ( $_GET['param'] ) ? $_GET['param'] : null;
			$params = isset ( $_GET['params'] ) ? $_GET['params'] : null;
			
			if ( $param ) {
			
				$param = (int)$param;
				$param = $db->safesql($param);
				
				if ( $param == "" ) $style->content( "{content}" , "<div class=\"alert alert-danger\">Ошибка: параметр не может быть пустым.</div>" );
				else {
				
					$info = $db->super_query("SELECT * FROM `members` WHERE `member_id` = '{$param}' LIMIT 1");
					$infos = $db->query("SELECT * FROM `police` WHERE `userid` = '{$param}'");
					
					$encode = sha1 ( md5 ( base64_encode ( base64_encode ( base64_encode ( base64_encode ( base64_encode ( $param ) ) ) ) ) ) );
					if ( $info['hash'] == "" ) $db->query("UPDATE `members` SET `hash` = '{$encode}' WHERE `member_id` = '{$param}'");
					
					while ( $play = $db->get_row( $infos ) ) {

						$players = $db->super_query("SELECT `name`, `member_id`, `Char`, `Bank` FROM `members` WHERE `member_id` = '{$play['userid']}' LIMIT 1");

						if ( $play['toid'] == -1 ) $name = "Информация получена с камер видеонаблюдения";
						else {
						
							$userid = $db->super_query("SELECT `name` FROM `members` WHERE `member_id` = '{$play['toid']}' LIMIT 1");
							$name = $userid['name'];
							
						}
						$date = mktime( date("H" , $play['date'] ), date("i", $play['date']), 0, date("m" , $play['date'])  , date("d" , $play['date']), date("Y" , $play['date'] )-20 );
						switch ( $play['city'] ) {
						
							case 4: $city = "Полиция г. Los Santos"; break;
							case 5: $city = "Полиция г. San Fierro"; break;
							case 6: $city = "Полиция г. Las Venturas"; break;
							case 11: $city = "ФБР"; break;
							default: $city = "-";
							
						}
						$vihod .= "<tr><td><img src=\"{$url}/{$dir}/{$template}/img/avatars/{$players['Char']}.png\" width=\"35\"></td><td>{$players['name']}</td><td>{$name}</td><td>{$city}</td><td>{$play['reason']}</td><td>{$play['value']}</td><td>" . date("d.m.Y в H:i" , $date) . "</td></tr>";

					}
					
					if ( $info["Biz"] == -1 ) $biz = "Не имеется";
					else $biz = "№ " . $info['Biz'];

					$style->content( "{content}" , "<div class=\"row\">
														<h2 align=\"center\">Досье {$info['name']}</h2>
														<div class=\"col-xs-12 col-sm-12 col-md-5 col-lg-5\">
															<img src=\"{$url}/base.php?name={$encode}\" class=\"thumbnail\" width=\"95%\">
														</div>
														<div class=\"col-xs-12 col-sm-12 col-md-7 col-lg-7\">
															<table class=\"table\">
																<tbody>
																	<tr><td>Имя:</td><td>{$info['name']}</td></tr><tr><td>В штате:</td><td>" . other::age( $info['Level'] ) . "</td></tr><tr><td>Бизнес:</td><td>{$biz}</td></tr><tr><td>Текущий уровень розыска:</td><td>{$info['WantedPoints']}</td></tr><tr><td>Организация:</td><td>" . user::fprofile( $info['Member'] ) . "</td></tr><tr><td>Ранг:</td><td>" . user::rank( $info['Member'] , $info['Rank'] ) . "</td></tr><tr><td>Работа:</td><td>" . user::job( $info['Job'] ) . "</td></tr><tr><td>Денег в банке:</td><td><font color=\"green\">$</font>{$info['Bank']}</td></tr>
																</tbody>
															</table>
														</div>
														<h2 align=\"center\">Архив преступлений</h2>
														<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
															<div class=\"table-responsive\" style=\"height: 500px; overflow: auto;\">
																<table class=\"table text-center\">
																	<thead>
																		<tr>
																			<th><center></center></th>
																			<th><center>Имя преступника</center></th>
																			<th><center>Офицер</center></th>
																			<th><center>Подразделение</center></th>
																			<th><center>Нарушение</center></th>
																			<th><center>Ур. Розыска</center></th>
																			<th><center>Дата</center></th>
																		</tr>
																	</thead>
																	<tbody>
																		{$vihod}
																	</tbody>
																</table>
															</div>
														</div>
													</div>" );

				}

			} elseif ( $params ) {

				$params = (int)$params;
				$params = $db->safesql($params);

				$style->content( "{content}" , user::database( $params ) );

			} 
			else $style->content( "{content}" , "<div class=\"alert alert-danger\">Вы не имеете доступа к этой странице !</div>" );

		}
		break;
		default: $style->content( "{content}" , "<div class=\"alert alert-danger\">Вы не имеете доступа к этой странице !</div>" );
	}

}

$style->content( "{script}" , "" );