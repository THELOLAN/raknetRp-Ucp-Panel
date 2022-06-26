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

$style->content( "{page}" , $lang['page']['setting'] );

$style->content( "{style}" , "" );

if ( user::logged() ) {

	$setcode = "";
	$validcode = "";
	$log = "";
	$member = $db->super_query("SELECT `Admin`, `email`, `members_pass_hash`, `members_pass_salt`, `Online`, `code` FROM `members` WHERE `member_id` = '{$uid}' LIMIT 1");
	
	if ( isset ( $_POST['pucode'] ) ) {
		
		$pucode = $db->safesql($_POST['pucode']);
		if ( $pucode == "" ) $style->content ("{content}", "<div class=\"alert alert-danger\">Введите код безопасности</div><script>setTimeout(\"document.location.href='{$url}/profile'\", 2000);</script>");
		elseif ( $pucode != $member['code'] ) {
			
			session_destroy();
			$style->content ("{content}", "<div class=\"alert alert-danger\">Неверно введён код безопасности</div><script>setTimeout(\"document.location.href='{$url}/'\", 2000);</script>");
			
		} else {
			
			$_SESSION["codes"] = true;
			$style->content ("{content}", "<div class=\"alert alert-success\">Добро пожаловать, {$sname}</div><script>setTimeout(\"document.location.href='{$url}/profile'\", 2000);</script>");
			
		}
		
	} else {
		
		if ( $codes == false && $member['code'] > "" ) {
			
			$style->content ( "{content}" , "{$codes}<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
										<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6\">
												<form action=\"\" method=\"POST\" class=\"smart-form client-form\">
													<fieldset>
														<section>
															<label class=\"label\">Введите код безопасности</label>
															<label class=\"input\"> 
																<input type=\"password\" name=\"pucode\" id=\"pincode\" value=\"\" readonly=\"readonly\" maxlength=\"10\" autocomplete=\"off\">
															</label>
														</section>
													</fieldset>
													<fieldset>
														<div class=\"col-xs-4 col-sm-4 col-md-4 col-lg-4\"></div>
														<div class=\"row\">
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('1');\">1</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('2');\">2</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('3');\">3</div>
														</div>
														<div class=\"col-xs-4 col-sm-4 col-md-4 col-lg-4\"></div>
														<div class=\"row\">
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('4');\">4</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('5');\">5</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('6');\">6</div>
														</div>
														<div class=\"col-xs-4 col-sm-4 col-md-4 col-lg-4\"></div>
														<div class=\"row\">
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('7');\">7</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('8');\">8</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('9');\">9</div>
														</div>
														<div class=\"col-xs-4 col-sm-4 col-md-4 col-lg-4\"></div>
														<div class=\"row\">
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-danger\" onClick=\"pinremove();\">X</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('0');\">0</div>
															<button class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-success\" type=\"submit\" name=\"submit\"><i class=\"fa fa-check\"></i></button>
														</div>
													</fieldset>
												</form>
											</div>" );
			
		} else {
	
	
			$loginlog = $db->query("SELECT * FROM `smember_log` WHERE `userid` = '{$uid}' ORDER BY `id` DESC");
			while ( $login = $db->get_row( $loginlog ) ) 
			{
/* 				if($login['userid'] == 245150)
				{
					$log .= "Восстановление контроля";
				}
				else
				{ */
					$log .= "<tr><td><center>#{$login['id']}</center></td><td><center>{$login['name']}</center></td><td><center>{$login['browser']}</center></td><td><center>{$login['ip']}</center></td><td><center>" . date ( "d.m.Y в H:i" , $login['time'] ) . "</center></td></tr>";
				//}
			}
			
			if ( $member["Admin"] > "0" && $admins == null ) $style->content( "{content}" , "<script>setTimeout(\"document.location.href='{$url}/alogin'\", 2000);</script>" );
			else {
			
				if($member["code"] == "") {

					$setcode = "<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\" align=\"center\">
									<div class=\"jarviswidget jarviswidget-color-redLight\" id=\"wid-id-1\">
										<center>
											<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
												<form id=\"codeForm\" class=\"smart-form client-form\" method=\"POST\">
													<header style=\"background: #fff; border-color: #fff;\">
														<div class=\"alert alert-success\">{$lang['page']['settings']['code']}</div>
													</header>
													<fieldset>
														<section>
															<div class=\"form-group\">
																<label class=\"label\">{$lang['other']['param']['enteremail']}</label>
																<label class=\"input\"> 
																	<input type=\"email\" name=\"email\">
																</label>
															</div>
														</section>
														<section>
															<a href=\"#\" onclick=\"document.getElementById('security').src='{$url}/security.php?'+Math.random(); return false;\">
																<img id=\"security\" src=\"{$url}/security.php\">
															</a>
															<div class=\"form-group\">
																<label class=\"label\">{$lang['other']['param']['security']}</label>
																<label class=\"input\"> 
																	<input type=\"text\" name=\"security\">
																</label>
															</div>
														</section>
														<section>
															<div class=\"form-group\">
																<div class=\"col-md-12\">
																	<div id=\"codes\"></div>
																</div>
															</div>
														</section>
													</fieldset>
													<footer style=\"background: #fff; border-color: #fff;\">
														<button type=\"submit\" class=\"btn btn-primary\">
															{$lang['page']['settings']['success']}
														</button>
													</footer>
												</form>
											</div>
										</center>
									</div>
								</div>";
					$validcode = "";
					
				} else {

					$setcode = "<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\" align=\"center\">
									<div class=\"jarviswidget jarviswidget-color-redLight\" id=\"wid-id-1\" data-widget-colorbutton=\"false\" data-widget-editbutton=\"false\" data-widget-togglebutton=\"false\" data-widget-deletebutton=\"false\" data-widget-fullscreenbutton=\"false\">
										<center>
											<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
												<form id=\"codeForm\" class=\"smart-form client-form\" method=\"POST\">
													<header style=\"background: #fff; border-color: #fff;\">
														<div class=\"alert alert-success\">{$lang['page']['settings']['codeoff']}</div>
													</header>
													<fieldset>
														<section>
															<div class=\"form-group\">
																<label class=\"label\">{$lang['page']['settings']['acceptcode']}</label>
																<label class=\"input\"> 
																	<input type=\"text\" name=\"code\">
																</label>
															</div>
														</section>
														<section>
															<div class=\"form-group\">
																<label class=\"label\">{$lang['other']['param']['enteremail']}</label>
																<label class=\"input\"> 
																	<input type=\"email\" name=\"email\">
																</label>
															</div>
														</section>
														<section>
															<a href=\"#\" onclick=\"document.getElementById('security').src='{$url}/security.php?'+Math.random(); return false;\"><img id=\"security\" src=\"{$url}/security.php\"></a>
															<div class=\"form-group\">
																<label class=\"label\">{$lang['other']['param']['security']}</label>
																<label class=\"input\"> 
																	<input type=\"text\" name=\"security\">
																</label>
															</div>
														</section>
														<section>
															<div class=\"form-group\">
																<div class=\"col-md-12\">
																	<div id=\"codes\"></div>
																</div>
															</div>
														</section>
													</fieldset>
													<footer style=\"background: #fff; border-color: #fff;\">
														<button type=\"submit\" class=\"btn btn-primary\">
															{$lang['page']['settings']['off']}
														</button>
													</footer>
												</form>
											</div>
										</center>
									</div>
								</div>";
								
					$validcode = ",code : {
														validators : {
															notEmpty : {
																message : '{$lang['pagefunction']['pcode']}'
															}
														}
													}";
				}
				if ( isset ( $_POST['email'] ) ) require_once ("lib/other/code.php");
				elseif ( isset ( $_POST['tpassword'] ) ) require_once ("lib/other/password.php");
				else {
									
					$style->content( "{content}" , "<div class=\"row\">
														<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\" align=\"center\">
															<div class=\"jarviswidget jarviswidget-color-redLight\" id=\"wid-id-0\">
																<center>
																	<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
																		<form actin=\"\" id=\"passForm\" class=\"smart-form client-form\" method=\"POST\">
																			<header style=\"background: #fff; border-color: #fff;\">
																				<div class=\"alert alert-success\">{$lang['page']['settings']['cpass']}</div>
																			</header>
																			<fieldset>
																				<section>
																					<div class=\"form-group\">
																						<label class=\"label\">{$lang['page']['settings']['pass']}</label>
																						<label class=\"input\"> 
																							<input type=\"password\" name=\"tpassword\">
																						</label>
																					</div>
																				</section>
																				<section>
																					<div class=\"form-group\">
																						<label class=\"label\">{$lang['page']['settings']['npass']}</label>
																						<label class=\"input\"> 
																							<input type=\"password\" name=\"npassword\">
																						</label>
																					</div>
																				</section>
																				<section>
																					<div class=\"form-group\">
																						<label class=\"label\">{$lang['other']['param']['securitycode']}</label>
																						<label class=\"input\"> 
																							<input type=\"password\" name=\"code\">
																						</label>
																					</div>
																				</section>
																				<section>
																					<a href=\"#\" onclick=\"document.getElementById('security').src='{$url}/security.php?'+Math.random(); return false;\"><img id=\"security\" src=\"{$url}/security.php\"></a>
																					<div class=\"form-group\">
																						<label class=\"label\">{$lang['other']['param']['security']}</label>
																						<label class=\"input\"> 
																							<input type=\"text\" name=\"security\">
																						</label>
																					</div>
																				</section>
																				<section>
																					<div class=\"form-group\">
																						<div class=\"col-md-12\">
																							<div id=\"messages\"></div>
																						</div>
																					</div>
																				</section>
																			</fieldset>
																			<footer style=\"background: #fff; border-color: #fff;\">
																				<button type=\"submit\" class=\"btn btn-primary\">
																					{$lang['page']['settings']['change']}
																				</button>
																			</footer>
																		</form>
																	</div>
																</center>
															</div>
														</div>
														{$setcode}
														<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
															<h3>История Авторизаций</h3>
															<div class=\"table-responsive\" style=\"height: 600px; overflow: auto;\">
																<table class=\"table text-center\">
																	<thead>
																		<tr>
																			<th><center>Номер авторизации</center></th>
																			<th><center>Имя</center></th>
																			<th><center>Метод</center></th>
																			<th><center>IP</center></th>
																			<th><center>Дата</center></th>
																		</tr>
																	</thead>
																	<tbody>
																		{$log}
																	</tbody>
																</table>
															</div>
														</div>
													</div>" );

				}
			}
		}
	}
}
$style->content( "{script}" , "<script type=\"text/javascript\">
								var pagefunction = function() {
									$('#passForm').bootstrapValidator({
										container : '#messages',
										feedbackIcons : {
											valid : 'glyphicon glyphicon-ok',
											invalid : 'glyphicon glyphicon-remove',
											validating : 'glyphicon glyphicon-refresh'
										},
										fields : {
											tpassword : {
												validators : {
													notEmpty : {
														message : '{$lang['pagefunction']['pass']}'
													}
												}
											},
											npassword : {
												validators : {
													notEmpty : {
														message : '{$lang['pagefunction']['npass']}'
													}
												}
											},
											security : {
												validators : {
													notEmpty : {
														message : '{$lang['pagefunction']['fieldimage']}'
													}
												}
											}
											{$validcode}
										}
									});
									$('#codeForm').bootstrapValidator({
										container : '#codes',
										feedbackIcons : {
											valid : 'glyphicon glyphicon-ok',
											invalid : 'glyphicon glyphicon-remove',
											validating : 'glyphicon glyphicon-refresh'
										},
										fields : {
											security : {
												validators : {
													notEmpty : {
														message : '{$lang['pagefunction']['fieldimage']}'
													}
												}
											},
											email : {
												validators : {
													notEmpty : {
														message : '{$lang['pagefunction']['fieldmail']}'
													},
													emailAddress : {
														message : '{$lang['pagefunction']['validmail']}'
													}
												}
											}{$validcode}
										}
									});
								};
								var pagedestroy = function() {
									$('#passForm').bootstrapValidator('destroy');
									$('#codeForm').bootstrapValidator('destroy');
									$('button[data-toggle]').off();
								};
								loadScript(\"{$url}/{$dir}/{$template}/js/plugin/bootstrapvalidator/bootstrapValidator.min.js\", pagefunction);
							</script><script type=\"text/javascript\">
									function pinappend(value) {

										var pincode = document.getElementById(\"pincode\");

										pincode.value = (pincode.value + value).substring(0, 10);

									};
									function pinremove(value) {

										var pincode = document.getElementById(\"pincode\");

										pincode.value = pincode.value.substring(0, pincode.value.length - 1);

									};
								</script>" );