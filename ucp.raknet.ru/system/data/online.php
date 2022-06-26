<?php 
error_reporting (-1);
ini_set("display_errors", -1);
header("Content-Type: text/html; charaset=UTF-8");

define("RUCP", true);
define("MYSQL_PATH", "/home/webuser/domains/ucp.raknet.ru/");
define("FORUM_PATH", "/home/webuser/domains/forum.raknet.ru/");

define("IPS_ENFORCE_ACCESS", true);
require(FORUM_PATH . "admin/api/member/api_member_login.php");
$ipbMemberLoginApi = new apiMemberLogin();
$ipbMemberLoginApi->init();

require(MYSQL_PATH . "system/mysql/mysql.php");
require(MYSQL_PATH . "system/models/OtherModels.php");
$db = new MysqliDb ('localhost', 'raknet_forum', 'RNRLovZry40k', 'raknet_forum', 13366);
$player = $db->rawQuery("SELECT `member_id`, `name`, `Level`, `Char`, `Job`, `Member`, `Rank` FROM `members` WHERE `Online` = ?", array(1));
$f = fopen("online.json", "w");
fwrite($f, json_encode($player) . "\n");
fclose($f);