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
	$dcode = isset($_POST['dcode']) ? $_POST['dcode'] : "";
	$param = isset($_POST['param']) ? $_POST['param'] : "";
	$friend = isset($_POST['friend']) ? $_POST['friend'] : "";
	
	if($param == 0)
	{
		$get = $db->where('code', $dcode);
		$get = $db->getOne('dcode');
		if(!$get)
		{
			echo "<div class=\"alert alert-danger\">Такого кода не существует.</div>";
		}
		else
		{
			if($member['Online'] > 0)
			{
				echo "<div class=\"alert alert-info\">Ваш персонаж находится в игре.</div>";
			}
			else
			{
				if($get['member'] != $member['member_id'] && $get['give'] == 0)
				{
					echo "<div class=\"alert alert-info\">Вы не можете активировать данный донат код.</div>";
				}
				else
				{
					if($get['member'] == $member['member_id'] && $get['give'] == 1)
					{
						echo "<div class=\"alert alert-info\">Вы не можете активировать данный донат код.</div>";
					}
					else
					{
						switch($member['DonateRank']) 
						{
							case 0: if ($member['DonateMOther'] > 199) $rank = "1"; break;
							case 1: if ($member['DonateMOther'] > 399) $rank = "2"; break;
							case 2: if ($member['DonateMOther'] > 799) $rank = "3"; break;
							case 3: if ($member['DonateMOther'] > 799) $rank = "3"; break;	
						}
						$data = array(
							'DonateMREAL' => $member['DonateMREAL']+$get['money'],
							'DonateMOther' => $member['DonateMOther']+$get['money'],
							'DonateRank' => $rank
						);
						$player = $db->where('member_id', $member['member_id']);
						$player = $db->update('members', $data);
						
						$r1 = array(
							'DonateRank' => 1
						);
						$r2 = array(
							'DonateRank' => 2
						);
						$r3 = array(
							'DonateRank' => 3
						);
						
						$rr1 = $db->where('DonateMOther', 199, '>')->where('DonateRank', 0)->update('members', $r1);
						$rr2 = $db->where('DonateMOther', 399, '>')->where('DonateRank', 0)->update('members', $r2);
						$rr3 = $db->where('DonateMOther', 799, '>')->where('DonateRank', 0)->update('members', $r3);
/* 						$rr1 = $db->update('members', $r1);
						$rr2 = $db->update('members', $r2);
						$rr3 = $db->update('members', $r3); */
						
						$delete = $db->where('code', $dcode);
						$delete = $db->delete('dcode');
						echo "<div class=\"alert alert-success\">Вы успешно активировали донат код на сумму {$get['money']} руб.</div><script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/pay'\", 2000);</script>";
					}
				}	
			}
		}
	}
	else
	{
		if($dcode == "")
		{
			echo "<div class=\"alert alert-danger\">Выберите донат код.</div>";
		}
		else
		{
			$get = $db->where('code', $dcode);
			$get = $db->getOne('dcode');
			if(!$get)
			{
				echo "<div class=\"alert alert-danger\">Такого кода не существует.</div>";
			}
			else
			{
				if($get['give'] == 1)
				{
					echo "<div class=\"alert alert-danger\">Вы не можете подарить данный донат код.</div>";
				}
				else
				{
					$data = array(
						'to_id' => $friend,
						'give' => 1
					);
					$player = $db->where('code', $dcode);
					$player = $db->update('dcode', $data);
					echo "<div class=\"alert alert-success\">Вы успешно подарили донат код на сумму {$get['money']} руб.</div><script type=\"text/javascript\">setTimeout(\"document.location.href='{$url}/pay'\", 2000);</script>";
				}
			}
		}
	}
}