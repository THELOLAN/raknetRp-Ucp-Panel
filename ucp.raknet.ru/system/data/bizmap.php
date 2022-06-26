<?php
error_reporting (-1);
ini_set("display_errors", -1);
header("Content-Type: text/html; charaset=UTF-8");

define("RUCP", true);
define("MYSQL_PATH", "/home/webuser/domains/ucp.raknet.ru/");

require(MYSQL_PATH . "system/mysql/mysql.php");

$db = new MysqliDb ('localhost', 'raknet_forum', 'RNRLovZry40k', 'raknet_forum', 13366);

$products = $db->join("members m", "b.Owned=m.member_id", "LEFT");
$products = $db->get ("bizzes b", null, "b.ID, b.Owned, m.member_id, m.name, b.Message, b.EnterProdPrice, b.EntranceX, b.EntranceY, b.EntranceZ, b.EntranceCost, b.BuyPrice, b.Products, b.MaxProducts, b.Klass, b.Gorod");

$f = fopen("biz.json", "w");
fwrite($f, json_encode($products) . "\n");
fclose($f);

$products1 = $db->join("members m", "b.Owned=m.member_id", "LEFT");
$products1 = $db->get ("bizzes_zapravki b", null, "b.id, b.Owned, b.Message, b.Fill_X, b.Fill_Y, b.Fill_Z, m.member_id, m.name, b.Cena, b.Cena_Fuell_1, b.Cenapokupki, b.b2ObKolicestvo, b.Gorod");

$f1 = fopen("fillbiz.json", "w");
fwrite($f1, json_encode($products1) . "\n");
fclose($f1);

$products2 = $db->join("members m", "h.Owned=m.member_id", "LEFT");
$products2 = $db->get ("house h", null, "h.ID, h.Owned, m.member_id, m.name, h.Entrancex, h.Entrancey, h.Value, h.Klass, h.Comnat, h.Itajey, h.Gorod, h.Garaj");

$f2 = fopen("house.json", "w");
fwrite($f2, json_encode($products2) . "\n");
fclose($f2);