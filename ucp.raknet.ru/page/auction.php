<?php
if(!defined('RUCP')) die("Hacking attempt!");

$style->content("{style}", "");
if($page[1] == "my")
{
	$style->content("{title}", "Мои лоты");
	$vehicle = "";
	require('config/vehicle.php');
	$query = $db->rawQuery("SELECT * FROM `veh_auction` WHERE `Owned` = ?", array($member['member_id']));
	foreach($query as $key => $value)
	{
		$load = IPSMember::load($value['auc_member_id']);
		$vehicle .= "<tr>
						<td>
							{$vehiclename[$value['Model']]}
						</td>
						<td>
							{$value['auc_start']} $
						</td>
						<td>
							{$value['auc_price']} $
						</td>
						<td>
							{$load['name']}
						</td>
						<td>
							<input name=\"radio\" type=\"radio\" id=\"radio\" value=\"{$value['ID']}\">
						</td>
					</tr>";
	}
	$style->content("{content}", "<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive\">
											<table id=\"dt_basic\" class=\"table table-striped table-bordered table-hover text-center\" width=\"100%\">
												<thead>
													<tr>
														<th>
															Лот
														</th>
														<th>
															Начальная ставка
														</th>
														<th>
															Предложение
														</th>
														<th>
															Имя предложившего
														</th>
														<th>
															Действие
														</th>
													</tr>
												</thead>
												<tbody>
												{$vehicle}
												</tbody>
											</table>
											<Br />
											<button type=\"button\" class=\"btn btn-primary\" onclick=\"LotParam('/lotparam.php', $('input[type=radio]:checked').val(), 0);\">Снять лот</button>
											<br />
											<button type=\"button\" class=\"btn btn-success\" onclick=\"LotParam('/lotparam.php', $('input[type=radio]:checked').val(), 1);\">Продать лот</button>
										</div>
									</div>");
	$style->content("{script}", "
	<script type=\"text/javascript\">
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
elseif($page[1] == "auto")
{
	$style->content("{title}", "Аукцион транспорта");
	$vehicle = "";
	require('config/vehicle.php');
	$query = $db->rawQuery("SELECT `ID`, `Model` FROM `vehicles_player` WHERE `Owned` = ?", array($member['member_id']));
	foreach($query as $key => $value)
	{
		$vehicle .= "<option value=\"{$value['ID']}\">{$vehiclename[$value['Model']]}</option>";
	}

	$style->content("{content}", "<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
											<table class=\"table table-bordered\">
												<tr>
													<th>
														Выставить лот на продажу
													</th>
													<th>
														Стартовая цена
													</th>
												</tr>
												<tr>
													<td>
														<form class=\"smart-form\">
															<fieldset>
																<label class=\"select\">
																	<select id=\"vehicle\">
																		<option>Выберите Транспорт</option>
																		{$vehicle}
																	</select>
																</label>
															</fieldset>
														</form>
													</td>
													<td>
														<form class=\"smart-form\">
															<fieldset>
																<label class=\"input\">
																	<input type=\"text\" id=\"summ\" value=\"\">
																</label>
																<button type=\"button\" class=\"btn btn-sm btn-success\" style=\"height: 32px;\" onclick=\"Lot('/lot.php', $('#vehicle').val(), $('#summ').val());\">Выставить</button>
															</fieldset>
														</form>
													</td>
												</tr>
											</table>
											<div class=\"row\">
												<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive\">										
														<font color=\"black\">
															<table id=\"dt_basic\" class=\"table table-striped table-bordered table-hover text-center\" width=\"100%\">
																<thead>			                
																	<tr>
																		<th>Лот №</th>
																		<th>Транспорт</th>
																		<th>Тип</th>
																		<th>Пробег</th>
																		<th>Год выпуска</th>
																		<th>Владелец</th>
																		<th>Начальная ставка</th>
																		<th>Последняя ставка</th>
																		<th>Действие</th>
																	</tr>
																</thead>
																<tbody>
																	" . Auction::auto() . "
																</tbody>
															</table>
														</font>
														<br />
														<form class=\"smart-form\">
															<label class=\"input col-lg-4\">
																<input type=\"text\" value=\"\" placeholder=\"Введите сумму для повышения\" id=\"cost\">
															</label>
															<button type=\"button\" class=\"btn btn-sm btn-primary\" style=\"height: 32px;\" onClick=\"Upstavka('/up.php');\">Повысить ставку</button>
														</form>
													</form>
												</div>
											</div>
										</div>
								</div>");
	$style->content("{script}", "
	<script type=\"text/javascript\">
		function Upstavka(url)
		{
			var radio = $('input[type=radio]:checked').val(),
				 cost = $('#cost').val();
			$.ajax({
				type: \"POST\",
				url: url,
				data:
				{
					'radio': radio,
					'cost': cost
				},
				success: function(data)
				{
					stavka(data);
				}
			});
		};
	</script>
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
else
{
	$style->content("{title}", "Аукцион автомобилей");
	$style->content("{content}", "OOPs");
	$style->content("{script}", "");
}