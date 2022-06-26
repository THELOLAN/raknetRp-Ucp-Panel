<?php
// регистрационная информация (пароль #1)
// registration info (password #1)
$mrh_pass1 = "873IUUkakjw9e8s9oihas091";
// чтение параметров
// read parameters
$out_summ = isset($_REQUEST['OutSum']) ? $_REQUEST['OutSum'] : false;
$inv_id = isset($_REQUEST['InvId']) ? $_REQUEST['InvId'] : false;
$shp_item = isset($_REQUEST['Shp_item']) ? $_REQUEST['Shp_item'] : false;
$crc = isset($_REQUEST['SignatureValue']) ? $_REQUEST['SignatureValue'] : false;
$crc = strtoupper($crc);
$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item"));
// проверка корректности подписи
// check signature
if ($my_crc != $crc)
{
  //echo "bad sign\n";
  exit();
}
// проверка наличия номера счета в истории операций
// check of number of the order info in history of operations
$f=@fopen("order.txt","r+") or die("error");
while(!feof($f))
{
  $str=fgets($f);

  $str_exp = explode(";", $str);
  if ($str_exp[0]=="order_num :$inv_id")
  { 
	/*echo "Операция прошла успешно\n";
	echo "Operation of payment is successfully completed\n";*/
  }
}
fclose($f);
?>