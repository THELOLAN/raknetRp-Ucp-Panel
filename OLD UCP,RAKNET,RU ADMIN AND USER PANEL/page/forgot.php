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

$style->content( "{page}" , $lang['page']['forgot'] );

$style->content( "{style}" , "" );
$text = "";
$projectname = "RakNet Role Play";
$fromemail = "support@raknet.ru";
$title = "Восстановление контроля";
if ( isset ( $_POST['name'] ) ) {

	$name = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['name'] ) ) );
	$not_allow_symbol = array ("\x22", "\x60", "\t", '\n', '\r', "\n", "\r", '\\', ",", "/", "¬", "#", ";", ":", "~", "[", "]", "{", "}", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"', "'", " " );
	$email = $db->safesql ( trim ( str_replace ( $not_allow_symbol , '' , strip_tags ( stripslashes ( $_POST['email'] ) ) ) ) );
	$code = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['code'] ) ) );
	
	$user = $db->super_query("SELECT `name`, `email`, `code` FROM `members` WHERE `name` = '{$name}' LIMIT 1");
	$messages = "";
	//if ( user::name($name) == false ) $text = "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Пользователь не найден</div><script>setTimeout(\"document.location.href='{$url}/forgot'\", 2000);</script>";
	if ( $name != $user['name'] ) $text = "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorname']}</div><script>setTimeout(\"document.location.href='{$url}/forgot'\", 2000);</script>";
	elseif ( $email != $user['email'] ) $text = "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errormail']}</div><script>setTimeout(\"document.location.href='{$url}/forgot'\", 2000);</script>";
	elseif ( $code != $_SESSION['code'] ) $text = "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorpic']}</div><script>setTimeout(\"document.location.href='{$url}/forgot'\", 2000);</script>";
	elseif($user['code'] > "") {
	
		$password = "";
		$salt = "";
		$nsalt = "";
		for($i = 0; $i < 10; $i++) {
		
			$arr = array('a','b','c','d','e','f',
			'g','h','i','j','k','l',
			'm','n','o','p','r','s',
			't','u','v','x','y','z',
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','R','S',
			'T','U','V','X','Y','Z',
			'1','2','3','4','5','6',
			'7','8','9','0');
			$index = rand(0, count($arr) - 1);
			$password .= $arr[$index];
			
		}
		for($i = 0; $i < 10; $i++) {
		
			$arr = array('1','2','3','4','5','6',
			'7','8','9','0');
			$index = rand(0, count($arr) - 1);
			$salt .= $arr[$index];
			
		}
		
		for($i = 0; $i < 5; $i++) {
		
			$arr = array('a','b','c','d','e','f',
			'g','h','i','j','k','l',
			'm','n','o','p','r','s',
			't','u','v','x','y','z',
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','R','S',
			'T','U','V','X','Y','Z',
			'1','2','3','4','5','6',
			'7','8','9','0');
			$index = rand(0, count($arr) - 1);
			$nsalt .= $arr[$index];
			
		}
		$npassword = md5 ( md5 ( $nsalt ) . md5 ( $password ) );
		$db->query("UPDATE `members` SET `members_pass_hash` = '{$npassword}', `members_pass_salt` = '{$nsalt}', `code` = '{$salt}' WHERE `name` = '{$user['name']}'");
		$messages .= "<!DOCTYPE html>
						<html>
							<head>
								<title>RakNet Role Play :: {$title}</title>
							</head>
							<body>
								<h4>Привет {$user['name']}.</h4>
								<p class=\"m-b-5\">Вы сброили пароль:</p>
								Новый пароль: {$password}
								<br />
								Новый код безопасности: {$salt}
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
		$text = "<div class=\"alert alert-success alert-dismissable fade in\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
					{$lang['other']['param']['successforgot']}
				</div>
				<script>setTimeout(\"document.location.href='{$url}/forgot'\", 2000);</script>";
	
	} else {
	
		$password = "";
		$nsalt = "";
		for($i = 0; $i < 10; $i++) {
		
			$arr = array('a','b','c','d','e','f',
			'g','h','i','j','k','l',
			'm','n','o','p','r','s',
			't','u','v','x','y','z',
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','R','S',
			'T','U','V','X','Y','Z',
			'1','2','3','4','5','6',
			'7','8','9','0');
			$index = rand(0, count($arr) - 1);
			$password .= $arr[$index];
			
		}
		for($i = 0; $i < 5; $i++) {
		
			$arr = array('a','b','c','d','e','f',
			'g','h','i','j','k','l',
			'm','n','o','p','r','s',
			't','u','v','x','y','z',
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','R','S',
			'T','U','V','X','Y','Z',
			'1','2','3','4','5','6',
			'7','8','9','0');
			$index = rand(0, count($arr) - 1);
			$nsalt .= $arr[$index];
			
		}
		$npassword = md5 ( md5 ( $nsalt ) . md5 ( $password ) );
		$db->query("UPDATE `members` SET `members_pass_hash` = '{$npassword}', `members_pass_salt` = '{$nsalt}' WHERE `name` = '{$user['name']}'");
		$messages .= "<!DOCTYPE html>
						<html>
							<head>
								<title>RakNet Role Play :: {$title}</title>
							</head>
							<body>
								<h4>Привет {$user['name']}.</h4>
								<p class=\"m-b-5\">Вы сброили пароль:</p>
								Новый пароль: {$password}
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
		$text = "<div class=\"alert alert-success alert-dismissable fade in\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
					{$lang['other']['param']['successforgot']}
				</div>
				<script>setTimeout(\"document.location.href='{$url}/forgot'\", 2000);</script>";
	
	}
	
}

$style->content( "{content}" , "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\"></div>
									<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\" align=\"center\">
										<div class=\"jarviswidget jarviswidget-color-redLight\" id=\"wid-id-0\">
											<center>
												<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
													<form actin=\"\" id=\"passForm\" class=\"smart-form client-form\" method=\"POST\">
														<header style=\"background: #fff; border-color: #fff;\">
															<div class=\"alert alert-success\">{$lang['other']['param']['controlacc']}</div>
															{$text}
														</header>
														<fieldset>
															<section>
																<div class=\"form-group\">
																	<label class=\"label\">{$lang['other']['param']['entername']}</label>
																	<label class=\"input\"> 
																		<input type=\"text\" name=\"name\">
																	</label>
																</div>
															</section>
															<section>
																<div class=\"form-group\">
																	<label class=\"label\">{$lang['other']['param']['enteremail']}</label>
																	<label class=\"input\"> 
																		<input type=\"emaiil\" name=\"email\">
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
																		<input type=\"text\" name=\"code\">
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
																{$lang['button']['remember']}
															</button>
														</footer>
													</form>
												</div>
											</center>
										</div>
									</div>
								</div>" );

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
											name : {
												validators : {
													notEmpty : {
														message : '{$lang['pagefunction']['fieldname']}'
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
											},
											code : {
												validators : {
													notEmpty : {
														message : '{$lang['pagefunction']['fieldimage']}'
													}
												}
											},
										}
									});
								};
								var pagedestroy = function() {
									$('#passForm').bootstrapValidator('destroy');
									$('button[data-toggle]').off();
								};
								loadScript(\"{$url}/{$dir}/{$template}/js/plugin/bootstrapvalidator/bootstrapValidator.min.js\", pagefunction);
							</script>" );