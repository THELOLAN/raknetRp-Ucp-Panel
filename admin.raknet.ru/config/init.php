<?php
if(!defined('RUCP')) die("Hacking attempt!");
defined("project") 	? null : define("project", "RakNet Role Play");
defined("keywords") ? null : define("keywords", "SAMP, SA-MP, Server, Gta San Andreas, gta, хостинг, онлайн, игры, online, мультиплеер, multiplayer, mta, pawno, php, html, игра, по сети, играй, отдых, лучший, сервер, ракнет, raknet, google, бесплатно, free to play, поиграть, Terminator 5, Терминатор 5, Терминатор генесис, Чем дальше в лес, Исход: Цари и боги, Несломленный, Восхождение Юпитер, Карта raknet, программное обеспичение, C++, проги, софт, программы");
defined("template") ? null : define("template", "template/raknet/");
defined("from") ? null : define("from", "support@raknet.ru");
defined("virt") ? null : define("virt", "500");
$admins = 	isset ( $_SESSION["admins"] ) ? $_SESSION["admins"] : null;
$page = array();
$query_string = str_replace("param=","",trim($_SERVER['QUERY_STRING']));
$query_string = urldecode($query_string);
$query_params = explode("/",$query_string);
foreach ($query_params as $query_param)
{
	if ($query_param != "") $page[] = $query_param;
	else $page[] = "";
}
/* $page = isset($_GET['param']) 		? $_GET['param'] : "";
$page = explode("/", trim($page,"/")); */
$name = isset($_SESSION['name']) 	? $_SESSION['name'] : false;
$code = isset($_SESSION['code']) 	? $_SESSION['code'] : false;

//echo $page[1];

require("nav/config.ui.php");