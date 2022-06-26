<?php
if(!defined('RUCP')) die("Hacking attempt!");
if(autox == 0)
{
	define("auto", "/home/webuser/auto.json");
}
else
{
	define("auto", "/home/webuser/auto1.json");
}

require('config/vehicle.php');
$veh = "";
$v = json_decode(file_get_contents(auto), true);
$v = (array)$v;

for($i = 0; $i < count($v); $i++)
{
	if($v[$i]['klass'] == 15)
	{
		$model = $v[$i]['model'];
		$veh .= "<option value=\"{$v[$i]['model']}\">{$vehiclename[$model]}</option>";
	}
}

$style->content("{title}", "R-Shop");
$style->content("{style}", "");
if ( $member["cname"] == 0 ) $cname = "Первая смена ника бесплатная";
else $cname = "Стоимость смены игрового ника состовляет 30 руб.";

$style->content("{content}", "<div class=\"row\">
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
									<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
											<div class=\"thumbnail\">
												<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal1\" title=\"Смена игрового имени\"><i class=\"fa fa-4x fa-edit\"></i></a>
												<div class=\"caption\">
													<h3>Смена игрового имени</h3>
													<p>Начните свою жизнь с чистого листа.</p>
													<p><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal1\" title=\"Смена игрового имени\" class=\"btn btn-primary\">Сменить</a>
												</div>
											</div>
										</div>
										<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
											<div class=\"thumbnail\">
												<a href=\"#\" data-toggle=\"modal\" data-target=\"#buynumber\" title=\"Покупка номера\"><i class=\"fa fa-4x fa-mobile\"></i></a>
												<div class=\"caption\">
													<h3>Покупка короткого номера</h3>
													<p>Выделяйся.</p>
													<p><a href=\"#\" data-toggle=\"modal\" data-target=\"#buynumber\" title=\"Покупка номера\" class=\"btn btn-primary\">Купить</a>
												</div>
											</div>
										</div>
										<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
											<div class=\"thumbnail\">
												<a href=\"#\" data-toggle=\"modal\" data-target=\"#buycar\" title=\"Покупка автомобиля\"><i class=\"fa fa-4x fa-car\"></i></a>
												<div class=\"caption\">
													<h3>Покупка элитного автомобиля</h3>
													<p>Отличайся от всех.</p>
													<p><a href=\"#\" data-toggle=\"modal\" data-target=\"#buycar\" title=\"Покупка автомобиля\" class=\"btn btn-primary\">Купить</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class=\"modal fade\" id=\"buynumber\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
								<div class=\"modal-dialog\">
									<div class=\"modal-content\">
										<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
											<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
										</div>
										<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
											<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">Покупка короткого номера</h4>
											<div id=\"result\"></div>
											<form class=\"smart-form client-form\" id=\"buysnumber\">
												<fieldset>
													<section>
														<label class=\"label\">Введите предпочитаемый номер телефона</label>
														<label class=\"input\"> 
															<i class=\"icon-append fa fa-mobile\"></i>
															<input type=\"text\" id=\"number\" name=\"number\" value=\"\" maxlength=\"8\">
														</label>
													</section>
													<section><div id=\"result\"></div></section>
												</fieldset>
												<footer style=\"background: #fff; border-color: #fff;\">
													<button type=\"button\" id=\"numberCheck\" class=\"btn btn-primary\">Купить</button>
													<button type=\"button\" class=\"btn btn-primary\" onclick=\"cnumber('/cnumber.php', $('#number').val());\">Проверить</button>
												</footer>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class=\"modal fade\" id=\"buycar\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
								<div class=\"modal-dialog\">
									<div class=\"modal-content\">
										<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
											<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
										</div>
										<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
											<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">Покупка экслюзивного автомобиля</h4>
											<div id=\"result\"></div>
											<form class=\"smart-form client-form\">
												<fieldset>
													<section>
														<label class=\"label\">Выберите автомобиль</label>
														<label class=\"select \">
															<select class=\"select\" id=\"car\" onchange=\"Vehicle('/buycar.php', $('#car').val());\">
																<option>Выберите автомобиль</option>
																{$veh}
															</select>
														</label>
													</section>
													<hr>
													<section id=\"resultcar\"></section>
												</fieldset>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class=\"modal fade\" id=\"myModal1\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
								<div class=\"modal-dialog\">
									<div class=\"modal-content\">
										<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
											<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
										</div>
										<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
											<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">{$cname}</h4>
											<form class=\"smart-form client-form\">
												<fieldset>
													<section>
														<label class=\"label\">Введите имя игрока</label>
														<label class=\"input\"> 
															<i class=\"icon-append fa fa-edit\"></i>
															<input type=\"text\" maxlength=\"20\" id=\"oname\">
															<b class=\"tooltip tooltip-top-right\">
																<i class=\"fa fa-edit txt-color-teal\"></i> Введите имя игрока
															</b>
														</label>
													</section>
													<section>
														<label class=\"label\">Придумайте новое имя игрока</label>
														<label class=\"input\"> 
															<i class=\"icon-append fa fa-edit\"></i>
															<input type=\"text\" maxlength=\"20\" id=\"name\">
															<b class=\"tooltip tooltip-top-right\">
																<i class=\"fa fa-edit txt-color-teal\"></i> Придумайте новое имя игрока
															</b>
														</label>
													</section>
												</fieldset>
												<footer style=\"background: #fff; border-color: #fff;\">
													<button type=\"button\" class=\"btn btn-primary\" onClick=\"cName('/cname.php', $('#oname').val(), $('#name').val());\">
														Сменить
													</button>
												</footer>
											</form>
										</div>
									</div>
								</div>
							</div>");
$style->content("{script}", 
"
	<script type=\"text/javascript\">
		$(document).ready(function() 
		{
			$('#numberCheck').click(function() 
			{
				if($('#number').val().charAt(0) != '0') 
				{
					$.ajax({
						type: \"POST\",
						url: \"/buynumber.php\",
						data: $(\"#buysnumber\").serialize(),
						success: function(data) 
						{
							buynumber(data);
						}
					});
				} 
				else 
				{
					$.smallBox({
						title : \"Произошла ошибка\",
						content : \"<i>Номер не может начинаться с 0.</i>\",
						color : \"#C26565\",
						iconSmall : \"fa fa-thumbs-down bounce animated\",
						timeout : 4000
					});
				}
			});
		});
	</script>
");