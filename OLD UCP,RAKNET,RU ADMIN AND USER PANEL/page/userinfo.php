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
 Файл: userinfo.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , "История входов" );

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
	
		$style->content( "{content}" , "<div class=\"row\">
											<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
												<div class=\"table-responsive\">							
													<form class=\"smart-form\" method=\"POST\" action=\"\" id=\"information\">
														<div class=\"input-group\">
															<span class=\"input-group-addon\">
																<i class=\"fa fa-search\"></i>
															</span>
															<input class=\"form-control\" style=\"width: 160px;\" type=\"text\" placeholder=\"Введите имя игрока\" name=\"name\">
														</div>
														<button type=\"button\" class=\"btn btn-lg btn-primary\" onclick=\"info();\">Получить информацию</button>
													</form>
													<form class=\"smart-form\" method=\"POST\" action=\"\" id=\"informationid\">
														<div class=\"input-group\">
															<span class=\"input-group-addon\">
																<i class=\"fa fa-search\"></i>
															</span>
															<input class=\"form-control\" style=\"width: 160px;\" type=\"text\" placeholder=\"Или номер аккаунта\" name=\"userid\">
														</div>
														<button type=\"button\" class=\"btn btn-lg btn-primary\" onclick=\"infoid();\">Получить информацию</button>
													</form>
												</div>
											</div>
										</div>
										<div id=\"result\"></div>
										<div id=\"results\"></div>" );
	
	}
}

$style->content( "{script}" , "<script type=\"text/javascript\">
									var pagefunction = function() {
										$('.progress-bar').progressbar({
											display_text : 'fill'
										});
									};
									loadScript(\"{$url}/{$dir}/{$template}/js/plugin/bootstrap-progressbar/bootstrap-progressbar.min.js\", pagefunction);
									pageSetUp();
								</script>
								<script type=\"text/javascript\">
									function info(){
										$.ajax({
											type: \"POST\",
											url: \"{$url}/lib/other/admin/userinfo.php\",
											data: $(\"#information\").serialize(),
											success: function(data) {
												document.getElementById(\"result\").innerHTML = data;
											},
											error: function(data) {
												document.getElementById(\"result\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
											}
										});
									};
									function infoid(){
										$.ajax({
											type: \"POST\",
											url: \"{$url}/lib/other/admin/userinfoid.php\",
											data: $(\"#informationid\").serialize(),
											success: function(data) {
												document.getElementById(\"results\").innerHTML = data;
											},
											error: function(data) {
												document.getElementById(\"results\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
											}
										});
									};
								</script>" );