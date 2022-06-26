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

	$param = isset($_POST['param']) ? $_POST['param'] : false;
	$param = (int)$param;
	$model = isset($_POST['model']) ? $_POST['model'] : false;
	$model = (int)$model;
	
	$query = $db->where('ID', $model);
	$query = $db->getOne('veh_auction');
	
	if($param == 0)
	{
		if($member['Online'] > 0)
		{
			echo "1";
		}
		else
		{
			if(!$query)
			{
				echo "2";
			}
			else
			{
				if($query['Owned'] != $member['member_id'])
				{
					echo "3";
				}
				else
				{
					if($query['auc_member_id'] == 0)
					{
						$update = $db->where('ID', $model);
						$udate = array(
							'auc_price' => 0,
							'auc_member_id' => 0
						);
						$update = $db->update('veh_auction', $udate);
						
						$querys = $db->rawQuery("INSERT `vehicles_player` SELECT * FROM `veh_auction` WHERE `ID` = '{$model}'");
						$delete = $db->where('ID', $model);
						$delete = $db->delete('veh_auction');
					}
					else
					{
 						$back = array(
							'c_member_id' => $query['auc_member_id'],
							'c_cash' => $query['auc_price']
						);
						$insert = $db->insert('cash_back', $back);

						$update = $db->where('ID', $model);
						$udate = array(
							'auc_price' => 0,
							'auc_member_id' => 0
						);
						$update = $db->update('veh_auction', $udate);
						
						$querys = $db->rawQuery("INSERT `vehicles_player` SELECT * FROM `veh_auction` WHERE `ID` = '{$model}'");
						$delete = $db->where('ID', $model);
						$delete = $db->delete('veh_auction');
					}
					echo "4";
				}
			}
		}
	}
	else
	{
		//$load = IPSMember::load($query['auc_member_id']);
		if($member['Online'] > 0)
		{
			echo "1";
		}
		else
		{
			if(!$query)
			{
				echo "2";
			}
			else
			{
				if($query['Owned'] != $member['member_id'])
				{
					echo "3";
				}
				else
				{
					if($query['auc_member_id'] == 0)
					{
						echo "4";
					}
					else
					{
						$data = array(
							'Owned' => $query['auc_member_id']
						);
						$vehupdate = $db->where('ID', $model);
						$vehupdate = $db->update('veh_auction', $data);
						
						$cash = array(
							'Cash' => $member['Cash']+$query['auc_price']
						);
						$pupdate = $db->where('member_id', $member['member_id']);
						$pupdate = $db->update('members', $cash);
						
						$update = $db->where('ID', $model);
						$udate = array(
							'auc_price' => 0,
							'auc_member_id' => 0
						);
						$update = $db->update('veh_auction', $udate);
						
						$querys = $db->rawQuery("INSERT `vehicles_player` SELECT * FROM `veh_auction` WHERE `ID` = '{$model}'");
						$delete = $db->where('ID', $model);
						$delete = $db->delete('veh_auction');
						
						echo "5";
					}
				}
			}
		}
	}
}