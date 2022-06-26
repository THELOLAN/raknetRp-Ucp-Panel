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
require(ROOT_DIR . "/system/mysql/mysql.php");
$ipbMemberLoginApi = new apiMemberLogin();
$ipbMemberLoginApi->init();

$db = new MysqliDb ('localhost', 'raknet_forum', 'RNRLovZry40k', 'raknet_forum', 13366);

$member = $ipbMemberLoginApi->getMember();

if($member['member_id'])
{
	if(isset($_POST))
	{
		$id = (int)$_POST['member_id'];
		$msg = isset($_POST['reason']) ? $_POST['reason'] : "";
		$msg = $db->escape($msg);
		$value = $_POST[$id];
		if($value == 0)
		{
			$data = array(
				'pp_moderators_confirm' => $value,
				'pp_moderators_id' => $member['member_id'],
				'pp_check_reason' => 0
			);
			$db->where ('pp_member_id', $id);
			$db->update ('profile_portal', $data);
			echo "Заявка одобрена";
		}
		elseif($value == 3)
		{
			if($msg == "")
			{
				echo "Вы не заполнили поле причины отклонения";
			}
			else
			{
				$data = array(
					'pp_moderators_confirm' => $value,
					'pp_moderators_id' => $member['member_id'],
					'pp_mod_reason' => $msg,
					'pp_check_reason' => 1
				);
				$db->where ('pp_member_id', $id);
				$db->update ('profile_portal', $data);
				echo "Пользователю отправлено уведомление на изменение биографии";
			}
		}
		else
		{
			if($msg == "")
			{
				echo "Вы не заполнили поле причины отклонения";
			}
			else
			{
				$data = array(
					'pp_moderators_confirm' => $value,
					'pp_moderators_id' => $member['member_id'],
					'pp_mod_reason' => $msg,
					'pp_check_reason' => 1
				);
				$db->where ('pp_member_id', $id);
				$db->update ('profile_portal', $data);
				echo "Заявка отклонена";
			}
		}
	}
}