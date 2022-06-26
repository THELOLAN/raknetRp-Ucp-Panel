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

require(ROOT_DIR . "/system/mysql/mysql.php");

$db = new MysqliDb ('localhost', 'raknet_forum', 'RNRLovZry40k', 'raknet_forum', 13366);

$member = $ipbMemberLoginApi->getMember();

if($member['member_id'])
{
	if($member['Admin'] > 0)
	{
		
		$userid = isset($_POST['userid']) ? $_POST['userid'] : "";
		$name = isset($_POST['name']) ? $_POST['name'] : "";
		$msg = "";
		if($userid == "" && $name != "")
		{
			$query = $db->rawQuery("SELECT `name`, `member_id`, `Level` FROM `members` WHERE `name` LIKE '%{$name}%' LIMIT 300");
			foreach($query as $key => $value)
			{
				$msg .= "<tr>
							<td>
								<a href=\"http://admin.raknet.ru/user/view/{$value['member_id']}\" target=\"_blank\">{$value['name']}</a>
							</td>
							<td>
								{$value['member_id']}
							</td>
							<td>
								{$value['Level']}
							</td>
						</tr>";
			}
			echo $msg;
		}
		elseif($userid != "" && $name == "")
		{
			$query = $db->rawQuery("SELECT `name`, `member_id`, `Level` FROM `members` WHERE `member_id` = '{$userid}' LIMIT 1");
			foreach($query as $key => $value)
			{
				$msg .= "<tr>
							<td>
								<a href=\"http://admin.raknet.ru/user/view/{$value['member_id']}\" target=\"_blank\">{$value['name']}</a>
							</td>
							<td>
								{$value['member_id']}
							</td>
							<td>
								{$value['Level']}
							</td>
						</tr>";
			}
			echo $msg;
		}
		else
		{
			$query = $db->rawQuery("SELECT `name`, `member_id`, `Level` FROM `members` WHERE `name` LIKE '%{$name}%' AND `member_id` LIKE '%{$userid}%'");
			foreach($query as $key => $value)
			{
				$msg .= "<tr>
							<td>
								<a href=\"http://admin.raknet.ru/user/view/{$value['member_id']}\" target=\"_blank\">{$value['name']}</a>
							</td>
							<td>
								{$value['member_id']}
							</td>
							<td>
								{$value['Level']}
							</td>
						</tr>";
			}
			echo $msg;
		}
	}
}