<?php
if(!defined('RUCP')) die("Hacking attempt!");

if($page[1] == "del")
{
	$style->content("{title}", "");
	$style->content("{style}", "");
	$style->content("{content}", "В Разработке");
	$style->content("{script}", "");
}