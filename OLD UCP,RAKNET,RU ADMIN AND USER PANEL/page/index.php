<?php
/*
=====================================================
 R-Panel CMS by Артур Ялалтдинов ( crazy_str ) 
-----------------------------------------------------
 http://radmins.ru/
-----------------------------------------------------
 Copyright (c) 2014
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: index.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , $lang['page']['index'] );

$style->content( "{style}" , "" );

$action = "";
$js = "";
$randomt = array(
	"id_asc",
	"id_desc"
);
$offsett = array (
	"0",
	"100"
);
$sizeof = count($randomt);
$random = (rand()%$sizeof);
$sizeofs = count($offsett);
$offset = (rand()%$sizeofs);

if ( poweraction == 1 ) 
{
	$action .= "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><center><a href=\"#\" class=\"btn btn-lg btn-success btn-block\" rel=\"tooltip\" data-placement=\"top\" data-original-title=\"Для пополнения счёта вам необходимо авторизоваться на сайте.<br />После процедуры авторизации перейдите во вкладку R-Store\" data-html=\"true\">{$lang['page']['updonate']} | Акция X2</a></center></div><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><div class=\"eTimer\"></div></div>";
	$js .= "		<script src=\"http://e-timer.ru/js/etimer.js\"></script>
		<script type=\"text/javascript\">
			
			jQuery(document).ready(function() {
				jQuery(\".eTimer\").eTimer({
					etType: 0, etDate: \"" . actiondate . "\", etTitleText: \"До окончания акции осталось:\", etTitleSize: 20, etShowSign: 1, etSep: \":\", etFontFamily: \"Courier New\", etTextColor: \"#a3a3a3\", etPaddingTB: 0, etPaddingLR: 5, etBackground: \"transparent\", etBorderSize: 0, etBorderRadius: 0, etBorderColor: \"white\", etShadow: \" 0px 0px 0px 0px transparent\", etLastUnit: 4, etNumberFontFamily: \"Impact\", etNumberSize: 35, etNumberColor: \"#a3a3a3\", etNumberPaddingTB: 0, etNumberPaddingLR: 0, etNumberBackground: \"#FFFFFF\", etNumberBorderSize: 0, etNumberBorderRadius: 0, etNumberBorderColor: \"white\", etNumberShadow: \"inset 0px 0px 10px 0px transparent\"
				});
			});
		</script>";
}
else
{
	$action .= "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><center><a href=\"#\" class=\"btn btn-lg btn-success btn-block\" rel=\"tooltip\" data-placement=\"top\" data-original-title=\"Для пополнения счёта вам необходимо авторизоваться на сайте.<br />После процедуры авторизации перейдите во вкладку R-Store\" data-html=\"true\">{$lang['page']['updonate']}</a></center></div>";
	$js = "";
}
$style->content( "{content}" , "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" align=\"center\">
										<div id=\"myCarousel-2\" class=\"carousel slide\">
											<div class=\"carousel-inner\">
												<div class=\"item active\">
													<img src=\"{$url}/{$dir}/{$template}/img/slide/1.jpg\" alt=\"\">
													<div class=\"carousel-caption\"></div>
												</div>
												<div class=\"item\">
													<img src=\"{$url}/{$dir}/{$template}/img/slide/2.jpg\" alt=\"\">
													<div class=\"carousel-caption\"></div>
												</div>
												<div class=\"item\">
													<img src=\"{$url}/{$dir}/{$template}/img/slide/3.jpg\" alt=\"\">
													<div class=\"carousel-caption\"></div>
												</div>
												<div class=\"item\">
													<img src=\"{$url}/{$dir}/{$template}/img/slide/4.jpg\" alt=\"\">
													<div class=\"carousel-caption\"></div>
												</div>
												<div class=\"item\">
													<img src=\"{$url}/{$dir}/{$template}/img/slide/5.jpg\" alt=\"\">
													<div class=\"carousel-caption\"></div>
												</div>
												<div class=\"item\">
													<img src=\"{$url}/{$dir}/{$template}/img/slide/6.jpg\" alt=\"\">
													<div class=\"carousel-caption\"></div>
												</div>
												<div class=\"item\">
													<img src=\"{$url}/{$dir}/{$template}/img/slide/7.jpg\" alt=\"\">
													<div class=\"carousel-caption\"></div>
												</div>
												<div class=\"item\">
													<img src=\"{$url}/{$dir}/{$template}/img/slide/8.jpg\" alt=\"\">
													<div class=\"carousel-caption\"></div>
												</div>
											</div>
										</div>
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-8 col-lg-8\">
										<div class=\"row\">
											<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-0\">
												<article class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
													<hr>
													<div class=\"chat-body no-padding profile-message\">
														 <ul class=\"media-list\">
															" . other::wallget('raknet_official', 5) . "
															<li class=\"message\">
																<div align=\"left\">
																	<a href=\"http://vk.com/raknet_official\" class=\"btn btn-success btn-lg btn-block\" target=\"blank\">{$lang['other']['vkload']}</a>
																</div>
															</li>
														</ul>
													</div>
												</article>
											</div>
										</div>
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
										<div class=\"row\">
											<hr>
											<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-1\" >
												<center>
													<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
														<center>
															<a href=\"{$url}/start\" class=\"btn btn-lg btn-success btn-block\">{$lang['other']['connect']}</a>
														</center>
													</div>
												</center>
											</div>
										</div>
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
										<div class=\"row\">
											<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-2\" >
												<center>
													{$action}
												</center>
											</div>
										</div>
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
										<div class=\"row\">
											<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-3\" >
												<center>
													<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
														<center>
															<a href=\"{$url}/monitoring\" class=\"btn btn-lg btn-success btn-block\">{$lang['other']['monitoring']}</a>
														</center>
													</div>
												</center>
											</div>
										</div>
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
										<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-4\" >
											<center>
												<div id=\"vk_groups\"></div>
												<script type=\"text/javascript\">
												VK.Widgets.Group(\"vk_groups\", {mode: 1, width: \"auto\", height: \"400\", color1: 'FFFFFF', color2: '4E4747', color3: '96BF48'}, 50017713);
												</script>
											</center>
										</div>
									</div>
									<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">
										<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-5\" >
											<center>
												<div class=\"row\" id=\"server\"></div>
												<div id=\"vkphoto\"></div>
											</center>
										</div>
									</div>
								</div>" );

$style->content( "{script}" , "<script type=\"text/javascript\">
			$(\".carousel.slide\").carousel({interval : 5000,cycle : true});
			$(function() {
				players = function () {
					$.ajax({
						url : \"{$url}/player.php\",
						type: \"POST\",
						dataType: \"html\",
						success : function(data) {
							document.getElementById(\"server\").innerHTML = data;
						},
						error : function(data) {
							document.getElementById(\"server\").innerHTML = \"<div class='alert alert-danger'>Не могу получить данные.</div>\";
						}
					});
				}
				players();
			});		
		</script>
		{$js}
		<script src=\"{$url}/{$dir}/{$template}/js/device.min.js\"></script>
		<script src=\"{$url}/{$dir}/{$template}/js/vkapi.js\"></script>
		<script type=\"text/javascript\">
			usersvk(\"{$randomt[$random]}\", {$offset});
		</script>" );