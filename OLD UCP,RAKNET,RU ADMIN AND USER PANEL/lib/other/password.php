<?php
if(!defined('CRAZY_STR')) die("Hacking attempt!");

$tpass = $db->safesql($_POST['tpassword']);
$npass = $db->safesql($_POST['npassword']);
$code = $db->safesql($_POST['code']);
$sec = $db->safesql($_POST['security']);
$messages = "";
if($member['code'] == "") {

	if($sec != $_SESSION['code']) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён код с картинки.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif( md5 ( md5 ( $member["members_pass_salt"] ) . md5 ( $tpass ) ) != $member['members_pass_hash']) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён текущий пароль.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif($tpass == $npass) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Старый пароль и новый не должны совпадать.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif(strlen($npass) < "3" || strlen($npass) > "24") $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Пароль не может быть меньше 3 и больше 24 символов.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif($member['Online'] >= 1) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Данный персонаж находится на сервере.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	else {
	
		$password = md5 ( md5 ( $member["members_pass_salt"] ) . md5 ( $npass ) );
		$db->query("UPDATE `members` SET `members_pass_hash` = '{$password}' WHERE `member_id` = '{$uid}'");
		$projectname = "RakNet Role Play";
		$fromemail = "support@raknet.ru";
		$title = "Смена пароля";
		$messages .= "<!DOCTYPE html>
							<html>
								<head>
									<title>RakNet Role Play :: Смена пароля</title>
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
																						<p class=\"m-b-5\">Вы сменили пароль:</p>
																					</td>
																				</tr>
																				<tr>
																					<td class=\"panel\">
																						Старый пароль: {$tpass}
																						<br />
																						Новый пароль: {$npass}
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
			$style->content( "{content}" , "<div class=\"alert alert-success\"><strong>Успех:</strong> Настройки сохранены.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	}
	
} else {

	if($sec != $_SESSION['code']) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён код с картинки.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif( md5 ( md5 ( $member["members_pass_salt"] ) . md5 ( $tpass ) ) != $member['members_pass_hash']) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён текущий пароль.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif($tpass == $npass) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Старый пароль и новый не должны совпадать.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif(strlen($npass) < "3" || strlen($npass) > "24") $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Пароль не может быть меньше 3 и больше 24 символов.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif($member['Online'] > 0) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Данный персонаж находится на сервере.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	elseif($member['code'] != $code) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён код безопасности.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	else {
	
		$password = md5 ( md5 ( $member["members_pass_salt"] ) . md5 ( $npass ) );
		$db->query("UPDATE `members` SET `members_pass_hash` = '{$password}' WHERE `member_id` = '{$uid}'");
		$projectname = "RakNet Role Play";
		$fromemail = "support@raknet.ru";
		$title = "Смена пароля";
		$messages .= "<!DOCTYPE html>
							<html>
								<head>
									<title>RakNet Role Play :: Смена пароля</title>
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
																						<p class=\"m-b-5\">Вы сменили пароль:</p>
																					</td>
																				</tr>
																				<tr>
																					<td class=\"panel\">
																						Старый пароль: {$tpass}
																						<br />
																						Новый пароль: {$npass}
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
			$style->content( "{content}" , "<div class=\"alert alert-success\"><strong>Успех:</strong> Настройки сохранены.</div><script>setTimeout(\"document.location.href='{$url}/setting'\", 2000);</script>");
	}
}