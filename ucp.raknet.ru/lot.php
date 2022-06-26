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
	$db = new MysqliDb ('localhost', '', '', '', 13366);
	
	$vehicle = isset($_POST['vehicle']) ? $_POST['vehicle'] : false;
	$vehicle = (int)$vehicle;
	
	$summ = isset($_POST['summ']) ? $_POST['summ'] : false;
	$summ = (int)$summ;
	
	$query = $db->where('ID', $vehicle);
	$query = $db->getOne('vehicles_player');
	if(!$query)
	{
		echo "1";
	}
	else
	{
		if($query['Owned'] != $member['member_id'])
		{
			echo "2";
		}
		else
		{
			if($summ < 1000 || $summ > 5000000)
			{
				echo "3";
			}
			else
			{
				if($member['Online'] > 0)
				{
					echo "4";
				}
				else
				{
/* 					$query = $db->rawQuery("INSERT `veh_auction` SELECT * FROM `vehicles_player` WHERE `ID` = '{$vehicle}'");
					$delete = $db->where('ID', $vehicle);
					$delete = $db->delete('vehicles_player');
					$update = array(
						'auc_start' => $summ
					);
					$db->where('ID', $vehicle);
					$db->update('veh_auction', $update); */
					echo "5";
				}
			}
		}
	}
}