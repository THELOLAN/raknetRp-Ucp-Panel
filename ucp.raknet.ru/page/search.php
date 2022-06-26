<?php
if(!defined('RUCP')) die("Hacking attempt!");

$get = isset($_POST['name']) ? $_POST['name'] : "";
$get = $db->escape($get);
$style->content("{style}", "");
$players = "";
$style->content("{title}", "Поиск игроков");
if($get == "")
{
	$get = "Sadler";
}
$player = $db->rawQuery("SELECT `member_id`, `members_display_name`, `Level`, `Char`, `Job`, `Member`, `Rank` FROM `members` WHERE `members_display_name` LIKE '%{$get}%'");
foreach($player as $key => $value)
{
	$prefix = IPSMember::load($value['member_id']);
	$players .= "<tr>
		<td>
			<img src=\"{$url}/" . template . "img/avatars/{$value['Char']}.png\" width=\"35\">
		</td>
		<td>
			<a href=\"{$url}/user/view/{$value['member_id']}\" target=\"_blank\">{$prefix['prefix']}{$value['members_display_name']}{$prefix['suffix']}</a>
		</td>
		<td>
			" . Param::job($value['Job']) . "
		</td>
		<td>
			" . Param::frac($value['Member'], 0) . "
		</td>
		<td>
			" . Param::rank($value['Member'], $value['Rank'], 1) . "
		</td>
		<td>
			{$value['Level']}
		</td>
	</tr>";
}
$style->content("{content}", "<div class=\"row\">
					<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
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