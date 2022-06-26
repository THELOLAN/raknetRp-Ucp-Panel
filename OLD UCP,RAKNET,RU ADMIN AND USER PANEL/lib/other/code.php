<?php
if(!defined('CRAZY_STR')) die("Hacking attempt!");
$messages = "";
$not_allow_symbol = array ("\x22", "\x60", "\t", '\n', '\r', "\n", "\r", '\\', ",", "/", "¬", "#", ";", ":", "~", "[", "]", "{", "}", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"', "'", " " );
$email = $db->safesql ( trim ( str_replace ( $not_allow_symbol , '' , strip_tags ( stripslashes ( $_POST['email'] ) ) ) ) );
$sec = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['security'] ) ) );
$code = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['code'] ) ) );
if($member['code'] == "") {

	if($sec != $_SESSION['code']) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён код с картинки.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif ($member['email'] != $email) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён электронный адрес.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	else {
	
		$psalt = "";
		$rand = mt_rand(5, 11);
		for($i = 0; $i < $rand; $i++) {
			$arr = array('1','2','3','4','5','6',
			'7','8','9','0');
			$index = rand(0, count($arr) - 1);
			$psalt .= $arr[$index];
		}
		$db->query("UPDATE `members` SET `code` = '{$psalt}' WHERE `member_id` = '{$uid}'");
		$projectname = "RakNet Role Play";
		$fromemail = "support@raknet.ru";
		$title = "Установка кода безопасности";
		$messages .= "<!DOCTYPE html>
								<html>
									<head>
										<title>RakNet Role Play :: Установка кода безопасности</title>
									</head>
									<body>
										<table class='body'>
											<tr>
												<td class=\"center\" align=\"center\" valign=\"top\">
													<center>
														<table class=\"row header\">
															<tr>
																<td class=\"center\" align=\"center\">
																	<center>
																		<table class=\"container\">
																			<tr>
																				<td class=\"wrapper\">
																					<table class=\"six columns\">
																						<tr>
																							<td>
																								<a href=\"{$url}\"><img src=\"http://mercury.raknet.ru/templates/style/img/logo.png\" width=\"110\" height=\"35\" style=\"top: -5px;\"></a>
																							</td>
																							<td class=\"expander\"></td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</center>
																</td>
															</tr>
														</table>
														<table class=\"container content dark-theme\">
															<tr>
																<td>
																	<!-- begin row -->
																	<table class=\"row\">
																		<tr>
																			<!-- begin wrapper -->
																			<td class=\"wrapper\">
																				<table class=\"twelve columns\">
																					<tr>
																						<td class=\"last\">
																							<h4>Привет {$sname}.</h4>
																							<p class=\"m-b-5\">Вы установили код безопасности:</p>
																						</td>
																					</tr>
																					<tr>
																						<td class=\"panel\">
																							Код безопасности: {$psalt}
																							<br />
																							Дата: " . date ( "d.m.Y в H:i" ) . "
																							<br />
																							IP: " . other::ip() . "
																						</td>
																					</tr>
																				</table>
																			</td>
																			<!-- end wrapper -->
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
														<table class=\"row footer\">
															<tr>
																<td class=\"center\" align=\"center\">
																	<center>
																		<!-- begin container -->
																		<table class=\"container\">
																			<tr>
																				<td class=\"wrapper\">
																					<table class=\"six columns\">
																						<tr>
																							<td>
																								RakNet Role Play &copy; 2012-2014
																							</td>
																							<td class=\"expander\"></td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																		<!-- end container -->
																	</center>
																</td>
															</tr>
														</table>
														<!-- end page footer -->
													</center>
												</td>
											</tr>
										</table>
									</body>
								</html>";
				$headers  = "Content-type: text/html; charset=utf-8 \r\n";
				$headers .= "MIME-Version: 1.0" . "\r\n";
				$headers .= "From: {$projectname} <{$fromemail}>" . "\r\n";
				mail($member["email"], $title, $messages, $headers);
				$style->content( "{content}" , "<div class=\"alert alert-success\"><strong>Успех:</strong> На ваш электронный адрес отправлен код безопасности.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	}
	
} else {

	if($sec != $_SESSION['code']) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён код с картинки.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif ($member['email'] != $email) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён электронный адрес.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif ($member['code'] != $code) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён код безопасности.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	else {
	
		$db->query("UPDATE `members` SET `code` = '' WHERE `member_id` = '{$uid}'");
		$projectname = "RakNet Role Play";
		$fromemail = "support@raknet.ru";
		$title = "Установка кода безопасности";
		$messages .= "<!DOCTYPE html>
								<html>
									<head>
										<title>RakNet Role Play :: Установка кода безопасности</title>
									</head>
									<body>
										<table class='body'>
											<tr>
												<td class=\"center\" align=\"center\" valign=\"top\">
													<center>
														<table class=\"row header\">
															<tr>
																<td class=\"center\" align=\"center\">
																	<center>
																		<table class=\"container\">
																			<tr>
																				<td class=\"wrapper\">
																					<table class=\"six columns\">
																						<tr>
																							<td>
																								<a href=\"{$url}\"><img src=\"http://mercury.raknet.ru/templates/style/img/logo.png\" width=\"110\" height=\"35\" style=\"top: -5px;\"></a>
																							</td>
																							<td class=\"expander\"></td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</center>
																</td>
															</tr>
														</table>
														<table class=\"container content dark-theme\">
															<tr>
																<td>
																	<!-- begin row -->
																	<table class=\"row\">
																		<tr>
																			<!-- begin wrapper -->
																			<td class=\"wrapper\">
																				<table class=\"twelve columns\">
																					<tr>
																						<td class=\"last\">
																							<h4>Привет {$sname}.</h4>
																							<p class=\"m-b-5\">Вы отключили код безопасности:</p>
																						</td>
																					</tr>
																					<tr>
																						<td class=\"panel\">
																							Дата: " . date ( "d.m.Y в H:i" ) . "
																							<br />
																							IP: " . other::ip() . "
																						</td>
																					</tr>
																				</table>
																			</td>
																			<!-- end wrapper -->
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
														<table class=\"row footer\">
															<tr>
																<td class=\"center\" align=\"center\">
																	<center>
																		<!-- begin container -->
																		<table class=\"container\">
																			<tr>
																				<td class=\"wrapper\">
																					<table class=\"six columns\">
																						<tr>
																							<td>
																								RakNet Role Play &copy; 2012-2014
																							</td>
																							<td class=\"expander\"></td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																		<!-- end container -->
																	</center>
																</td>
															</tr>
														</table>
														<!-- end page footer -->
													</center>
												</td>
											</tr>
										</table>
									</body>
								</html>";
				$headers  = "Content-type: text/html; charset=utf-8 \r\n";
				$headers .= "MIME-Version: 1.0" . "\r\n";
				$headers .= "From: {$projectname} <{$fromemail}>" . "\r\n";
				mail($member["email"], $title, $messages, $headers);
				$style->content( "{content}" , "<div class=\"alert alert-success\"><strong>Успех:</strong> Настройки сохранены .</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	}
}