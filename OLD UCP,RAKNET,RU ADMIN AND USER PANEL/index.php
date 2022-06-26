<?php
/*
=====================================================
 R-Panel CMS by Артур Ялалтдинов ( crazy_str ) 
-----------------------------------------------------
 http://radmins.ru/
-----------------------------------------------------
 Copyright (c) 2014
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: index.php
=====================================================
*/
session_start();

error_reporting ( 0 );
ini_set( 'display_errors', 0 );

header( "Content-Type: text/html; charaset=UTF-8" );
/* $ts = time();
$s_time = ( empty ( $_SESSION["f5"] ) ) ? 0 : $_SESSION["f5"];
$proverka = 	isset ( $_SESSION['proverka'] ) ? $_SESSION['proverka'] : 0;
$_SESSION["f5"] = $ts;
if ( $ts - $s_time >= 1 && $proverka == 0 ) 
{ */
	//date_default_timezone_set('Europe/Moscow');
	$start_time = microtime();
	$start_array = explode ( " " , $start_time );
	$start_time = $start_array[1] + $start_array[0];

	define ( 'CRAZY_STR' , true );
	define ( 'ROOT_DIR' , dirname ( __FILE__ ) );
	
	require_once ( "lib/init.php" );
	require_once ( "lib/vehicle.php" );
	require_once ( "lib/config/queryparam.php" );
	require_once ( "lib/template/template.php" );

	if ( DBDRIVER == "mysql" ) require_once ( "lib/classes/mysql.class.php" );
	else require_once ( "lib/classes/mysqli.class.php" );

	require_once ( "lib/classes/func.global.php" );
	
	if($lang) {
		if(!in_array($lang, $language)) setcookie("lang", $defaultlang, time()+86400);
	} 
	else setcookie("lang", $defaultlang, time()+86400);

	$langu = addslashes($langs);
	
	if($langu) {
	
		if(!in_array($langu, $language)) setcookie("lang", $defaultlang, time()+86400);
		else setcookie("lang", $langu, time()+86400);
		
	}
	
	$currentlang = addslashes($lang);
	
	if($currentlang == "") require_once ( "lib/language/ru.php" );	
	else require_once ( "lib/language/{$currentlang}.php" );
	
	$style = new template ( template_dir . "/" . template . "/index.raknet" );
	$style->content ( "{template_dir}" , template_dir );
	$style->content ( "{template}" , template );
	$style->content ( "{ASSETS_URL}" , APP_URL );
	$style->content ( "{projectname}" , projectname );
	$style->content ( "{keywords}" , keywords );
	$style->content ( "{index}" , $lang['page']['index'] );
	$style->content ( "{searchplayer}" , $lang['other']['search'] );
	$style->content ( "{forum}" , $lang['page']['forum'] );
	$style->content ( "{copyright}" , "2012 - " . date ( "Y" ) );

	if ( $connect == 1 ) {

		$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
		$db->query ( "SET NAMES UTF8" );
		
	} elseif ( $connect == 2 ) {

		$db->connect ( DBUSER1 , DBPASS1 , DBNAME1 , DBHOST1 );
		$db->query ( "SET NAMES UTF8" );
		
	}
	if($currentlang == "") {
		
		$style->content( "{langimg}" , "ru" );
		$style->content( "{selectlanguage}" , "RU" );
		
	} elseif($currentlang == "ru") {
	
		$style->content( "{langimg}" , "ru" );
		$style->content( "{selectlanguage}" , "RU" );
		
	} elseif($currentlang == "ua") {
	
		$style->content( "{langimg}" , "ua" );
		$style->content( "{selectlanguage}" , "UA" );
		
	} elseif($currentlang == "by") {
	
		$style->content( "{langimg}" , "by" );
		$style->content( "{selectlanguage}" , "BY" );
		
	} elseif($currentlang == "en") {
		
		$style->content( "{langimg}" , "us" );
		$style->content( "{selectlanguage}" , "EN" );
		
	}
	

	require_once ( "lib/navigation.php" ) ;

	$style->parse();
	$db->close();
	
	$end_time = microtime();
	$end_array = explode ( " " ,$end_time );
	$end_time = $end_array[1] + $end_array[0];
	$time = $end_time - $start_time;
	$endtime = substr ( $time , 0,5 );

	echo "\n<!-- R-Panel Copyright by Артур Ялалтдинов ( CRAZy_STR ) http://radmins.ru -->";
	echo "\n<!-- Скорость генерации страницы {$endtime} Сек. -->";
	
/*  } else {

	$_SESSION['proverka'] = 1;
	echo "<form action=\"http://{$_SERVER['HTTP_HOST']}/proverka.php\" method=\"POST\"><a href=\"#\" onclick=\"document.getElementById('security').src='http://{$_SERVER['HTTP_HOST']}/security.php?'+Math.random(); return false;\"><img id=\"security\" src=\"http://{$_SERVER['HTTP_HOST']}/security.php\"></a><br /><label>Введите код с картинки</label><br /><input type=\"text\" value=\"\" name=\"proverka\"><br /><input type=\"submit\" name=\"submit\" value=\"Я не бот\"></form>";
		
} */