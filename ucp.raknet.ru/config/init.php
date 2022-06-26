<?php
if(!defined('RUCP')) die("Hacking attempt!");
defined("project") 	? null : define("project", "RakNet Role Play");
defined("keywords") ? null : define("keywords", "SAMP, SA-MP, Server, Gta San Andreas, gta, хостинг, онлайн, игры, online, мультиплеер, multiplayer, mta, pawno, php, html, игра, по сети, играй, отдых, лучший, сервер, ракнет, raknet, google, бесплатно, free to play, поиграть, Карта raknet, программное обеспичение, C++, проги, софт, программы");
defined("template") ? null : define("template", "template/raknet/");
defined("from") ? null : define("from", "support@raknet.ru");
defined("virt") ? null : define("virt", "500");
defined("autox") ? null : define("autox", "0");

$directory = realpath(dirname(__FILE__));
$document_root = $_SERVER['DOCUMENT_ROOT'];
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'];
if(strpos($directory, $document_root) === 0) 
{
	$base_url .= str_replace(DIRECTORY_SEPARATOR, '/', substr($directory, strlen($document_root)));
}
defined("APP_URL") ? null : define ("APP_URL", str_replace("/config", "", $base_url));
$url = APP_URL;

$page = array();
$query_string = str_replace("param=","",trim($_SERVER['QUERY_STRING']));
$query_string = urldecode($query_string);
$query_params = explode("/",$query_string);
foreach ($query_params as $query_param)
{
	if ($query_param != "") $page[] = $db->escape($query_param);
	else $page[] = "";
}
/* $page = isset($_GET['param']) 		? $_GET['param'] : "";
$page = explode("/", trim($page,"/")); */
$name = isset($_SESSION['name']) 	? $_SESSION['name'] : false;
$code = isset($_SESSION['code']) 	? $_SESSION['code'] : false;

//echo $page[1];

require("nav/config.ui.php");