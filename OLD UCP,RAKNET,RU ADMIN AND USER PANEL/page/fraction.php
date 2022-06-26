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

$style->content( "{page}" , "Мониторинг фракций" );

$style->content( "{style}" , "" );

$style->content( "{script}" , "" );

if ( user::logged() ) {

	$param = isset ( $_GET['param'] ) ? $_GET['param'] : "";
	$param = (int)$param;
	
	$user = $db->super_query("SELECT `Member`, `Admin` FROM `members` WHERE `member_id` = '{$uid}' LIMIT 1");

	$message = "";
	$i = 0;
	
	if ( $user['Admin'] > 0 ) {
	
		if ( $param == "" && $param == 0 ) {
		
			$style->content( "{content}" , "<div class=\"row\">
												<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
													<ol>
														<li><a href=\"{$url}/fraction&param=1\">" . user::fprofile( 1 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=2\">" . user::fprofile( 2 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=3\">" . user::fprofile( 3 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=4\">" . user::fprofile( 4 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=5\">" . user::fprofile( 5 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=6\">" . user::fprofile( 6 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=7\">" . user::fprofile( 7 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=8\">" . user::fprofile( 8 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=9\">" . user::fprofile( 9 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=10\">" . user::fprofile( 10 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=11\">" . user::fprofile( 11 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=12\">" . user::fprofile( 12 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=13\">" . user::fprofile( 13 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=14\">" . user::fprofile( 14 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=15\">" . user::fprofile( 15 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=16\">" . user::fprofile( 16 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=17\">" . user::fprofile( 17 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=18\">" . user::fprofile( 18 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=19\">" . user::fprofile( 19 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=20\">" . user::fprofile( 20 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=21\">" . user::fprofile( 21 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=22\">" . user::fprofile( 22 ) . "</a></li>
														<li><a href=\"{$url}/fraction&param=23\">" . user::fprofile( 23 ) . "</a></li>
													</ol>
												</div>
											</div>" );
		} else {
		
			$player = $db->query("SELECT `member_id`, `name`, `Level`, `Rank`, `Char`, `Online` FROM `members` WHERE `Member` = '{$param}' ORDER BY `Online` DESC");
			while ( $play = $db->get_row( $player ) ) {
			
				$login = $db->super_query("SELECT `time` FROM `smember_log` WHERE `userid` = '{$play['member_id']}' AND `browser` = '0.3z-R2' ORDER BY `id` DESC LIMIT 1");
				$i++;
				$message .= "<tr><td><img src=\"{$url}/{$dir}/{$template}/img/avatars/{$play["Char"]}.png\" width=\"35\"></td><td><a href=\"{$url}/databaseadmin&param={$play["member_id"]}\">{$play["name"]}</a></td><td>{$play["Level"]}</td><td>" . user::frank ( $param , $play["Rank"] ) . "</td><td>" . other::online ( $play["Online"] ) . "</td><td>" . date ( "d.m.Y в H:i" , $login["time"] ) . "</td></tr>";
			
			}
			$style->content( "{content}" , "<div class=\"row\">
												<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
													<h3>" . user::fprofile( $param ) . ". Кол-во: {$i} чел.</h3>
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