<?php
if(!defined('RUCP')) die("Hacking attempt!");

$style->content("{title}", "Друзья");
$style->content("{style}", "");
$friends = "";
$friend = $db->rawQuery("SELECT `friends_friend_id` FROM `profile_friends` WHERE `friends_member_id` = ?", array($member['member_id']));
$k = md5( $member['email'].'&'.$member['member_login_key'].'&'.$member['joined'] );
foreach($friend as $key => $value)
{
	$name = $db->where("member_id", $value['friends_friend_id']);
	$name = $db->getOne("members");
	if(!$name['name']) $output = "";
	else 
	{
		$output = "<tr>
						<td>
							<img src=\"{$url}/" . template . "img/avatars/{$name['Char']}.png\" width=\"35\">
						</td>
						<td>
							<a href=\"{$url}/user/view/{$name['member_id']}\">{$name['name']}</a>
						</td>
						<td>
							" . Param::job($name['Job']) . "
						</td>
						<td>
							" . Param::frac($name['Member'], 1) . "
						</td>
						<td>
							" . Param::rank($name['Member'], $name['Rank'], 0) . "
						</td>
						<td>
							{$name['Pnumber']}
						</td>
						<td>
							" . Param::Online($name['Online']) . "
						</td>
						<td>
							<a class=\"btn btn-danger\" href=\"http://forum.raknet.ru/index.php?app=members&module=list&module=profile&section=friends&do=remove&member_id={$name['member_id']}&secure_key={$k}\" target=\"_blank\">Удалить</a>
						</td>
					</tr>";
	}
	$friends .= $output;
}
$style->content("{content}", "
				<div class=\"row\">
					<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
						<ul id=\"myTab1\" class=\"nav nav-tabs bordered\">
							<li class=\"active\">
								<a href=\"#s1\" data-toggle=\"tab\">Телефонная книга</a>
							</li>
							<li>
								<a href=\"#s2\" data-toggle=\"tab\">Поиск друзей</a>
							</li>
						</ul>
						<div id=\"myTabContent1\" class=\"tab-content padding-10\">
							<div class=\"tab-pane fade in active\" id=\"s1\">
								<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
										<table id=\"dt_basic\" class=\"table table-striped table-bordered table-hover text-center\" width=\"100%\">
											<thead>			                
												<tr>
													<th style=\"width: 3%\"></th>
													<th>Имя игрока</th>
													<th>Работа</th>
													<th>Организация</th>
													<th>Ранг</th>
													<th>Телефон</th>
													<th>Статус</th>
													<th>Действие</th>
												</tr>
											</thead>
											<tbody>
												{$friends}
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class=\"tab-pane fade\" id=\"s2\">
								<center>
									<form class=\"smart-form\">
										<fieldset>
											<div class=\"row\">
												<section class=\"col-lg-2\">
													<label class=\"input\">
														<input type=\"text\" placeholder=\"Введите имя друга\" id=\"name\">
													</label>
												</section>
												<section class=\"col-lg-1\">
													<label class=\"input\">
														<button type=\"button\" class=\"btn btn-sm btn-success\" onClick=\"Search('/friend.php', $('#name').val());\">Поиск</button>
													</label>
												</section>
											</div>
										</fieldset>
									</form>
									<div id=\"result\"></div>
								</center>
							</div>
						</div>
					</div>
				</div>");
$style->content("{script}", "
<script type=\"text/javascript\">
var pagefunction = function() 
{
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