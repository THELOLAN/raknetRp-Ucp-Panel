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
 Файл: payment.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , $lang['page']['store'] );

$style->content( "{style}" , "" );

if ( user::logged() ) {

	$user = $db->super_query( "SELECT `Admin`, `email`, `DonateMOther`, `DonateRank`, `DonateMREAL`, `Online`, `cname`, `code`, `deladmin` FROM `members` WHERE `member_id` = '{$uid}' LIMIT 1" );
	
	if ( isset ( $_POST['changename'] ) ) require_once ("lib/other/name.php");
	else {

			if ( $user["cname"] == 0 ) $cname = $lang['other']['cname'];
			else $cname = $lang['other']['cname30'];

			$style->content( "{content}" , "<div class=\"row\">
												<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
													<div class=\"row\">
														<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">
															<div class=\"thumbnail\">
																<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal1\" title=\"{$lang['rshop']['changename']['changename']}\"><i class=\"fa fa-4x fa-edit\"></i></a>
																<div class=\"caption\">
																	<h3>{$lang['rshop']['changename']['changename']}</h3>
																	<p>{$lang['rshop']['changename']['lozung']}</p>
																	<p><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal1\" title=\"{$lang['rshop']['changename']['changename']}\" class=\"btn btn-primary\">{$lang['button']['start']}</a>
																</div>
															</div>
														</div>
														<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">
															<div class=\"thumbnail\">
																<a href=\"{$url}/store&param=4\" title=\"{$lang['rshop']['other']['other']}\"><i class=\"fa fa-4x fa-archive\"></i></a>
																<div class=\"caption\">
																	<h3>{$lang['rshop']['other']['other']}</h3>
																	<p>{$lang['rshop']['other']['lozung']}</p>
																	<p><a href=\"{$url}/store&param=4\" title=\"{$lang['rshop']['other']['other']}\" class=\"btn btn-primary\">{$lang['button']['next']}</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class=\"modal fade\" id=\"myModal1\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
												<div class=\"modal-dialog\">
													<div class=\"modal-content\">
														<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
															<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
														</div>
														<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
															<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">{$cname}</h4>
															<form action=\"\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
																<fieldset>
																	<section>
																		<label class=\"label\">{$lang['other']['param']['entername']}</label>
																		<label class=\"input\"> 
																			<i class=\"icon-append fa fa-edit\"></i>
																			<input type=\"text\" name=\"name\" maxlength=\"22\">
																			<b class=\"tooltip tooltip-top-right\">
																				<i class=\"fa fa-edit txt-color-teal\"></i> {$lang['other']['param']['entername']}
																			</b>
																		</label>
																	</section>
																	<section>
																		<label class=\"label\">{$lang['other']['param']['enternewname']}</label>
																		<label class=\"input\"> 
																			<i class=\"icon-append fa fa-edit\"></i>
																			<input type=\"text\" name=\"oname\" maxlength=\"22\">
																			<b class=\"tooltip tooltip-top-right\">
																				<i class=\"fa fa-edit txt-color-teal\"></i> {$lang['other']['param']['enternewname']}
																			</b>
																		</label>
																	</section>
																	<section>
																		<center>
																			<a href=\"#\" onclick=\"document.getElementById('security').src='{$url}/security.php?'+Math.random(); return false;\"><img id=\"security\" src=\"{$url}/security.php\" align=\"center\"></a>
																		</center>
																		<label class=\"label\">{$lang['other']['param']['security']}</label>
																		<label class=\"input\"> 
																			<i class=\"icon-append fa fa-lock\"></i>
																			<input type=\"text\" name=\"code\" maxlength=\"6\">
																			<b class=\"tooltip tooltip-top-right\">
																				<i class=\"fa fa-lock txt-color-teal\"></i> {$lang['other']['param']['security']}
																			</b>
																		</label>
																	</section>
																</fieldset>
																<footer style=\"background: #fff; border-color: #fff;\">
																	<button type=\"submit\" class=\"btn btn-primary\" name=\"changename\">
																		{$lang['button']['next']}
																	</button>
																</footer>
															</form>
														</div>
													</div>
												</div>
											</div>
											<div class=\"modal fade\" id=\"myModal2\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
												<div class=\"modal-dialog\">
													<div class=\"modal-content\">
														<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
															<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
														</div>
														<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
															<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">Покупка одежды</h4>
															<form action=\"\" id=\"skin_type\" class=\"smart-form client-form\" method=\"POST\">
																<fieldset>
																	<section>
																		<label class=\"label\">Введите номер скина</label>
																		<label class=\"input\"> 
																			<i class=\"icon-append fa fa-child\"></i>
																			<input type=\"text\" name=\"skin\" maxlength=\"3\">
																			<b class=\"tooltip tooltip-top-right\">
																				<i class=\"fa fa-child txt-color-teal\"></i> Введите номер скина
																			</b>
																		</label>
																	</section>
																	<section>
																		<div id=\"result\"></div>
																	</section>
																</fieldset>
																<footer style=\"background: #fff; border-color: #fff;\">
																	<button type=\"button\" onclick=\"typeSkin();\" class=\"btn btn-primary\">
																		Получить информацию
																	</button>
																</footer>
															</form>
														</div>
													</div>
												</div>
											</div>" );
		
	}
	
}
$style->content( "{script}" , "<script>
			function typeSkin(){
				$.ajax({
					type: \"POST\",
					url: \"test.php\",
					data: $(\"#skin_type\").serialize(),
					success: function(data) {
						document.getElementById(\"result\").innerHTML = data;
					},
					error: function(data) {
						document.getElementById(\"result\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
					}
				});
			};
			</script>" );