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
 Файл: banlog.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , "Мои блокировки" );

$style->content( "{style}" , "" );
if ( user::logged () ) {

	$user = $db->super_query( "SELECT
									`Admin`
								FROM
									`members`
								WHERE 
									`member_id` = '{$uid}'
								LIMIT 1" );

	if ( $user["Admin"] > 0 && $admins == null ) $style->content( "{content}" , "<script>setTimeout(\"document.location.href='{$url}/alogin'\", 2000);</script>" );
	else {
	
		$message = "";
		$log = $db->query("SELECT * FROM `banlog` WHERE `aid` = '{$uid}' ORDER BY `id` DESC");
		while ( $ban = $db->get_row( $log ) ) {
		
			$tid = $db->super_query("SELECT `name` FROM `members` WHERE `member_id` = '{$ban['tid']}' LIMIT 1");
			$message .= "<tr><td><center>{$ban['id']}</center></td><td><center><a href=\"{$url}/profuser&uid={$ban['tid']}\" target=\"_blank\">{$tid['name']}</a></center></td><td><center>{$sname}</center></td><td><center>" . date ( "d.m.Y в H:i" , $ban['bdate'] ) . "</center></td><td><center>" . date ( "d.m.Y в H:i" , $ban['udate'] ) . "</center></td><td><center>{$ban['ip']}</center></td><td><center>{$ban['reason']}</center></td></tr>";
		
		}
		$style->content( "{content}" , "<div class=\"row\">
											<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
												<div class=\"table-responsive\" style=\"height: 700px; overflow: auto;\">
													<table class=\"table text-center\">
														<thead>
															<tr>
																<th><center>Номер блокировки</center></th>
																<th><center>Имя игрока</center></th>
																<th><center>Администратор</center></th>
																<th><center>Дата блокировки</center></th>
																<th><center>Дата разблокировки</center></th>
																<th><center>IP - Адрес</center></th>
																<th><center>Причина</center></th>
															</tr>
														</thead>
														<tbody>
															{$message}
														</tbody>
													</table>
												</div>
											</div>
										</div>" );
	}
}

$style->content( "{script}" , "" );