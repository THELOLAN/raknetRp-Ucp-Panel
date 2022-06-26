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
 Файл: cashlog.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , "История переводов" );

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
												<div class=\"table-responsive\" style=\"height: 700px; overflow: auto;\">							
													<form class=\"smart-form\" method=\"POST\" action=\"\" id=\"information\">
														<div class=\"input-group\">
															<span class=\"input-group-addon\">
																<i class=\"fa fa-search\"></i>
															</span>
															<input class=\"form-control\" style=\"width: 160px;\" type=\"text\" placeholder=\"День\" name=\"d\">
															<input class=\"form-control\" style=\"width: 160px;\" type=\"text\" placeholder=\"Месяц\" name=\"m\">
															<input class=\"form-control\" style=\"width: 160px;\" type=\"text\" placeholder=\"Год\" name=\"y\">
															<span class=\"input-group-addon\">
																<i class=\"fa fa-usd\"></i>
															</span>
															<input class=\"form-control\" style=\"width: 160px;\" type=\"text\" placeholder=\"Сумма от\" name=\"money\" value=\"0\">
														</div>
														<button type=\"button\" class=\"btn btn-lg btn-primary\" onclick=\"info();\">Получить информацию</button>
													</form>
													<table class=\"table text-center\">
														<thead>
															<tr>
																<th><center>IP - Адрес</center></th>
																<th><center>Кому передали</center></th>
																<th><center>Номер аккаунта - IP</center></th>
																<th><center>Имя передаваемого</center></th>
																<th><center>Номер аккаунта - IP</center></th>
																<th><center>Сумма</center></th>
																<th><center>Дата перевода</center></th>
															</tr>
														</thead>
														<tbody id=\"result\"></tbody>
													</table>
												</div>
											</div>
										</div>" );
	
	}
}

$style->content( "{script}" , "<script type=\"text/javascript\">
									function info(){
										$.ajax({
											type: \"POST\",
											url: \"{$url}/lib/other/admin/cashlogto.php\",
											data: $(\"#information\").serialize(),
											success: function(data) {
												document.getElementById(\"result\").innerHTML = data;
											},
											error: function(data) {
												document.getElementById(\"result\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
											}
										});
									};
								</script>" );