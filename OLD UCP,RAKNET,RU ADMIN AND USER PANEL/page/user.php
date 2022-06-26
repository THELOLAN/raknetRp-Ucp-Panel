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
 Файл: user.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , "Панель лидера" );

$style->content( "{style}" , "" );

$style->content( "{script}" , "" );

$param = isset ( $_GET['member'] ) ? $_GET['member'] : "";
$param = (int)$param;

$user = $db->super_query("SELECT `Leader` FROM `members` WHERE `member_id` = '{$uid}' LIMIT 1");
$player = $db->super_query("SELECT `member_id`, `name`, `Level`, `Member`, `Online`, `Char`, `Rank` FROM `members` WHERE `member_id` = '{$param}' LIMIT 1");

if ( $user["Leader"] == 0 ) $style->content( "{content}" , "<div class=\"alert alert-danger\">Ваши полномочия не позволяют просматривать данную страницу!</div>" );
elseif ( $user["Leader"] != $player["Member"] ) $style->content( "{content}" , "<div class=\"alert alert-danger\">Данный пользователь не состоит в вашей организации!</div><script>setTimeout(\"document.location.href='{$url}/lmenu'\", 2000);</script>" );
elseif( $player["Online"] != 0 ) $style->content( "{content}" , "<div class=\"alert alert-danger\">Данный пользователь находится в игре!</div><script>setTimeout(\"document.location.href='{$url}/lmenu'\", 2000);</script>" );
elseif( $player["member_id"] == $uid ) $style->content( "{content}" , "<div class=\"alert alert-danger\">Вы не можете менять свои параметры</div><script>setTimeout(\"document.location.href='{$url}/lmenu'\", 2000);</script>" );
else $style->content( "{content}" , "<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\">
											<img src=\"{$url}/{$dir}/{$template}/img/avatars/{$player["Char"]}.png\">
										</div>
										<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\">
											<table class=\"table table-responsive table-bordered\">
												<tr><td>Имя:</td><td>{$player["name"]}</td></tr>
												<tr><td>В Штате:</td><td>" . other::age( $player["Level"] ) . "</td></tr>
												<tr><td>Ранг:</td><td> " . user::rank( $player["Member"] , $player["Rank"] ) . " </td></tr>
											</table>
										</div>
									</div>" );