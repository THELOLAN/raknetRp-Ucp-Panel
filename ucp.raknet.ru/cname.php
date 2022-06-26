<?php
session_start();
error_reporting(-1);
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
	//require(ROOT_DIR . "/config/init.php");
	require(ROOT_DIR . "/system/mysql/mysql.php");
	require(ROOT_DIR . "/system/models/OtherModels.php");
	$db = new MysqliDb ('localhost', '', '', '', 13366);
	$oname = isset($_POST['oname']) ? $_POST['oname'] : false;
	$name = isset($_POST['name']) ? $_POST['name'] : false;
	$query = $db->where('name', $name);
	$query = $db->getOne('members');
	if($member['Onlien'] > 0)
	{
		echo "1";
	}
	else
	{
		if($oname == "" && $name == "")
		{
			echo "2";
		}
		elseif($oname == $name)
		{
			echo "3";
		}
		elseif($oname != $member['name'])
		{
			echo "4";
		}
		elseif($query['name'] == $name)
		{
			echo "5";
		}
		elseif(strlen($name) < 3 || strlen($name) > 20)
		{
			echo "6";
		} 
		elseif(!preg_match("/^[a-z]+_[a-z]*?$/i",$name))
		{
			echo "7";
		}
		else
		{
			if($member['cname'] == 1)
			{
				if($member['DonateMREAL'] < 30)
				{
					echo "8";
				}
				else
				{
					$cost = $member['DonateMREAL']-30;
					$seoname = str_replace("_", "-", $name);
					$seoname = strtolower($seoname);
					$lname = strtolower($name);
					$data = array(
						'name' => $name,
						'members_display_name' => $name,
						'members_seo_name' => $seoname,
						'members_l_display_name' => $lname,
						'members_l_username' => $lname,
						'DonateMREAL' => $cost
					);
					$update = $db->where('member_id', $member['member_id']);
					$update = $db->update('members', $data);
					$insert = array(
						'userid' => $member['member_id'],
						'Newname' => $name,
						'Oldname' => $oname,
						'Email' => $member['email'],
						'vremya' => time()
					);
					$insert = $db->insert('name', $insert);
					$message = "Привет {$name}.
								<br />
								Вы сменили игровое имя:
								<br />
								Старое имя: {$oname}
								<br />
								Новое имя: {$name}
								<Br />
								Дата: " . date("d.m.Y в H:i", time()) . "
								<br />
								IP: " . Param::get_real_ip();
					$headers  = "Content-type: text/html; charset=utf-8 \r\n";
					$headers .= "MIME-Version: 1.0" . "\r\n";
					$headers .= "From: RakNet Role Play <support@raknet.ru>" . "\r\n";
					mail($member['email'], "Смена игрового имени", $message, $headers);
					echo "9";
					
				}
			}
			else
			{
				$seoname = str_replace("_", "-", $name);
				$seoname = strtolower($seoname);
				$lname = strtolower($name);
				$data = array(
					'name' => $name,
					'members_display_name' => $name,
					'members_seo_name' => $seoname,
					'members_l_display_name' => $lname,
					'members_l_username' => $lname
				);
				$update = $db->where('member_id', $member['member_id']);
				$update = $db->update('members', $data);
				$insert = array(
					'userid' => $member['member_id'],
					'Newname' => $name,
					'Oldname' => $oname,
					'Email' => $member['email'],
					'vremya' => time()
				);
				$insert = $db->insert('name', $insert);
				$message = "Привет {$name}.
							<br />
							Вы сменили игровое имя:
							<br />
							Старое имя: {$oname}
							<br />
							Новое имя: {$name}
							<Br />
							Дата: " . date("d.m.Y в H:i", time()) . "
							<br />
							IP: " . Param::get_real_ip();
				$headers  = "Content-type: text/html; charset=utf-8 \r\n";
				$headers .= "MIME-Version: 1.0" . "\r\n";
				$headers .= "From: RakNet Role Play <support@raknet.ru>" . "\r\n";
				mail($member['email'], "Смена игрового имени", $message, $headers);
				echo "9";
			}
		}
	}
}