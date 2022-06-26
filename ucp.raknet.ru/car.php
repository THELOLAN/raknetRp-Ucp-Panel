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
//define("auto", "/home/webuser/auto.json");
$ipbMemberLoginApi = new apiMemberLogin();
$ipbMemberLoginApi->init();
$member = $ipbMemberLoginApi->getMember();

if($member['member_id'])
{
	require(ROOT_DIR . "/system/mysql/mysql.php");
	$db = new MysqliDb ('localhost', '', '', '', 13366);
	
	$model = isset($_POST['model']) ? $_POST['model'] : null;
	$model = $db->escape($model);
	
	$price = isset($_POST['price']) ? $_POST['price'] : null;
	$price = $db->escape($price);

	require("x.php");
	
	if(autox == 0)
	{
		$query = $db->where('model', $model);
		$query = $db->getOne('veh_rub');
	}
	else
	{
		$query = $db->where('model', $model);
		$query = $db->getOne('veh_rubax');
	}
	
	if(!$query)
	{
		echo "1";
	}
	else
	{
		if($query['model'] == $model && $query['price'] == $price)
		{
			if($member['DonateMREAL'] < $price)
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
					$insert = array(
						"userid" => $member['member_id'],
						"name" => $member['name'],
						"time" => time(),
						"item" => 8,
						"value" => $model
					);
					$shop = $db->insert('rshop', $insert);
					$data = array(
						"Model" => $model,
						"Owned" => $member['member_id'],
						"vColor1" => 0,
						"vColor2" => 0,
						"Fuel" => 40,
						"vehicleHealth" => 1000,
						"vDate" => time()
					);
					
					$db->insert('vehicles_player', $data);
					$update = array(
						"DonateMREAL" => $member['DonateMREAL']-$price
					);
					$db->where('member_id', $member['member_id']);
					$db->update('members', $update);
					echo "4";
				}
			}
		}
		else
		{
			echo "5";
		}
	}
}