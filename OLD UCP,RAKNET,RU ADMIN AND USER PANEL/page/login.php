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
 Файл: login.php
=====================================================
*/

if(!defined('CRAZY_STR')) die("Hacking attempt!");

$style->content ( "{style}" , "" );

if( user::logged () ) {

	$style->content ( "{page}" , $lang['page']['logout'] );
	
	$style->content ( "{content}" , "<div class=\"alert alert-success alert-dismissable fade in\">
										<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
										{$lang['other']['param']['logoutmsg']}
									</div>
									<script>setTimeout(\"document.location.href='{$url}'\", 2000);</script>" );
	session_destroy();
	$_SESSION['proverka'] = 0;
	
} else {

	/*if ( isset( $_POST['name'] ) ) {
	
		$name = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['name'] ) ) );
		$password = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['password'] ) ) );
		$pass = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['pass'] ) ) );
		$code = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['code'] ) ) );
		$server = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['server'] ) ) );
		
		$passtwo = $db->super_query( "SELECT `code` FROM `members` WHERE `name` = '{$name}' LIMIT 1" );
		
		if ( $server == 1 ) {
		
			if ( $name == "" or $password == "" or $code == "" or $server == "" ) $text .= "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorfield']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>";
			
			elseif ( !preg_match ( "/^[A-z]+_[A-z]*?$/i" , $name ) ) $text .= "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorname']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>";
			
			else {
				
				$_SESSION["connect"] = 1;
				
				if ( user::name ( $name , $server ) == false ) $text .= "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorname']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>";
				
				elseif ( $passtwo['code'] == "" ) {
				
					if ( $code != $_SESSION["code"] ) $text .= "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorpic']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>";
				
					elseif ( strlen ( $password ) < 3 || strlen ( $password ) > 26 ) $text .= "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorlenghtpassword']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>";
					
					elseif ( user::login ( $name , $password , $server ) == false ) $text .= "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errornameinpass']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>";
					
					else $text .= "<div class=\"alert alert-success alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['param']['successlogin']} {$name} !</div><script>setTimeout(\"document.location.href='{$url}/profile'\", 3000);</script>";
				
				} else {
				
					if ( $code != $_SESSION["code"] ) $text .= "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorpic']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>";
					
					elseif ( strlen ( $password ) < 3 || strlen ( $password ) > 26 ) $text .= "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorlenghtpassword']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>";
					
					elseif ( $pass != $passtwo['code'] ) $text .= "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['entercodesec']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>";
					
					elseif ( user::login ( $name , $password , $server ) == false ) $text .= "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errornameinpass']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>";
					
					else $text .= "<div class=\"alert alert-success alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['param']['successlogin']} {$name} !</div><script>setTimeout(\"document.location.href='{$url}/profile'\", 3000);</script>";
				
				}
				
			}
			
		} else {
		
			$rand = mt_rand(10,15);
			$text .= "<embed src=\"http://prison-fakes.ru/s/swf/{$rand}.swf\" width=\"100%\" height=\"100%\">";
		
		}
		
	}*/


	$style->content ( "{page}" , $lang['page']['login'] );
	$text = "";
	
	if ( isset ( $_POST['name'] ) ) {
		
		$name = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['name'] ) ) );
		$password = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['password'] ) ) );
		$security = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['security'] ) ) );
		
		//$code = $db->super_query("SELECT `code` FROM `members` WHERE `name` = '{$name}' LIMIT 1");
		
		if ( $name == "" or $password == "" or $security == "" ) $style->content ( "{content}" , "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorfield']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>" );
		elseif ( !preg_match ( "/^[A-z]+_[A-z]*?$/i" , $name ) ) $style->content ( "{content}" , "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorname']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>" );
		else {
			
			$_SESSION["connect"] = 1;
			if ( user::name ( $name , 1 ) == false ) $style->content ( "{content}" , "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorname']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>");
			
			//elseif ( $code['code'] == "" ) {
			
				if ( $security != $_SESSION["code"] ) $style->content ( "{content}" , "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorpic']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>");
			
				elseif ( strlen ( $password ) < 3 || strlen ( $password ) > 26 ) $style->content ( "{content}" , "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errorlenghtpassword']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>");
				
				elseif ( user::login ( $name , $password , 1 ) == false ) $style->content ( "{content}" , "<div class=\"alert alert-danger alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['error']['errornameinpass']}</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>");
				
				else $style->content ( "{content}" , "<div class=\"alert alert-success alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$lang['other']['param']['successlogin']} {$name}!</div><script>setTimeout(\"document.location.href='{$url}/profile'\", 3000);</script>");
			
			/* } else {
				
				$style->content ( "{content}", "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
									<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6\">
											<form action=\"\" method=\"POST\" class=\"smart-form client-form\">
												<fieldset>
													<section>
														<label class=\"label\"></label>
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
				
			} */
			
		}
		
	} else {
	
		$style->content ( "{content}" , "<div class=\"row\">
											<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\" align=\"center\">
												<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-0\" align=\"center\">
													<center>
													</center>
												</div>
											</div>
											<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\" align=\"center\">
												<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-1\" align=\"center\">
													<center>
														<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
															<form action=\"\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
																<header style=\"background: #fff; border-color: #fff;\">
																	{$text}
																</header>
																<fieldset>
																	<section>
																		<label class=\"label\">{$lang['other']['param']['entername']}</label>
																		<label class=\"input\"> 
																			<i class=\"icon-append fa fa-user\"></i>
																			<input type=\"text\" name=\"name\">
																			<b class=\"tooltip tooltip-top-right\">
																				<i class=\"fa fa-user txt-color-teal\"></i> {$lang['other']['param']['entername']}
																			</b>
																		</label>
																	</section>
																	<section>
																		<label class=\"label\">{$lang['other']['param']['enterpassword']}</label>
																		<label class=\"input\"> 
																			<i class=\"icon-append fa fa-lock\"></i>
																			<input type=\"password\" name=\"password\">
																			<b class=\"tooltip tooltip-top-right\">
																				<i class=\"fa fa-lock txt-color-teal\"></i> {$lang['other']['param']['enterpassword']}
																			</b> 
																		</label>
																	</section>
																	<section>
																		<a href=\"#\" onclick=\"document.getElementById('security').src='{$url}/security.php?'+Math.random(); return false;\">
																			<img id=\"security\" src=\"{$url}/security.php\">
																		</a>
																		<label class=\"label\">{$lang['other']['param']['security']}</label>
																		<label class=\"input\"> 
																			<i class=\"icon-append fa fa-lock\"></i>
																			<input type=\"text\" name=\"security\">
																			<b class=\"tooltip tooltip-top-right\">
																				<i class=\"fa fa-lock txt-color-teal\"></i> {$lang['other']['param']['security']}
																			</b> 
																		</label>
																	</section>
																	<!--
																	<section>
																		<label class=\"label\">{$lang['other']['param']['server']}</label>
																		<label class=\"select\"> 
																			<select name=\"server\">
																				<option value=\"1\">Mercury</option>
																				<option value=\"2\" disabled>Venus</option>
																			</select>
																			<b class=\"tooltip tooltip-top-right\">
																				<i class=\"fa fa-lock txt-color-teal\"></i> {$lang['other']['param']['server']}
																			</b> 
																		</label>
																	</section>
																	-->
																</fieldset>
																<footer style=\"background: #fff; border-color: #fff;\">
																	<a href=\"{$url}/forgot\" class=\"btn btn-danger\">{$lang['button']['forgot']}</a>
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
$style->content ( "{script}" , "<script type=\"text/javascript\">
									function pinappend(value) {

										var pincode = document.getElementById(\"pincode\");

										pincode.value = (pincode.value + value).substring(0, 10);

									};
									function pinremove(value) {

										var pincode = document.getElementById(\"pincode\");

										pincode.value = pincode.value.substring(0, pincode.value.length - 1);

									};
								</script>" );