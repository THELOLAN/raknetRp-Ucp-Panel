<?php
if(!defined('RUCP')) die("Hacking attempt!");

$biz = "";
$azs = "";
$house = "";

if($page[1] == "biz")
{
	$query[0] = $db->where('ID', 0, '>');
	$query[0] = $db->get('bizzes');
	foreach($query[0] as $key[0] => $value[0])
	{
		$bizinfo = IPSMember::load($value[0]['Owned']);
		if(!$bizinfo)
		{
			$biz .= "<tr>
						<td>
							<font color='red'>{$value[0]['ID']}</font>
						</td>
						<td>
							<font color='red'>{$value[0]['Message']}</font>
						</td>
						<td>
							<font color='red'>Нет владельца</font>
						</td>
						<td>
							<font color='red'>Нет владельца</font>
						</td>
					</tr>";
		}
		else
		{
			$biz .= "<tr>
						<td>
							{$value[0]['ID']}
						</td>
						<td>
							{$value[0]['Message']}
						</td>
						<td>
							{$bizinfo['name']}
						</td>
						<td>
							{$value[0]['Owned']}
						</td>
					</tr>";
		}
	}
	$style->content("{style}", "
		<link href=\"" . template . "css/plugins/dataTables/dataTables.bootstrap.css\" rel=\"stylesheet\">
		<link href=\"" . template . "css/plugins/dataTables/dataTables.responsive.css\" rel=\"stylesheet\">
		<link href=\"" . template . "css/plugins/dataTables/dataTables.tableTools.min.css\" rel=\"stylesheet\">
		<style>
			body.DTTT_Print {
				background: #fff;
			}
			.DTTT_Print #page-wrapper {
				margin: 0;
				background:#fff;
			}
			button.DTTT_button, div.DTTT_button, a.DTTT_button {
				border: 1px solid #e7eaec;
				background: #fff;
				color: #676a6c;
				box-shadow: none;
				padding: 6px 8px;
			}
			button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
				border: 1px solid #d2d2d2;
				background: #fff;
				color: #676a6c;
				box-shadow: none;
				padding: 6px 8px;
			}
			.dataTables_filter label {
				margin-right: 5px;

			}
		</style>
		");
		$style->content("{title}", "Владельцы бизнеса");
		$style->content("{content}", "<div class=\"col-lg-12\">
											<div class=\"ibox float-e-margins\">
												<div class=\"ibox-content table-responsive\">
													<table class=\"table table-striped table-bordered table-hover dataTables-example\">
														<thead>
															<tr>
																<th>
																	Номер бизнеса
																</th>
																<th>
																	Название бизнеса
																</th>
																<th>
																	Владелец
																</th>
																<th>
																	Номер аккаунта
																</th>
															</tr>
														</thead>
														<tbody>
															{$biz}
														</tbody>
													</table>
													<iframe src=\"http://ucp.raknet.ru/newmap/biz.php\" frameborder=\"0\" width=\"100%\" height=\"1000\"></iframe>
												</div>
											</div>
										</div>");
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
			});
		</script>");
}
elseif($page[1] == "azs")
{
	$query[1] = $db->where('id', 0, '>');
	$query[1] = $db->get('bizzes_zapravki');
	foreach($query[1] as $key[1] => $value[1])
	{
		$azsinfo = IPSMember::load($value[1]['Owned']);
		if(!$azsinfo)
		{
			$azs .= "<tr>
						<td>
							<font color='red'>{$value[1]['id']}</font>
						</td>
						<td>
							<font color='red'>{$value[1]['Message']}</font>
						</td>
						<td>
							<font color='red'>Нет владельца</font>
						</td>
						<td>
							<font color='red'>Нет владельца</font>
						</td>
					</tr>";
		}
		else
		{
			$azs .= "<tr>
						<td>
							{$value[1]['id']}
						</td>
						<td>
							{$value[1]['Message']}
						</td>
						<td>
							{$azsinfo['name']}
						</td>
						<td>
							{$value[1]['Owned']}
						</td>
					</tr>";
		}
	}
	$style->content("{style}", "
		<link href=\"" . template . "css/plugins/dataTables/dataTables.bootstrap.css\" rel=\"stylesheet\">
		<link href=\"" . template . "css/plugins/dataTables/dataTables.responsive.css\" rel=\"stylesheet\">
		<link href=\"" . template . "css/plugins/dataTables/dataTables.tableTools.min.css\" rel=\"stylesheet\">
		<style>
			body.DTTT_Print {
				background: #fff;
			}
			.DTTT_Print #page-wrapper {
				margin: 0;
				background:#fff;
			}
			button.DTTT_button, div.DTTT_button, a.DTTT_button {
				border: 1px solid #e7eaec;
				background: #fff;
				color: #676a6c;
				box-shadow: none;
				padding: 6px 8px;
			}
			button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
				border: 1px solid #d2d2d2;
				background: #fff;
				color: #676a6c;
				box-shadow: none;
				padding: 6px 8px;
			}
			.dataTables_filter label {
				margin-right: 5px;

			}
		</style>
		");
		$style->content("{title}", "Владельцы АЗС");
		$style->content("{content}", "<div class=\"col-lg-12\">
											<div class=\"ibox float-e-margins\">
												<div class=\"ibox-content table-responsive\">
													<table class=\"table table-striped table-bordered table-hover dataTables-example\">
														<thead>
															<tr>
																<th>
																	Номер АЗС
																</th>
																<th>
																	Название АЗС
																</th>
																<th>
																	Владелец
																</th>
																<th>
																	Номер аккаунта
																</th>
															</tr>
														</thead>
														<tbody>
															{$azs}
														</tbody>
													</table>
													<iframe src=\"http://ucp.raknet.ru/newmap/biz.php\" frameborder=\"0\" width=\"100%\" height=\"1000\"></iframe>
												</div>
											</div>
										</div>");
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
			});
		</script>");
}
elseif($page[1] == "house")
{
	$query[2] = $db->where('ID', 0, '>');
	$query[2] = $db->get('house');
	foreach($query[2] as $key[2] => $value[2])
	{
		$houseinfo = IPSMember::load($value[2]['Owned']);
		if(!$houseinfo)
		{
			$house .= "<tr>
						<td>
							<font color='red'>{$value[2]['ID']}</font>
						</td>
						<td>
							<font color='red'>Нет владельца</font>
						</td>
						<td>
							<font color='red'>Нет владельца</font>
						</td>
					</tr>";
		}
		else
		{
			$house .= "<tr>
						<td>
							{$value[2]['ID']}
						</td>
						<td>
							{$houseinfo['name']}
						</td>
						<td>
							{$value[2]['Owned']}
						</td>
					</tr>";
		}
	}
	$style->content("{style}", "
		<link href=\"" . template . "css/plugins/dataTables/dataTables.bootstrap.css\" rel=\"stylesheet\">
		<link href=\"" . template . "css/plugins/dataTables/dataTables.responsive.css\" rel=\"stylesheet\">
		<link href=\"" . template . "css/plugins/dataTables/dataTables.tableTools.min.css\" rel=\"stylesheet\">
		<style>
			body.DTTT_Print {
				background: #fff;
			}
			.DTTT_Print #page-wrapper {
				margin: 0;
				background:#fff;
			}
			button.DTTT_button, div.DTTT_button, a.DTTT_button {
				border: 1px solid #e7eaec;
				background: #fff;
				color: #676a6c;
				box-shadow: none;
				padding: 6px 8px;
			}
			button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
				border: 1px solid #d2d2d2;
				background: #fff;
				color: #676a6c;
				box-shadow: none;
				padding: 6px 8px;
			}
			.dataTables_filter label {
				margin-right: 5px;

			}
		</style>
		");
		$style->content("{title}", "Владельцы Дома");
		$style->content("{content}", "<div class=\"col-lg-12\">
											<div class=\"ibox float-e-margins\">
												<div class=\"ibox-content table-responsive\">
													<table class=\"table table-striped table-bordered table-hover dataTables-example\">
														<thead>
															<tr>
																<th>
																	Номер Дома
																</th>
																<th>
																	Владелец
																</th>
																<th>
																	Номер аккаунта
																</th>
															</tr>
														</thead>
														<tbody>
															{$house}
														</tbody>
													</table>
													<iframe src=\"http://ucp.raknet.ru/newmap/house.php\" frameborder=\"0\" width=\"100%\" height=\"1000\"></iframe>
												</div>
											</div>
										</div>");
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
			});
		</script>");
}