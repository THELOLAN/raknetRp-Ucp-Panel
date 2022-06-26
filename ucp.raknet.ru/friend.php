<?php
session_start();
error_reporting (0);
ini_set("display_errors", 0);
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

	$name = isset($_POST['name']) ? $_POST['name'] : "";
	$name = $db->escape($name);
	$query = $db->rawQuery("SELECT * FROM `members` WHERE `name` LIKE '%{$name}%'");
	$friend = "";
	$k = md5( $member['email'].'&'.$member['member_login_key'].'&'.$member['joined'] );
	foreach($query as $key => $value)
	{
		$friend .= "<tr>
							<td>
								<img src=\"http://ucp.raknet.ru/template/raknet/img/avatars/{$value['Char']}.png\" width=\"35\">
							</td>
							<td>
								{$value['name']}
							</td>
							<td>
								" . Param::job($value['Job']) . "
							</td>
							<td>
								" . Param::frac($value['Member'], 1) . "
							</td>
							<td>
								" . Param::rank($value['Member'], $value['Rank'], 0) . "
							</td>
							<td>
								" . Param::Online($value['Online']) . "
							</td>
							<td>
								<a href=\"http://forum.raknet.ru/index.php?app=members&module=profile&section=friends&do=add&member_id={$value['member_id']}&secure_key={$k}\" class=\"btn btn-success\" target=\"_blank\">Добавить</a>
							</td>
						</tr>";
	}
	echo "<div class=\"row\">
				<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
					<table id=\"dt_basic\" class=\"table table-striped table-bordered table-hover text-center\" width=\"100%\">
						<thead>			                
							<tr>
								<th style=\"width: 3%\"></th>
								<th>Имя игрока</th>
								<th>Работа</th>
								<th>Организация</th>
								<th>Ранг</th>
								<th>Статус</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							{$friend}
						</tbody>
					</table>
				</div>
			</div>";
}