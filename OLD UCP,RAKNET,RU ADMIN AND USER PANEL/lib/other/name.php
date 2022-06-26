<?php
if(!defined('CRAZY_STR')) die("Hacking attempt!");
$name = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['name'] ) ) );
$oname = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['oname'] ) ) );
$code = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['code'] ) ) );
$messages = "";
if ( $name == "" or $oname == "" or $code == "" ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Заполните все поля.</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");
elseif ( $name != sname ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введено имя персонажа.</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");
elseif ( $code != $_SESSION['code'] ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введён код с картинки.</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");
elseif ( $name == $oname ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Старое имя и новое не должны совпадать.</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");
elseif ( user::name($oname, 1) ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Данное имя персонажа уже занято.</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");
elseif ( $user['Online'] >= 1 ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Данный персонаж находится на сервере.</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");
elseif ( strlen($oname) < 3 || strlen($oname) > 20 ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Имя персонажа должно быть не мешьше 3 и больше 20 символов.</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");
elseif ( !preg_match("/^[a-z]+_[a-z]*?$/i" , $oname ) ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Неверно введено имя персонажа. Пример: Vasya_Pupkin</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");
else {

	if ( $user["cname"] == 1 ) {
	
		if ( $user["DonateMREAL"] < 30 ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> На вашем аккаунте не хватает средств для смены игрового имени</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");
		else {
		
			$style->content( "{content}" , "<div class=\"alert alert-success\"><strong>Успех:</strong> Вы успешно изменили игровое имя</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>");
			$cost = $user["DonateMREAL"]-30;
			$robokassa = $db->query("SELECT * FROM `robokassa` WHERE `Name` = '{$sname}' AND `status1` = '1'");
			while($rb = $db->get_row($robokassa)) $db->query("UPDATE `robokassa` SET `Name` = '{$oname}' WHERE `Name` = '{$sname}' AND `status1` = '1'");
			unset($rb);
			$seoname = str_replace("_", "-", $oname);
			$seoname = strtolower($seoname);
			$lname = strtolower($oname);
			$db->query("UPDATE `members` SET `name` = '{$oname}', `members_display_name` = '{$oname}', `members_seo_name` = '{$seoname}', `members_l_display_name` = '{$lname}', `members_l_username` = '{$lname}', `DonateMREAL` = '{$cost}' WHERE `member_id` = '{$uid}'");
			$db->query("INSERT INTO 
							`name` ( userid , Newname , Oldname , email , vremya )
						VALUES 
							(
								'{$uid}',
								'{$oname}',
								'{$sname}',
								'{$user['email']}',
								'" . time() . "'
							)");
			$projectname = "RakNet Role Play";
			$fromemail = "support@raknet.ru";
			$title = "Смена игровго имени";
			$messages .= "<!DOCTYPE html>
							<html>
								<head>
									<title>RakNet Role Play :: Смена игрового имени</title>
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
																							<a href=\"{$url}\"><img src=\"http://ucp.raknet.ru/templates/style/img/logo1.png\" width=\"110\" height=\"35\" style=\"top: -5px;\"></a>
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
																						<p class=\"m-b-5\">Вы сменили игровое имя:</p>
																					</td>
																				</tr>
																				<tr>
																					<td class=\"panel\">
																						Старое имя: {$sname}
																						<br />
																						Новое имя: {$oname}
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
																							RakNet Role Play &copy; 2012-2015
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
							mail($user["email"], $title, $messages, $headers);
							session_destroy();
							$_SESSION['proverka'] = 0;
			
		}
		
	} else {
	
			$style->content( "{content}" , "<div class=\"alert alert-success\"><strong>Успех:</strong> Вы успешно изменили игровое имя</div><script>setTimeout(\"document.location.href='{$url}/login'\", 2000);</script>");
			$robokassa = $db->query("SELECT * FROM `robokassa` WHERE `Name` = '{$sname}' AND `status1` = '1'");
			while($rb = $db->get_row($robokassa)) $db->query("UPDATE `robokassa` SET `Name` = '{$oname}' WHERE `Name` = '{$sname}' AND `status1` = '1'");
			unset($rb);
			$seoname = str_replace("_", "-", $oname);
			$seoname = strtolower($seoname);
			$lname = strtolower($oname);
			$db->query("UPDATE `members` SET `name` = '{$oname}', `members_display_name` = '{$oname}', `members_seo_name` = '{$seoname}', `members_l_display_name` = '{$lname}', `members_l_username` = '{$lname}', `cname` = '1' WHERE `member_id` = '{$uid}'");

			$db->query("INSERT INTO 
							`name` ( userid , Newname , Oldname , email , vremya )
						VALUES 
							(
								'{$uid}',
								'{$oname}',
								'{$sname}',
								'{$user['email']}',
								'" . time() . "'
							)");
			$projectname = "RakNet Role Play";
			$fromemail = "support@raknet.ru";
			$title = "Смена игровго имени";
			$messages .= "<!DOCTYPE html>
							<html>
								<head>
									<title>RakNet Role Play :: Смена игрового имени</title>
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
																							<a href=\"{$url}\"><img src=\"http://ucp.raknet.ru/templates/style/img/logo1.png\" width=\"110\" height=\"35\" style=\"top: -5px;\"></a>
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
																						<p class=\"m-b-5\">Вы сменили игровое имя:</p>
																					</td>
																				</tr>
																				<tr>
																					<td class=\"panel\">
																						Старое имя: {$sname}
																						<br />
																						Новое имя: {$oname}
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
																							RakNet Role Play &copy; 2012-2015
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
							mail($user["email"], $title, $messages, $headers);
							session_destroy();
							$_SESSION['proverka'] = 0;
	}
}