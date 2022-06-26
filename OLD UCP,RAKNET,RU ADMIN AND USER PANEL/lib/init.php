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
 Файл: init.php
=====================================================
*/
$directory = realpath ( dirname ( __FILE__ ) );
$document_root =  $_SERVER['DOCUMENT_ROOT'];
$base_url = ( isset ( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'];
if( strpos ( $directory , $document_root ) === 0 ) $base_url .= str_replace ( DIRECTORY_SEPARATOR , '/' , substr ( $directory , strlen ( $document_root ) ) );

$connect = 	isset ( $_SESSION['connect'] ) ? $_SESSION['connect'] : null;
$sname = 	isset ( $_SESSION['sname'] ) ? $_SESSION['sname'] : null;
$stime =	isset ( $_SESSION['stime'] ) ? $_SESSION['stime'] : "0";
$uid = 		isset ( $_SESSION['uid'] ) ? $_SESSION['uid'] : "0";
$admins = 	isset ( $_SESSION["admins"] ) ? $_SESSION["admins"] : null;
$acode = 	isset ( $_SESSION["acode"] ) ? $_SESSION["acode"] : "";
$codes = 	isset ( $_SESSION["codes"] ) ? $_SESSION["codes"] : false;
$page = 	isset ( $_GET['page'] ) ? $_GET['page'] : null;
$langs = 	isset ( $_GET['lang'] ) ? $_GET['lang'] : "";
$lang = 	isset ( $_COOKIE['lang'] ) ? $_COOKIE['lang'] : "";
$slang = 	isset ( $_SESSION["langs"] ) ? $_SESSION["langs"] : "";

$_SESSION['query'] = $page;
//Assets URL, location of your css, img, js, etc, files, other
defined ( "APP_URL" ) ? null : define ( "APP_URL" , str_replace ( "/lib" , "" , $base_url ) );
defined ( "projectname" ) ? null : define ( "projectname" , "RakNet Role Play" );
defined ( "keywords" ) ? null : define ( "keywords" , "SAMP, SA-MP, Server, Gta San Andreas, gta, хостинг, онлайн, игры, online, мультиплеер, multiplayer, mta, pawno, php, html, игра, по сети, играй, отдых, лучший, сервер, ракнет, raknet, google, бесплатно, free to play, поиграть, Terminator 5, Терминатор 5, Терминатор генесис, Чем дальше в лес, Исход: Цари и боги, Несломленный, Восхождение Юпитер, Карта raknet, программное обеспичение, C++, проги, софт, программы" );
//defined ( "ASSETS_URL" ) ? null : define ( "ASSETS_URL" , APP_URL );

//driver(mysql or mysqli)
defined ( "DBDRIVER" ) ? null : define ( "DBDRIVER" , "mysqli" );

//database connect 
defined ( "DBHOST" ) ? null : define ( "DBHOST" , "localhost:13366" );
defined ( "DBUSER" ) ? null : define ( "DBUSER" , "raknet_forum" );
defined ( "DBPASS" ) ? null : define ( "DBPASS" , "RNRLovZry40k" );
defined ( "DBNAME" ) ? null : define ( "DBNAME" , "raknet_forum" );

//database connect 
defined ( "DBHOST1" ) ? null : define ( "DBHOST1" , "5.254.105.217" );
defined ( "DBUSER1" ) ? null : define ( "DBUSER1" , "samp" );
defined ( "DBPASS1" ) ? null : define ( "DBPASS1" , "yTVdYVKDKr1v" );
defined ( "DBNAME1" ) ? null : define ( "DBNAME1" , "gtadb" );

//session config
defined ( "sname" ) ? null : define ( "sname" , $sname );
defined ( "uid" ) ? null : define ( "uid" , $uid );

//template config
defined ( "template_dir" ) ? null : define ( "template_dir" , "templates" );
defined ( "template" ) ? null : define ( "template" , "style" );

defined ( "virt" ) ? null : define ( "virt" , "500" );

defined ( "actiondate" ) ? null : define ( "actiondate" , "01.06.2015.0.0" ); // Дата окончания акции .0.0 не убирать.
defined ( "poweraction" ) ? null : define ( "poweraction" , "0" ); // 0 выключено 1 включено
defined ( "xaction" ) ? null : define ( "xaction" , "0" ); //1 не умножаем / 2 умножаем на 2

$dir = template_dir;
$template = template;
$url = APP_URL;

$_SESSION['connect'] = 1;

$sex = array (
	0 => "Женский",
	1 => "Мужской"
);
$defaultlang = "ru";

$language = array ( "ru" , "ua" , "by" , "en" );