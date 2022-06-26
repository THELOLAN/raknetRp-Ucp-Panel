<?php
session_start();
error_reporting (-1);
ini_set("display_errors", -1);
header("Content-Type: text/html; charaset=UTF-8");

define("RUCP", true);
define("ROOT_DIR", dirname(__FILE__));
define("FORUM_PATH", "/home/webuser/domains/forum.raknet.ru/");
define("IPS_ENFORCE_ACCESS", true);
require(FORUM_PATH . "admin/api/member/api_member_login.php");
$ipbMemberLoginApi = new apiMemberLogin();
$ipbMemberLoginApi->init();
$member = $ipbMemberLoginApi->getMember();

if($member['member_id'])
{
	require(ROOT_DIR . "/system/mysql/mysql.php");
	require(ROOT_DIR . "/system/models/OtherModels.php");
	$db = new MysqliDb ('localhost', '', '', '', 13366);

	$member_id = (int)$_POST['member_id'];
	$pp_member_id = (int)$_POST['pp_member_id'];
	
	$member_id = isset($member_id) ? $member_id : false;
	$pp_member_id = isset($pp_member_id) ? $pp_member_id : false;
	
	$query = $db->where("pp_member_id", $pp_member_id)->where('member_id', $member_id);
	$query = $db->getOne("likes");
	if($query['member_id'] == $member_id)
	{
		echo "<button href=\"javascript:void(0);\" class=\"btn btn-danger\">Вы уже ставили отметку мне нравится</button>";
	}
	else
	{
		$data = array(
			'pp_member_id' => $pp_member_id,
			'member_id' => $member_id
		);
		$db->insert('likes', $data);
		
		$stats = $db->where("pp_member_id", $pp_member_id);
		$stats = $db->getOne ("likes", "count(*) as cnt");
		echo "<button href=\"javascript:void(0);\" class=\"btn btn-primary\">Мне нравится {$stats['cnt']} <i class=\"fa fa-thumbs-up\"></i></button>";
	}
}