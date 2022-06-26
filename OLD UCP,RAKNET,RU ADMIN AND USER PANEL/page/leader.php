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
 Файл: ledaer.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , "Панель лидера" );

$style->content( "{style}" , "" );

$style->content( "{script}" , "" );

if ( user::logged() ) {

	$param = isset ( $_GET['param'] ) ? $_GET['param'] : "";
	$param = (int)$param;

	$user = $db->super_query("SELECT `Member`, `Leader` FROM `members` WHERE `member_id` = '{$uid}' LIMIT 1");

	$message = "";
	$i = 0;
	
	if ( $user['Leader'] > 0 ) {
	
		$style->content( "{content}" , "<div class=\"row\">
											<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
												<h3>Управление - Мониторинг фракции</h3>
												<div class=\"thumbnail\">
													<a href=\"{$url}/lmenu&param={$user["Member"]}\"><img src=\"{$url}/{$dir}/{$template}/img/mon.png\"></a>
												</div>
											</div>
										</div>" );
											
		if ( $param == $user["Member"] ) {

			$player = $db->query("SELECT `member_id`, `name`, `Level`, `Rank`, `Char`, `Online` FROM `members` WHERE `Member` = '{$user["Member"]}' ORDER BY `members`.`Online` DESC");
			while ( $play = $db->get_row( $player ) ) {
			
				$login = $db->super_query("SELECT `time` FROM `smember_log` WHERE `userid` = '{$play['member_id']}' AND `browser` = '0.3z-R2' ORDER BY `id` DESC LIMIT 1");
				$i++;
				$message .= "<tr><td><img src=\"{$url}/{$dir}/{$template}/img/avatars/{$play["Char"]}.png\" width=\"35\"></td><td><a href=\"{$url}/user&member={$play["member_id"]}\">{$play["name"]}</a></td><td>{$play["Level"]}</td><td>" . user::rank ( $user["Member"] , $play["Rank"] ) . "</td><td>" . other::online ( $play["Online"] ) . "</td><td>" . date ( "d.m.Y в H:i" , $login["time"] ) . "</td></tr>";
			
			}
			$style->content( "{content}" , "<div class=\"row\">
												<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
													<h3>" . user::fraction( $user["Member"] ) . ". Кол-во: {$i} чел.</h3>
													<table class=\"table\">
														<thead>
															<th>
																Аватар
															</th>
															<th>
																Имя
															</th>
															<th>
																LVL
															</th>
															<th>
																Ранг
															</th>
															<th>
																Статус
															</th>
															<th>
																Последний вход
															</th>
														</thead>
														<tbody>
															{$message}
														</tbody>
													</table>
												</div>
											</div>" );
		}
		
	} else $style->content( "{content}" , "" );
}