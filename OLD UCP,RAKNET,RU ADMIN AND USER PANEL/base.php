<?php
session_start();
define ( 'CRAZY_STR' , true );

if ( isset ( $_GET['name'] ) ) {

	header("Content-type: image/png");
	require_once ( "lib/init.php" );
	require_once ( "lib/classes/mysql.class.php" );
	//include_once 'engine/mysql/mysql.php';

	if ( $_SESSION['cops'] == 1 ) {
	
		$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
		$db->query ( "SET NAMES UTF8" );
		
		$dname = $db->safesql($_GET['name']);
		$player = $db->super_query("SELECT `member_id`, `name`, `Char` FROM `members` WHERE `hash` = '{$dname}' LIMIT 1");
		$players = $db->query("SELECT * FROM `members` WHERE `hash` = '{$dname}' LIMIT 1");
		
		if($db->num_rows($players) > 0) {

			$im = ImageCreateFromJPEG ("templates/style/img/policebase/{$player['Char']}.png");
			$color = imagecolorallocate($im, 0, 0, 0);
			imagettftext($im, 13, 0, 115, 350, $color, "templates/style/fonts/arialbd.ttf", "{$player['name']}");
			imagettftext($im, 13, 0, 435, 350, $color, "templates/style/fonts/arialbd.ttf", "{$player['name']}");
			imagettftext($im, 13, 0, 115, 380, $color, "templates/style/fonts/arialbd.ttf", "#{$player['member_id']}");
			imagettftext($im, 13, 0, 452, 380, $color, "templates/style/fonts/arialbd.ttf", "#{$player['member_id']}");
			imagepng($im);
			ImageJPEG($im, NULL, 100);
			imagedestroy($im);

		} else {

			$im = ImageCreateFromJPEG ("templates/style/img/policebase/1.png");
			$color = imagecolorallocate($im, 0, 0, 0);
			imagettftext($im, 13, 0, 123, 370, $color, "templates/style/fonts/arialbd.ttf", "Пользователь не найден");
			imagettftext($im, 13, 0, 452, 370, $color, "templates/style/fonts/arialbd.ttf", "Пользователь не найден");
			imagepng($im);
			ImageJPEG($im, NULL, 100);
			imagedestroy($im);

		}
		$db->close();
		
	}

}
else echo "Error";