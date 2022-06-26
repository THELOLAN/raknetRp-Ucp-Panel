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

require("x.php");

if(autox == 0)
{
	define("auto", "/home/webuser/auto.json");
}
else
{
	define("auto", "/home/webuser/auto1.json");
}
//define("auto", "/home/webuser/auto.json");
$ipbMemberLoginApi = new apiMemberLogin();
$ipbMemberLoginApi->init();
$member = $ipbMemberLoginApi->getMember();

if($member['member_id'])
{
	require(ROOT_DIR . "/system/mysql/mysql.php");
	require("config/vehicle.php");
	$db = new MysqliDb ('localhost', '', '', '', 13366);
	
	$car = isset($_POST['car']) ? $_POST['car'] : null;
	$car = $db->escape($car);
	$v = json_decode(file_get_contents(auto), true);
	$v = (array)$v;
	
	for($i = 0; $i < count($v); $i++)
	{
		if($v[$i]['model'] == $car)
		{
			if($v[$i]['surfers'] == 0)
			{
				$surfers = "Нет";
			}
			else
			{
				$surfers = "Да";
			}
			echo "<table class=\"table\">
						<tr>
							<td>
								<img src=\"http://ucp.raknet.ru/template/raknet/img/cars/{$v[$i]['model']}.png\">
							</td>
							<td>
								<font color=\"black\">
									Название: {$vehiclename[$v[$i]['model']]}
									<br />
									Максимальная скорость: " . floor($v[$i]['maxspeed']) . " км/ч.
									<br />
									Бак: " . floor($v[$i]['maxfuel']) . " л.
									<br />
									Расход: {$v[$i]['fueldrop']}
									<br />
									Багаж: {$v[$i]['bagaj']} слота.
									<br />
									Езда в кузове: {$surfers}
									<br />
									Цена: {$v[$i]['price']} руб.
								</font>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<Td>
							</td>
						</tr>
					</table>
					
					<form class=\"smart-form\">
						<input type=\"hidden\" value=\"{$v[$i]['price']}\" id=\"price\">
						<input type=\"hidden\" value=\"{$v[$i]['model']}\" id=\"model\">
						<button type=\"button\" class=\"btn btn-sm btn-primary\" onClick=\"BuyCar('/car.php', $('#price').val(), $('#car').val());\">Купить</button>
					</form>";
		}
	}
}