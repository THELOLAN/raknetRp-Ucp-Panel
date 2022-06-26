<?php 
class User extends Param
{	
	static public function view($param = false)
	{
		global $ipbMemberLoginApi, $style, $db, $url;
		$member = $ipbMemberLoginApi->getMember();
		$query = "";
		$alert = "";
		if($param <= false) $param = $member['member_id'];
		elseif($param == "") $param = $member['member_id'];
		$load = IPSMember::load($param, "all");
		if($load['pp_moderators_confirm'] == 0) $aboutme .= (($load["pp_about_me"] > "") ? "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive\"><h4>Биография персонажа {$load['name']}</h4>{$load['pp_about_me']}</div>" : "");
		else $aboutme .= "";
		if(!$load['member_id'])
		{
			$style->content("{title}", "Пользователь с таким идентификатором не найден");
			return "Пользователь с таким идентификатором не найден";
		}
 		if($load['member_id'] == $member['member_id'])
		{
			if($load['pp_moderators_confirm'] == 3  && $load['pp_check_reason'] == 1)
			{
				$upreason = array(
					'pp_check_reason' => 0
				);
				$db->update('profile_portal', $upreason);
				$alert .= "<script type=\"text/javascript\">
							$(document).ready(function() 
							{
								$.smallBox({
									title : \"Внимание!\",
									content : \"Ваша биография была отклонена на изменение модератором по причине: {$load['pp_mod_reason']}.\",
									color : \"#C26565\",
									icon : \"fa fa-warning\",
									timeout : 6000
								});
							});
							</script>";
			}
			elseif($load['pp_moderators_confirm'] == 2  && $load['pp_check_reason'] == 1)
			{
				$upreason = array(
					'pp_check_reason' => 0
				);
				$db->update('profile_portal', $upreason);
				$alert .= "<script type=\"text/javascript\">
							$(document).ready(function() 
							{
								$.smallBox({
									title : \"Внимание!\",
									content : \"Ваша биография была отклонена модератором по причине: {$load['pp_mod_reason']}.\",
									color : \"#C26565\",
									icon : \"fa fa-warning\",
									timeout : 6000
								});
							});
							</script>";
			}
			$time = $load['date']/3600;
			$exp = $load['Level']+1;
			$exp = $exp*4;
			$style->content("{title}", "Просмотр профиля {$load['name']}");
			$pinventory = "";
			$vehicles = "";
			$hcash = "";
			for($i = 0; $i < 48; $i++) $pinventory .= self::objecuser($load["P{$i}"], $load["V{$i}"], $i, "user");
			
			$memberid = array($load['member_id']);
			$car = $db->rawQuery("SELECT * FROM `vehicles_player` WHERE `Owned` = ?", $memberid);
			$house = $db->where("Owned", $load['member_id']);
			$house = $db->getOne("house");
			if(!$house)
			{
				$hcash = "";
			}
			else
			{
				$hcash .= "<tr>
								<td>
									Домашний счет:
								</td>
								<td>
									$ " . number_format($house['hCash']) . "
								</td>
							</tr>";
			}
			require('config/vehicle.php');
			foreach($car as $key => $value)
			{
				if(!$value['Owned'])
				{
					$vehicles = "";
				}
				else
				{
					$date = mktime( date("H" , $value['vDate'] ), date("i", $value['vDate']), 0, date("m" , $value['vDate'])  , date("d" , $value['vDate']), date("Y" , $value['vDate'] )-20 );
					$vehicles .= "<td>
									<p>
										{$vehiclename[$value['Model']]}
									</p>
									<img src=\"{$url}/" . template . "img/cars/{$value['Model']}.png\">
									<p>
										Тип: {$vehicletype[$value['Model']]}
									</p>
									<p>
										Пробег: " . floor($value['Probeg']) . " км.
									</p>
									<p>
										Цвета: <div style=\"background: #{$colorvehicle[$value['vColor1']]}; border: 1px solid black; border-bottom: none; padding: 3px; display: inline-block; font-weight: bold; font-size: 90%; margin: 0; white-space: nowrap;\">{$value['vColor1']}</div> <div style=\"background: #{$colorvehicle[$value['vColor2']]}; border: 1px solid black; border-bottom: none; padding: 3px; display: inline-block; font-weight: bold; font-size: 90%; margin: 0; white-space: nowrap;\">{$value['vColor2']}</div>
									</p>
									<p>
										Дата покупки: " . date("d.m.Y в H:i" , $date) . "
									</p>
								</td>";
				}
			}
			$query .= "<div class=\"row\">
								{$alert}
								<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\">
									<center>
										<div id=\"myCarousel-2\" class=\"carousel slide\">
											<div class=\"carousel-inner\">
												<div class=\"item active\">
													<img src=\"{$url}/" . template . "img/avatars/{$load['Char']}.png\">
													<div class=\"carousel-caption\"></div>
												</div>
												<div class=\"item\">
													<img src=\"http://forum.raknet.ru/uploads/{$load['pp_main_photo']}\" alt=\"\">
													<div class=\"carousel-caption\"></div>
												</div>
											</div>
										</div>
									</center>
								</div>
								<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
									<h4>
										<table class=\"table\">
											<tr>
												<td>
													Имя:
												</td>
												<td>
													 {$load['name']}
												</td>
											</tr>
											<tr>
												<td>
													Уровень:
												</td>
												<td>
													{$load['Level']} ({$load['Exp']}/{$exp} EXP)
												</td>
											</tr>
											<tr>
												<td>
													Пол:
												</td>
												<td>
													" . self::gender($load['Sex']) . "
												</td>
											</tr>
											<tr>
												<td>
													Работа:
												</td>
												<td>
													" . self::job($load['Job']) . "
												</td>
											</tr>
											<tr>
												<td>
													Организация:
												</td>
												<td>
													" . self::frac($load['Member'], 1) . " " . self::rank($load['Member'], $load['Rank'], 0) . "
												</td>
											</tr>
											<tr>
												<td>
												</td>
												<td>
												</td>
											</tr>
										</table>
									</h4>
								</div>
								<div class=\"col-xs-12 col-sm-12 col-md-5 col-lg-5\">
									<h4>
										<table class=\"table\">
											<tr>
												<td>
													На руках/В банке:
												</td>
												<td>
													$ " . number_format($load['Cash']) . " / $ " . number_format($load['Bank']) . "
												</td>
											</tr>
											<tr>
												<td>
													Баланс телефона:
												</td>
												<td>
													$ " . number_format($load['Mobile']) . "
												</td>
											</tr>
											{$hcash}
											<tr>
												<td>
													Общая сумма пополнений:
												</td>
												<td>
													" . number_format($load['DonateMREAL']) . " / " . number_format($load['DonateMOther']) . " RUB
												</td>
											</tr>
											<tr>
												<td>
													Мобильный тел.:
												</td>
												<td>
													{$load['Pnumber']}
												</td>
											</tr>
											<tr>
												<td>
												</td>
												<td>
												</td>
											</tr>
										</table>
									</h4>
								</div>
							</div>
							<hr>
							<div class=\"col-xs-12 col-sm-12 col-md-5 col-lg-5\">
								{$pinventory}
							</div>
							<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
								<h4>
									<table class=\"table\">
										<tr>
											<td>
												Владение языками
											</td>
											<td>
											</td>
										</tr>
										<tr>
											<td>
												Итальянский:
											</td>
											<td>
												" .(($load["Italy"] == 5000) ? "Владеет" : "Не владеет")."
											</td>
										</tr>
										<tr>
											<td>
												Испанский:
											</td>
											<td>
												" .(($load["Ispan"] == 5000) ? "Владеет" : "Не владеет")."
											</td>
										</tr>
										<tr>
											<td>
												Японский:
											</td>
											<td>
												" .(($load["Japan"] == 5000) ? "Владеет" : "Не владеет")."
											</td>
										</tr>
										<tr>
											<td>
												Русский:
											</td>
											<td>
												" .(($load["Russia"] == 5000) ? "Владеет" : "Не владеет")."
											</td>
										</tr>
										<tr>
											<td>
												Немецкий:
											</td>
											<td>
												" .(($load["Nemec"] == 5000) ? "Владеет" : "Не владеет")."
											</td>
										</tr>
									</table>
								</h4>
							</div>
							<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\">
								<h4>
									<table class=\"table\">
										<tr>
											<td>
												Владение оружием
											</td>
											<td>
											</td>
										</tr>
										<tr>
											<td>
												Deagle:
											</td>
											<td>
												{$load['S_DesertEagle']}%
											</td>
										</tr>
										<tr>
											<td>
												ShotGun:
											</td>
											<td>
												{$load['S_ShotGun']}%
											</td>
										</tr>
										<tr>
											<td>
												MP5:
											</td>
											<td>
												{$load['S_MP5']}%
											</td>
										</tr>
										<tr>
											<td>
												AK47:
											</td>
											<td>
												{$load['S_AK47']}%
											</td>
										</tr>
										<tr>
											<td>
												M4A1:
											</td>
											<td>
												{$load['S_M4']}%
											</td>
										</tr>
									</table>
								</h4>
							</div>
							<div class=\"col-xs-12 col-sm-12 col-md-7 col-lg-7\">
								<h4>Персональные автомобили</h4>
								<div class=\"table-responsive\">
									<table class=\"table\">
										<tr>
											{$vehicles}
										</tr>
									</table>
								</div>
							</div>
							<hr>
							{$aboutme}";
		}
		else
		{
			if($load['profile_setup'] <= 1)
			{
				$memberid = array($load['member_id']);
				$car = $db->rawQuery("SELECT * FROM `vehicles_player` WHERE `Owned` = ?", $memberid);
				require('config/vehicle.php');
				foreach($car as $key => $value)
				{
					if(!$value['Owned'])
					{
						$vehicles = "";
					}
					else
					{
						$date = mktime( date("H" , $value['vDate'] ), date("i", $value['vDate']), 0, date("m" , $value['vDate'])  , date("d" , $value['vDate']), date("Y" , $value['vDate'] )-20 );
						$vehicles .= "<td>
										<p>
											{$vehiclename[$value['Model']]}
										</p>
										<img src=\"{$url}/" . template . "img/cars/{$value['Model']}.png\">
										<p>
											Тип: {$vehicletype[$value['Model']]}
										</p>
										<p>
											Пробег: " . floor($value['Probeg']) . " км.
										</p>
										<p>
											Цвета: <div style=\"background: #{$colorvehicle[$value['vColor1']]}; border: 1px solid black; border-bottom: none; padding: 3px; display: inline-block; font-weight: bold; font-size: 90%; margin: 0; white-space: nowrap;\">{$value['vColor1']}</div> <div style=\"background: #{$colorvehicle[$value['vColor2']]}; border: 1px solid black; border-bottom: none; padding: 3px; display: inline-block; font-weight: bold; font-size: 90%; margin: 0; white-space: nowrap;\">{$value['vColor2']}</div>
										</p>
										<p>
											Дата покупки: " . date("d.m.Y в H:i" , $date) . "
										</p>
									</td>";
					}
				}
				$time = $load['date']/3600;
				$style->content("{title}", "Просмотр профиля {$load['name']}");
					
				$query .= "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\">
										<center>
											<div id=\"myCarousel-2\" class=\"carousel slide\">
												<div class=\"carousel-inner\">
													<div class=\"item active\">
														<img src=\"{$url}/" . template . "/img/avatars/{$load['Char']}.png\">
														<div class=\"carousel-caption\"></div>
													</div>
													<div class=\"item\">
														<img src=\"http://forum.raknet.ru/uploads/{$load['pp_main_photo']}\" alt=\"\" width=\"236\" height=\"236\">
														<div class=\"carousel-caption\"></div>
													</div>
												</div>
											</div>
										</center>
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
										<h4>
											<table class=\"table\">
												<tr>
													<td>
														Имя:
													</td>
													<td>
														 {$load['name']}
													</td>
												</tr>
												<tr>
													<td>
														Уровень:
													</td>
													<td>
														{$load['Level']}
													</td>
												</tr>
												<tr>
													<td>
														Пол:
													</td>
													<td>
														" . self::gender($load['Sex']) . "
													</td>
												</tr>
												<tr>
													<td>
														Работа:
													</td>
													<td>
														" . self::job($load['Job']) . "
													</td>
												</tr>
												<tr>
													<td>
														Организация:
													</td>
													<td>
														" . self::frac($load['Member'], 0) . " " . self::rank($load['Member'], $load['Rank'], 1) . "
													</td>
												</tr>
												<tr>
													<td>
														Телефон:
													</td>
													<td>
														{$load['Pnumber']}
													</td>
												</tr>
												<tr>
													<td>
													</td>
													<td>
													</td>
												</tr>
											</table>
										</h4>
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-5 col-lg-5\">
										<h4>
											<table class=\"table\">
												<tr>
													<td>
														Владение языками
													</td>
													<td>
													</td>
												</tr>
												<tr>
													<td>
														Итальянский:
													</td>
													<td>
														" .(($load["Italy"] == 5000) ? "Владеет" : "Не владеет")."
													</td>
												</tr>
												<tr>
													<td>
														Испанский:
													</td>
													<td>
														" .(($load["Ispan"] == 5000) ? "Владеет" : "Не владеет")."
													</td>
												</tr>
												<tr>
													<td>
														Японский:
													</td>
													<td>
														" .(($load["Japan"] == 5000) ? "Владеет" : "Не владеет")."
													</td>
												</tr>
												<tr>
													<td>
														Русский:
													</td>
													<td>
														" .(($load["Russia"] == 5000) ? "Владеет" : "Не владеет")."
													</td>
												</tr>
												<tr>
													<td>
														Немецкий:
													</td>
													<td>
														" .(($load["Nemec"] == 5000) ? "Владеет" : "Не владеет")."
													</td>
												</tr>
											</table>
										</h4>
									</div>
								</div>
								<hr>
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
									<h4>Персональные автомобили</h4>
									<div class=\"table-responsive\">
										<table class=\"table\">
											<tr>
												{$vehicles}
											</tr>
										</table>
									</div>
								</div>
								<hr>
								<hr>
								{$aboutme}";
			}
			elseif($load['profile_setup'] == 2)
			{
				$style->content("{title}", "Просмотр профиля {$load['name']}");		
				$query .= "<div class=\"alert alert-danger\">Данный пользователь запретил просматривать его профиль.</div>";
			}
		}
		return $query;
	}
	
	static public function friend($param)
	{
		global $db, $url;
		$friends = "";
		$param = array($param);
		$friend = $db->rawQuery("SELECT `friends_friend_id` FROM `profile_friends` WHERE `friends_member_id` = ?",$param);
		foreach($friend as $key => $value)
		{
			$name = $db->where("member_id", $value['friends_friend_id']);
			$name = $db->getOne("members");
			if(!$name['name']) $output = "";
			else 
			{
				$output = "<tr>
								<td>
									<center>
										<img src=\"{$url}/" . template . "img/avatars/{$name['Char']}.png\" width=\"35\">
									</center>
								</td>
								<td>
									<a href=\"{$url}/user/view/{$name['member_id']}\" target=\"_blank\">{$name['name']}</a>
								</td>
								<td>
									<center>{$name['Pnumber']}</center>
								</td>
							</tr>";
			}
			$friends .= $output;
		}
		return $friends;
	}
	
	static public function objecuser($object, $valve, $param, $params)
	{
		global $db, $url;
		$query = $db->where("id", $object);
		$query = $db->getOne("inventar");
		if($params == "user")
		{
			$descriptor = str_replace("\n","<br />", $query['descriptionobjekt']);
			if($query['realobjekt'] == 19374) return "<button type=\"button\" class=\"thumbnail col-xs-2 col-md-2\"><img  src=\"{$url}/" . template . "img/shop/0.png\"></button>";
			else 
			{
				$headers = get_headers("{$url}/" . template . "img/shop/{$query['realobjekt']}.png");
				if($headers[0] == 'HTTP/1.1 404 Not Found') 
				{
					$img = "<img src=\"{$url}/" . template . "img/shop/0.png\">";
				}
				else
				{
					$img = "<img src=\"{$url}/" . template . "img/shop/{$query['realobjekt']}.png\">";
				}
				return "<button href=\"#\" data-toggle=\"modal\" data-target=\"#{$params}{$param}\" class=\"thumbnail col-xs-2 col-md-2\">{$img}</button>
							<div class=\"modal\" id=\"{$params}{$param}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
								<div class=\"modal-dialog\">
									<div class=\"modal-content\">
										<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
											<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
										</div>
										<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
											<div class=\"table-responsive\" style=\"max-height: 400px;\">
												<table class=\"table text-center\">
													<tbody>
														<tr>
															<td>
																{$img}
															</td>
															<td>
																{$descriptor}
																<br />
																Остаток: {$valve} шт.
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>";
			}
		}
	}
	
	static public function getip()
	{
		global $ipbMemberLoginApi, $db;
		$member = $ipbMemberLoginApi->getMember();
		$param = array($member['member_id']);
		$data = $db->rawQuery("SELECT * FROM `smember_log` WHERE `userid` = ? ORDER BY `id` DESC", $param);
		$return = "";
		foreach($data as $key => $value)
		{
			$return .= "<tr>
							<td>
								<center>#{$value['id']}</center>
							</td>
							<td>
								<center>{$value['name']}</center>
							</td>
							<td>
								<center>{$value['browser']}</center>
							</td>
							<td>
								<center>{$value['ip']}</center>
							</td>
							<td>
								<center>" . date ( "d.m.Y в H:i" , $value['time'] ) . "</center>
							</td>
						</tr>";
		}
		return $return;
	}
	static public function getcode()
	{
		global $ipbMemberLoginApi, $db;
		$member = $ipbMemberLoginApi->getMember();
		$paramr = array($member['member_id']);
		$r = "";
		$getcode = $db->rawQuery("SELECT * FROM `dcode` WHERE `member` = ?", $paramr);
		foreach($getcode as $key => $value)
		{
			if($value['give'] == 1)
			{
				$r .= "";
			}
			else
			{
				$r .= "<tr>
					<td>
						{$value['money']} руб.
					</td>
					<td>
						{$value['code']}
					</td>
					<td>
						<input name=\"dcode\" type=\"radio\" value=\"{$value['code']}\" id=\"dcode\">
					</td>
				</tr>";
			}
		}
		return $r;
	}
	
	static public function getfriendcode()
	{
		global $ipbMemberLoginApi, $db;
		$member = $ipbMemberLoginApi->getMember();
		$paramr = array($member['member_id']);
		$r = "";
		$getcode = $db->rawQuery("SELECT * FROM `dcode` WHERE `to_id` = ?", $paramr);
		foreach($getcode as $key => $value)
		{
			$name = $db->where('member_id', $value['member']);
			$name = $db->getOne('members');
			if($value['give'] == 1)
			{
				$r .= "<tr class=\"success\">
							<td>
								{$value['money']} руб.
							</td>
							<td>
								Подарок от {$name['name']}
							</td>
							<td>
								<input name=\"dcode\"  type=\"radio\" value=\"{$value['code']}\" id=\"dcode\">
							</td>
						</tr>";
			}
			else
			{
				$r .= "";
			}
		}
		return $r;
	}
	
	static public function getpay()
	{
		global $ipbMemberLoginApi, $db;
		$member = $ipbMemberLoginApi->getMember();
		$paramu = array($member['name']);
		$parami = array($member['member_id']);
		$paramr = array($member['member_id']);
		$u = "";
		$i = "";
		$r = "";
		$datau = $db->rawQuery("SELECT * FROM `unitpay_payments` WHERE `account` = ? AND `status` = '1'", $paramu);
		$datai = $db->rawQuery("SELECT * FROM `unitpay_payments` WHERE `account` = ? AND `status` = '1'", $parami);
		$datar = $db->rawQuery("SELECT * FROM `robokassa` WHERE `userid` = ? AND `status1` = '1'", $paramr);
		foreach($datau as $key => $value)
		{
			$u .= "<tr>
						<td>
							UNITPAY
						</td>
						<td>
							{$value['unitpayId']}
						</td>
						<td>
							{$value['sum']}
						</td>
						<td>
							{$value['itemsCount']}
						</td>
						<td>
							{$value['dateComplete']}
						</td>
					</tr>";
		}
		foreach($datai as $key => $value)
		{
			$i .= "<tr>
						<td>
							UNITPAY
						</td>
						<td>
							{$value['unitpayId']}
						</td>
						<td>
							{$value['sum']}
						</td>
						<td>
							{$value['itemsCount']}
						</td>
						<td>
							{$value['dateComplete']}
						</td>
					</tr>";
		}
		foreach($datar as $key => $value)
		{
			$u .= "<tr>
						<td>
							ROBOKASSSA
						</td>
						<td>
							{$value['id_order']}
						</td>
						<td>
							{$value['itemsCount']}
						</td>
						<td>
							{$value['money']}
						</td>
						<td>
							{$value['odate']}
						</td>
					</tr>";
		}
		return $u . $r . $i;
	}
}