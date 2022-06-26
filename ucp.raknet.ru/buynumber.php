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
	
	$number = isset($_POST['number']) ? $_POST['number'] : null;
	$number = (int)$number;
	$number = ltrim($number, '0');
	
	$pnumber = $db->where('Pnumber', $number);
	$pnumber = $db->getOne('members');
	
	foreach (count_chars($number, 1) as $i => $val) 
	{
		if($val == 2) 
		{
			$money = $member['DonateMREAL']-40;
			$price = 40;
		}
		elseif($val == 3) 
		{
			$money = $member['DonateMREAL']-50;
			$price = 50;
		}
		elseif($val == 4) 
		{
			$money = $member['DonateMREAL']-60;
			$price = 60;
		}
		elseif($val == 5) 
		{
			$money = $member['DonateMREAL']-70;
			$price = 70;
		}
		elseif($val == 6) 
		{
			$money = $member['DonateMREAL']-80;
			$price = 80;
		}
		elseif($val == 7) 
		{
			$money = $member['DonateMREAL']-90;
			$price = 90;
		}
		elseif($val == 8) 
		{
			$money = $member['DonateMREAL']-100;
			$price = 100;
		}
		else 
		{
			$money = $member['DonateMREAL']-40;
			$price = 40;
		}
	}
	if($number == "")
	{
		echo "0";
	}
	elseif(strlen($number) < 4 || strlen($number) > 8)
	{
		echo "1";
	}
	elseif($member['DonateMREAL'] < $price)
	{
		echo "2";
	}
	elseif($member['Online'] > 0)
	{
		echo "3";
	}
	elseif($number == $pnumber['Pnumber'])
	{
		echo "4";
	}
	else
	{
		$data = array(
			'Pnumber' => $number,
			'DonateMREAL' => $money
		);
		$update = $db->where('member_id', $member['member_id']);
		$update = $db->update('members', $data);
		$vdata = array(
			'userid' => $member['member_id'],
			'name' => $member['name'],
			'time' => time(),
			'item' => 7
		);
		$insert = $db->insert('rshop', $vdata);
		echo "5";
	}
}