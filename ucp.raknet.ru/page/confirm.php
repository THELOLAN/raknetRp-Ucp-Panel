<?php
if(!defined('RUCP')) die("Hacking attempt!");

$page1 = isset($page[1]) ? $page[1] : "";
$page2 = isset($page[2]) ? $page[2] : "";
$page3 = isset($page[3]) ? $page[3] : "";

$style->content("{title}", "Сброс кода безопасности");
$style->content("{style}", "");
$style->content("{content}", "<div class=\"row\">
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
									" . Setting::confirm($page1, $page2, $page3) . "
								</div>
							</div>");
$style->content("{script}", "");