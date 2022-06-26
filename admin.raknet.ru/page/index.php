<?php
if(!defined('RUCP')) die("Hacking attempt!");

$data = "";
foreach($sacnr->get_query_by_id(1640197) as $key => $value)
{
	$data .= "[{$value['Timestamp']}000, {$value['PlayersOnline']}],\n";
}
$query = $db->where ('Admin', 0, ">");
$query = $db->orderBy("Admin","desc");
$query = $db->get("members");
$admin = "";
foreach($query as $key => $value)
{
	$set = $db->orderBy("id","desc");
	$set = $db->where("userid", $value['member_id']);
	$set = $db->getOne("smember_log");
	
	$get = IPSMember::load($value['member_id'], 'all');
	$date = floor($get['date']/3600);
	if($get['member_id'] == 3)
	{
		$offline = "" .(($get['Online'] == 1) ? "<span class=\"label label-danger\">OFFLINE</span>" : "<span class=\"label label-success\">ONLINE</span>")."";
	}
	else
	{
		$offline = "" .(($get['Online'] == 1) ? "<span class=\"label label-success\">ONLINE</span>" : "<span class=\"label label-danger\">OFFLINE</span>")."";
	}
	$admin .= "<tr>
					<td>
						{$get['member_id']}
					</td>
					<td>
						{$get['prefix']}{$get['members_display_name']}{$get['suffix']}
					</td>
					<td>
						{$get['Admin']}
					</td>
					<td>
						{$date} ч.
					</td>
					<td>
						" . date("d.m.Y в H:i", $set['time']) . "
					</td>
					<td>
						{$offline}
					</td>
				</tr>";
}
$leader = $db->where('Leader', 0, '>');
$leader = $db->get('members');
$lead = "";
foreach($leader as $key => $value)
{
	$date = floor($value['date']/3600);
	$get = $db->orderBy("id","DESC");
	$get = $db->where ("userid", $value['member_id']);
	$get = $db->getOne ("smember_log");
	$ips = IPSMember::load($value['member_id'], 'all');
	if($ips['Admin'] > 0)
	{
		$lead .= "";
	}
	else
	{
		$lead .= "<tr>
					<td>
						{$value['member_id']}
					</td>
					<td>
						{$ips['prefix']}{$value['members_display_name']}{$ips['suffix']}
					</td>
					<td>
						" . Param::frac($value['Leader'], 1) . "
					</td>
					<td>
						{$date} ч.
					</td>
					<td>
						" . date("d.m.Y в H:i", $get['time']) . "
					</td>
					<td>
						" .(($value['Online'] == 1) ? "<span class=\"label label-success\">ONLINE</span>" : "<span class=\"label label-danger\">OFFLINE</span>")."
					</td>
				</tr>";
	}
}
$style->content("{style}", "");
$style->content("{title}", "Главная");
$style->content("{content}", "<div class=\"col-lg-6\">
									<div class=\"ibox float-e-margins\">
										<div class=\"ibox-title\">
											<h5>Администрация</h5>
										</div>
										<div class=\"ibox-content table-responsive\">
											<table class=\"table text-center\">
												<thead>
													<tr>
														<th>№ аккаунта</th>
														<th>Имя Администратора</th>
														<th>Уровень</th>
														<th>Времени провёл на сервере</th>
														<th>Последний вход</th>
														<th>Статус</th>
													</tr>
												</thead>
												<tbody>
													{$admin}
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class=\"col-lg-6\">
									<div class=\"ibox float-e-margins\">
										<div class=\"ibox-title\">
											<h5>Лидеры</h5>
										</div>
										<div class=\"ibox-content table-responsive\" style=\"height: 553px; overflow: auto;\">
											<table class=\"table text-center\" width=\"100%\">
												<thead>
													<tr>
														<th>№ аккаунта</th>
														<th>Имя лидера</th>
														<th>Организация</th>
														<th>Времени провёл на сервере</th>
														<th>Последний вход</th>
														<th>Статус</th>
													</tr>
												</thead>
												<tbody>
													{$lead}
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class=\"col-lg-12\">
									<div id=\"container\" style=\"height: 400px; min-width: 310px\"></div>	
								</div>
								");
$style->content("{script}", "<script src=\"http://code.highcharts.com/stock/highstock.js\"></script>
<script src=\"http://code.highcharts.com/stock/modules/exporting.js\"></script>
<script type=\"text/javascript\">
$(function () 
{
	$('#container').highcharts('StockChart', 
	{
		rangeSelector : 
		{
			selected : 1
		},
		title : 
		{
			text : 'Статистика игроков Онлайн'
		},
		series : 
		[{
			name : 'Online',
			data : [{$data}],
			tooltip: 
			{
				valueDecimals: 2
			}
		}]
	});
});
</script>");