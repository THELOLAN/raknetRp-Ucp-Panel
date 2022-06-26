<?php
if(!defined('RUCP')) die("Hacking attempt!");

$style->content("{style}", "");
if($page[1] == "rich")
{
	$style->content("{title}", "ТОП 20 Богачей");
	$topcash = "";
	$query = $db->rawQuery("SELECT `member_id`, `Cash`, `Bank`, `name`, `Char`, `Online` FROM `members` WHERE `Cash` > '0' AND `Admin` = '0' ORDER BY `Cash` DESC LIMIT 20");
	foreach($query as $key => $value)
	{
		$topcash .= "<tr>
						<td>
							<img src=\"{$url}/" . template . "img/avatars/{$value['Char']}.png\" width=\"35\">
						</td>
						<td>
							<a href=\"{$url}/user/view/{$value['member_id']}\" target=\"_blank\">{$value['name']}</a>
						</td>
						<td>
							" . number_format($value['Cash']) . " <font color=\"green\">$</font>
						</td>
						<td>
							" . Param::online($value['Online']) . "
						</td>
					</tr>";
	}
	$style->content("{content}", "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
										<table class=\"table table-bordered text-center\">
											<thead>
												<tr>
													<th style=\"width: 3%\"></th>
													<th>
														Имя игрока
													</th>
													<th>
														Сумма
													</th>
													<th>
														Статус
													</th>
												</tr>
											</thead>
											<tbody>
												{$topcash}
											</tbody>
										</table>
									</div>
								</div>");
}
elseif($page[1] == "level")
{
	$style->content("{title}", "ТОП 20 Уровень");
	$toplevel = "";
	$query = $db->rawQuery("SELECT `member_id`, `name`, `Char`, `Online`, `Level` FROM `members` WHERE `Level` > '0' AND `Admin` = '0'  ORDER BY `Level` DESC LIMIT 20");
	foreach($query as $key => $value)
	{
		$date = $db->where('userid', $value['member_id']);
		$date = $db->orderby('id', 'desc');
		$date = $db->getOne('smember_log');
		$toplevel .= "<tr>
						<td>
							<img src=\"{$url}/" . template . "img/avatars/{$value['Char']}.png\" width=\"35\">
						</td>
						<td>
							<a href=\"{$url}/user/view/{$value['member_id']}\" target=\"_blank\">{$value['name']}</a>
						</td>
						<td>
							{$value['Level']}
						</td>
						<td>
							" . Param::online($value['Online']) . "
						</td>
						<td>
							" . date("d.m.Y в H:i", $date['time']) . "
						</td>
					</tr>";
	}
	
	$style->content("{content}", "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
										<table class=\"table table-bordered text-center\">
											<thead>
												<tr>
													<th style=\"width: 3%\"></th>
													<th>
														Имя игрока
													</th>
													<th>
														Уровень
													</th>
													<th>
														Статус
													</th>
													<th>
														Активность
													</th>
												</tr>
											</thead>
											<tbody>
												{$toplevel}
											</tbody>
										</table>
									</div>
								</div>");
}
else
{
	$style->content("{title}", "-");
	$style->content("{content}", "");
}
$style->content("{script}", "");