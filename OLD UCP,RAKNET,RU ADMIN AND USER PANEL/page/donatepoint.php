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
 Файл: banlog.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , "Злосные донатеры" );

$style->content( "{style}" , "" );
if ( user::logged () ) {

	$user = $db->super_query( "SELECT
									`Admin`
								FROM
									`members`
								WHERE 
									`member_id` = '{$uid}'
								LIMIT 1" );
	
	$point = $db->super_query("SELECT SUM(DonateMOther) as rur FROM `members` WHERE `DonateMOther` >= 1");
	if ( $user["Admin"] == 10 ) {
	
		$param = isset ( $_GET['param'] ) ? $_GET['param'] : null;
		$style->content( "{content}" , "<!--Общая: {$point['rur']}-->" . user::donatepoint( $param ) );
		
	}
	else $style->content( "{content}" , "<script>setTimeout(\"document.location.href='{$url}/alogin'\", 2000);</script>" );
	
}

$style->content( "{script}" , "" );