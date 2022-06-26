<?php
if(!defined('RUCP')) die("Hacking attempt!");

$style->content("{style}", "");
if(isset($_POST['summ']))
{
	$sum = (int)$_POST['summ'];
	if($sum == "")
	{
		$style->content("{title}", "Донат");
		$style->content("{content}", "<div class=\"alert alert-danger\">Заполните все поля!</div>");
		$style->content("{script}", "");
	}
	elseif($sum > 99999 && $sum <= 0)
	{
		$style->content("{title}", "Донат");
		$style->content("{content}", "<div class=\"alert alert-danger\">Неверная сумма!</div><script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/pay'\", 2000);</script>");
		$style->content("{script}", "");
	} 
	else
	{
		if(preg_match("/^[1-9]\\d*$/", $sum))
		{
			if($member['DonateMOther'] >= 0 && $member['DonateMOther'] <= 499)
			{
				$percent = $sum/100*0;
				$total = $sum-$percent;
			}
			elseif($member['DonateMOther'] >= 500 && $member['DonateMOther'] <= 1499)
			{
				$percent = $sum/100*3;
				$total = $sum-$percent;
			}
			elseif($member['DonateMOther'] >= 1500 && $member['DonateMOther'] <= 2999)
			{
				$percent = $sum/100*5;
				$total = $sum-$percent;
			}
			elseif($member['DonateMOther'] >= 3000 && $member['DonateMOther'] <= 5999)
			{
				$percent = $sum/100*7;
				$total = $sum-$percent;
			}
			else
			{
				$percent = $sum/100*10;
				$total = $sum-$percent;
			}
			$style->content("{title}", "Донат");
			$style->content("{content}", "<div class=\"row\">
											<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\"></div>
											<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
												<div class=\"thumbnail\">
													<form action=\"https://unitpay.ru/pay/12277-8b69d\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
														<header style=\"background: #fff; border-color: #fff;\">
															<img src=\"https://unitpay.ru/images/f8ede98.png\" height=\"16\">
															<br />
															Проверка данных
														</header>
														<fieldset>
															<section>
																<label class=\"label\">Сумма платежа</label>
																<label class=\"input\"> 
																	<i class=\"icon-append fa fa-rub\"></i>
																	<input type=\"text\" value=\"{$sum} RUB\" disabled>
																	<input type=\"hidden\" name=\"sum\" value=\"{$sum}\">
																	<input type=\"hidden\" name=\"desc\" value=\"Пополнение счёта игрового аккаунта {$member['name']} #{$member['member_id']}\">
																	<input type=\"hidden\" name=\"account\" value=\"{$member['member_id']}\">
																	<b class=\"tooltip tooltip-top-right\">
																		<i class=\"fa fa-rub txt-color-teal\"></i> Введите сумму платежа
																	</b>
																</label>
															</section>
														</fieldset>
														<footer style=\"background: #fff; border-color: #fff;\">
															<button type=\"submit\" class=\"btn btn-primary\" name=\"submit\">
																Перейти к оплате
															</button>
														</footer>
													</form>
												</div>
											</div>
										</div>");
			$style->content("{script}", "");
		}
	}
}
elseif(isset($_POST['money']))
{
	$money = (int)$_POST['money'];
	if($money == "")
	{
		$style->content("{title}", "Донат");
		$style->content("{content}", "<div class=\"alert alert-danger\">Заполните все поля!</div>");
		$style->content("{script}", "");
	}
	elseif($money > 99999 && $money <= 0)
	{
		$style->content("{title}", "Донат");
		$style->content("{content}", "<div class=\"alert alert-danger\">Неверная сумма!</div><script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/pay'\", 2000);</script>");
		$style->content("{script}", "");
	} 
	else
	{
		if(preg_match("/^[1-9]\\d*$/", $money))
		{
			if($member['DonateMOther'] >= 0 && $member['DonateMOther'] <= 499)
			{
				$percent = $money/100*0;
				$total = $money-$percent;
			}
			elseif($member['DonateMOther'] >= 500 && $member['DonateMOther'] <= 1499)
			{
				$percent = $money/100*3;
				$total = $money-$percent;
			}
			elseif($member['DonateMOther'] >= 1500 && $member['DonateMOther'] <= 2999)
			{
				$percent = $money/100*5;
				$total = $money-$percent;
			}
			elseif($member['DonateMOther'] >= 3000 && $member['DonateMOther'] <= 5999)
			{
				$percent = $money/100*7;
				$total = $money-$percent;
			}
			else
			{
				$percent = $money/100*10;
				$total = $money-$percent;
			}
			$order = $member['member_id']+time();
			$mrh_login = "RAKNET";
			$mrh_pass1 = "873IUUkakjw9e8s9oihas091";
			$desc = "Пополнение счёта игрового аккаунта {$member['name']} #{$member['member_id']}";
			$in_curr = "";
			$culture = "ru";
			$crc = md5("{$mrh_login}:{$total}:{$order}:{$mrh_pass1}:Shp_item={$member['name']}");
			$data = array("id_order" => $order,
						"userid" => $member['member_id'],
						"Name" => $member['name'],
						"itemsCount" => $total,
						"money" => $money,
						"status" => 0,
						"email" => $member['email'],
						"odate" => date("d.m.Y H:i", time()),
						"tid" => $crc,
						"status1" => 0);
			$db->insert('robokassa', $data);
			$style->content("{title}", "Донат");
			$style->content("{content}", "<div class=\"row\">
											<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\">
											</div>
											<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\"><!--http://test.robokassa.ru/Index.aspx-->
												<div class=\"thumbnail\">
													<form action=\"https://merchant.roboxchange.com/Index.aspx\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
														<header style=\"background: #fff; border-color: #fff;\">
															<img src=\"https://partner.robokassa.ru/Content/images/robo_main_logo.png\">
															<br />
															Проверка данных
														</header>
														<fieldset>
															<section>
																<label class=\"label\">Сумма платежа</label>
																<label class=\"input\"> 
																	<i class=\"icon-append fa fa-rub\"></i>
																	<input type=\"text\" value=\"{$money} RUB\" disabled>
																	<input type=\"hidden\" name=\"MrchLogin\" value=\"{$mrh_login}\">
																	<input type=\"hidden\" name=\"OutSum\" value=\"{$total}\">
																	<input type=\"hidden\" name=\"InvId\" value=\"{$order}\">
																	<input type=\"hidden\" name=\"Desc\" value=\"{$desc}\">
																	<input type=\"hidden\" name=\"SignatureValue\" value=\"{$crc}\">
																	<input type=\"hidden\" name=\"Shp_item\" value=\"{$member['name']}\">
																	<input type=\"hidden\" name=\"IncCurrLabel\" value=\"{$in_curr}\">
																	<input type=\"hidden\" name=\"Culture\" value=\"{$culture}\">
																	<b class=\"tooltip tooltip-top-right\">
																		<i class=\"fa fa-rub txt-color-teal\"></i> Введите сумму платежа
																	</b>
																</label>
															</section>
														</fieldset>
														<footer style=\"background: #fff; border-color: #fff;\">
															<button type=\"submit\" class=\"btn btn-primary\" name=\"submit\">
																Перейти к оплате
															</button>
														</footer>
													</form>
												</div>
											</div>
										</div>");
			$style->content("{script}", "");
		}
	}
}
else
{
	$style->content("{title}", "Донат");
	$friend = $db->rawQuery("SELECT `friends_friend_id` FROM `profile_friends` WHERE `friends_member_id` = ?", array($member['member_id']));
	foreach($friend as $key => $value)
	{
		$name = $db->where("member_id", $value['friends_friend_id']);
		$name = $db->getOne("members");
		if(!$name['name']) $output = "";
		else 
		{
			$output = "<option value=\"{$value['friends_friend_id']}\">{$name['name']}</option>\n";
		}
		$friends .= $output;
	}
	if($member['DonateMOther'] >= 0 && $member['DonateMOther'] <= 499)
	{
		$per = 0;
	}
	elseif($member['DonateMOther'] >= 500 && $member['DonateMOther'] <= 1499)
	{
		$per = 3;
	}
	elseif($member['DonateMOther'] >= 1500 && $member['DonateMOther'] <= 2999)
	{
		$per = 5;
	}
	elseif($member['DonateMOther'] >= 3000 && $member['DonateMOther'] <= 5999)
	{
		$per = 7;
	}
	else
	{
		$per = 10;
	}
	$style->content("{content}", "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
										<div class=\"thumbnail\">
											<form action=\"\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
												<header style=\"background: #fff; border-color: #fff;\">
													<img src=\"https://unitpay.ru/images/f8ede98.png\" height=\"16\">
												</header>
												<fieldset>
													<section>
														<label class=\"label\">Введите сумму платежа</label>
														<label class=\"input\"> 
															<i class=\"icon-append fa fa-rub\"></i>
															<input type=\"text\" name=\"summ\" onkeyup=\"Price();\" id=\"rubunit\" maxlength=\"5\">
															<b class=\"tooltip tooltip-top-right\">
																<i class=\"fa fa-rub txt-color-teal\"></i>
															</b>
														</label>
													</section>
												</fieldset>
												<footer style=\"background: #fff; border-color: #fff;\">
													<button type=\"submit\" class=\"btn btn-primary\" name=\"submit\">
														Продолжить
													</button>
												</footer>
											</form>
										</div>
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
										<div class=\"thumbnail\">
											<form action=\"\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
												<header style=\"background: #fff; border-color: #fff;\">
													<img src=\"https://partner.robokassa.ru/Content/images/robo_main_logo.png\">
												</header>
												<fieldset>
													<section>
														<label class=\"label\">Введите сумму платежа</label>
														<label class=\"input\"> 
															<i class=\"icon-append fa fa-rub\"></i>
															<input type=\"text\" name=\"money\" onkeyup=\"Prices();\" id=\"rubrobo\" maxlength=\"5\">
															<b class=\"tooltip tooltip-top-right\">
																<i class=\"fa fa-rub txt-color-teal\"></i>
															</b>
														</label>
													</section>
												</fieldset>
												<footer style=\"background: #fff; border-color: #fff;\">
													<button type=\"submit\" class=\"btn btn-primary\" name=\"submit\">
														Продолжить
													</button>
												</footer>
											</form>
										</div>
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\">
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
										<div class=\"thumbnail\">
											<form action=\"\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
													<div class=\"alert alert-info\" align=\"center\">
														Курс обмена игровой валюты
													</div>
													<section>
														<label class=\"label\">Платите с учетом скидки (В разработке)</label>
														<label class=\"input\"> 
															<i class=\"icon-append fa fa-rub\"></i>
															<input type=\"text\" maxlength=\"5\"id=\"tots\" disabled>
															<b class=\"tooltip tooltip-top-right\">
																<i class=\"fa fa-rub txt-color-teal\"></i>
															</b>
														</label>
													</section>
													<section>
														<label class=\"label\">Вы получите</label>
														<label class=\"input\"> 
															<i class=\"icon-append fa fa-dollar\"></i>
															<input type=\"text\" maxlength=\"5\" id=\"total\" disabled>
															<b class=\"tooltip tooltip-top-right\">
																<i class=\"fa fa-dollar txt-color-teal\"></i>
															</b>
														</label>
													</section>
												</fieldset>
											</form>
										</div>
									</div>
								<hr>
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
									<div class=\"alert alert-success\"><h4>Неиспользованные донат коды</h4></div>
									<div class=\"thumbnail\" id=\"result\">
											<table id=\"dt_basic1\" class=\"table table-striped table-bordered table-hover text-center\" width=\"100%\">
												<thead>			                
													<tr>
														<th>Сумма</th>
														<th>Код</th>
														<th>Действие</th>
													</tr>
												</thead>
												<tbody>
													" . User::getcode() . "
													" . User::getfriendcode() . "
												</tbody>
											</table>
											<form class=\"smart-form\">
											<br />
											<button type=\"button\" class=\"btn btn-sm btn-primary\" onClick=\"ActivationCode('/dcode.php', $('#dcode').val(), 0);\">Активировать</button>
											<br />
											<br />
											<label class=\"select col-xs-2 col-sm-2 col-md-2 col-lg-2\">
												<select class=\"select\" id=\"friend\">
													<option>Выберите друга</option>
													{$friends}
												</select>
											</label>
											<button type=\"button\" class=\"btn btn-sm btn-success\" style=\"height: 32px;\" onclick=\"ActivationCode('/dcode.php', $('input[type=radio]:checked').val(), 1, $('#friend').val());\">Подарить другу</button>
											</form>
									</div>
									<h4>История пополнений</h4>
									<div class=\"thumbnail\">
										<div class=\"table-responsive\">
											<table id=\"dt_basic\" class=\"table table-striped table-bordered table-hover text-center\" width=\"100%\">
												<thead>			                
													<tr>
														<th>Система</th>
														<th>№ Транзакции</th>
														<th>Сумма</th>
														<th>Рублей</th>
														<th>Дата</th>
													</tr>
												</thead>
												<tbody>
													" . User::getpay() . "
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>");
	$style->content("{script}", "<script type=\"text/javascript\">
			function Price() 
			{ 										
				var rur = $('#rubunit').val(); 
				var total = 0;
				if(rur <= 0)
				{
					$('#total').val('0');
					$('#tots').val('0');
				}
				else
				{		
					total = 500 * rur;
					procent = rur/100*{$per};
					obshee = rur-procent;
				}
				$('#total').val(total);
				$('#tots').val(obshee);
			}
			function Prices() 
			{ 										
				var rur = $('#rubrobo').val(); 
				var total = 0;
				if(rur <= 0)
				{
					$('#total').val('0');
					$('#tots').val('0');
				}
				else
				{		
					total = 500 * rur;
					procent = rur/100*{$per};
					obshee = rur-procent;
				}
				$('#total').val(total);
				$('#tots').val(obshee);
			}
			var pagefunction = function() 
			{
				var responsiveHelper_dt_basic = undefined;
				var breakpointDefinition = 
				{
					tablet : 1024,
					phone : 480
				};
				$('#dt_basic').dataTable({
					\"sDom\": \"<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>\"+
						\"t\"+
						\"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>\",
					\"autoWidth\" : true,
					\"preDrawCallback\" : function() 
					{
						if (!responsiveHelper_dt_basic) 
						{
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
						}
					},
					\"rowCallback\" : function(nRow) 
					{
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					\"drawCallback\" : function(oSettings) 
					{
						responsiveHelper_dt_basic.respond();
					}
				});
				$('#dt_basic1').dataTable({
					\"sDom\": \"<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>\"+
						\"t\"+
						\"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>\",
					\"autoWidth\" : true,
					\"preDrawCallback\" : function() 
					{
						if (!responsiveHelper_dt_basic) 
						{
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic1'), breakpointDefinition);
						}
					},
					\"rowCallback\" : function(nRow) 
					{
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					\"drawCallback\" : function(oSettings) 
					{
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