<?php
class User extends Param
{
	static public function view($param = false)
	{
		global $ipbMemberLoginApi, $db;
		$member = $ipbMemberLoginApi->getMember();
		$query = "";
		if($param <= false) $param = $member['member_id'];
		elseif($param == "") $param = $member['member_id'];
		$load = IPSMember::load($param, "all");

		if(!$load['member_id'])
		{
			return "Пользователь с таким идентификатором не найден";
		}
 		if($load['member_id'] == $param)
		{
			$time = $load['date']/3600;
			$exp = $load['Level']+1;
			$exp = $exp*4;
			for($i = 0; $i < 48; $i++) $pinventory .= self::objecuser($load["P{$i}"], $load["V{$i}"], $i, "user");
			
			$car = $db->rawQuery("SELECT * FROM `vehicles_player` WHERE `Owned` = ?", array($param));
			
			$house = $db->where("Owned", $load['member_id']);
			$house = $db->getOne("house");
			
			require('config/vehicle.php');
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

			foreach($car as $key => $value)
			{
				if(!$value['Owned'])
				{
					$vehicles = "";
				}
				else
				{
					$vehicles .= "<td>
									<p>
										{$vehiclename[$value['Model']]}
									</p>
									<img src=\"http://ucp.raknet.ru/" . template . "img/cars/{$value['Model']}.png\">
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
										Дата покупки: " . date("d.m.Y H:i", $value['vDate']) . "
									</p>
								</td>";
				}
			}
			$query .= 
			"<div id=\"bresult\"></div>
				<div class=\"row\">
								<div class=\"col-lg-5\">
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
							<div class=\"col-lg-4\">
								{$pinventory}
							</div>
							<div class=\"col-lg-5\">
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
							<div class=\"col-lg-3\">
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
							<div class=\"col-lg-8\">
								<h4>Персональные автомобили</h4>
								<div class=\"table-responsive\">
									<table class=\"table\">
										<tr>
											{$vehicles}
										</tr>
									</table>
								</div>
							</div>
			";
		}
		return $query;
	}
	
	static public function objecuser($object, $valve, $param, $params)
	{
		global $db;
		$query = $db->where("id", $object);
		$query = $db->getOne("inventar");
		if($params == "user")
		{
			$descriptor = str_replace("\n","<br />", $query['descriptionobjekt']);
			if($query['realobjekt'] == 19374) return "<button type=\"button\" class=\"thumbnail col-xs-2 col-md-2\"><img  src=\"http://ucp.raknet.ru/" . template . "img/shop/0.png\"></button>";
			else 
			{
				$headers = get_headers("http://ucp.raknet.ru/" . template . "img/shop/{$query['realobjekt']}.png");
				if($headers[0] == 'HTTP/1.1 404 Not Found') 
				{
					$img = "<img src=\"http://ucp.raknet.ru/" . template . "img/shop/0.png\">";
				}
				else
				{
					$img = "<img src=\"http://ucp.raknet.ru/" . template . "img/shop/{$query['realobjekt']}.png\">";
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
	
	static public function checkbio()
	{
		global $ipbMemberLoginApi, $style, $db;
		$member = $ipbMemberLoginApi->getMember();
		$bio = "";
		$db->where ('pp_about_me', "", ">")->where('pp_moderators_confirm', 0, '>=');
		$query = $db->get("profile_portal");
		foreach($query as $key => $value)
		{
			$name = IPSMember::load($value['pp_member_id']);
			$aname = IPSMember::load($value['pp_moderators_id']);
			if($value['pp_moderators_confirm'] == 0)
			{
				$admin = "<i>Проверил: {$aname['prefix']}{$aname['name']}{$aname['suffix']}</i>";
			}
			elseif($value['pp_moderators_confirm'] == 3)
			{
				$admin = "<i>Отклонил на изменение: {$aname['prefix']}{$aname['name']}{$aname['suffix']} Причина: {$value['pp_mod_reason']}</i>";
			}
			elseif($value['pp_moderators_confirm'] == 2)
			{
				$admin = "<i>Отклонил: {$aname['prefix']}{$aname['name']}{$aname['suffix']} Причина: {$value['pp_mod_reason']}</i>";
			}
			$bio .= "<tr>
						<td>
							{$value['pp_member_id']}
						</td>
						<td>
							{$name['name']}
						</td>
						<td>
							{$admin}
						</td>
					</tr>";
		}
		return "<hr>
				<table class=\"table table-striped table-bordered table-hover dataTables-example1\">
					<thead>
						<tr>
							<th>
								Номер аккаунта
							</th>
							<th>
								Имя игрока
							</th>
							<th>
								Статус
							</th>
						</tr>
					</thead>
					<tbody>
						{$bio}
					</tbody>
				</table>";
	}
	static public function bio($param = false)
	{
		global $ipbMemberLoginApi, $style, $db;
		$member = $ipbMemberLoginApi->getMember();
		if($param == "" && $param == 0)
		{
			$bio = "";
			$db->where ('pp_about_me', "", ">")->where('pp_moderators_confirm', 1);
			$query = $db->get("profile_portal");
			foreach($query as $key => $value)
			{
				$name = IPSMember::load($value['pp_member_id']);
				if($value['pp_moderators_confirm'] == 1)
				{
					$button = "<a href=\"/bio/edit/{$value['pp_member_id']}/0\" class=\"btn btn-warning\">Новая</a>";
					
				}
				elseif($value['pp_moderators_confirm'] == 2)
				{
					$button = "<a href=\"/bio/edit/{$value['pp_member_id']}/0\" class=\"btn btn-danger\">Отклонена</a>";
				}
				$bio .= "<tr>
							
								<td>
									{$value['pp_member_id']}
								</td>
								<td>
									{$name['name']}
								</td>
								<td>
									{$button}
								</td>
						</tr>";
			}
			$style->content("{script}", " 
										<script src=\"" . template . "js/plugins/dataTables/jquery.dataTables.js\"></script>
										<script src=\"" . template . "js/plugins/dataTables/dataTables.bootstrap.js\"></script>
										<script src=\"" . template . "js/plugins/dataTables/dataTables.responsive.js\"></script>
										<script src=\"" . template . "js/plugins/dataTables/dataTables.tableTools.min.js\"></script>
										<script>
											$(document).ready(function() {
												$('.dataTables-example').dataTable({
													responsive: true,
													\"dom\": 'T<\"clear\">lfrtip',
													\"tableTools\": {
														\"sSwfPath\": \"" . template . "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf\"
													}
												});
												$('.dataTables-example1').dataTable({
													responsive: true,
													\"dom\": 'T<\"clear\">lfrtip',
													\"tableTools\": {
														\"sSwfPath\": \"" . template . "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf\"
													}
												});
											});
										</script>");
			return "<table class=\"table table-striped table-bordered table-hover dataTables-example\">
						<thead>
							<tr>
								<th>
									Номер аккаунта
								</th>
								<th>
									Имя игрока
								</th>
								<th>
									Статус
								</th>
							</tr>
						</thead>
						<tbody>
							{$bio}
						</tbody>
					</table>";
		}
		else
		{
			$about = IPSMember::load($param, "all");
			if($about['pp_moderators_confirm'] != 1)
			{
				$style->content("{script}", "");
				return "<h4>Кто то уже проверял данную биографию</h4>";
			}
			else
			{
				$style->content("{script}", "<script type=\"text/javascript\">
										function selectbio()
										{
											$.ajax({
												type: \"POST\",
												url: \"update.php\",
												data: $(\"#updatebio\").serialize(),
												success: function(data) 
												{
													alert(data);
												},
												error: function(data) 
												{
													alert('Произошла ошибка при обработке запроса');
												}
											});
										};
								</script>");
				return "
					<h4>Биография: {$about['name']}</h4>
					<br />
					" . $about['pp_about_me'] . "
					<p>
						<form action=\"\" method=\"POST\" id=\"updatebio\">
							<div class=\"col-sm-2\">
								<label>Заполните причину отклонения</label>
								<input class=\"form-control m-b\" type=\"text\" name=\"reason\" value=\"\" placeholder=\"Введите причину отклонения\">
							</div>
							<div class=\"col-sm-2\">
								<label>Действие</label>
								<select class=\"form-control m-b\" name=\"{$about['member_id']}\" onchange=\"selectbio();\">
									<option>Выберите параметр</option>
									<option value=\"2\">Отклонить</option>
									<option value=\"0\">Одобрить</option>
									<option value=\"3\">На изменение</option>
								</select>
							</div>
							<input type=\"hidden\" name=\"member_id\" value=\"{$about['member_id']}\">
						</form>
						<br />
						<Br />
						<Br />
						<Br />
						<br />
					</p>";
			}
		}
	}
}