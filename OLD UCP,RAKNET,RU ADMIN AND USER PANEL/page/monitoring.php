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
 Файл: monitoring.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , $lang['other']['monitoring'] );

$style->content( "{style}" , "" );

$param = isset ( $_GET['param'] ) ? $_GET['param'] : null;

if ( $admins == 1 ) $params = 1;
else $params = 0;

$style->content( "{content}" , "<ul id=\"myTab1\" class=\"nav nav-tabs bordered\">
									<li class=\"active\">
										<a href=\"#s1\" data-toggle=\"tab\">{$lang['other']['monplayer']}</a>
									</li>
									<li>
										<a href=\"#s2\" data-toggle=\"tab\">{$lang['other']['monhouse']}</a>
									</li>
									<li>
										<a href=\"#s3\" data-toggle=\"tab\">{$lang['other']['monbiz']}</a>
									</li>
								</ul>
								<div id=\"myTabContent1\" class=\"tab-content padding-10\">
									<div class=\"tab-pane fade in active\" id=\"s1\">
										" . user::players($db->safesql($param)) . "
									</div>
									<div class=\"tab-pane fade\" id=\"s2\">
										<center class=\"table-responsive\">
											<iframe src=\"{$url}/newmap/house.php\" frameborder=\"0\" width=\"100%\" height=\"1000\"></iframe>
										</center>
									</div>
									<div class=\"tab-pane fade\" id=\"s3\">
										<center class=\"table-responsive\">
											<iframe src=\"{$url}/newmap/biz.php\" frameborder=\"0\" width=\"100%\" height=\"1000\"></iframe>
										</center>
									</div>
								</div>" );

$style->content( "{script}" , "" );