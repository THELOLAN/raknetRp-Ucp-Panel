<?php
if(!defined('RUCP')) die("Hacking attempt!");

$style->content("{style}", "");
$style->content("{title}", "Сброс кода безопасности");
if($member['Online'] == 0)
{
	$query = $db->where('c_id', $member['member_id']);
	$query = $db->getOne('confirm_link');
	if($query['c_id'] == $member['member_id'])
	{
		$style->content("{content}", "<div class=\"alert alert-danger\">Вы уже запускали процедуру восстановления кода безопасности.</div>");
	}
	else
	{
		$data = array(
			"c_id" => $member['member_id'],
			"c_hash" => md5(md5(Param::get_real_ip() . $member['member_id'])),
			"c_ip" => Param::get_real_ip()
		);
		$db->insert("confirm_link", $data);
		$message = "Привет {$member['name']}.<br />
					Вы сделали запрос на сброс кода безопасности<br />
					Ссылка: <a href=\"{$url}/confirm/" . md5(md5(Param::get_real_ip() . $member['member_id'])) . "/" . Param::get_real_ip() . "/{$member['member_id']}\">сбросить</a><br />
					Дата: " . date("d.m.Y в H:i", time()) . "<br />
					IP: " . Param::get_real_ip();
		$headers  = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "From: " . project . " <" . from . ">" . "\r\n";
		mail($member['email'], "Сброс кода безопасности", $message, $headers);
		$style->content("{content}", "<div class=\"alert alert-info\">На ваш электронный адрес отправлено сообщение с ссылкой о подтверждении действия.</div>");
	}
}
else
{
	$style->content("{content}", "<div class=\"alert alert-danger\">Ваш персонаж находится в игре.</div>");
}
$style->content("{script}", "");