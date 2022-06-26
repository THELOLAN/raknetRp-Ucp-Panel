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
 Файл: navigation.php
=====================================================
*/
if (!defined('CRAZY_STR') ) die("Hacking attempt!");

if ( user::logged() ) {

	$param = $db->super_query("SELECT 
									`Admin`, 
									`Leader`,
									`Member`,
									`DonateMREAL`
								FROM 
									`members` 
								WHERE 
									`member_id` = '{$uid}' 
								LIMIT 1");
	
	switch ( $param["Member"] ) {
	
		case 4:
		case 5:
		case 6:
		case 11: $menu = "<li {base}><a href=\"{$url}/database&params=1\" title=\"{$lang['page']['database']}\"><i class=\"fa fa-lg fa-fw fa-cloud \"></i> <span class=\"menu-item-parent\">{$lang['page']['database']}</span></a></li>"; break;
		default: $menu = "";
	
	}

	switch ( $param["Admin"] ) {
	
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:		
		case 6:
		case 7:
		case 8:
		case 9:
		case 10: $amenu = "<li {admin}><a href=\"{$url}/amenu\" title=\"{$lang['page']['acp']}\"><i class=\"fa fa-lg fa-fw fa-edit\"></i> <span class=\"menu-item-parent\">{$lang['page']['acp']}</span></a></li>"; break;
		default: $amenu = "";
	
	}
	
	if ( $param['Leader'] > 0 ) $lmenu = "<li {ledaer}><a href=\"{$url}/lmenu\" title=\"{$lang['page']['lcp']}\"><i class=\"fa fa-lg fa-fw fa-edit\"></i> <span class=\"menu-item-parent\">{$lang['page']['lcp']}</span></a></li>";
	else $lmenu = "";
	
	$style->content ( "{nav}" , "<li {profile}>
									<a href=\"{$url}/profile\" title=\"{$lang['page']['profile']['profile']}\">
										<i class=\"fa fa-lg fa-fw fa-user\"></i> 
										<span class=\"menu-item-parent\">{$lang['page']['profile']['profile']}</span>
									</a>
								</li>
								<li>
									<a href=\"{$url}/profile&param=1\" title=\"{$lang['page']['donate']}\">
										<i class=\"fa fa-lg fa-fw fa-credit-card\"></i> 
										<span class=\"menu-item-parent\">{$lang['page']['donate']}</span>
									</a>
								</li>
								<li {payment}>
									<a href=\"{$url}/payment\" title=\"{$lang['page']['store']}\">
										<i class=\"fa fa-lg fa-fw fa-shopping-cart\"></i> 
										<span class=\"menu-item-parent\">{$lang['page']['store']}</span>
									</a>
								</li>
								<li {setting}>
									<a href=\"{$url}/setting\" title=\"{$lang['page']['setting']}\">
										<i class=\"fa fa-lg fa-fw fa-cog\"></i> 
										<span class=\"menu-item-parent\">{$lang['page']['setting']}</span>
									</a>
								</li>
								<li {logout}>
									<a href=\"{$url}/logout\" title=\"{$lang['page']['logout']}\">
										<i class=\"fa fa-lg fa-fw fa-sign-out\"></i> 
										<span class=\"menu-item-parent\">{$lang['page']['logout']}</span>
									</a>
								</li>
								{$lmenu}
								{$amenu}
								{$menu}" );
	$style->content ( "{payments}" , "" );
	
	switch( $page ) {
	
		/*ADMIN PAGE*/
		case "amenu": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/admin.php" ); break;
		case "alogin": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/alogin.php" ); break;
		case "banlog": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/banlog.php" ); break;
		case "mylog": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/mylog.php" ); break;
		case "cashlog": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/cashlog.php" ); break;
		case "cashtolog": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/cashtolog.php" ); break;
		case "userinfo": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/userinfo.php" ); break;
		case "databaseadmin": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/databaseadmin.php" ); break;
		case "ipinfo": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/ipinfo.php" ); break;
		case "fraction": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/fraction.php" ); break;
		case "donatepoint": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/donatepoint.php" ); break;
		case "rshoplog": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/rshoplog.php" ); break;
		case "cashlogto": $style->content("{admin}", "class=\"active\""); require_once ( ROOT_DIR . "/page/cashlogto.php" ); break;
		/*END ADMIN PAGE*/
		case "logout": $style->content("{logout}", "class=\"active\""); require_once ( ROOT_DIR . "/page/login.php" ); break;
		case "profuser": $style->content("{profile}", "class=\"active\""); require_once ( ROOT_DIR . "/page/profuser.php" ); break;
		case "profile": $style->content("{profile}", "class=\"active\""); require_once ( ROOT_DIR . "/page/profile.php" ); break;
		case "payment": $style->content("{payment}", "class=\"active\""); require_once ( ROOT_DIR . "/page/payment.php" ); break;
		case "query": $style->content("{query}", "class=\"active\""); require_once ( ROOT_DIR . "/page/query.php" ); break;
		case "setting": $style->content("{setting}", "class=\"active\""); require_once ( ROOT_DIR . "/page/setting.php" ); break;
		case "lmenu": $style->content("{ledaer}", "class=\"active\""); require_once ( ROOT_DIR . "/page/leader.php" ); break;
		case "user": $style->content("{ledaer}", "class=\"active\""); require_once ( ROOT_DIR . "/page/user.php" ); break;
		case "database": $style->content("{base}", "class=\"active\""); require_once ( ROOT_DIR . "/page/database.php" ); break;
		case "store": $style->content("{payment}", "class=\"active\""); require_once ( ROOT_DIR . "/page/store.php" ); break;
		case "start": require_once ( ROOT_DIR . "/page/faq.php" ); break;
		case "search": require_once ( ROOT_DIR . "/page/search.php" ); break;
		case "success": require_once ( ROOT_DIR . "/page/success.php" ); break;
		case "fail": require_once ( ROOT_DIR . "/page/fail.php" ); break;
		case "monitoring": require_once ( ROOT_DIR . "/page/monitoring.php" ); break;
		case "": $style->content("{indexs}", "class=\"active\""); require_once ( ROOT_DIR . "/page/index.php" ); break;
		default: $style->content("{indexs}", "class=\"active\""); require_once ( ROOT_DIR . "/page/404.php" );
		
	}
	
} else {

	$style->content ( "{nav}" , "<li {logins}>
									<a href=\"{$url}/login\" title=\"{$lang['page']['login']}\">
										<i class=\"fa fa-lg fa-fw fa-sign-in\"></i> 
										<span class=\"menu-item-parent\">{$lang['page']['login']}</span>
									</a>
								</li>
								<li {forgot}>
									<a href=\"{$url}/forgot\" title=\"{$lang['page']['forgot']}\">
										<i class=\"fa fa-lg fa-fw fa-key\"></i> 
										<span class=\"menu-item-parent\">{$lang['page']['forgot']}</span>
									</a>
								</li>" );
	$style->content ( "{payments}" , "" );
	
	switch( $page ) {
	
		case "login": $style->content("{logins}", "class=\"active\""); require_once ( ROOT_DIR . "/page/login.php" ); break;
		case "query": $style->content("{query}", "class=\"active\""); require_once ( ROOT_DIR . "/page/query.php" ); break;
		case "forgot": $style->content("{forgot}", "class=\"active\""); require_once ( ROOT_DIR . "/page/forgot.php" ); break;
		case "start": require_once ( ROOT_DIR . "/page/faq.php" ); break;
		case "success": require_once ( ROOT_DIR . "/page/success.php" ); break;
		case "fail": require_once ( ROOT_DIR . "/page/fail.php" ); break;
		case "monitoring": require_once ( ROOT_DIR . "/page/monitoring.php" ); break;
		case "search": require_once ( ROOT_DIR . "/page/search.php" ); break;
		case "": $style->content("{indexs}", "class=\"active\""); require_once ( ROOT_DIR . "/page/index.php" ); break;
		default: $style->content ( "{indexs}", "class=\"active\"" ); require_once ( ROOT_DIR . "/page/404.php" );
		
	}
	
}