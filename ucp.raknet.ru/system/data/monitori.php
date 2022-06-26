<?php
error_reporting (-1);
ini_set("display_errors", -1);
header("Content-Type: text/html; charaset=UTF-8");

define("RUCP", true);
define("MYSQL_PATH", "/home/webuser/domains/ucp.raknet.ru/");

require(MYSQL_PATH . "system/mysql/mysql.php");
$db = new MysqliDb ('localhost', 'raknet_forum', 'RNRLovZry40k', 'raknet_forum', 13366);


$job[] = array();

$job[0] = $db->where("Job", 1);
$job[0] = $db->where("Online", 1);
$job[0] = $db->getOne ("members", "count(member_id) as c");

$job[1] = $db->where("Job", 2);
$job[1] = $db->where("Online", 1);
$job[1] = $db->getOne ("members", "count(member_id) as c");

$job[2] = $db->where("Job", 3);
$job[2] = $db->where("Online", 1);
$job[2] = $db->getOne ("members", "count(member_id) as c");

$job[3] = $db->where("Job", 4);
$job[3] = $db->where("Online", 1);
$job[3] = $db->getOne ("members", "count(member_id) as c");

$job[4] = $db->where("Job", 50, ">=");
$job[4] = $db->where("Online", 1);
$job[4] = $db->getOne ("members", "count(member_id) as c");

$job[5] = $db->where("Online", 1);
$job[5] = $db->getOne ("members", "count(member_id) as c");

$f = fopen("monitori.txt", "w");
fwrite($f, json_encode(
				array(
					$job[5]['c'],
					$job[0]['c'],
					$job[3]['c'],
					$job[2]['c'],
					$job[1]['c'],
					$job[4]['c']
				)
			)
		);
fclose($f);