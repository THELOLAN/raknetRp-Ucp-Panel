<?php
class Bio extends Param
{
	static public function viewbio($param = false)
	{
		global $ipbMemberLoginApi, $style, $db, $url;
		$players = "";
		if($param <= false) $param = 0;
		elseif($param == "") $param = 0;
		
		if($param == 0)
		{
			$style->content("{title}", "Биографии игроков");
			$db->where ('pp_about_me', "", ">")->where('pp_moderators_confirm', 0);
			$query = $db->get("profile_portal");
			foreach($query as $key => $value)
			{
				$stat = $db->where("pp_member_id", $value['pp_member_id']);
				$stat = $db->getOne ("likes", "count(*) as cnt");
				$load = IPSMember::load($value['pp_member_id']);
				$players .= "<tr>
								<td>
									<img src=\"{$url}/" . template . "img/avatars/{$load['Char']}.png\" width=\"35\">
								</td>
								<td>
									<a href=\"{$url}/user/view/{$load['member_id']}\">{$load['name']}</a>
								</td>
								<td>
									<a href=\"{$url}/bio/view/{$value['pp_member_id']}\" target=\"_blank\">Прочесть</a>
								</td>
								<td>
									<button type=\"button\" class=\"btn btn-primary\"><i class=\"fa fa-thumbs-up\"></i> {$stat['cnt']}</button>
								</td>
							</tr>";
				
			}
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
			return "<div class=\"row\">
						<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
							<table id=\"dt_basic\" class=\"table table-striped table-bordered table-hover text-center\" width=\"100%\">
								<thead>			                
									<tr>
										<th style=\"width: 3%\"></th>
										<th>Имя игрока</th>
										<th>Ссылка на биографию</th>
										<th>Рейтинг</th>
									</tr>
								</thead>
								<tbody>
									{$players}
								</tbody>
							</table>
						</div>
					</div>";
		}
		else
		{
			$button = "";
			$member = $ipbMemberLoginApi->getMember();
			$about = IPSMember::load($param, "all");
			if(!$about['member_id'])
			{
				$style->content("{title}", "Биография с таким идентификатором не найдена");
				$style->content("{script}", "");
				return "Биография с таким идентификатором не найдена";
			}
			$style->content("{title}", "Биография {$about['name']}");
			$stats = $db->where("pp_member_id", $about['member_id']);
			$stats = $db->getOne ("likes", "count(*) as cnt");
			if($member['member_id'])
			{
				$query = $db->where("pp_member_id", $about['member_id'])->where('member_id', $member['member_id']);
				$query = $db->getOne("likes");
				
				$aname = IPSMember::load($about['pp_moderators_id']);
				
				if($member['member_id'] == $query['member_id'])
				{
					$style->content("{script}", "");
					$button .= "<button type=\"button\" class=\"btn btn-primary\">Мне нравится {$stats['cnt']} <i class=\"fa fa-thumbs-up\"></i></button>";
				}
				else
				{
					$style->content("{script}", "");
					$button .= "<div id=\"result\">
									<input type=\"hidden\" id=\"member_id\" value=\"{$member['member_id']}\">
									<input type=\"hidden\" id=\"pp_member_id\" value=\"{$about['member_id']}\">
									<button type=\"button\" class=\"btn btn-success\" onclick=\"Likes('/like.php', $('#member_id').val(), $('#pp_member_id').val());\">Нравится {$stats['cnt']} <i class=\"fa fa-thumbs-up\"></i></button>
								</div>
								";
				}
				return "<h4>Биография: {$about['name']}</h4>
						<br />
						" . $about['pp_about_me'] . "
						<div class=\"pull-right\"><i>Одобрил: {$aname['prefix']}{$aname['name']}{$aname['suffix']}</i></div>
							{$button}
						<br />
						<br />";
			}
			else
			{
				$style->content("{script}", "");
				return "<h4>Биография: {$about['name']}</h4>
						<br />
						" . $about['pp_about_me'] . "
						<div class=\"pull-right\"><i>Одобрил: {$aname['prefix']}{$aname['name']}{$aname['suffix']}</i></div>
						<button type=\"button\" class=\"btn btn-primary\">Нравится {$stats['cnt']} <i class=\"fa fa-thumbs-up\"></i></button>
						<br />
						<br />";
			}
		}
	}
}