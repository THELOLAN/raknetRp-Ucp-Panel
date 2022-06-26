<?php
if(!defined('RUCP')) die("Hacking attempt!");

define("monitori", "/home/webuser/monitori.txt");

$players = "";
$monitori = json_decode(file_get_contents(monitori), true);
$monitori = (array)$monitori;

for($i = 0; $i < count($monitori); $i++)
{
 	switch($i)
	{
		case 0:
		{
			$players .= "<tr>
								<td>Игроков онлайн:</td>
								<td>
									<span class=\"label bg-color-green\">{$monitori[0]}</span>
								</td>
							</tr>";
		}
		break;
		case 1:
		{
			$players .= "<tr>
								<td>Водителей автобуса:</td>
								<td>
									<span class=\"label bg-color-green\">{$monitori[1]}</span>
								</td>
							</tr>";
		}
		break;
		case 2:
		{
			$players .= "<tr>
								<td>Дальнобойщиков:</td>
								<td>
									<span class=\"label bg-color-green\">{$monitori[2]}</span>
								</td>
							</tr>";
		}
		break;
		case 3:
		{
			$players .= "<tr>
								<td>Механиков:</td>
								<td>
									<span class=\"label bg-color-green\">{$monitori[3]}</span>
								</td>
							</tr>";
		}
		break;
		case 4:
		{
			$players .= "<tr>
								<td>Таксистов:</td>
								<td>
									<span class=\"label bg-color-green\">{$monitori[4]}</span>
								</td>
							</tr>";
		}
		break;
		case 5:
		{
			$players .= "<tr>
								<td>Фермеров:</td>
								<td>
									<span class=\"label bg-color-green\">{$monitori[5]}</span>
								</td>
							</tr>";
		}
		break;
	}
}

$style->content("{style}", "");
$style->content("{title}", "Главная");
$slide = "";
defined ( "actiondate" ) ? null : define ( "actiondate" , "01.09.2015.0.0" ); // Дата окончания акции .0.0 не убирать.
for($i = 2; $i < 9; $i++)
{
	$slide .= "<div class=\"item\">
			<img src=\"{$url}/" . template . "img/slide/{$i}.jpg\" alt=\"\">
			<div class=\"carousel-caption\"></div>
		</div>";
}
$js .= "<script src=\"http://e-timer.ru/js/etimer.js\"></script>
		<script type=\"text/javascript\">
			jQuery(document).ready(function() 
			{
				jQuery(\".eTimer\").eTimer({
					etType: 0, etDate: \"" . actiondate . "\", etTitleText: \"До окончания акции осталось:\", etTitleSize: 20, etShowSign: 1, etSep: \":\", etFontFamily: \"Courier New\", etTextColor: \"#a3a3a3\", etPaddingTB: 0, etPaddingLR: 5, etBackground: \"transparent\", etBorderSize: 0, etBorderRadius: 0, etBorderColor: \"white\", etShadow: \" 0px 0px 0px 0px transparent\", etLastUnit: 4, etNumberFontFamily: \"Impact\", etNumberSize: 35, etNumberColor: \"#a3a3a3\", etNumberPaddingTB: 0, etNumberPaddingLR: 0, etNumberBackground: \"#FFFFFF\", etNumberBorderSize: 0, etNumberBorderRadius: 0, etNumberBorderColor: \"white\", etNumberShadow: \"inset 0px 0px 10px 0px transparent\"
				});
			});
		</script>";
$style->content("{content}", "<div class=\"row\">
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
									<div id=\"myCarousel\" class=\"carousel fade\">
										<div class=\"carousel-inner\">
											<div class=\"item active\">
												<img src=\"{$url}/" . template . "img/slide/1.jpg\" alt=\"\">
												<div class=\"carousel-caption\"></div>
											</div>
											{$slide}
										</div>
									</div>
								</div>
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><hr></div>
								<div class=\"col-xs-12 col-sm-12 col-md-8 col-lg-8\">
									<div class=\"row\">
										<article class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
											<div class=\"chat-body no-padding profile-message\">
												 <ul class=\"media-list\">
													" . VKAPI::wallget('raknet_official', 3) . "
													<li class=\"message\">
														<div align=\"left\">
															<a href=\"http://vk.com/raknet_official\" class=\"btn btn-success btn-lg btn-block\" target=\"blank\">Больше новостей</a>
														</div>
													</li>
												</ul>
											</div>
										</article>
									</div>
								</div>
								<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
									<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
											<hr>
											<a href=\"{$url}/info/start\" class=\"btn btn-lg btn-success btn-block\">Начать игру</a>
											<br />
										</div>
									</div>
								</div>
								<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
									<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
											<a href=\"{$url}/pay\" class=\"btn btn-lg btn-success btn-block\">Пополнить счёт</a>
											<br />
										</div>
									</div>
								</div>
								<!--
								<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
									<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
											<a href=\"{$url}/shop\" class=\"btn btn-lg btn-success btn-block\">Акция на все авто -50%</a>
											<br />
										</div>
									</div>
								</div>
								<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
									<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
											<center><div class=\"eTimer\"></div></center>
											<br />
										</div>
									</div>
								</div>
								-->
								<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
									<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
											<a href=\"{$url}/info/online\" class=\"btn btn-lg btn-success btn-block\">Подробный мониторинг</a>
											<br />
										</div>
									</div>
								</div>
								<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
									<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
											" . VKAPI::vkwidget('50017713', 'FFFFFF', '4E4747', '96BF48') . "
											<br />
										</div>
									</div>
								</div>
								<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4 table-responsive\">
									<table class=\"table\">
										<tbody>
											{$players}
											<tr>
												<td></td>
												<td></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
									<div class=\"row\">
										<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
											<div id=\"vkphoto\"></div>
										</div>
									</div>
								</div>
							</div>");
$style->content("{script}", "
		<script type=\"text/javascript\" src=\"{$url}/" . template . "js/device.min.js\"></script>
		<script type=\"text/javascript\">
			$(\".carousel.fade\").carousel({
				interval : 3000,
				cycle : true
			});
			usersvk(\"id_desc\", 1);
		</script>
		{$js}");
/* 		" . VKAPI::vkwidget('50017713', 'FFFFFF', '4E4747', '96BF48') . "
		" . VKAPI::wallget('raknet_official', 3) . "
		usersvk(\"id_desc\", 1); */