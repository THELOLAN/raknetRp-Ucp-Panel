<?php
if(!defined('RUCP')) die("Hacking attempt!");

$style->content("{style}", "");
$style->content("{title}", "Главная");

if($_SESSION['ecode'] == 1)
{
	if(isset($_POST['ecode']))
	{
		$ecode = (int)$_POST['ecode'];
		$code = $db->escape($_POST['code']);
		if($ecode == "" or $code == "") $text = "<div class=\"alert alert-danger\">Заполните все поля</div>";
		elseif($_SESSION['authcode'] != $ecode) 
		{
			session_destroy();
			$k = md5( $member['email'].'&'.$member['member_login_key'].'&'.$member['joined'] );
			$text = "<div class=\"alert alert-danger\">Неверно введён код с почты</div><script type=\"text/javascript\">setTimeout(\"document.location.href='http://forum.raknet.ru/index.php?app=core&module=global&section=login&do=logout&k={$k}'\", 2000);</script>";
		}
		elseif($code != $member['code'])
		{
			session_destroy();
			$k = md5( $member['email'].'&'.$member['member_login_key'].'&'.$member['joined'] );
			$text = "<div class=\"alert alert-danger\">Неверно введён код безопасности</div><script type=\"text/javascript\">setTimeout(\"document.location.href='http://forum.raknet.ru/index.php?app=core&module=global&section=login&do=logout&k={$k}'\", 2000);</script>";
		}
		else
		{
			$_SESSION['auth'] = true;
			$_SESSION["admins"] = 1;
			setcookie("admins", 1, time()+3600, "/", "raknet.ru");
			$text = "<div class=\"alert alert-success\">Успешная авторизация</div><script type=\"text/javascript\">setTimeout(\"document.location.href='http://admin.raknet.ru'\", 2000);</script>";
		}
	}
}
else
{
	$rgLetters = array('2','1','3','4','5','6','7','8','9');
	shuffle($rgLetters);
	$code = join('',array_slice($rgLetters, 0, mt_rand(5, 10)));
	$message = "Код доступа: {$code}<br />
				Дата: " . date("d.m.Y в H:i", time()) . "<br />
				IP: {$_SERVER['REMOTE_ADDR']}";
	$headers  = "Content-type: text/html; charset=utf-8 \r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "From: " . project . " <" . from . ">" . "\r\n";
	mail($member['email'], "Auth Admin", $message, $headers);
	$_SESSION['authcode'] = $code;
	$_SESSION['ecode'] = 1;
}
$style->content("{content}", "<div class=\"middle-box text-center loginscreen animated fadeInDown\">
									<div>
										<div class=\"m-b-md\">
											<img alt=\"image\" class=\"img-circle circle-border\" src=\"http://ucp.raknet.ru/template/raknet/img/avatars/{$member['Char']}.png\">
										</div>
										<h3>{$member['name']}</h3>
										<p>Для того чтобы попасть в админ панель необходимо авторизоваться.</p>
										<form class=\"m-t\" role=\"form\" action=\"\" method=\"POST\">
											{$text}
											<div class=\"form-group\">
												<input type=\"text\" class=\"form-control\" placeholder=\"Введите код отправленный на почту\" name=\"ecode\" required=\"\" value=\"\">
											</div>
											<div class=\"form-group\">
												<input type=\"password\" class=\"form-control\" placeholder=\"Код безопасности\" readonly=\"readonly\" maxlength=\"10\" id=\"code\" name=\"code\" required=\"\" value=\"\">
											</div>
											<table align=\"center\">
												<tr>
													<td>
														<div class=\"btn btn-lg btn-primary\" onClick=\"pinappend('1');\">1</div>
													</td>
													<td>
														<div class=\"btn btn-lg btn-primary\" onClick=\"pinappend('2');\">2</div>
													</td>
													<td>
														<div class=\"btn btn-lg btn-primary\" onClick=\"pinappend('3');\">3</div>
													</td>
												</tr>
												<tr>
													<td>
														<div class=\"btn btn-lg btn-primary\" onClick=\"pinappend('4');\">4</div>
													</td>
													<td>
														<div class=\"btn btn-lg btn-primary\" onClick=\"pinappend('5');\">5</div>
													</td>
													<td>
														<div class=\"btn btn-lg btn-primary\" onClick=\"pinappend('6');\">6</div>
													</td>
												</tr>
												<tr>
													<td>
														<div class=\"btn btn-lg btn-primary\" onClick=\"pinappend('7');\">7</div>
													</td>
													<td>
														<div class=\"btn btn-lg btn-primary\" onClick=\"pinappend('8');\">8</div>
													</td>
													<td>
														<div class=\"btn btn-lg btn-primary\" onClick=\"pinappend('9');\">9</div>
													</td>
												</tr>
												<tr>
													<td>
														
													</td>
													<td>
														<div class=\"btn btn-lg btn-primary\" onClick=\"pinappend('0');\">0</div>
													</td>
													<td>
														
													</td>
												</tr>
											</table>
											<button class=\"btn btn-lg btn-primary\">Войти</button>
										</form>
									</div>
								</div>");
$style->content("{script}", "<script type=\"text/javascript\">
												function pinappend(value) 
												{
													var pincode = document.getElementById(\"code\");
													pincode.value = (pincode.value + value).substring(0, 10);
												};
												function pinremove(value) 
												{
													var pincode = document.getElementById(\"code\");
													pincode.value = pincode.value.substring(0, pincode.value.length - 1);
												};
											</script>");