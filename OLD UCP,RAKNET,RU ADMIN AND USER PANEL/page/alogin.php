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
if ( !defined ( "CRAZY_STR" ) ) die ( "Hacking attempt!" );

$style->content( "{page}" , $lang['page']['acp'] );

$style->content( "{style}" , "" );

if ( user::logged() ) {

 	$user = $db->super_query( "SELECT
									`member_id`,
									`Admin`,
									`email`,
									`Dostup`,
									`code`
								FROM
									`members`
								WHERE 
									`member_id` = '{$uid}'
								LIMIT 1" );
								
	if ( isset ( $_POST['pucode'] ) ) {
		
		$pucode = $db->safesql($_POST['pucode']);
		if ( $pucode == "" ) $style->content ("{content}", "<div class=\"alert alert-danger\">Введите код безопасности</div><script>setTimeout(\"document.location.href='{$url}/profile'\", 2000);</script>");
		elseif ( $pucode != $user['code'] ) {
			
			session_destroy();
			$style->content ("{content}", "<div class=\"alert alert-danger\">Неверно введён код безопасности</div><script>setTimeout(\"document.location.href='{$url}/'\", 2000);</script>");
			
		} else {
			
			$_SESSION["codes"] = true;
			$style->content ("{content}", "<div class=\"alert alert-success\">Добро пожаловать, {$sname}</div><script>setTimeout(\"document.location.href='{$url}/profile'\", 2000);</script>");
			
		}
		
	} else {
		
		if ( $codes == false && $user['code'] > "" ) {
			
			$style->content ( "{content}" , "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
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
			$ip = $db->super_query("SELECT `userid`, `ip` FROM `smember_log` WHERE `userid` = '{$uid}' ORDER BY `id` DESC LIMIT 1");
			//$user = $db->super_query("SELECT `A`.`Admin`, `A`.`email`, `A`.`Dostup`, `B`.`ip`, `B`.`userid` FROM `members` AS A LEFT JOIN `smember_log` AS B ON ( `B`.`userid` = A.member_id ) WHERE `A`.`member_id` = '{$uid}' LIMIT 1");
			
			if ( $ip['ip'] != other::ip() ) {

				$text = "";
				if ( isset ( $_POST["code"]) ) {

					$pcode = $db->safesql($_POST["code"]);
					$ecode = $db->safesql($_POST["ecode"]);
					$dostup = $db->safesql($_POST["apassword"]);
					if ( $pcode == "" or $ecode == "" ) $text = "<div class=\"alert alert-danger\">{$lang['other']['error']['errorfield']}</div>";
					elseif ( $ecode != $acode ) $text = "<div class=\"alert alert-danger\">{$lang['other']['error']['acperrorcode']}</div>";
					elseif ( $pcode != $_SESSION['code'] ) $text = "<div class=\"alert alert-danger\">{$lang['other']['error']['errorpic']}</div>";
					elseif ( $dostup != $user['Dostup'] ) $text = "<div class=\"alert alert-danger\">{$lang['other']['error']['erroracpcode']}</div>";
					else {
					
						$_SESSION["admins"] = 1;
						$text = "<div class=\"alert alert-success\">{$lang['other']['param']['successacp']}</div><script>setTimeout(\"document.location.href='{$url}/amenu'\", 2000);</script>";
						$db->query ( "INSERT INTO `smember_log` 
											( 
												name , 
												userid , 
												browser , 
												ip , 
												time 
											) 
										VALUES 
											( 
												'{$sname}' , 
												{$user['member_id']} , 
												'{$_SERVER['HTTP_USER_AGENT']}' , 
												'" . other::ip() . "' , 
												'" . time() . "' 
											)" 
										);
					
					}
					
				}
				if ( $user["Admin"] > 0 && $admins == null ) {

					if ( $acode == "" ) {

						$code = "";
						$messages = "";
						$rand = mt_rand(5,7);
						for($i = 0; $i < $rand; $i++) {
						
							$arr = array(
								'1','2','3','4','5','6','7','8','9','0'
							);
							$index = rand(0, count($arr) - 1);
							$code .= $arr[$index];
							
						}
						$projectname = "RakNet Role Play";
						$fromemail = "support@raknet.ru";
						$title = "Код Авторизации";
						$messages .= "<!DOCTYPE html>
										<html>
											<head>
											</head>
											<body>
												Ваш код для входа в Админ Центр: {$code}
												<br />
												Дата: " . date ( "d.m.Y в H:i" ) . "
												<br />
												IP: " . other::ip() . "
											</body>
										</html>";
						$headers  = "Content-type: text/html; charset=utf-8 \r\n";
						$headers .= "MIME-Version: 1.0" . "\r\n";
						$headers .= "From: {$projectname} <{$fromemail}>" . "\r\n";
						mail($user["email"], $title, $messages, $headers);
						$_SESSION['acode'] = $code;
						$style->content( "{content}" , "<div class=\"row\">
															<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
																<div class=\"alert alert-info\" align=\"center\">На ваш электронный адрес отправлен код Авторизации в Админ-центре.</div>
															</div>
															<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\" align=\"center\">
																<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-0\" align=\"center\"><center></center></div>
															</div>
															<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\" align=\"center\">
																<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-1\" align=\"center\">
																	<center>
																		<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
																			<form action=\"\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
																				<header style=\"background: #fff; border-color: #fff;\">{$text}</header>
																				<fieldset>
																					<section>
																						<a href=\"#\" onclick=\"document.getElementById('security').src='{$url}/security.php?'+Math.random(); return false;\">
																							<img id=\"security\" src=\"{$url}/security.php\">
																						</a>
																						<label class=\"label\">{$lang['other']['param']['security']}</label>
																						<label class=\"input\"> 
																							<i class=\"icon-append fa fa-lock\"></i>
																							<input type=\"text\" name=\"code\">
																							<b class=\"tooltip tooltip-top-right\">
																								<i class=\"fa fa-lock txt-color-teal\"></i> {$lang['other']['param']['security']}
																							</b> 
																						</label>
																					</section>
																					<section>
																						<label class=\"label\">{$lang['other']['param']['exportmail']}</label>
																						<label class=\"input\"> 
																							<i class=\"icon-append fa fa-lock\"></i>
																							<input type=\"password\" name=\"ecode\">
																							<b class=\"tooltip tooltip-top-right\">
																								<i class=\"fa fa-lock txt-color-teal\"></i> {$lang['other']['param']['exportmail']}
																							</b> 
																						</label>
																					</section>
																					<section>
																						<label class=\"label\">{$lang['other']['param']['acppassword']}</label>
																						<label class=\"input\"> 
																							<i class=\"icon-append fa fa-lock\"></i>
																							<input type=\"password\" name=\"apassword\">
																							<b class=\"tooltip tooltip-top-right\">
																								<i class=\"fa fa-lock txt-color-teal\"></i> {$lang['other']['param']['acppassword']}
																							</b> 
																						</label>
																					</section>
																					<section>
																						<div id=\"messages\"></div>
																					</section>
																				</fieldset>
																				<footer style=\"background: #fff; border-color: #fff;\">
																					<button type=\"submit\" class=\"btn btn-primary\">
																						{$lang['button']['enter']}
																					</button>
																				</footer>
																			</form>
																		</div>
																	</center>
																</div>
															</div>
														</div>" );
														
					} else {
					
						$style->content( "{content}" , "<div class=\"row\">
															<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
																<div class=\"alert alert-info\" align=\"center\">На ваш электронный адрес отправлен код Авторизации в Админ-центре.</div>
															</div>
															<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\" align=\"center\">
																<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-0\" align=\"center\"><center></center></div>
															</div>
															<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\" align=\"center\">
																<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-1\" align=\"center\">
																	<center>
																		<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
																			<form action=\"\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
																				<header style=\"background: #fff; border-color: #fff;\">{$text}</header>
																				<fieldset>
																					<section>
																						<a href=\"#\" onclick=\"document.getElementById('security').src='{$url}/security.php?'+Math.random(); return false;\">
																							<img id=\"security\" src=\"{$url}/security.php\">
																						</a>
																						<label class=\"label\">{$lang['other']['param']['security']}</label>
																						<label class=\"input\"> 
																							<i class=\"icon-append fa fa-lock\"></i>
																							<input type=\"text\" name=\"code\">
																							<b class=\"tooltip tooltip-top-right\">
																								<i class=\"fa fa-lock txt-color-teal\"></i> {$lang['other']['param']['security']}
																							</b> 
																						</label>
																					</section>
																					<section>
																						<label class=\"label\">{$lang['other']['param']['exportmail']}</label>
																						<label class=\"input\"> 
																							<i class=\"icon-append fa fa-lock\"></i>
																							<input type=\"password\" name=\"ecode\">
																							<b class=\"tooltip tooltip-top-right\">
																								<i class=\"fa fa-lock txt-color-teal\"></i> {$lang['other']['param']['exportmail']}
																							</b> 
																						</label>
																					</section>
																					<section>
																						<label class=\"label\">{$lang['other']['param']['acppassword']}</label>
																						<label class=\"input\"> 
																							<i class=\"icon-append fa fa-lock\"></i>
																							<input type=\"password\" name=\"apassword\">
																							<b class=\"tooltip tooltip-top-right\">
																								<i class=\"fa fa-lock txt-color-teal\"></i> {$lang['other']['param']['acppassword']}
																							</b> 
																						</label>
																					</section>
																					<section>
																						<div id=\"messages\"></div>
																					</section>
																				</fieldset>
																				<footer style=\"background: #fff; border-color: #fff;\">
																					<button type=\"submit\" class=\"btn btn-primary\">
																						{$lang['button']['enter']}
																					</button>
																				</footer>
																			</form>
																		</div>
																	</center>
																</div>
															</div>
														</div>" );
					
					}

				}
			
			} else {
			
				$_SESSION["admins"] = 1;
				$style->content( "{content}" , "<div class=\"alert alert-success\">{$lang['other']['param']['successacp']}</div><script>setTimeout(\"document.location.href='{$url}/amenu'\", 2000);</script>");
				$db->query ( "INSERT INTO `smember_log` 
									( 
										name , 
										userid , 
										browser , 
										ip , 
										time 
									) 
								VALUES 
									( 
										'{$sname}' , 
										{$user['member_id']} , 
										'{$_SERVER['HTTP_USER_AGENT']}' , 
										'" . other::ip() . "' , 
										'" . time() . "' 
									)" 
								);
				
			}
		}
	}
}

$style->content( "{script}" , "
							<script type=\"text/javascript\">
								var pagefunction = function() {
									$('#login-form').bootstrapValidator({
										container : '#messages',
										feedbackIcons : {
											valid : 'glyphicon glyphicon-ok',
											invalid : 'glyphicon glyphicon-remove',
											validating : 'glyphicon glyphicon-refresh'
										},
										fields : {
											code : {
												validators : {
													notEmpty : {
														message : '{$lang['pagefunction']['fieldimage']}'
													}
												}
											},
											ecode : {
												validators : {
													notEmpty : {
														message : '{$lang['pagefunction']['fieldcode']}'
													}
												}
											},
											apassword : {
												validators : {
													notEmpty : {
														message : '{$lang['pagefunction']['acpcode']}'
													}
												}
											},
										}
									});
								};
								var pagedestroy = function() {
									$('#login-form').bootstrapValidator('destroy');
									$('button[data-toggle]').off();
								};
								loadScript(\"{$url}/{$dir}/{$template}/js/plugin/bootstrapvalidator/bootstrapValidator.min.js\", pagefunction);
									function pinappend(value) {

										var pincode = document.getElementById(\"pincode\");

										pincode.value = (pincode.value + value).substring(0, 10);

									};
									function pinremove(value) {

										var pincode = document.getElementById(\"pincode\");

										pincode.value = pincode.value.substring(0, pincode.value.length - 1);

									};
								</script>" );