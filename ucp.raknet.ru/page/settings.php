<?php
if(!defined('RUCP')) die("Hacking attempt!");

$style->content("{style}", "");

if($member['Online'] == 0)
{
	if(isset($_POST['oldpassword']))
	{
		$opass = $db->escape($_POST['oldpassword']);
		$npass = $db->escape($_POST['newpassword']);
		$tpass = $db->escape($_POST['newpasswordtwo']);
		if($opass == "" or $npass == "" or $tpass == "")
		{
			$style->content("{title}", "Настройки");
			$style->content("{content}", "<div class=\"alert alert-danger\">Заполните все поля!</div>");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
		}
		elseif(md5(md5($member['members_pass_salt']).md5($opass)) != $member['members_pass_hash'])
		{
			$style->content("{title}", "Настройки");
			$style->content("{content}", "<div class=\"alert alert-danger\">Неверно введён текущий пароль!</div>");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
		}
		elseif($opass == $tpass)
		{
			$style->content("{title}", "Настройки");
			$style->content("{content}", "<div class=\"alert alert-danger\">Старый и новый пароль не должны совпадать!</div>");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
		}
		elseif($tpass != $npass)
		{
			$style->content("{title}", "Настройки");
			$style->content("{content}", "<div class=\"alert alert-danger\">Поле новый пароль и повтор не совпадают!</div>");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
		}
		elseif(strlen($tpass) < 3 || strlen($tpass) > 24)
		{
			$style->content("{title}", "Настройки");
			$style->content("{content}", "<div class=\"alert alert-danger\">Длина пароля должна быть не меньше 3 и больше 24 символов!</div>");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
		}
		elseif($member['Online'] > 0)
		{
			$style->content("{title}", "Настройки");
			$style->content("{content}", "<div class=\"alert alert-danger\">Ваш персонаж находится на сервере!</div>");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
		}
		else
		{
			$password = md5(md5($member['members_pass_salt']) . md5($tpass));
			$data = array('members_pass_hash' => $password);
			$db->where('member_id', $member['member_id']);
			$db->update('members', $data);
			$message = "Привет {$member['name']}.<br />
						Вы сменили пароль на нашем сервере<br />
						Старый пароль: {$opass}<br />
						Новый пароль: {$tpass}<br />
						Дата: " . date("d.m.Y в H:i", time()) . "<br />
						IP: {$_SERVER['REMOTE_ADDR']}";
			$headers  = "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= "MIME-Version: 1.0" . "\r\n";
			$headers .= "From: RakNet Role Play <support@raknet.ru>" . "\r\n";
			mail($member['email'], "Смена пароля", $message, $headers);
			$style->content("{title}", "Настройки");
			$style->content("{content}", "<div class=\"alert alert-success\">Вы успешно сменили пароль!</div>");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
		}
	}
	elseif(isset($_POST['code']))
	{
		$codes = $db->escape($_POST['code']);
		if($codes == $member['code'])
		{
			$_SESSION['code'] = true;
			$style->content("{title}", "Авторизация");
			$style->content("{content}", "");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
		}
		else
		{
			session_destroy();
			$k = md5( $member['email'].'&'.$member['member_login_key'].'&'.$member['joined'] );
			$style->content("{title}", "Авторизация");
			$style->content("{content}", "");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='http://forum.raknet.ru/index.php?app=core&module=global&section=login&do=logout&k={$k}'\", 2000);</script>");
		}
	}
	elseif(isset($_POST['offcode']))
	{
		$offcode = (int)$_POST['offcode'];
		if($offcode == $member['code'])
		{
			if($member['Online'] > 0)
			{
				$style->content("{title}", "Авторизация");
				$style->content("{content}", "<div class=\"alert alert-danger\">Ваш персонаж находится на сервере!</div>");
				$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
			}
			else
			{
				$data = array('code' => '');
				$db->where('member_id', $member['member_id']);
				$db->update('members', $data);
				$_SESSION['code'] = false;
				$style->content("{title}", "Авторизация");
				$style->content("{content}", "<div class=\"alert alert-success\">Всё прошло успешно</div>");
				$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
			}
		}
		else
		{
			session_destroy();
			$k = md5( $member['email'].'&'.$member['member_login_key'].'&'.$member['joined'] );
			$style->content("{title}", "Авторизация");
			$style->content("{content}", "");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='http://forum.raknet.ru/index.php?app=core&module=global&section=login&do=logout&k={$k}'\", 2000);</script>");			
		}
	}
	elseif(isset($_POST['generate']))
	{
		$gener = (int)$_POST['generate'];
		if($gener != 1)
		{
			session_destroy();
			$k = md5( $member['email'].'&'.$member['member_login_key'].'&'.$member['joined'] );
			$style->content("{title}", "Авторизация");
			$style->content("{content}", "");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='http://forum.raknet.ru/index.php?app=core&module=global&section=login&do=logout&k={$k}'\", 2000);</script>");			
		}
		else
		{
			if($member['Online'] > 0)
			{
				$style->content("{title}", "Авторизация");
				$style->content("{content}", "<div class=\"alert alert-danger\">Ваш персонаж находится на сервере!</div>");
				$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
			}
			else
			{
				$rgLetters = array('2','1','3','4','5','6','7','8','9');
				shuffle($rgLetters);
				$code = join('',array_slice($rgLetters, 0, mt_rand(5, 10)));
				$data = array('code' => $code);
				$db->where('member_id', $member['member_id']);
				$db->update('members', $data);

				$messages .= "Привет {$member['name']}.<br />
							Вы установили код безопасности:<br />
							Код безопасности: {$code}<br />
							<br />
							Дата: " . date ( "d.m.Y в H:i" ) . "
							<br />
							IP: {$_SERVER['REMOTE_ADDR']}";
				$headers  = "Content-type: text/html; charset=utf-8 \r\n";
				$headers .= "MIME-Version: 1.0" . "\r\n";
				$headers .= "From: RakNet Role Play <support@raknet.ru>" . "\r\n";
				mail($member["email"], "Смена кода безопасности", $messages, $headers);
				$_SESSION['code'] = false;
				$style->content("{title}", "Авторизация");
				$style->content("{content}", "<div class=\"alert alert-success\">На ваш электронный адрес отправлено сообщение с кодом безопасности.</div>");
				$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
			}
		}
	}
	elseif(isset($_POST['select']))
	{
		$select = (int)$_POST['select'];
		if($select == 0)
		{
			$style->content("{title}", "Настройки");
			$style->content("{content}", "<div class=\"alert alert-danger\">Вы не выбрали параметр</div>");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
		}
		elseif($select == 1)
		{
			if($member['Online'] > 0)
			{
				$style->content("{title}", "Авторизация");
				$style->content("{content}", "<div class=\"alert alert-danger\">Ваш персонаж находится на сервере!</div>");
				$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
			}
			else
			{
				$data = array('profile_setup' => 1);
				$db->where('member_id', $member['member_id']);
				$db->update('members', $data);
				$style->content("{title}", "Настройки");
				$style->content("{content}", "<div class=\"alert alert-success\">Вы разрешили просматривать ваш профиль другим пользователям.</div>");
				$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
			}
		}
		elseif($select == 2)
		{
			if($member['Online'] > 0)
			{
				$style->content("{title}", "Авторизация");
				$style->content("{content}", "<div class=\"alert alert-danger\">Ваш персонаж находится на сервере!</div>");
				$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
			}
			else
			{
				$data = array('profile_setup' => 2);
				$db->where('member_id', $member['member_id']);
				$db->update('members', $data);
				$style->content("{title}", "Настройки");
				$style->content("{content}", "<div class=\"alert alert-success\">Вы запретили просматривать ваш профиль пользователям.</div>");
				$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
			}
		}
		else
		{
			$style->content("{title}", "Настройки");
			$style->content("{content}", "<div class=\"alert alert-danger\">Вы не выбрали параметр</div>");
			$style->content("{script}", "<script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/settings'\", 2000);</script>");
		}
	}
	else
	{
		if($code == false && $member['code'] > "")
		{
			$style->content("{title}", "Авторизация");
			$style->content("{content}", "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
										<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6\">
												<form action=\"\" method=\"POST\" class=\"smart-form client-form\">
													<fieldset>
														<div class=\"row\">
															<div class=\"alert alert-info\">Введите код безопасности</div>
															<section class=\"col-lg-12\">
																<label class=\"input\">
																	<input type=\"password\" name=\"code\" id=\"code\" value=\"\" readonly=\"readonly\" maxlength=\"10\" autocomplete=\"off\">
																</label>
															</section>
															<section class=\"col-lg-12\">
																<div class=\"row\">
																	<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('1');\">1</div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('2');\">2</div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('3');\">3</div>
																</div>
																<div class=\"row\">
																	<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('4');\">4</div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('5');\">5</div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('6');\">6</div>
																</div>
																<div class=\"row\">
																	<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('7');\">7</div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('8');\">8</div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('9');\">9</div>
																</div>
																<div class=\"row\">
																	<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-danger\" onClick=\"pinremove();\">X</div>
																	<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('0');\">0</div>
																	<button class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-success\" type=\"submit\"><i class=\"fa fa-check\"></i></button>
																</div>
															</section>
														</div>
													</fieldset>
													<fieldset>
														<a href=\"{$url}/forgot\" class=\"btn btn-lg btn-danger\">Забыли код?</a>
													</fieldset>
												</form>
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
		}
		else
		{
			if($member['code'] != "")
			{
				$generate .= "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
									<form action=\"\" method=\"POST\" class=\"smart-form\">
										<fieldset>
											<div class=\"row\">
												<div class=\"alert alert-info\">Код безопасности</div>
												<section class=\"col-lg-12\">
													<label class=\"input\">
														<input type=\"password\" name=\"offcode\" id=\"code\" value=\"\" readonly=\"readonly\" maxlength=\"10\" autocomplete=\"off\">
													</label>
												</section>
												<section class=\"col-lg-12\">
													<div class=\"row\">
														<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('1');\">1</div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('2');\">2</div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('3');\">3</div>
													</div>
													<div class=\"row\">
														<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('4');\">4</div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('5');\">5</div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('6');\">6</div>
													</div>
													<div class=\"row\">
														<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('7');\">7</div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('8');\">8</div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('9');\">9</div>
													</div>
													<div class=\"row\">
														<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-danger\" onClick=\"pinremove();\">X</div>
														<div class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-primary\" onClick=\"pinappend('0');\">0</div>
														<button class=\"col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-lg btn-success\" type=\"submit\">OFF</button>
													</div>
												</section>
											</div>
										</fieldset>
									</form>
								</div>";
			}
			else
			{
				$generate .= "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
									<form action=\"\" method=\"POST\" class=\"smart-form\">
										<fieldset>
											<div class=\"row\">
												<div class=\"alert alert-info\">Код безопасности</div>
												<section class=\"col-lg-12\">
													<label class=\"input\">
														<input type=\"hidden\" name=\"generate\" value=\"1\">
														<button type=\"submit\" class=\"btn btn-lg btn-success\">Включить</button>
													</label>
												</section>
											</div>
										</fieldset>
									</form>
								</div>";
			}
			$style->content("{title}", "Настройки");
			$style->content("{content}", "<div class=\"row\">
											<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
												<form action=\"\" method=\"POST\" class=\"smart-form\">
													<fieldset>
														<div class=\"row\">
															<div class=\"alert alert-info\">Смена пароля</div>
															<section class=\"col-lg-12\">
																<label class=\"input\">
																	<input type=\"password\" name=\"oldpassword\" placeholder=\"Введите текущий пароль\">
																</label>
															</section>
															<section class=\"col-lg-12\">
																<label class=\"input\">
																	<input type=\"password\" name=\"newpassword\" placeholder=\"Введите новый пароль\">
																</label>
															</section>
															<section class=\"col-lg-12\">
																<label class=\"input\">
																	<input type=\"password\" name=\"newpasswordtwo\" placeholder=\"Введите новый пароль ещё раз\">
																</label>
															</section>
															<section class=\"col-lg-12\">
																<label class=\"input\">
																	<button type=\"submit\" class=\"btn btn-sm btn-success\">Сменить</button>
																</label>
															</section>
														</div>
													</fieldset>
												</form>
											</div>
											<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
												{$generate}
											</div>
											<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
												<form action=\"\" method=\"POST\" class=\"smart-form\">
													<fieldset>
														<div class=\"row\">
															<div class=\"alert alert-info\">Настройки приватности</div>
															<section class=\"col-lg-12\">
																<label class=\"select\">
																	<select class=\"select\" name=\"select\">
																		<option value=\"0\">Выберите параметр</option>
																		<option value=\"1\">Разрешить просмотр основной информации всем пользователям</option>
																		<option value=\"2\">Запретить просмотр профиля</option>
																	</select>
																</label>
															</section>
															<section class=\"col-lg-12\">
																<label class=\"input\">
																	<button type=\"submit\" class=\"btn btn-sm btn-success\">Обновить</button>
																</label>
															</section>
														</div>
													</fieldset>
												</form>
											</div>
											<hr>
											<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
												<h4>История авторизаций</h4>
												<div class=\"table-responsive\">
													<table id=\"dt_basic\" class=\"table table-striped table-bordered table-hover text-center\" width=\"100%\">
														<thead>			                
															<tr>
																<th>Номер авторизации</th>
																<th>Имя</th>
																<th>Метод</th>
																<th>IP</th>
																<th>Дата</th>
															</tr>
														</thead>
														<tbody>
														" . User::getip() . "
														</tbody>
													</table>
												</div>
											</div>
										</div>");
			$style->content("{script}", "
			<script type=\"text/javascript\">
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
			</script>
			<script type=\"text/javascript\">
				var pagefunction = function() {
					var responsiveHelper_dt_basic = undefined;
							var breakpointDefinition = {
								tablet : 1024,
								phone : 480
							};
					$('#dt_basic').dataTable({
						\"sDom\": \"<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>\"+
							\"t\"+
							\"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>\",
						\"autoWidth\" : true,
						\"preDrawCallback\" : function() {
							if (!responsiveHelper_dt_basic) {
								responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
							}
						},
						\"rowCallback\" : function(nRow) {
							responsiveHelper_dt_basic.createExpandIcon(nRow);
						},
						\"drawCallback\" : function(oSettings) {
							responsiveHelper_dt_basic.respond();
						}
					});
				};
				loadScript(\"{$url}/" . template . "js/plugin/datatables/jquery.dataTables.min.js\", function()
				{
					loadScript(\"{$url}/" . template . "js/plugin/datatables/dataTables.colVis.min.js\", function()
					{
						loadScript(\"{$url}/" . template . "js/plugin/datatables/dataTables.tableTools.min.js\", function()
						{
							loadScript(\"{$url}/" . template . "js/plugin/datatables/dataTables.bootstrap.min.js\", function()
							{
								loadScript(\"{$url}/" . template . "js/plugin/datatable-responsive/datatables.responsive.min.js\", pagefunction)
							});
						});
					});
				});
			</script>");
		}
	}
}
else
{
	$style->content("{title}", "Настройки");
	$style->content("{content}", "<div class=\"alert alert-danger\">Ваш персонаж находится на сервере.</div>");
	$style->content("{script}", "");
}