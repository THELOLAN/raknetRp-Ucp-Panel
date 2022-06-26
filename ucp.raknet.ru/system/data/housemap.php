<?php
error_reporting (-1);
ini_set("display_errors", -1);
header("Content-Type: text/html; charaset=UTF-8");

define("RUCP", true);
define("MYSQL_PATH", "/home/webuser/domains/ucp.raknet.ru/");

/* require(MYSQL_PATH . "system/mysql/mysql.php");

$db = new MysqliDb ('localhost', 'raknet_forum', 'RNRLovZry40k', 'raknet_forum', 13366);

$products2 = $db->join("members m", "h.Owned=m.member_id", "LEFT");
$products2 = $db->get ("house h", null, "h.ID, h.Owned, m.member_id, m.name, h.Entrancex, h.Entrancey, h.Value, h.Klass, h.Comnat, h.Itajey, h.Gorod, h.Garaj");

$f2 = fopen("house.json", "w");
fwrite($f2, json_encode($products2) . "\n");
fclose($f2); */
echo 1;