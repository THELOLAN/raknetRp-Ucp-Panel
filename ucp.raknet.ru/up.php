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
	
	$radio = isset($_POST['radio']) ? $_POST['radio'] : false;
	$radio = $db->escape($radio);
	
	$cost = isset($_POST['cost']) ? $_POST['cost'] : false;
	$cost = (int)$cost;
	
	$query = $db->where('ID', $radio);
	$query = $db->getOne('veh_auction');
	if(!$query)
	{
		echo "1";
	}
	else
	{
		if($query['auc_member_id'] == 0)
		{
			$price = $query['auc_start'];
		}
		else
		{
			$price = $query['auc_price'];
		}
		
		if($query['Owned'] == $member['member_id'])
		{
			echo "2";
		}
		else
		{
			if($member['Online'] > 0)
			{
				echo "3";
			}
			else
			{
				if($query['auc_member_id'] == $member['member_id'])
				{
					echo "4";
				}
				else
				{
					if($member['Cash'] < $cost)
					{
						echo "5";
					}
					else
					{
						if($cost < $price)
						{
							echo "6";
						}
						else
						{
							if($cost == $price)
							{
								echo "7";
							}
							else
							{
								if($query['auc_member_id'] == 0)
								{
/* 									$data = array(
										'auc_member_id' => $member['member_id'],
										'auc_price' => $cost
									);
									$update = $db->where('ID', $radio);
									$update = $db->update('veh_auction', $data);
									
									$player = array(
										'Cash' => $member['Cash']-$cost
									);
									$upd = $db->where('member_id', $member['member_id']);
									$upd = $db->update('members', $player); */

									echo "8";
								}
								else
								{
/* 									$back = array(
										'c_member_id' => $query['auc_member_id'],
										'c_cash' => $query['auc_price']
									);
									$insert = $db->insert('cash_back', $back);
									
									$data = array(
										'auc_member_id' => $member['member_id'],
										'auc_price' => $cost
									);
									$update = $db->where('ID', $radio);
									$update = $db->update('veh_auction', $data);
									
									$player = array(
										'Cash' => $member['Cash']-$cost
									);
									$upd = $db->where('member_id', $member['member_id']);
									$upd = $db->update('members', $player); */
									echo "8";
								}
							}
						}
					}
				}
			}
		}
	}
}