<?php
/*
=====================================================
 R-Panel CMS by Артур Ялалтдинов ( crazy_str ) 
-----------------------------------------------------
 http://radmins.ru/
-----------------------------------------------------
 Copyright (c) 2014
=====================================================
This code is copyrighted
=====================================================
 Файл: ru.php
=====================================================
*/
if(!defined('CRAZY_STR')) die("Hacking attempt!");

$lang = array ( 

	"page" => array (
	
		"index" => "Main",
		"database" => "criminals database",
		"acp" => "Administrator control panel",
		"lcp" => "Lieder control panel",
		"donate" => "Donate",
		"updonate" => "Top-up",
		"store" => "R-Store",
		"setting" => "Settings",
		"logout" => "Exit",
		"login" => "Login",
		"forgot" => "Forget the password?",
		"forum" => "Forum",
		"settings" => array (
		
			"code" => "Security code on",
			"codeoff" => "Security code off",
			"acceptcode" => "Enter the current security code",
			"off" => "Off",
			"loghistory" => "Authorization history",
			"cpass" => "Change password",
			"pass" => "Enter the current password",
			"npass" => "Enter new password",
			"change" => "Change password"
		
		),
		"profile" => array (
		
			"profile" => "Profile",
			"allrub" => "The total amount of top-up",
			"auto" => "Auto",
			"typeauto" => "Auto type",
			"house" => "House",
			"azs" => "GAS station / Money",
			"biz" => "Business / Money",
			"Italy" => "Italian",
			"Ispan" => "Espanola",
			"Japan" => "Japanese",
			"Russia" => "Russian",
			"Nemec" => "German",
			"CarLic" => "Driver license",
			"name" => "Accounts name",
			"level" => "Level",
			"exp" => "EXP",
			"vip" => "VIP Status",
			"id" => "Account number",
			"job" => "Job",
			"member" => "Company",
			"rank" => "Rank",
			"sex" => "Gender",
			"bank" => "Money in the bank",
			"cash" => "Money in a wallet",
			"gun" => "Weapon level",
			"language" => "Languages level",
			"number" => "Phone number",
			"balance" => "Money on your phone",
			"player" => "Player",
			"friends" => "Contacts"
			
		),
		"payment" => array (
		
			"sum" => "Enter the payment amount",
			"total" => "Total amount of money that you'll get in the game after exchange"
		
		),
	),
	"other" => array (
	
		"vkload" => "Show more news",
		"connect" => "Start the game",
		"monitoring" => "Detailed monitoring",
		"search" => "Players Search",
		"cname" => "First nickname change for free",
		"cname30" => "Nickname change is cost 30 rubles",
		"monplayer" => "Players monitoring",
		"monbiz" => "Business map",
		"monhouse" => "House map",
		"param" => array (
		
			"logoutmsg" => "You are outside!",
			"entername" => "Enter player name",
			"enternewname" => "Enter new player name",
			"enterpassword" => "Enter password",
			"securitycode" => "Enter security code if you have so",
			"security" => "Enter picture code",
			"server" => "Select a server",
			"controlacc" => "Account access recovery",
			"enteremail" => "Enter Email address used for registration",
			"successforgot" => "New password has been sent to your Email address!",
			"successlogin" => "Welcome!",
			"successacp" => "You did everything right!",
			"exportmail" => "Enter the code that has been sent to your Email address",
			"acppassword" => "Enter Admin password"
		
		),
		"error" => array (
		
			"errorname" => "Incorrect player name!",
			"errormail" => "Incorrect Email address!",
			"errorpic" => "Incorrect picture code!",
			"errorfield" => "Fill in all fields!",
			"errorlenghtpassword" => "The password length have to be from 3 to 26 characters!",
			"errornameinpass" => "Incorrect password or player name!",
			"entercodesec" => "Incorrect security code!",
			"acperrorcode" => "Incorrect code from your Email address!",
			"erroracpcode" => "Incorrect Admin password!",
			"DANGER" => "Attention!",
			"accountblock" => "Your accounts blocked",
			"blockdate" => "Date of blocking",
			"unblockdate" => "Date of unblocking",
			"adminblock" => "Administrator",
			"blockreason" => "Reason",
			"noblock" => "Your account is not blocking"
		
		),
	),
	"button" => array (
		
		"enter" => "Enter",
		"forgot" => "Forget a password?",
		"remember" => "password recover",
		"next" => "Continue",
		"start" => "Start"
		
	),
	"pagefunction" => array (
	
		"fieldname" => "Blank field \"Player name\"",
		"fieldmail" => "Blank field \"E-Mail\"",
		"validmail" => "Wrong E-Mail",
		"fieldimage" => "Blank field \"Picture code\"",
		"fieldcode" => "Blank field \"Code\"",
		"acpcode" => "Blank field \"Admin password\"",
		"pcode" => "Blank field \"Security code\"",
		"pass" => "Blank field \"Password\"",
		"npass" => "Blank field \"New password\""
	
	),
	"rshop" => array (
	
		"changename" => array (
		
			"changename" => "Change player name",
			"lozung" => "Begin a new life (without any history)."
		
		),
		"other" => array (
		
			"other" => "Other objects",
			"lozung" => "Additional functions."
			
		),
		"number" => array (
		
			"number" => "Buy a phone number",
			"buynumber" => "Buy a short phone number",
			"lozung" => "Be different.",
			"pred" => "Enter preference phone number",
			"buy" => "Buy",
			"info" => "Information"
		
		),
		"mute" => array (
		
			"mute" => "Block the chart",
			"lozung" => "Unblock the chart.",
			"buy" => "Unblock",
			"cherez" => "The chat will be unblocked in",
			"second" => "seconds</b>.<br />Unblock the chart: 20 publes."
		
		),
		"wanted" => array ( 
		
			"wanted" => "Wanted",
			"lozung" => "Still your documents from police station.",
			"buy" => "Still",
			"delete" => "Delete criminal database",
			"naake" => "In your account",
			"rozisk" => "Wanted level</b>.<br />Delete all data from database: 50 rubles."
		
		),
		"jail" => array (
		
			"jail" => "Jail",
			"lozung" => "Escape from the prison right now.",
			"buy" => "Escape",
			"exit" => "come up with a prison",
			"lozung2" => "Escape from the prison</b>.<br />Cost of escape is: 200 rubles."
		
		),
		"warn" => array (
		
			"warn" => "WARN",
			"lozung" => "Reset all warnings.",
			"buy" => "Reset",
			"admin" => "Remove administrator warning",
			"naake" => "On your account",
			"warns" => "Warning</b>.<br />Removing of 1 warning is cost: 300 rubles.<br />Removing of all warnings cost: 500 rubles.",
			"down" => "Remove one warning",
			"all" => "Remove all warnings"
		
		),
		"ban" => array (
		
			"ban" => "Your account is blocked",
			"lozung" => "Unblock your account.",
			"buy" => "Unblock",
			"bans" => "Unblock account",
			"all" => "It will unblock your account",
			"sum" => "Unblocking your account is cost: 600 rubles."
		
		)
	
	)

);
