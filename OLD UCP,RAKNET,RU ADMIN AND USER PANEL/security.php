<?php
header("Content-type: image/png"); 
// ������� �������� �������� 172X52
$img = imagecreatetruecolor(172, 52) or die('Cannot create image');
// ��������� ��� �������� 
imagefill($img, 0, 0, 0x2C3742);

$x = 0;

$i = 1;

$sum = "";

//���� ������
$color_RGB = rand(180,200);
while ( $i++ <= 5000 ) imageSetPixel($img, rand(0,172), rand(0,50),0x515151);

$rand = rand(1,4);
for ( $n = 0; $n < $rand; $n++ ) imageLine($img, rand(0,10), rand(0,50), rand(110,172), rand(0,50), 0x909090);

//�����
imageRectangle($img,0,0,172,50,0x2C3742);

$fonts = array (
	'templates/style/fonts/FRSCRIPT.ttf',
	'templates/style/fonts/CHILLER.ttf',
	'templates/style/fonts/Bradley Hand ITC.ttf',
	'templates/style/fonts/de_Manu_2_Regular.ttf',
	'templates/style/fonts/Edgar_da_cool_Regular.ttf',
	'templates/style/fonts/Hurryup_Hurryup.ttf',
	'templates/style/fonts/Fh_Script_Regular.ttf',
	'templates/style/fonts/Gabo4_Gabo4.ttf',
	'templates/style/fonts/JAMI_Regular.ttf',
	'templates/style/fonts/Justy1_Regular.ttf'
);
$font = $fonts[rand(0, sizeof($fonts)-1)];
  // ���������� ������
session_start();
// ������� ���� ����� �� ���� ������ ����� (����� 6 ����)
$i = 1;
while ( $i++ <= 6) {
	// ������� ����� ������ ��������
	imagettftext($img, rand(20,25), rand(-35,35), $x=$x+25, 30+rand(0,10), 
	imagecolorallocate($img, $color_RGB,$color_RGB,$color_RGB), $font, $rnd = rand(0,9)); 
	// �������� � ���� ������ ��� ������� �� ��������
	$sum = $sum.(string)$rnd;
}
//�� �������� $sum �������� � ������� ��� STR1
// ������� ������� �������� � ������� PNG
imagepng($img);
// ����������� ������, ���������� ��� ��������
imagedestroy($img);
// �������� �������� ��� � ������
$_SESSION['code'] = $sum;