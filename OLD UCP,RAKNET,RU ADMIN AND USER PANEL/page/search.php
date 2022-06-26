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
 Файл: monitoring.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , "Мониторинг игроков" );

$style->content( "{style}" , "" );

$text = "";

$param = isset ( $_POST['player'] ) ? $_POST['player'] : null;

$param = $db->safesql( $param );

$player = $db->super_query("SELECT 
								`A`.`member_id`, 
								`A`.`name`, 
								`A`.`Level`, 
								`A`.`Job`, 
								`A`.`Member`, 
								`A`.`Rank`,
								`A`.`Char`, 
								`A`.`Online`, 
								`B`.`id`, 
								`B`.`time` 
							FROM 
								`members` AS A 
							LEFT JOIN 
								`smember_log` AS B 
							ON 
								( `B`.`userid` = `A`.`member_id` )
							WHERE 
								`A`.`name` LIKE '%{$param}%'
							AND 
								`B`.`browser` LIKE '%0.3%'
							ORDER BY
								`B`.`id`
							DESC LIMIT 1");

if ( $param == "" ) $text .= "<div class=\"alert alert-danger\">Заполните все поля.</div>";
elseif ( !preg_match ( "/^[A-z]+_[A-z]*?$/i" , $param ) ) $text .= "<div class=\"alert alert-danger\">Неверно введено имя игрока.</div>";
elseif ( !$player['name'] ) $text .= "<div class=\"alert alert-danger\">Игрок не найден.</div>";
else $text .= "<tr><td><img src=\"{$url}/{$dir}/{$template}/img/avatars/{$player['Char']}.png\" width=\"35\"></td><td>{$player['name']}</td><td>{$player['Level']}</td><td>" . user::job ( $player['Job'] ) . "</td><td>" . user::fraction ( $player['Member'] ) . "</td><td>" . user::rank ( $player['Member'] , $player['Rank'] ) . "</td><td>" . date( "d.m.Y в H:i" , $player['time'] ) . "</td><td>" . other::online ( $player['Online'] ) . "</td></tr>";

$style->content( "{content}" , "<div class=\"row\">
					<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
						<div class=\"table-responsive\">
							<table class=\"table text-center\">
								<thead>
									<tr>
										<th><center></center></th>
										<th><center>Имя игрока</center></th>
										<th><center>LVL</center></th>
										<th><center>Работа</center></th>
										<th><center>Организация</center></th>
										<th><center>Ранг</center></th>
										<th><center>Дата последнего входа</center></th>
										<th><center>Статус</center></th>
									</tr>
								</thead>
								<tbody>
									{$text}
								</tbody>
							</table>
						</div>
					</div>
				</div>" );

$style->content( "{script}" , "" );