<?php
class Setting extends Param
{
	static public function confirm($param1, $param2, $param3)
	{
		global $ipbMemberLoginApi, $db;
		$member = $ipbMemberLoginApi->getMember();
		$load = IPSMember::load($param3, "all");
		$query = $db->where("c_id", $param3);
		$query = $db->getOne("confirm_link");
		$param3 = (int)$param3;
		$param1 = $db->escape($param1);
		$param2 = $db->escape($param2);
		if($load['member_id'] == $param3 && $query['c_hash'] == $param1 && $query['c_ip'] == $param2)
		{
			$delete = $db->where('c_id', $load['member_id']);
			$delete = $db->delete('confirm_link');

			$rgLetters = array('2','1','3','4','5','6','7','8','9');
			shuffle($rgLetters);
			$code = join('',array_slice($rgLetters, 0, mt_rand(5, 10)));
			$data = array('code' => $code);
			$db->where('member_id', $load['member_id']);
			$db->update('members', $data);
			$message = "Привет {$load['name']}.<br />
						Вы сбросили код безопасности<br />
						Новый код безопасности: {$code}<br />
						Дата: " . date("d.m.Y в H:i", time()) . "<br />
						IP: " . Param::get_real_ip();
			$headers  = "Content-type: text/html; charset=utf-8 \r\n";
			$headers .= "MIME-Version: 1.0" . "\r\n";
			$headers .= "From: " . project . " <" . from . ">" . "\r\n";
			mail($load['email'], "Смена кода безопасности", $message, $headers);
			return "<div class=\"alert alert-success\">На ваш электронный адрес отправлен новый код безопасности.</div>";
		}
		else
		{
			return "<div class=\"alert alert-danger\">Неверные параметры.</div>";
		}
	}
}