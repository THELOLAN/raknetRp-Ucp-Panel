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
 Файл: admin.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , "Панель администратора" );

$style->content( "{style}" , "" );

if ( user::logged() ) {

	$user = $db->super_query( "SELECT
									`Admin`
								FROM
									`members`
								WHERE 
									`member_id` = '{$uid}'
								LIMIT 1" );

	if ( $user["Admin"] > 0 && $admins == null ) $style->content( "{content}" , "<script>setTimeout(\"document.location.href='{$url}/alogin'\", 2000);</script>" );
	elseif ( $user["Admin"] > 0 && $user["Admin"] <= 9 && $admins != null) {
	
		$style->content( "{content}" , "<div class=\"row\">
											<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
												<center>
													<div class=\"table-responsive\">
														<table class=\"table table-bordered\">
															<tr>
																<td align=\"center\">
																	<a href=\"{$url}/banlog\" class=\"btn btn-block btn-lg btn-primary\">История блокировок</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/mylog\" class=\"btn btn-block btn-lg btn-primary\">Мои блокировки</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/cashlog\" class=\"btn btn-block btn-lg btn-primary\">Кому деньги передали</a>
																</td>
															</tr>
															<tr>
																<td align=\"center\">
																	<a href=\"{$url}/cashtolog\" class=\"btn btn-block btn-lg btn-info\">Кто передал деньги</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/userinfo\" class=\"btn btn-block btn-lg btn-info\">Просмотр профиля</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/ipinfo\" class=\"btn btn-block btn-lg btn-info\">Поиск по IP</a>
																</td>
															</tr>
															<tr>
																<td align=\"center\">
																	<a href=\"{$url}/databaseadmin&params=1\" class=\"btn btn-block btn-lg btn-success\">База преступников</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/fraction\" class=\"btn btn-block btn-lg btn-success\">Мониторинг фракций</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/rshoplog\" class=\"btn btn-block btn-lg btn-success\">История покупок</a>
																</td>
															</tr>
															<tr>
																<td align=\"center\">
																	<a href=\"{$url}/cashlogto\" class=\"btn btn-block btn-lg btn-success\">Передачи денег</a>
																</td>
															</tr>
														</table>
													</div>
												</center>
											</div>
										</div>" );
		
	} elseif ( $user["Admin"] == 10 ) {
	
		$style->content( "{content}" , "<div class=\"row\">
											<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
												<center>
													<div class=\"table-responsive\">
														<table class=\"table table-bordered\">
															<tr>
																<td align=\"center\">
																	<a href=\"{$url}/banlog\" class=\"btn btn-block btn-lg btn-primary\">История блокировок</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/mylog\" class=\"btn btn-block btn-lg btn-primary\">Мои блокировки</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/cashlog\" class=\"btn btn-block btn-lg btn-primary\">Кому деньги передали</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/rshoplog\" class=\"btn btn-block btn-lg btn-success\">История покупок</a>
																</td>
															</tr>
															<tr>
																<td align=\"center\">
																	<a href=\"{$url}/cashtolog\" class=\"btn btn-block btn-lg btn-info\">Кто передал деньги</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/userinfo\" class=\"btn btn-block btn-lg btn-info\">Просмотр профиля</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/ipinfo\" class=\"btn btn-block btn-lg btn-info\">Поиск по IP</a>
																</td>
															</tr>
															<tr>
																<td align=\"center\">
																	<a href=\"{$url}/databaseadmin&params=1\" class=\"btn btn-block btn-lg btn-success\">База преступников</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/fraction\" class=\"btn btn-block btn-lg btn-success\">Мониторинг фракций</a>
																</td>
																<td align=\"center\">
																	<a href=\"{$url}/donatepoint\" class=\"btn btn-block btn-lg btn-success\">Злосные донатеры</a>
																</td>
															</tr>
															<tr>
																<td align=\"center\">
																	<a href=\"{$url}/cashlogto\" class=\"btn btn-block btn-lg btn-success\">Передачи денег</a>
																</td>
															</tr>
														</table>
													</div>
												</center>
											</div>
										</div>" );
	
	}
	
}


$style->content( "{script}" , "" );