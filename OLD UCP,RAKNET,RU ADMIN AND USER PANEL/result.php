<?php
// ��������������� ���������� (������ #2)
// registration info (password #2)
$mrh_pass2 = "78O98siu2iiu23hdzxfdy2ih";
//��������� �������� �������
//current date
$tm=getdate(time()+9*3600);
$date="$tm[year]-$tm[mon]-$tm[mday] $tm[hours]:$tm[minutes]:$tm[seconds]";
// ������ ����������
// read parameters
$out_summ = isset($_REQUEST['OutSum']) ? $_REQUEST['OutSum'] : false;
$inv_id = isset($_REQUEST['InvId']) ? $_REQUEST['InvId'] : false;
$shp_item = isset($_REQUEST['Shp_item']) ? $_REQUEST['Shp_item'] : false;
$crc = isset($_REQUEST['SignatureValue']) ? $_REQUEST['SignatureValue'] : false;

$crc = strtoupper($crc);
$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:Shp_item=$shp_item"));
// �������� ������������ �������
// check signature
if ($my_crc !=$crc)
{
  //echo "bad sign\n";
  exit();
}
// ������� ������� ����������� ��������
// success
/*echo "OK$inv_id\n";*/
// ������ � ���� ���������� � ���������� ��������
// save order info to file
$f=@fopen("order.txt","a+") or die("error");
fputs($f,"order_num :$inv_id;Summ :$out_summ;Date :$date\n");
fclose($f);
?>