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
 Файл: faq.php
=====================================================
*/

if(!defined('CRAZY_STR')) die("Hacking attempt!");

$style->content ( "{page}" , $lang['other']['connect'] );

$style->content ( "{style}" , "" );

$style->content ( "{content}" , "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
										<div class=\"row\">
											<div class=\"col-xs-6 col-md-6\">
												<a href=\"javascript:void(0);\" class=\"thumbnail site\" id=\"modal_link1\">
													<center>
														<img src=\"{$url}/{$dir}/{$template}/img/help/sa1.png\" width=\"100%\" alt=\"\">
													</center>
												</a>
											</div>
											<div class=\"col-xs-6 col-md-6\">
												<a href=\"javascript:void(0);\" class=\"thumbnail site\" id=\"modal_link2\">
													<center>
														<img src=\"{$url}/{$dir}/{$template}/img/help/samp1.png\" width=\"100%\" alt=\"\">
													</center>
												</a>
											</div>
											<div class=\"col-xs-6 col-md-6\">
												<a href=\"javascript:void(0);\" class=\"thumbnail site\" id=\"modal_link3\">
													<center>
														<img src=\"{$url}/{$dir}/{$template}/img/help/sanltd1.png\" width=\"100%\" alt=\"\">
													</center>
												</a>
											</div>
											<div class=\"col-xs-6 col-md-6\">
												<a href=\"javascript:void(0);\" class=\"thumbnail site\" id=\"modal_link4\">
													<center>
														<img src=\"{$url}/{$dir}/{$template}/img/help/set1.png\" width=\"100%\" alt=\"\">
													</center>
												</a>
											</div>
										</div>
									</div>
								</div>
								<br />
								<div class=\"row\">
									<div class=\"col-xs-12 col-md-12\">
										<a href=\"javascript:void(0);\" class=\"thumbnail\" id=\"modal_link5\">
											<center>
												<img src=\"{$url}/{$dir}/{$template}/img/help/video1.png\" width=\"100%\" alt=\"\">
											</center>
										</a>
									</div>
								</div>
								<div id=\"dialog-message1\" title=\"Установка GTA.\">
									<p>
										<center>
											<img src=\"{$url}/{$dir}/{$template}/img/help/sa1.png\" width=\"100%\" alt=\"\">
										</center>
									</p>
									Для начала игры, вам потребуется игра Grand Theft Auto San Andreas которую вы можете <a href=\"{$url}/download/gta.zip\">скачать</a> на нашем сайте.
									<div class=\"ui-dialog-buttonpane ui-widget-content ui-helper-clearfix\">
										<div class=\"ui-dialog-buttonset\">
											<a href=\"{$url}/download/gta.zip\" class=\"btn btn-primary\">Скачать</a>
										</div>
									</div>
								</div>
								<div id=\"dialog-message2\" title=\"Установка SA:MP.\">
									<p>
										<center>
											<img src=\"{$url}/{$dir}/{$template}/img/help/samp_logo.png\" alt=\"\">
										</center>
									</p>
									Чтобы играть по сети, вам необходимо установить дополнение SA-MP.
									<div class=\"ui-dialog-buttonpane ui-widget-content ui-helper-clearfix\">
										<div class=\"ui-dialog-buttonset\">
											<a href=\"http://files.sa-mp.com/sa-mp-0.3.7-install.exe\" target=\"_blank\" class=\"btn btn-primary\">Скачать</a>
										</div>
									</div>
								</div>
								<div id=\"dialog-message3\" title=\"Установка Руссификатора.\">
									<p>
										<center>
											<img src=\"{$url}/{$dir}/{$template}/img/help/sanltd.png\" alt=\"\">
										</center>
									</p>
									Скачайте и установите руссификатор от SanLtd Team в папку с установленной игрой.
									<div class=\"ui-dialog-buttonpane ui-widget-content ui-helper-clearfix\">
										<div class=\"ui-dialog-buttonset\">
											<a href=\"{$url}/download/sanltd.exe\" class=\"btn btn-primary\">Скачать</a>
										</div>
									</div>
								</div>
								<div id=\"dialog-message4\" title=\"Запуск и настройка.\">
									<p>
										<center>
											<img src=\"{$url}/{$dir}/{$template}/img/help/samp.png\" height=\"195\" alt=\"\">
										</center>
									</p>
									<h3>Запуск</h3>
									<p>
										Запустите приложение, кликнув на иконку SA:MP на рабочем столе.
									</p>
									<h3>Создание персонажа и вход в игру.</h3>
									<p>
										1. В поле Name укажите желаемый логин.
										Пример: Eugene_Kovalsky.
										<br />
										2. В поле ввода IP, введите адрес нашего сервера.
										<a href=\"samp://5.254.105.217:7777\">5.254.105.217:7777</a>
										<br />
										3. Затем нажмите Connect.
									</p>
									<div class=\"ui-dialog-buttonpane ui-widget-content ui-helper-clearfix\">
									</div>
								</div>
								<div id=\"dialog-message5\" title=\"Видео инструкция по началу игры.\">
									<p>
										<object id=\"videoplayer2490\" type=\"application/x-shockwave-flash\" data=\"{$url}/download/uppod.swf\" width=\"100%\" height=\"430\">
											<param name=\"bgcolor\" value=\"#ffffff\" />
											<param name=\"allowFullScreen\" value=\"true\" />
											<param name=\"allowScriptAccess\" value=\"always\" />
											<param name=\"wmode\" value=\"transparent\" />
											<param name=\"movie\" value=\"{$url}/download/uppod.swf\" />
											<param name=\"flashvars\" value=\"comment=RakNet Role Play&amp;st={$url}/download/video97-1297.txt&amp;file=http://youtu.be/hjqjXSGCLho\" />
										</object>
									</p>
									<div class=\"ui-dialog-buttonpane ui-widget-content ui-helper-clearfix\">
										<center><a href=\"samp://5.254.105.217:7777\" class=\"btn btn-block btn-lg btn-success\">Играть</a></center>
									</div>
								</div>" );

$style->content ( "{script}" , "<script type=\"text/javascript\">
									$('#modal_link1').click(function() {
										$('#dialog-message1').dialog('open');
										return false;
									});
									$(\"#dialog-message1\").dialog({
										autoOpen : false,
										modal : true,
										title : '',
									});
									$('#modal_link2').click(function() {
										$('#dialog-message2').dialog('open');
										return false;
									});
									$(\"#dialog-message2\").dialog({
										autoOpen : false,
										modal : true,
										title : '',
									});
									$('#modal_link3').click(function() {
										$('#dialog-message3').dialog('open');
										return false;
									});
									$(\"#dialog-message3\").dialog({
										autoOpen : false,
										modal : true,
										title : '',
									});
									$('#modal_link4').click(function() {
										$('#dialog-message4').dialog('open');
										return false;
									});
									$(\"#dialog-message4\").dialog({
										autoOpen : false,
										modal : true,
										title : '',
										width : 500,
										resizable : false,
									});
									$('#modal_link5').click(function() {
										$('#dialog-message5').dialog('open');
										return false;
									});
									$(\"#dialog-message5\").dialog({
										autoOpen : false,
										modal : true,
										title : '',
										width : 700,
										resizable : false,
									});
								</script>" );