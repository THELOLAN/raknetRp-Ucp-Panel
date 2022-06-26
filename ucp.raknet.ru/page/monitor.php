<?php
if(!defined('RUCP')) die("Hacking attempt!");

$players = "";
$style->content("{style}", "");
define("hjson", "/home/webuser/house.json");
define("bjson", "/home/webuser/biz.json");
define("ason", "/home/webuser/fillbiz.json");
define("online", "/home/webuser/online.json");
if($page[1] == "online")
{
	$style->content("{title}", "Подробный мониторинг");

	$online = json_decode(file_get_contents(online), true);
	$online = (array)$online;
	for($i = 0; $i < count($online); $i++)
	{
		$prefix = IPSMember::load($online[$i]['member_id']);
		$players .= "<tr>
			<td>
				<img src=\"{$url}/" . template . "img/avatars/{$online[$i]['Char']}.png\" width=\"35\">
			</td>
			<td>
				<a href=\"{$url}/user/view/{$online[$i]['member_id']}\" target=\"_blank\">{$online[$i]['name']}</a>
			</td>
			<td>
				" . Param::job($online[$i]['Job']) . "
			</td>
			<td>
				" . Param::frac($online[$i]['Member'], 0) . "
			</td>
			<td>
				" . Param::rank($online[$i]['Member'], $online[$i]['Rank'], 1) . "
			</td>
			<td>
				{$online[$i]['Level']}
			</td>
		</tr>";
	}
	$style->content("{content}", "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
										<div class=\"table-responsive\">
											<table id=\"dt_basic\" class=\"table table-striped table-bordered table-hover text-center\" width=\"100%\">
												<thead>			                
													<tr>
														<th style=\"width: 3%\"></th>
														<th>Имя игрока</th>
														<th>Работа</th>
														<th>Организация</th>
														<th>Ранг</th>
														<th>LVL</th>
													</tr>
												</thead>
												<tbody>
													{$players}
												</tbody>
											</table>
										</div>
									</div>
								</div>");
	$style->content("{script}", "<script type=\"text/javascript\">
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
elseif($page[1] == "bussines")
{
	$style->content("{title}", "Карта бизнесов");
	$style->content("{content}", "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
										<div class=\"table-responsive\">
											<iframe src=\"{$url}/map/biz.php\" frameborder=\"0\" width=\"100%\" height=\"1000\"></iframe>
										</div>
									</div>
								</div>");
	$style->content("{script}", "");
}
elseif($page[1] == "house")
{
	$style->content("{title}", "Карта домов");
	$style->content("{content}", "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
										<div class=\"table-responsive\">
											<iframe src=\"{$url}/map/house.php\" frameborder=\"0\" width=\"100%\" height=\"1000\"></iframe>
										</div>
									</div>
								</div>");
	$style->content("{script}", "");
}
elseif($page[1] == "fuel")
{
	$style->content("{title}", "Карта АЗС");
	$style->content("{content}", "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
										<div class=\"table-responsive\">
											<iframe src=\"{$url}/map/azs.php\" frameborder=\"0\" width=\"100%\" height=\"1000\"></iframe>
										</div>
									</div>
								</div>");
	$style->content("{script}", "");
}
else
{
	$style->content("{title}", "Начать игру");
	$style->content("{content}", "На редизайне.");
	$style->content("{script}", "");
}