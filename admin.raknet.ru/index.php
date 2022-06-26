<?php
session_start();
error_reporting(-1);
ini_set("display_errors", -1);
header("Content-Type: text/html; charaset=UTF-8");
date_default_timezone_set('Europe/Moscow');

define("RUCP", true);
define("ROOT_DIR", dirname(__FILE__));
define('FORUM_PATH', '/home/webuser/domains/forum.raknet.ru/');
define('IPS_ENFORCE_ACCESS', true);
require(FORUM_PATH . "admin/api/member/api_member_login.php");
$ipbMemberLoginApi = new apiMemberLogin();
$ipbMemberLoginApi->init();

require(ROOT_DIR . "/system/template.php");
require(ROOT_DIR . "/system/mysql/mysql.php");

$db = new MysqliDb ('localhost', 'raknet_forum', 'RNRLovZry40k', 'raknet_forum', 13366);

$member = $ipbMemberLoginApi->getMember();

if($member['member_id'])
{
	if($member['Admin'] > 0)
	{
		if($_SESSION['auth'] == true)
		{
			$templates .= "template/raknet/main.tpl";
		}
		else
		{
			$templates .= "template/raknet/lock.tpl";
		}
	}
}
else
{
	session_destroy();
	$templates .= "template/raknet/notfound.php";
}
$style = new template($templates);
require(ROOT_DIR . "/system/app.php");
new App;
$sacnr = new SACNRMonitor;
require(ROOT_DIR . "/config/init.php");
$style->content("{template}", template);
$style->content("{copyright}", "2012 - " . date("Y"));
$style->content("{project}", project);
$style->content("{key}", keywords);

$style->parse();