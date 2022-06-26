<?php
if(!defined('RUCP')) die("Hacking attempt!");

if($page[1] == "my")
{
	$query = $db->orderBy("id", 'DESC');
	$query = $db->where("aid", $member['member_id']);
	$query = $db->get("banlog");
	$blocked = "";
	foreach($query as $key => $value)
	{
		$name = IPSMember::load($value['tid']);
		$blocked .= "{id: \"{$value['id']}\", tid: \"{$name['name']}\", aid: \"{$member['name']}\", dblock: \"" . date("Y-m-d", $value['bdate']) . "\", ublock: \"" . date("Y-m-d", $value['udate']) . "\", ip: \"{$value['ip']}\", reason: \"{$value['reason']}\"} ,\n";
	}
	$style->content("{style}", "
		<link href=\"" . template . "css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css\" rel=\"stylesheet\">
		<link href=\"" . template . "css/plugins/jqGrid/ui.jqgrid.css\" rel=\"stylesheet\">
	");
	$style->content("{title}", "Мои блокировки");
	$style->content("{content}", "<div class=\"col-lg-12\">
										<div class=\"ibox float-e-margins\">
											<div class=\"ibox-content table-responsive\">
												<div class=\"jqGrid_wrapper\">
													<table id=\"table_list_1\"></table>
													<div id=\"pager_list_1\"></div>
											   </div>
											</div>
										</div>
									</div>");
	$style->content("{script}", "
	<script src=\"" . template . "js/plugins/peity/jquery.peity.min.js\"></script>
	<script src=\"" . template . "js/plugins/jqGrid/i18n/grid.locale-en.js\"></script>
    <script src=\"" . template . "js/plugins/jqGrid/jquery.jqGrid.min.js\"></script>
	<script src=\"" . template . "js/plugins/jquery-ui/jquery-ui.min.js\"></script>
	<script type=\"text/javascript\">
			$(document).ready(function () 
			{
				var mydata = [
					{$blocked}
				];
				$(\"#table_list_1\").jqGrid({
					data: mydata,
					datatype: \"local\",
					height: 600,
					autowidth: true,
					shrinkToFit: true,
					rowNum: 30,
					rowList: [10, 20, 30],
					colNames: ['Номер блокировки', 'Имя игрока', 'Администратор', 'Дата блокировки', 'Дата разблокировки', 'IP - Адрес', 'Причина'],
					colModel: [
						{name: 'id', index: 'id', width: 60, sorttype: \"int\"},
						{name: 'tid', index: 'name', width: 100},
						{name: 'aid', index: 'name', width: 100},
						{name: 'dblock',index:'invdate', editable: true, width:90, sorttype:\"date\", formatter:\"date\"},
						{name: 'ublock',index:'invdate', editable: true, width:90, sorttype:\"date\", formatter:\"date\"},
						{name: 'ip', index: 'name', width: 100},
						{name: 'reason', index: 'name', width: 100}
					],
					pager: \"#pager_list_1\",
					viewrecords: true,
					caption: \"Мои блокировки\",
					hidegrid: false
				});
				$(window).bind('resize', function () {
					var width = $('.jqGrid_wrapper').width();
					$('#table_list_1').setGridWidth(width);
				});
			});
	</script>");
}
else
{
	$query = $db->orderBy("id", 'DESC');
	$query = $db->where("id", 0, '>');
	$query = $db->get("banlog");
	$blocked = "";
	foreach($query as $key => $value)
	{
		$name = IPSMember::load($value['tid']);
		if(!$name['name']) $name['name'] = "<font color='red'>DELETED</font>";
		$aname = IPSMember::load($value['aid']);
		if(!$aname['name']) $aname['name'] = "<font color='red'>DELETED</font>";
		$blocked .= "<tr>
						<td>
							{$value['id']}
						</td>
						<td>
							{$name['name']} - {$value['tid']}
						</td>
						<td>
							{$aname['name']}
						</td>
						<td>
							" . date("Y-m-d в H:i", $value['bdate']) . "
						</td>
						<td>
							" . date("Y-m-d в H:i", $value['udate']) . "
						</td>
						<td>
							{$value['ip']}
						</td>
						<td>
							{$value['reason']}
						</td>
					</tr>";
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
	$style->content("{title}", "История блокировок");
	$style->content("{content}", "<div class=\"col-lg-12\">
										<div class=\"ibox float-e-margins\">
											<div class=\"ibox-content table-responsive\">
												<table class=\"table table-striped table-bordered table-hover dataTables-example\">
													<thead>
														<tr>
															<th>
																Номер блокировки
															</th>
															<th>
																Имя игрока - Номер аккаунта
															</th>
															<th>
																Имя Администратора
															</th>
															<th>
																Дата блокировки
															</th>
															<th>
																Дата разблокировки
															</th>
															<th>
																IP
															</th>
															<th>
																Причина
															</th>															
														</tr>
													</thead>
													<tbody>
														{$blocked}
													</tbody>
												</table>
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