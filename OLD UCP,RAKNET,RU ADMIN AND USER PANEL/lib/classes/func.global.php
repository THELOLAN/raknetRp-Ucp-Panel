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
 Файл: func.global.php
=====================================================
*/
if(!defined('CRAZY_STR')) die("Hacking attempt!");

class other {
	
	static public function VIP ( $param ) {
	
		switch ( $param ) {
		
			case 0: $param = "Нет"; break;
			case 1: $param = "BRONZE VIP"; break;
			case 2: $param = "SILVER VIP"; break;
			case 3: $param = "GOLD VIP"; break;
			//default: $param = 'Нет';
		
		}
		return $param;
	}
	
	static public function item ($items) {
	
		switch( $items ) {
		
			case 1: $text = "Разблокировка аккаунта"; break;
			case 2: $text = "Побег из тюрьмы/деморгана"; break;
			case 3: $text = "Разблокировка чата"; break;
			case 4: $text = "Снятие 1 предупреждения"; break;
			case 5: $text = "Удаление из базы данных преступника"; break;
			case 6: $text = "Полное снятие предупреждений"; break;
			case 7: $text = "Покупка номера телефона"; break;
		
		}
		return $text;
	
	}
	
	static public function house( $param = 0 ) {

		$db = new db;
		$house = "";
		$query = $db->query("SELECT `ID`, `Owned`, `member_id`, `name`, `Entrancex`, `Entrancey`, `Value`, `Klass`, `Comnat`, `Itajey`, `Gorod`, `Garaj` FROM `house` as A LEFT JOIN `members` as B ON ( B.member_id = A.Owned ) WHERE A.ID > '0'");

		while ( $val = $db->get_row( $query ) ) {

			switch ( $val["Klass"] ) {

				case 0: $klass = "Эконом"; break;
				case 1: $klass = "Эконом +"; break;
				case 2: $klass = "Средний"; break;
				case 3: $klass = "Люкс"; break;
				case 4: $klass = "Де люкс"; break;

			}
			switch ( $val["Garaj"] ) {

				case 0: $garage = "<font style='color: #ff2400;'>Отсутствует</font>"; break;
				case 1: $garage = "<font style='color: #3caa3c;'>Есть</font>"; break;

			}

			switch ( $val["Gorod"] ) {

				case 1:	$gorods = "Los Santos"; break;
				case 2:	$gorods = "San Fierro"; break;
				case 3:	$gorods = "Las Venturas"; break;

			}

			if ( $val['Entrancex'] > 0 ) $left = ( 3000 + abs ( $val['Entrancex'] ) )/6; // 2.1
			else $left = ( 3000 - abs ( $val['Entrancex'] ) )/6; // 2.2

			if ( $val['Entrancey'] > 0 ) $top = ( 3000 - abs ( $val['Entrancey'] ) )/6; // 3.1
			else $top = ( 3000 + abs ( $val['Entrancey'] ) )/6; // 3.2

			if ( $param == 0 ) {
			
				if ( $val["name"] == "" ) $name = "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"Продаётся.<br /><br /><table><tr align='left'><td>Цена: </td><td>{$val["Value"]}<font color='green'> $</font></td></tr><tr align='left'><td>Класс: </td><td>{$klass}</td></tr><tr align='left'><td>Комнат: </td><td>{$val["Comnat"]}</td></tr><tr align='left'><td>Гараж: </td><td>{$garage}</td></tr><tr align='left'><td>Этажей: </td><td>{$val["Itajey"]}</td></tr><tr align='left'><td><br /></td><td><br /></td></tr><tr align='left'><td>Номер дома:&nbsp;</td><td>{$val["ID"]}</td></tr><tr align='left'><td>Город: </td><td>{$gorods}</td></tr></table>\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url(http://wiki.sa-mp.com/wroot/images2/b/b6/Icon_31.gif); width:16px; height:16px;\"></div>";
				else $name = "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"Дом занят.<br /><br /><table><tr align='left'><td>Класс: </td><td>{$klass}</td></tr><tr align='left'><td>Комнат: </td><td>{$val["Comnat"]}</td></tr><tr align='left'><td>Гараж: </td><td>{$garage}</td></tr><tr align='left'><td>Этажей: </td><td>{$val["Itajey"]}</td></tr><tr align='left'><td><br /></td><td><br /></td></tr><tr align='left'><td>Номер дома:&nbsp;</td><td>{$val["ID"]}</td></tr><tr align='left'><td>Город: </td><td>{$gorods}</td></tr></table>\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url(http://wiki.sa-mp.com/wroot/images2/a/a9/Icon_32.gif); width:16px; height:16px;\"></div>";
			
			} else {
			
				if ( $val["name"] == "" ) $name = "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"Продаётся.<br /><br /><table><tr align='left'><td>Цена: </td><td>{$val["Value"]}<font color='green'> $</font></td></tr><tr align='left'><td>Класс: </td><td>{$klass}</td></tr><tr align='left'><td>Комнат: </td><td>{$val["Comnat"]}</td></tr><tr align='left'><td>Гараж: </td><td>{$garage}</td></tr><tr align='left'><td>Этажей: </td><td>{$val["Itajey"]}</td></tr><tr align='left'><td><br /></td><td><br /></td></tr><tr align='left'><td>Номер дома:&nbsp;</td><td>{$val["ID"]}</td></tr><tr align='left'><td>Город: </td><td>{$gorods}</td></tr></table>\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url(http://wiki.sa-mp.com/wroot/images2/b/b6/Icon_31.gif); width:16px; height:16px;\"></div>";
				else $name = "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"Дом занят.<br /><br /><table><tr align='left'><td>Владелец: </td><td>{$val['name']}</td></tr><tr align='left'><td>Класс: </td><td>{$klass}</td></tr><tr align='left'><td>Комнат: </td><td>{$val["Comnat"]}</td></tr><tr align='left'><td>Гараж: </td><td>{$garage}</td></tr><tr align='left'><td>Этажей: </td><td>{$val["Itajey"]}</td></tr><tr align='left'><td><br /></td><td><br /></td></tr><tr align='left'><td>Номер дома:&nbsp;</td><td>{$val["ID"]}</td></tr><tr align='left'><td>Город: </td><td>{$gorods}</td></tr></table>\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url(http://wiki.sa-mp.com/wroot/images2/a/a9/Icon_32.gif); width:16px; height:16px;\"></div>";
			
			}
			$house .= $name;

		}

		return $house;

	}

	static public function bussines( $param = 0 ) {

		$db = new db;
		$name = "";
		$house = "";
		$query = $db->query("SELECT `ID`, `Owned`, `Message`, `EntranceX`, `EntranceY`, `EntranceCost`, `member_id`, `name`, `BuyPrice`, `EnterProdPrice`, `Products`, `MaxProducts`, `Klass`, `Gorod` FROM `bizzes` as A LEFT JOIN `members` as B ON ( B.member_id = A.Owned ) WHERE A.ID > '0'");
		$querys = $db->query("SELECT `id`, `Owned`, `Message`, `Fill_X`, `Fill_Y`, `member_id`, `name`, `Cena`, `Cena_Fuell_1`, `Cenapokupki`, `b2ObKolicestvo`, `Gorod` FROM `bizzes_zapravki` as A LEFT JOIN `members` as B ON ( B.member_id = A.Owned ) WHERE A.id > '0'");

 		while ( $vals = $db->get_row( $querys ) ) {

			switch ( $vals['Gorod'] ) {

				case 0:	$gorods = "Los Santos"; break;
				case 1:	$gorods = "San Fierro"; break;
				case 2:	$gorods = "Las Venturas"; break;

			}
		
			if ( $vals['Fill_X'] > 0 ) $left = ( 3000 + abs ( $vals['Fill_X'] ) )/6; // 2.1
			else $left = ( 3000 - abs ( $vals['Fill_X'] ) )/6; // 2.2

			if ( $vals['Fill_Y'] > 0 ) $top = ( 3000 - abs ( $vals['Fill_Y'] ) )/6; // 3.1
			else $top = ( 3000 + abs ( $vals['Fill_Y'] ) )/6; // 3.2

			$message = str_replace( '"' , "'" , $vals["Message"] );

			if ( $param == 0 ) {
			
				if ( $vals["name"] == "" ) $name = "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - АЗС - № {$vals["id"]}</center><br />{$message}<br />Цена: {$vals["Cena"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url(http://wiki.sa-mp.com/wroot/images2/1/18/Icon_47.gif); width:16px; height:16px;\"></div>";
				else $name = "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - АЗС - № {$vals["id"]}</center><br />{$message}<br />Цена за литр: {$vals["Cena_Fuell_1"]} <font color='green'>$</font><br />Цена за ввоз бензина: {$vals["Cenapokupki"]} <font color='green'>$</font><br />Кол-во топлива на АЗС: {$vals["b2ObKolicestvo"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url(http://wiki.sa-mp.com/wroot/images2/1/18/Icon_47.gif); width:16px; height:16px;\"></div>";
			
			} else {

				if ( $vals["name"] == "" ) $name = "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - АЗС - № {$vals["id"]}</center><br />{$message}<br />Цена: {$vals["Cena"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url(http://wiki.sa-mp.com/wroot/images2/1/18/Icon_47.gif); width:16px; height:16px;\"></div>";
				else $name = "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - АЗС - № {$vals["id"]}</center><br />{$vals['name']}<br /><br />{$message}<br />Цена за литр: {$vals["Cena_Fuell_1"]} <font color='green'>$</font><br />Цена за ввоз бензина: {$vals["Cenapokupki"]} <font color='green'>$</font><br />Кол-во топлива на АЗС: {$vals["b2ObKolicestvo"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url(http://wiki.sa-mp.com/wroot/images2/1/18/Icon_47.gif); width:16px; height:16px;\"></div>";			
			
			}
			$house .= $name;

		}

		while ( $val = $db->get_row( $query ) ) {

			switch ( $val['Gorod'] ) {

				case 0:	$gorods = "Los Santos"; break;
				case 1:	$gorods = "San Fierro"; break;
				case 2:	$gorods = "Las Venturas"; break;

			}
			
			if ( $val['EntranceX'] > 0 ) $left = ( 3000 + abs ( $val['EntranceX'] ) )/6; // 2.1
			else $left = ( 3000 - abs ( $val['EntranceX'] ) )/6; // 2.2

			if ( $val['EntranceY'] > 0 ) $top = ( 3000 - abs ( $val['EntranceY'] ) )/6; // 3.1
			else $top = ( 3000 + abs ( $val['EntranceY'] ) )/6; // 3.2

			$message = str_replace( '"' , "'" , $val["Message"] );

			switch ( $val["Klass"] ) { 

				case 0: {

					$klass = "Бургершот"; 
					$icon = "http://wiki.sa-mp.com/wroot/images2/0/0e/Icon_10.gif";

					if ( $param == 0 ) {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена за вход: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки продуктов: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Продуктов: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
					
					} else {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$val['name']}<br /><br />{$message}<br />Цена за вход: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки продуктов: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Продуктов: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";					
					
					}
					
				}
				break;
				case 1: {

					$klass = "Пиццерия"; 
					$icon = "http://wiki.sa-mp.com/wroot/images2/6/68/Icon_29.gif"; 

					if ( $param == 0 ) {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена за вход: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки продуктов: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Продуктов: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
					
					} else {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$val['name']}<br /><br />{$message}<br />Цена за вход: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки продуктов: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Продуктов: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";						
					
					}
					
				}
				break;
				case 2: {

					$klass = "Закусочная"; 
					$icon = "http://wiki.sa-mp.com/wroot/images2/3/3a/Icon_50.gif"; 

					if ( $param == 0 ) {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена за вход: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки продуктов: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Продуктов: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
					
					} else {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$val['name']}<br /><br />{$message}<br />Цена за вход: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки продуктов: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Продуктов: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";						
					
					}
					
				}
				break;
				case 3: {

					$klass = "Магазин"; 
					$icon = "http://wiki.sa-mp.com/wroot/images2/0/06/Icon_38.gif";

					if ( $param == 0 ) {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена за вход: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки продуктов: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Продуктов: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
					
					} else {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$val['name']}<br /><br />{$message}<br />Цена за вход: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки продуктов: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Продуктов: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";						
					
					}
					
				}
				break;
				case 4: {

					$klass = "Клуб"; 
					$icon = "http://wiki.sa-mp.com/wroot/images2/a/a4/Icon_49.gif"; 

					if ( $param == 0 ) {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена за вход: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки продуктов: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Продуктов: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
					
					} else {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$val['name']}<br /><br />{$message}<br />Цена за вход: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки продуктов: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Продуктов: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";						
					
					}
					
				}
				break;
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				case 10: {

					$klass = "Ферма"; 
					$icon = "http://wiki.sa-mp.com/wroot/images2/1/15/Icon_56.gif"; 

					if ( $param == 0 ) {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />За 1 ящик урожая: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки семян: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Семян на складе: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
					
					} else {
					
						if ( $val["Owned"] == -1 ) $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$message}<br />Цена: {$val["BuyPrice"]} <font color='green'>$</font><br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
						else $name .= "<div rel=\"tooltip\" data-placement=\"bottom\" data-original-title=\"<center>Бизнес - {$klass} - № {$val["ID"]}</center><br />{$val['name']}<br /><br />{$message}<br />За 1 ящик урожая: {$val["EntranceCost"]} <font color='green'>$</font><br />Цена закупки семян: {$val["EnterProdPrice"]} <font color='green'>$</font><br /> Семян на складе: {$val["Products"]} / {$val["MaxProducts"]}<br />Город: {$gorods}\" data-html=\"true\" style=\"position:absolute; top: {$top}px; left: {$left}px; background:url({$icon}); width:16px; height:16px;\"></div>";
					
					}
					
				}
				break;

			}

		}

		return $name . $house;

	}

	static public function online( $param ) {

		switch ( $param ) {

			case 0: $param = "<span class=\"label bg-color-red\">OFFLINE</span>"; break;
			case 1: $param = "<span class=\"label bg-color-green\">ONLINE</span>"; break;
			case 2: $param = "<span class=\"label bg-color-green\">ONLINE</span>"; break;
			//default: $param = "<span class=\"label bg-color-red\">OFFLINE</span>";

		}

		return $param;

	}

	static public function load() {

		$db = new db;
		$ferm = 0;
		$job1 = $db->super_query("SELECT COUNT(Job) as count FROM `members` WHERE `Job` = '1' AND `Online` = '1' LIMIT 1");
		$job2 = $db->super_query("SELECT COUNT(Job) as count FROM `members` WHERE `Job` = '2' AND `Online` = '1' LIMIT 1");
		$job3 = $db->super_query("SELECT COUNT(Job) as count FROM `members` WHERE `Job` = '3' AND `Online` = '1' LIMIT 1");
		$job4 = $db->super_query("SELECT COUNT(Job) as count FROM `members` WHERE `Job` = '4' AND `Online` = '1' LIMIT 1");
		$farm = $db->super_query("SELECT COUNT(Job) as count FROM `members` WHERE `Job` = '50' AND `Online` = '1' LIMIT 1");
		$farm2 = $db->super_query("SELECT COUNT(Job) as count FROM `members` WHERE `Job` = '72' AND `Online` = '1' LIMIT 1");
		$farm3 = $db->super_query("SELECT COUNT(Job) as count FROM `members` WHERE `Job` = '73' AND `Online` = '1' LIMIT 1");
		$farm4 = $db->super_query("SELECT COUNT(Job) as count FROM `members` WHERE `Job` = '74' AND `Online` = '1' LIMIT 1");
		$farm5 = $db->super_query("SELECT COUNT(Job) as count FROM `members` WHERE `Job` = '75' AND `Online` = '1' LIMIT 1");
		$farm6 = $db->super_query("SELECT COUNT(Job) as count FROM `members` WHERE `Job` = '79' AND `Online` = '1' LIMIT 1");

		$ferm = $farm['count']+$farm2['count']+$farm3['count']+$farm4['count']+$farm5['count']+$farm6['count'];

		$play = $db->super_query("SELECT COUNT(Online) as count FROM `members` WHERE `Online` = '1' LIMIT 1");

		return "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><table class=\"table table-responsive\"><tbody><tr><td>Игроков онлайн:</td><td><span class=\"label bg-color-green\">{$play["count"]}</span></td></tr><tr><td>Водителей автобуса:</td><td><span class=\"label bg-color-green\">{$job1['count']}</span></td></tr><tr><td>Дальнобойщиков:</td><td><span class=\"label bg-color-green\">{$job4['count']}</span></td></tr><tr><td>Механиков:</td><td><span class=\"label bg-color-green\">{$job3['count']}</span></td></tr><tr><td>Таксистов:</td><td><span class=\"label bg-color-green\">{$job2['count']}</span></td></tr><tr><td>Фермеров:</td><td><span class=\"label bg-color-green\">{$ferm}</span></td></tr><tr><td></td><td></td></tr></tbody></table></div>";

	}

	static public function age( $age ) {

		if ( ( $age >= 10 && $age < 20 ) || substr ( $age , -1 ) == 0 || substr ( $age , -1 ) >= 5 ) $return = " лет";
		elseif ( substr ( $age , -1 ) == 1 ) $return = " год";
		elseif ( substr ( $age , -1 ) > 1 ) $return = " года";
		return "$age $return";

	}

	static public function ip() {

		if ( isset( $_SERVER['HTTP_X_REAL_IP'] ) )
		return $_SERVER['HTTP_X_REAL_IP'];
		return $_SERVER['REMOTE_ADDR'];

	}

	/*
	use function
		other::times( $time )
	*/

	static public function times( $time ) {

		$month_name = array( 
			1 => "января",
			2 => "февраля",
			3 => "марта",
			4 => "апреля",
			5 => "мая",
			6 => "июня",
			7 => "июля",
			8 => "августа",
			9 => "сентября",
			10 => "октября",
			11 => "ноября",
			12 => "декабря"
		);

		$month = $month_name[ date( "n" , $time ) ];
		$day = date( "j" , $time );
		$year = date( "Y" , $time );
		$hour = date( "G" , $time );
		$min = date( "i" , $time );
		$date = $day . " " . $month . " " . $year . " г. в " . $hour . ":" . $min;
		$dif = time() - $time;

		if ( $dif < 59 ) return $dif . " сек. назад";
		elseif ( $dif/60 > 1 and $dif/60 < 59 ) return round( $dif/60 ) . " мин. назад";
		elseif ( $dif/3600 > 1 and $dif/3600 < 23 ) return round( $dif/3600 ) . " час. назад";
		else return $date;

	}

	static public function users( $groupid ) {

		$randomt = array(
			"id_asc",
			"id_desc"
		);
		$offsett = array (
			"0",
			"100"
		);

		$sizeof = count($randomt);
		$random = (rand()%$sizeof);

		$sizeofs = count($offsett);
		$offset = (rand()%$sizeofs);

		$uimg = "";

		$users = json_decode ( file_get_contents ( "http://api.vk.com/method/groups.getMembers?group_id={$groupid}&sort={$randomt[$random]}&offset={$offset}&count=72&fields=photo_50&v=5.26" ) , true );

		$user = (array)$users;

		$userr = $user["response"]["items"];

		for ( $i = 0; $i < 72; $i++ ) $uimg .= "<div class=\"superbox-list\"><a href=\"http://vk.com/id{$user["response"]["items"][$i]["id"]}\" target=\"_blank\"><img src=\"{$user["response"]["items"][$i]["photo_50"]}\" alt=\"{$user["response"]["items"][$i]["first_name"]} {$user["response"]["items"][$i]["last_name"]}\" title=\"{$user["response"]["items"][$i]["first_name"]} {$user["response"]["items"][$i]["last_name"]}\" class=\"superbox-img\"></a></div>";

		return $uimg;

	}

	/*
	use function API photos.get

		other::photosget( "ownerid", "albumid" )

	*/

	static public function photosget( $owner_id , $album_id ) {

		$images = "";

		$image = json_decode ( file_get_contents ( "http://api.vk.com/method/photos.get?owner_id={$owner_id}&album_id={$album_id}&rev=1&extended=0&v=5.26" ) , true );

		$img = (array)$image;

		$response = $img["response"]["items"];

		for ( $i = 0; $i < 8; $i++ ) $images .= "<div class=\"superbox-list\"><div class=\"thumbnail\" style=\"background: #000;\"><img src=\"{$response[$i]["photo_130"]}\" alt=\"{$response[$i]["text"]}\" title=\"{$response[$i]["text"]}\" class=\"superbox-img\"></div></div>";

		return $images;

	}

	/*
	use function API VK wall.get

		other::wallget( "groupid" , "postcount" )

	*/

/* 	static public function wallget( $groupid , $count = 3 ) {

		$message = "";
		$modal = "";
		$wallget = json_decode ( file_get_contents ( "http://api.vk.com/method/wall.get?domain={$groupid}&count={$count}&v=5.26" ) , true );
		$getById = json_decode ( file_get_contents ( "http://api.vk.com/method/groups.getById?group_id={$groupid}&fields=description&v=5.26" ) , true );

		$json = (array)$wallget;
		$img = (array)$getById;

		$api = $json["response"]["items"];
		$image = $img["response"];

		for ( $i = 0; $i < count ( $api ); $i++ ) {


		
			$text = preg_replace ( "/(^|[\n ])([\w]*?)((ht)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is" , "$1$2<a href=\"$3\" target=\"_blank\">$3</a>" , $api[$i]["text"] );
			$text = str_replace ( "\n","<br />" , $text );
			$text = str_replace ( "#RakNet_Group" , "<a href=\"http://vk.com/feed?section=search&q=%23RakNet_Group\" target=\"_blank\">#RakNet_Group</a>" , $text );
			$text = str_replace ( "#RakNet" , "<a href=\"http://vk.com/feed?section=search&q=%23RakNet\" target=\"_blank\">#RakNet</a>" , $text );
			$text = str_replace ( "#RakNet Group" , "<a href=\"http://vk.com/feed?q=%23RakNet&section=search\" target=\"_blank\">#RakNet Group</a>" , $text );

			if ( isset ( $api[$i]['is_pinned'] ) ) {

				if ( $api[$i]['is_pinned'] == 1 ) $pinned = "<button class=\"btn btn-danger\">Запись закреплена</button>";
				else $pinned = "";

			}

    		if ( isset ( $api[$i]["attachments"] ) ) {

				foreach ( $api[$i]["attachments"] as $attacment ) {

					switch( $attacment["type"] ) {

						case "photo": $modal = "<br /><img src=\"{$attacment["photo"]["photo_604"]}\" alt=\"\" title=\"\" align=\"center\">"; break;
						case "page": $modal .= "<br /><i class=\"fa fa-mail-forward\"></i> <font color=\"#777\">Страница</font> <a href=\"{$attacment["page"]["view_url"]}\">" . substr($image[0]["name"], 0,7) . "</a> <a class=\"btn btn-xs btn-primary\" href=\"{$attacment["page"]["view_url"]}\">Посмотреть</a>"; break;

					}

				}

			}

			$message .= "<li class=\"media\">
							<a class=\"pull-left\" href=\"javascript:void(0);\"> 
								<img class=\"media-object\" alt=\"64x64\" src=\"{$image[0]["photo_50"]}\"> 
							</a>
							<div class=\"media-body\">
								<h4 class=\"media-heading\"><a href=\"http://vk.com/raknet_official\">{$image[0]["name"]}</a></h4>
								<p>
									<font color=\"#4E4747\">{$text}</font>
									{$modal}
								</p>
								<br />
								<div align=\"left\">
									<span class=\"pull-right\">
										<a href=\"javascript:void(0);\" class=\"btn btn-success\">{$api[$i]["reposts"]["count"]} <i class=\"fa fa-mail-reply\"></i></a> 
										<a href=\"javascript:void(0);\" class=\"btn btn-success\">{$api[$i]["likes"]["count"]} <i class=\"fa fa-thumbs-up\"></i></a> 
										<a href=\"javascript:void(0);\" class=\"btn btn-success\">{$api[$i]["comments"]["count"]} <i class=\"fa fa-comments\"></i></a>
									</span>
								</div>
							</div>
						</li>
						<hr>";

		}

		return $message;

	} */

	static public function wallget( $groupid , $count = 3 ) {

		$message = "";

		$wallget = json_decode ( file_get_contents ( "http://api.vk.com/method/wall.get?domain={$groupid}&count={$count}&v=5.26" ) , true );
		$getById = json_decode ( file_get_contents ( "http://api.vk.com/method/groups.getById?group_id={$groupid}&fields=description&v=5.26" ) , true );

		$json = (array)$wallget;
		$img = (array)$getById;

		$api = $json["response"]["items"];
		$image = $img["response"];

		for ( $i = 0; $i < count ( $api ); $i++ ) {
		
			$text = preg_replace ( "/(^|[\n ])([\w]*?)((ht)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is" , "$1$2<a href=\"$3\" target=\"_blank\">$3</a>" , $api[$i]["text"] );
			$text = str_replace ( "\n","<br />" , $text );
			$text = str_replace ( "#RakNet_Group" , "<a href=\"http://vk.com/feed?section=search&q=%23RakNet_Group\" target=\"_blank\">#RakNet_Group</a>" , $text );
			$text = str_replace ( "#RakNet Group" , "<a href=\"http://vk.com/feed?q=%23RakNet&section=search\" target=\"_blank\">#RakNet Group</a>" , $text );
			
			$modal = preg_replace ( "/(^|[\n ])([\w]*?)((ht)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is" , "$1$2<a href=\"$3\" target=\"_blank\">$3</a>" , $api[$i]["text"] );
			$modal = str_replace ( "\n","<br />" , $modal );
			$modal = str_replace ( "#RakNet_Group" , "<a href=\"http://vk.com/feed?section=search&q=%23RakNet_Group\" target=\"_blank\">#RakNet_Group</a>" , $modal );
			$modal = str_replace ( "#RakNet Group" , "<a href=\"http://vk.com/feed?q=%23RakNet&section=search\" target=\"_blank\">#RakNet Group</a>" , $modal );

			$button = "";

    		if ( isset ( $api[$i]["attachments"] ) ) {

				foreach ( $api[$i]["attachments"] as $attacment ) {

					switch( $attacment["type"] ) {
						
						case "page": $button = "<a class=\"btn btn-primary\" href=\"{$attacment["page"]["view_url"]}\">Подробнее</a>"; break;
						default: $button = "<a class=\"btn btn-primary\" href=\"http://vk.com/raknet_official?w=wall{$api[$i]['owner_id']}_{$api[$i]['id']}\">Подробнее</a>";

					}

				}

			}

			$message .= "<li class=\"message\">
							<hr>
							<img src=\"{$image[0]["photo_50"]}\">
							<span class=\"message-text\"> 
								<a href=\"http://vk.com/raknet_official\" class=\"username\">{$image[0]["name"]}</a>
								<font color=\"#4E4747\">{$text}</font>
							</span>
							<hr>
							<div align=\"left\">
								<a href=\"#\" style=\"display: inline-block;\"></a> 
								{$button}
								<span class=\"pull-right\">
									<a href=\"javascript:void(0);\" class=\"btn btn-success\">{$api[$i]["reposts"]["count"]} <i class=\"fa fa-mail-reply\"></i></a> 
									<a href=\"javascript:void(0);\" class=\"btn btn-success\">{$api[$i]["likes"]["count"]} <i class=\"fa fa-thumbs-up\"></i></a> 
									<a href=\"javascript:void(0);\" class=\"btn btn-success\">{$api[$i]["comments"]["count"]} <i class=\"fa fa-comments\"></i></a>
								</span>
							</div>
						</li>";

		}

		return $message;

	}

	
}

class user extends other {

	static public function logged() {

		if ( isset ( $_SESSION['sname'] ) ) return true;

		else return false;

	}

	static public function password( $password ) {

		if ( $password == "" ) return -1;

		elseif ( strlen ( $password ) < 3 || strlen ( $password ) > 26 ) return -2;

		else {

			if ( !preg_match ( "/[^A-Za-z0-9.#\\-$]/" , $password ) ) return 1;

			return -3;

		}

	}

	static public function name( $name , $server ) {

		$db = new db;
		$name = $db->safesql ( stripslashes( htmlspecialchars( $name ) ) );
		$server = $db->safesql ( stripslashes( htmlspecialchars( $server ) ) );

		if ( $name != "" ) {

			if ( $server == 1 ) {

				$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
				$db->query ( "SET NAMES UTF8" );

				$result = $db->super_query ( "SELECT `name` FROM `members` WHERE `name` = '{$name}' LIMIT 1" );

				if ( $result != false ) return true;

				else return false;

			} /* elseif ( $server == 2 ) {

				$db->connect ( DBUSER1 , DBPASS1 , DBNAME1 , DBHOST1 );
				$db->query ( "SET NAMES UTF8" );

				$result = $db->super_query ( "SELECT `name` FROM `members` WHERE `name` = '{$name}' LIMIT 1" );

				if ( $result != false ) return true;

				else return false;

			} */

		}

	}

	static public function login( $name , $password , $server ) {

		$db = new db;
		$name = $db->safesql ( stripslashes( htmlspecialchars( $name ) ) );
		$password = $db->safesql ( stripslashes( htmlspecialchars( $password ) ) );
		$server = $db->safesql ( stripslashes( htmlspecialchars( $server ) ) );

		if ( $server == 1 ) {

			$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
			$db->query ( "SET NAMES UTF8" );

			$query = $db->super_query ( "SELECT `Admin`, `member_id`, `name`, `members_pass_hash`, `member_login_key`, `member_login_key_expire`, `members_pass_salt`, `Online` FROM `members` WHERE `name` = '{$name}' LIMIT 1" );

		} /* elseif ( $server == 2 ) {

			$db->connect ( DBUSER1 , DBPASS1 , DBNAME1 , DBHOST1 );
			$db->query ( "SET NAMES UTF8" );

			$query = $db->super_query ( "SELECT `Admin`, `member_id`, `name`, `members_pass_hash`, `member_login_key`, `member_login_key_expire`, `members_pass_salt` FROM `members` WHERE `name` = '{$name}' LIMIT 1" );

		} */

		if ( md5 ( md5 ( $query["members_pass_salt"] ) . md5 ( $password ) ) == $query['members_pass_hash'] ) {

			$db->safesql ( $_SESSION['uid'] = $query['member_id'] );
			$db->safesql ( $_SESSION['sname'] = $query['name'] );
			$db->safesql ( $_SESSION['stime'] = time()+3600 );
/* 			setcookie("member_id", $query["member_id"], time()+3600, "", ".raknet.ru");
			setcookie("pass_hash", $query["member_login_key"], $query["member_login_key_expire"], "", ".raknet.ru"); */

			if ( $server == 1 ) {

				$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
				$db->query ( "SET NAMES UTF8" );

				//if( $query['Online'] == 0) $db->query("UPDATE `members` SET `Online` = '1' WHERE `member_id` = '{$query['member_id']}'");
				
				if ( $query['Admin'] == 0 ) {
								
					$db->query ( "INSERT INTO `smember_log` 
									( 
										name , 
										userid , 
										browser , 
										ip , 
										time 
									) 
								VALUES 
									( 
										'{$name}' , 
										{$query['member_id']} , 
										'{$_SERVER['HTTP_USER_AGENT']}' , 
										'" . self::ip() . "' , 
										'" . time() . "' 
									)" 
								);

				}
				return true;

			}

		}

		else return false;

	}

	static public function frank( $member , $rank ) {

		switch ( $member ) {

			case 0: {

				switch ( $rank ) {

					case 0: $rank = "-"; break;
					default: $rank = "-";

				}
				break;

			}
			case 1:
			case 2:
			case 3: {

				switch ( $rank ) {

					case 1: $rank = "Стажёр"; break;
					case 2: $rank = "Водитель"; break;
					case 3: $rank = "Секретарь"; break;
					case 4: $rank = "Охранник"; break;
					case 5: $rank = "Телохранитель"; break;
					case 6: $rank = "Начальник охраны"; break;
					case 7: $rank = "Адвокат"; break;
					case 8: $rank = "Министр культуры"; break;
					case 9: $rank = "Министр финансов"; break;
					case 10: $rank = "Министр здравоохранения"; break;
					case 11: $rank = "Министр обороны"; break;
					case 12: $rank = "Заместитель Мэра"; break;
					case 13: $rank = "Мэр"; break;
					default: $rank = "Стажёр";

				}
				break;

			}
			case 4:
			case 5:
			case 6: {

				switch ( $rank ) {

					case 1: $rank = "Рядовой"; break;
					case 2: $rank = "Мл. сержант"; break;
					case 3: $rank = "Сержант"; break;
					case 4: $rank = "Ст. сержант"; break;
					case 5: $rank = "Старшина"; break;
					case 6: $rank = "Мл. прапорщик"; break;
					case 7: $rank = "Прапорщик"; break;
					case 8: $rank = "Мл. лейтенант"; break;
					case 9: $rank = "Лейтенант"; break;
					case 10: $rank = "Капитан"; break;
					case 11: $rank = "Майор"; break;
					case 12: $rank = "Подполковник"; break;
					case 13: $rank = "Полковник"; break;
					case 14: $rank = "Генерал"; break;
					default: $rank = "Рядовой";				
				}
				break;

			}
			case 7:
			case 8: {

				switch ( $rank ) {

					case 1: $rank = "Практикант"; break;
					case 2: $rank = "Стажёр"; break;
					case 3: $rank = "Интерн"; break;
					case 4: $rank = "Санитар"; break;
					case 5: $rank = "Педиатр"; break;
					case 6: $rank = "Хирург"; break;
					case 7: $rank = "Терапевт"; break;
					case 8: $rank = "Глав. врач"; break;
					default: $rank = "Практикант";

				}
				break;

			}
			case 9: {

				switch ( $rank ) {

					case 1: $rank = "Юнга"; break;
					case 2: $rank = "Матрос"; break;
					case 3: $rank = "Ст. Матрос"; break;
					case 4: $rank = "Главный старшина"; break;
					case 5: $rank = "Гл. корабельный старшина"; break;
					case 6: $rank = "Мичман"; break;
					case 7: $rank = "Ст. Мичман"; break;
					case 8: $rank = "Мл. Лейтенант"; break;
					case 9: $rank = "Лейтенант"; break;
					case 10: $rank = "Ст. Лейтенант"; break;
					case 11: $rank = "Капитан-Лейтенант"; break;
					case 12: $rank = "Капитан 3 ранга"; break;
					case 13: $rank = "Капитан 2 ранга"; break;
					case 14: $rank = "Капитан 1 ранга"; break;
					case 15: $rank = "Коммодор"; break;
					case 16: $rank = "Капитан-командор"; break;
					case 17: $rank = "Генерал-адмирал"; break;
					case 18: $rank = "Контр-адмирал"; break;
					case 19: $rank = "Вице-адмирал"; break;
					case 20: $rank = "Адмирал"; break;
					default: $rank = "Юнга";

				}
				break;

			}
			case 10: {

				switch ( $rank ) {

					case 1: $rank = "Новобранец"; break;
					case 2: $rank = "Рекрут"; break;
					case 3: $rank = "Солдат"; break;
					case 4: $rank = "Сержант"; break;
					case 5: $rank = "Комендор-Сержант"; break;
					case 6: $rank = "Уорент-офицер"; break;
					case 7: $rank = "Старший уорент-офицер"; break;
					case 8: $rank = "Квартирмейстер"; break;
					case 9: $rank = "Мл. Лейтенант"; break;
					case 10: $rank = "Лейтенант"; break;
					case 11: $rank = "Ст. Лейтенант"; break;
					case 12: $rank = "Капитан-Лейтенант"; break;
					case 13: $rank = "Капитан"; break;
					case 14: $rank = "Капитан разведки"; break;
					case 15: $rank = "Капитан спецназа"; break;
					case 16: $rank = "Майор"; break; 
					case 17: $rank = "Подполковник"; break; 
					case 18: $rank = "Полковник"; break;
					case 19: $rank = "Генерал"; break;
					case 20: $rank = "Маршал"; break;
					default: $rank = "Новобранец";

				}
				break;

			}
			case 11: {

				switch ( $rank ) {

					case 1: $rank = "Стажёр"; break;
					case 2: $rank = "Дежурный"; break;
					case 3: $rank = "Мл. Агент"; break;
					case 4: $rank = "Ст. Агент"; break;
					case 5: $rank = "Спец. Агент"; break;
					case 6: $rank = "Агент отдела DEA"; break;
					case 7: $rank = "Агент отдела CID"; break;
					case 8: $rank = "Глава отдела DEA"; break;
					case 9: $rank = "Глава отдела CID"; break;
					case 10: $rank = "Зам.Директора FBI"; break;
					case 11: $rank = "Директор FBI"; break;
					default: $rank = "Стажёр";

				}
				break;

			}
			case 12: {

				switch ( $rank ) {

					case 1: $rank = "Плэйя"; break;
					case 2: $rank = "Хастла"; break;
					case 3: $rank = "Килла"; break;
					case 4: $rank = "Юонг"; break;
					case 5: $rank = "Гангста"; break;
					case 6: $rank = "О.Г."; break;
					case 7: $rank = "Мобста"; break;
					case 8: $rank = "Де Кинг"; break;
					case 9: $rank = "Легенд"; break;
					case 10: $rank = "Мэд Дог"; break;
					default: $rank = "Плэйя";

				}
				break;

			}
			case 13: {

				switch ( $rank ) {

					case 1: $rank = "Блайд"; break;
					case 2: $rank = "Младший Нига"; break;
					case 3: $rank = "Крэкер"; break;
					case 4: $rank = "Гун брo"; break;
					case 5: $rank = "Ап Бро"; break;
					case 6: $rank = "Гангстер"; break;
					case 7: $rank = "Федерал Блок"; break;
					case 8: $rank = "Фолкс"; break;
					case 9: $rank = "Райч Нига"; break;
					case 10: $rank = "Биг Вилли"; break;
					default: $rank = "Блайд";

				}
				break;

			}
			case 14: {

				switch ( $rank ) {

					case 1: $rank = "Перро"; break;
					case 2: $rank = "Тирадор"; break;
					case 3: $rank = "Геттор"; break;
					case 4: $rank = "Лас Геррас"; break;
					case 5: $rank = "Мирандо"; break;
					case 6: $rank = "Сабио"; break;
					case 7: $rank = "Инвасор"; break;
					case 8: $rank = "Тесосеро"; break;
					case 9: $rank = "Нестро"; break;
					case 10: $rank = "Падре"; break;
					default: $rank = "Перро";

				}
				break;

			}
			case 15: {

				switch ( $rank ) {

					case 1: $rank = "Новато"; break;
					case 2: $rank = "Криминаль"; break;
					case 3: $rank = "Сольдадо"; break;
					case 4: $rank = "Эстимадо"; break;
					case 5: $rank = "Амиго"; break;
					case 6: $rank = "Асесино"; break;
					case 7: $rank = "Авторитарио"; break;
					case 8: $rank = "Асесор"; break;
					case 9: $rank = "Падрино"; break;
					case 10: $rank = "Падре"; break;
					default: $rank = "Новато";

				}
				break;

			}
			case 16: {

				switch ( $rank ) {

					case 1: $rank = "Новато"; break;
					case 2: $rank = "Ладрон"; break;
					case 3: $rank = "Амиго"; break;
					case 4: $rank = "Мачo"; break;
					case 5: $rank = "Джуниор"; break;
					case 6: $rank = "Эрмано"; break;
					case 7: $rank = "Бандидо"; break;
					case 8: $rank = "Ауторидад"; break;
					case 9: $rank = "Аджунто"; break;
					case 10: $rank = "Падре"; break;
					default: $rank = "Новато";

				}
				break;

			}
			case 17: {

				switch ( $rank ) {

					case 1: $rank = "Шнырь"; break;
					case 2: $rank = "Фраер"; break;
					case 3: $rank = "Вышибала"; break;
					case 4: $rank = "Жиган"; break;
					case 5: $rank = "Вор"; break;
					case 6: $rank = "Пахан"; break;
					case 7: $rank = "Дед"; break;
					case 8: $rank = "Смотрящий"; break;
					case 9: $rank = "Авторитет"; break;
					case 10: $rank = "Вор в законе"; break;
					default: $rank = "Шнырь";

				}
				break;

			}
			case 18: {

				switch ( $rank ) {

					case 1: $rank = "Новицио"; break;
					case 2: $rank = "Ассосиатоёр"; break;
					case 3: $rank = "Сомбаттенте"; break;
					case 4: $rank = "Солдато"; break;
					case 5: $rank = "Боец"; break;
					case 6: $rank = "Сотто-Капо"; break;
					case 7: $rank = "Капо"; break;
					case 8: $rank = "Младший Босс"; break;
					case 9: $rank = "Консильери"; break;
					case 10: $rank = "Дон"; break;
					default: $rank = "Новицио";

				}
				break;

			}
			case 19: {

				switch ( $rank ) {

					case 1: $rank = "Вакасю"; break;
					case 2: $rank = "Кёдай"; break;
					case 3: $rank = "Сятейгасира"; break;
					case 4: $rank = "Вакагасира"; break;
					case 5: $rank = "Со-хобунтё"; break;
					case 6: $rank = "Камбу"; break;
					case 7: $rank = "Оядзи"; break;
					case 8: $rank = "Cайко комон"; break;
					case 9: $rank = "Оябун-кобун"; break;
					case 10: $rank = "Кумите"; break;
					default: $rank = "Вакасю";

				}
				break;

			}
			case 20: {

				switch ( $rank ) {

					case 1: $rank = "Син сю"; break;
					case 2: $rank = "Тонг ши"; break;
					case 3: $rank = "Цо ши"; break;
					case 4: $rank = "Сей коу джай"; break;
					case 5: $rank = "Пак це син"; break;
					case 6: $rank = "Шо хай"; break;
					case 7: $rank = "Хунг кван"; break;
					case 8: $rank = "Синг фунг"; break;
					case 9: $rank = "Фу шан шу"; break;
					case 10: $rank = "Сан шу"; break;
					default: $rank = "Син сю";

				}
				break;

			}
			case 21: 
			case 22: {

				switch ( $rank ) {

					case 1: $rank = "Свободный наездник"; break;
					case 2: $rank = "Сторонник"; break;
					case 3: $rank = "Кочевник"; break;
					case 4: $rank = "Полноправный член клуба"; break;
					case 5: $rank = "Дорожный капитан"; break;
					case 6: $rank = "Курьер"; break;
					case 7: $rank = "Казначей"; break;
					case 8: $rank = "Зам. Президента клуба"; break;
					case 9: $rank = "Глава клуба"; break;
					default: $rank = "Свободный наездник";

				}
				break;
			}
			case 23: {
				
				switch( $rank ) {
					
					case 1: $rank = "Стажёр"; break;
					case 2: $rank = "Фотограф"; break;
					case 3: $rank = "Репортёр"; break;
					case 4: $rank = "Ведущий"; break;
					case 5: $rank = "Редактор"; break;
					case 6: $rank = "Гл. Редактор (Лидер)"; break;
					default: $rank = "Стажёр";
					
				}
				break;
				
			}

		}

		return $rank;

	}
	
	static public function rank( $member , $rank ) {

		switch ( $member ) {

			case 0: {

				switch ( $rank ) {

					case 0: $rank = "-"; break;
					default: $rank = "-";

				}
				break;

			}
			case 1:
			case 2:
			case 3: {

				switch ( $rank ) {

					case 1: $rank = "Стажёр"; break;
					case 2: $rank = "Водитель"; break;
					case 3: $rank = "Секретарь"; break;
					case 4: $rank = "Охранник"; break;
					case 5: $rank = "Телохранитель"; break;
					case 6: $rank = "Начальник охраны"; break;
					case 7: $rank = "Адвокат"; break;
					case 8: $rank = "Министр культуры"; break;
					case 9: $rank = "Министр финансов"; break;
					case 10: $rank = "Министр здравоохранения"; break;
					case 11: $rank = "Министр обороны"; break;
					case 12: $rank = "Заместитель Мэра"; break;
					case 13: $rank = "Мэр"; break;
					default: $rank = "Стажёр";

				}
				break;

			}
			case 4:
			case 5:
			case 6: {

				switch ( $rank ) {

					case 1: $rank = "Рядовой"; break;
					case 2: $rank = "Мл. сержант"; break;
					case 3: $rank = "Сержант"; break;
					case 4: $rank = "Ст. сержант"; break;
					case 5: $rank = "Старшина"; break;
					case 6: $rank = "Мл. прапорщик"; break;
					case 7: $rank = "Прапорщик"; break;
					case 8: $rank = "Мл. лейтенант"; break;
					case 9: $rank = "Лейтенант"; break;
					case 10: $rank = "Капитан"; break;
					case 11: $rank = "Майор"; break;
					case 12: $rank = "Подполковник"; break;
					case 13: $rank = "Полковник"; break;
					case 14: $rank = "Генерал"; break;
					default: $rank = "Рядовой";				
				}
				break;

			}
			case 7:
			case 8: {

				switch ( $rank ) {

					case 1: $rank = "Практикант"; break;
					case 2: $rank = "Стажёр"; break;
					case 3: $rank = "Интерн"; break;
					case 4: $rank = "Санитар"; break;
					case 5: $rank = "Педиатр"; break;
					case 6: $rank = "Хирург"; break;
					case 7: $rank = "Терапевт"; break;
					case 8: $rank = "Глав. врач"; break;
					default: $rank = "Практикант";

				}
				break;

			}
			case 9: {

				switch ( $rank ) {

					case 1: $rank = "Юнга"; break;
					case 2: $rank = "Матрос"; break;
					case 3: $rank = "Ст. Матрос"; break;
					case 4: $rank = "Главный старшина"; break;
					case 5: $rank = "Гл. корабельный старшина"; break;
					case 6: $rank = "Мичман"; break;
					case 7: $rank = "Ст. Мичман"; break;
					case 8: $rank = "Мл. Лейтенант"; break;
					case 9: $rank = "Лейтенант"; break;
					case 10: $rank = "Ст. Лейтенант"; break;
					case 11: $rank = "Капитан-Лейтенант"; break;
					case 12: $rank = "Капитан 3 ранга"; break;
					case 13: $rank = "Капитан 2 ранга"; break;
					case 14: $rank = "Капитан 1 ранга"; break;
					case 15: $rank = "Коммодор"; break;
					case 16: $rank = "Капитан-командор"; break;
					case 17: $rank = "Генерал-адмирал"; break;
					case 18: $rank = "Контр-адмирал"; break;
					case 19: $rank = "Вице-адмирал"; break;
					case 20: $rank = "Адмирал"; break;
					default: $rank = "Юнга";

				}
				break;

			}
			case 10: {

				switch ( $rank ) {

					case 1: $rank = "Новобранец"; break;
					case 2: $rank = "Рекрут"; break;
					case 3: $rank = "Солдат"; break;
					case 4: $rank = "Сержант"; break;
					case 5: $rank = "Комендор-Сержант"; break;
					case 6: $rank = "Уорент-офицер"; break;
					case 7: $rank = "Старший уорент-офицер"; break;
					case 8: $rank = "Квартирмейстер"; break;
					case 9: $rank = "Мл. Лейтенант"; break;
					case 10: $rank = "Лейтенант"; break;
					case 11: $rank = "Ст. Лейтенант"; break;
					case 12: $rank = "Капитан-Лейтенант"; break;
					case 13: $rank = "Капитан"; break;
					case 14: $rank = "Капитан разведки"; break;
					case 15: $rank = "Капитан спецназа"; break;
					case 16: $rank = "Майор"; break; 
					case 17: $rank = "Подполковник"; break; 
					case 18: $rank = "Полковник"; break;
					case 19: $rank = "Генерал"; break;
					case 20: $rank = "Маршал"; break;
					default: $rank = "Новобранец";

				}
				break;

			}
			case 11: {

				switch ( $rank ) {

					case 1: $rank = "<!--Стажёр-->"; break;
					case 2: $rank = "<!--Дежурный-->"; break;
					case 3: $rank = "<!--Мл. Агент-->"; break;
					case 4: $rank = "<!--Ст. Агент-->"; break;
					case 5: $rank = "<!--Спец. Агент-->"; break;
					case 6: $rank = "<!--Агент отдела DEA-->"; break;
					case 7: $rank = "<!--Агент отдела CID-->"; break;
					case 8: $rank = "<!--Глава отдела DEA-->"; break;
					case 9: $rank = "<!--Глава отдела CID-->"; break;
					case 10: $rank = "<!--Зам.Директора FBI-->"; break;
					case 11: $rank = "<!--Директор FBI-->"; break;
					default: $rank = "<!--Стажёр-->";

				}
				break;

			}
			case 12: {

				switch ( $rank ) {

					case 1: $rank = "Плэйя"; break;
					case 2: $rank = "Хастла"; break;
					case 3: $rank = "Килла"; break;
					case 4: $rank = "Юонг"; break;
					case 5: $rank = "Гангста"; break;
					case 6: $rank = "О.Г."; break;
					case 7: $rank = "Мобста"; break;
					case 8: $rank = "Де Кинг"; break;
					case 9: $rank = "Легенд"; break;
					case 10: $rank = "Мэд Дог"; break;
					default: $rank = "Плэйя";

				}
				break;

			}
			case 13: {

				switch ( $rank ) {

					case 1: $rank = "Блайд"; break;
					case 2: $rank = "Младший Нига"; break;
					case 3: $rank = "Крэкер"; break;
					case 4: $rank = "Гун брo"; break;
					case 5: $rank = "Ап Бро"; break;
					case 6: $rank = "Гангстер"; break;
					case 7: $rank = "Федерал Блок"; break;
					case 8: $rank = "Фолкс"; break;
					case 9: $rank = "Райч Нига"; break;
					case 10: $rank = "Биг Вилли"; break;
					default: $rank = "Блайд";

				}
				break;

			}
			case 14: {

				switch ( $rank ) {

					case 1: $rank = "Перро"; break;
					case 2: $rank = "Тирадор"; break;
					case 3: $rank = "Геттор"; break;
					case 4: $rank = "Лас Геррас"; break;
					case 5: $rank = "Мирандо"; break;
					case 6: $rank = "Сабио"; break;
					case 7: $rank = "Инвасор"; break;
					case 8: $rank = "Тесосеро"; break;
					case 9: $rank = "Нестро"; break;
					case 10: $rank = "Падре"; break;
					default: $rank = "Перро";

				}
				break;

			}
			case 15: {

				switch ( $rank ) {

					case 1: $rank = "Новато"; break;
					case 2: $rank = "Криминаль"; break;
					case 3: $rank = "Сольдадо"; break;
					case 4: $rank = "Эстимадо"; break;
					case 5: $rank = "Амиго"; break;
					case 6: $rank = "Асесино"; break;
					case 7: $rank = "Авторитарио"; break;
					case 8: $rank = "Асесор"; break;
					case 9: $rank = "Падрино"; break;
					case 10: $rank = "Падре"; break;
					default: $rank = "Новато";

				}
				break;

			}
			case 16: {

				switch ( $rank ) {

					case 1: $rank = "Новато"; break;
					case 2: $rank = "Ладрон"; break;
					case 3: $rank = "Амиго"; break;
					case 4: $rank = "Мачo"; break;
					case 5: $rank = "Джуниор"; break;
					case 6: $rank = "Эрмано"; break;
					case 7: $rank = "Бандидо"; break;
					case 8: $rank = "Ауторидад"; break;
					case 9: $rank = "Аджунто"; break;
					case 10: $rank = "Падре"; break;
					default: $rank = "Новато";

				}
				break;

			}
			case 17: {

				switch ( $rank ) {

					case 1: $rank = "Шнырь"; break;
					case 2: $rank = "Фраер"; break;
					case 3: $rank = "Вышибала"; break;
					case 4: $rank = "Жиган"; break;
					case 5: $rank = "Вор"; break;
					case 6: $rank = "Пахан"; break;
					case 7: $rank = "Дед"; break;
					case 8: $rank = "Смотрящий"; break;
					case 9: $rank = "Авторитет"; break;
					case 10: $rank = "Вор в законе"; break;
					default: $rank = "Шнырь";

				}
				break;

			}
			case 18: {

				switch ( $rank ) {

					case 1: $rank = "Новицио"; break;
					case 2: $rank = "Ассосиатоёр"; break;
					case 3: $rank = "Сомбаттенте"; break;
					case 4: $rank = "Солдато"; break;
					case 5: $rank = "Боец"; break;
					case 6: $rank = "Сотто-Капо"; break;
					case 7: $rank = "Капо"; break;
					case 8: $rank = "Младший Босс"; break;
					case 9: $rank = "Консильери"; break;
					case 10: $rank = "Дон"; break;
					default: $rank = "Новицио";

				}
				break;

			}
			case 19: {

				switch ( $rank ) {

					case 1: $rank = "Вакасю"; break;
					case 2: $rank = "Кёдай"; break;
					case 3: $rank = "Сятейгасира"; break;
					case 4: $rank = "Вакагасира"; break;
					case 5: $rank = "Со-хобунтё"; break;
					case 6: $rank = "Камбу"; break;
					case 7: $rank = "Оядзи"; break;
					case 8: $rank = "Cайко комон"; break;
					case 9: $rank = "Оябун-кобун"; break;
					case 10: $rank = "Кумите"; break;
					default: $rank = "Вакасю";

				}
				break;

			}
			case 20: {

				switch ( $rank ) {

					case 1: $rank = "Син сю"; break;
					case 2: $rank = "Тонг ши"; break;
					case 3: $rank = "Цо ши"; break;
					case 4: $rank = "Сей коу джай"; break;
					case 5: $rank = "Пак це син"; break;
					case 6: $rank = "Шо хай"; break;
					case 7: $rank = "Хунг кван"; break;
					case 8: $rank = "Синг фунг"; break;
					case 9: $rank = "Фу шан шу"; break;
					case 10: $rank = "Сан шу"; break;
					default: $rank = "Син сю";

				}
				break;

			}
			case 21: 
			case 22: {

				switch ( $rank ) {

					case 1: $rank = "Свободный наездник"; break;
					case 2: $rank = "Сторонник"; break;
					case 3: $rank = "Кочевник"; break;
					case 4: $rank = "Полноправный член клуба"; break;
					case 5: $rank = "Дорожный капитан"; break;
					case 6: $rank = "Курьер"; break;
					case 7: $rank = "Казначей"; break;
					case 8: $rank = "Зам. Президента клуба"; break;
					case 9: $rank = "Глава клуба"; break;
					default: $rank = "Свободный наездник";

				}
				break;
			}
			case 23: {
				
				switch( $rank ) {
					
					case 1: $rank = "Стажёр"; break;
					case 2: $rank = "Фотограф"; break;
					case 3: $rank = "Репортёр"; break;
					case 4: $rank = "Ведущий"; break;
					case 5: $rank = "Редактор"; break;
					case 6: $rank = "Гл. Редактор"; break;
					default: $rank = "Стажёр";
					
				}
				break;
				
			}

		}

		return $rank;

	}

	static public function fprofile( $param ) {

		switch( $param ) {

			case 0: $param = "-"; break;
			case 1: $param = "Мэрия Лос Сантоса"; break;
			case 2: $param = "Мэрия Сан Фиерро"; break;
			case 3: $param = "Мэрия Лас Вентурас"; break;
			case 4: $param = "Полицейский Департамент г. Лос Сантос"; break;
			case 5: $param = "Полицейский Департамент г. Cан Фиерро"; break;
			case 6: $param = "Полицейский Департамент г. Лас Вентурас"; break;
			case 7: $param = "Министерство здравоохранения г. Лос Сантос"; break;
			case 8: $param = "Министерство здравоохранения г. Сан Фиерро"; break;
			case 9: $param = "Военная база `Авианосец`"; break;
			case 10: $param = "Военная база `Зона 51`"; break;
			case 11: $param = "The Federal Bureau of Investigation"; break;
			case 12: $param = "Grove Street Gang"; break;
			case 13: $param = "The Ballas Gang"; break;
			case 14: $param = "Varios Los Aztecas Gang"; break;
			case 15: $param = "Los Santos Vagos Gang"; break;
			case 16: $param = "The Rifa Gang"; break;
			case 17: $param = "Русская мафия"; break;
			case 18: $param = "La Cosa Nostra"; break;
			case 19: $param = "Yakuza"; break;
			case 20: $param = "Triada"; break;
			case 21: $param = "Hells Angels"; break;
			case 22: $param = "Free Souls"; break;
			case 23: $param = "SA NEWS"; break;
			default: $param = "-";

		}

		return $param;

	}

	static public function fraction( $param ) {

		switch( $param ) {

			case 0: $param = "-"; break;
			case 1: $param = "Мэрия Лос Сантоса"; break;
			case 2: $param = "Мэрия Сан Фиерро"; break;
			case 3: $param = "Мэрия Лас Вентурас"; break;
			case 4: $param = "Полицейский Департамент г. Лос Сантос"; break;
			case 5: $param = "Полицейский Департамент г. Cан Фиерро"; break;
			case 6: $param = "Полицейский Департамент г. Лас Вентурас"; break;
			case 7: $param = "Министерство здравоохранения г. Лос Сантос"; break;
			case 8: $param = "Министерство здравоохранения г. Сан Фиерро"; break;
			case 9: $param = "Военная база `Авианосец`"; break;
			case 10: $param = "Военная база `Зона 51`"; break;
			case 11: $param = "-"; break;
			case 12: $param = "Grove Street Gang"; break;
			case 13: $param = "The Ballas Gang"; break;
			case 14: $param = "Varios Los Aztecas Gang"; break;
			case 15: $param = "Los Santos Vagos Gang"; break;
			case 16: $param = "The Rifa Gang"; break;
			case 17: $param = "Русская мафия"; break;
			case 18: $param = "La Cosa Nostra"; break;
			case 19: $param = "Yakuza"; break;
			case 20: $param = "Triada"; break;
			case 21: $param = "Hells Angels"; break;
			case 22: $param = "Free Souls"; break;
			case 23: $param = "SA NEWS"; break;
			default: $param = "-";

		}

		return $param;

	}

	static public function job( $param ) {

		switch( $param ) {

			case 0: $param = "Безработный"; break;
			case 1: $param = "Водитель автобуса"; break;
			case 2: $param = "Таксист"; break;
			case 3: $param = "Механик"; break;
			case 4: $param = "Дальнобойщик"; break;
			case 50:
			case 72:
			case 73:
			case 74:
			case 75:
			case 79: $param = "Фермер"; break;
			
			//default: $param = "Безработный";
			
		}

		return $param;

	}	

	static public function players( $pages = 1 ) {

		$db = new db;
		$player = "";
		$prevp = "";
		$ptwoleft = "";
		$poneleft = "";
		$poneright= "";
		$ptworight = "";
		$nextp = "";

		if ( $pages <= 0 ) $pages = 1;

		$users_on_page = "30";

		$count = $db->super_query("SELECT 
										COUNT(member_id) as count 
									FROM 
										`members` 
									WHERE 
										`Online` = '1' 
									LIMIT 1");

		$total = ceil ( $count['count']/$users_on_page );

		if ( !ctype_digit ( $pages ) or $pages > $total ) $pages = "1";

		$first = $pages*$users_on_page-$users_on_page; 

		$result = $db->query( "SELECT 
									`name`, 
									`Level`, 
									`Member`, 
									`Char`, 
									`Job`, 
									`Rank` 
								FROM 
									`members` 
								WHERE 
									`Online` = '1' 
								ORDER BY 
									`member_id` 
								ASC LIMIT {$first}, {$users_on_page}" );

		if ( $db->num_rows( $result ) > 0 ) {

			if ( $total > 1 ) {

				if ( ( $pages-2 ) > 0 ) $ptwoleft = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/monitoring&param=" . ( $pages-2 ) . "\">" . ( $pages-2 ) . "</a></li>";
				else $ptwoleft = null;

				#одна назад
				if ( ( $pages-1 ) > 0 ) {

					$poneleft = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/monitoring&param=" . ( $pages-1 ) . "\">" . ( $pages-1 ) . "</a></li>";
					$ptemp = ($pages-1);

				} else {

					$poneleft = null;
					$ptemp = null;

				}

				#две вперед
				if ( ( $pages+2 ) <= $total ) $ptworight="<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/monitoring&param=" . ( $pages+2 ) . "\">" . ( $pages+2 ) . "</a></li>";
				else $ptworight = null;

				#одна вперед
				if ( ( $pages+1 ) <= $total ) {

					$poneright = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/monitoring&param=" . ( $pages+1 ) . "\">" . ( $pages+1 ) . "</a></li>";
					$ptemp2 = ($pages+1);

				} else {

					$poneright = null;
					$ptemp2 = null;

				}

				# в начало
				if ( $pages != 1 && $ptemp != 1 && $ptemp != 2 ) $prevp = "<li id=\"datatable_tabletools_previous\" tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button previous\"><a href=\"" . APP_URL . "/monitoring&param=1\">В Начало</a></li>";
				else $prevp = null;

				#в конец (последняя)
				if ( $pages != $total && $ptemp2 != ( $total-1 ) && $ptemp2 != $total ) $nextp = "<li id=\"datatable_tabletools_ellipsis\" class=\"paginate_button disabled\" aria-controls=\"datatable_tabletools\" tabindex=\"0\"><a href=\"#\">…</a></li><li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/monitoring&param={$total}\">В Конец</a></li>";
				else $nextp = null;
			}
			while ( $user = $db->get_row( $result ) ) $player .= "<tr><td><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/avatars/{$user['Char']}.png\" width=\"35\"></td><td>{$user['name']}</td><td>" . user::job($user['Job']) . "</td><td>" . user::fraction( $user['Member'] ) . "</td><td>" . user::rank( $user['Member'], $user['Rank'] ) . "</td><td>{$user['Level']}</td></tr>";

		} else $player .= "<tr><td><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/avatars/0.png\" width=\"35\"></td><td>Нет игроков онлайн</td><td>Нет игроков онлайн</td><td>Нет игроков онлайн</td><td>Нет игроков онлайн</td><td>Нет игроков онлайн</td></tr>";

		return "<div class=\"row\"><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><div class=\"table-responsive\"><table class=\"table text-center\"><thead><tr><th><center></center></th><th><center>Имя игрока</center></th><th><center>Работа</center></th><th><center>Организация</center></th><th><center>Ранг</center></th><th><center>LVL</center></th></tr></thead><tbody>{$player}</tbody></table><div class=\"dt-toolbar-footer\"><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><div id=\"datatable_tabletools_paginate\" class=\"dataTables_paginate paging_simple_numbers\"><ul class=\"pagination pagination-sm\">{$prevp}{$ptwoleft}{$poneleft}  <li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button active\"><a href=\"#\">{$pages}</a></li>  {$poneright}{$ptworight}{$nextp}</ul></div></div></div></div></div></div>";

	}

	static public function frac( $param ) {

		$db = new db;
		$player = "";
		$result = $db->query("SELECT 
								`name`, 
								`Level`, 
								`Rank`, 
								`Char`, 
								`Online` 
							FROM 
								`members` 
							WHERE 
								`Member` = '{$param}'");
		while ( $user = $db->get_row( $result ) ) $player .= "<tr><td><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/avatars/{$user['Char']}.png\" width=\"35\"></td><td>{$user['name']}</td><td>" . user::rank( $user['Member'], $user['Rank'] ) . "</td><td>{$user['Level']}</td><td>" . other::online( $user["Online"] ) . "</td></tr>";
		
		return "<div class=\"row\"><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><div class=\"table-responsive\"><table id=\"dt_basic\" class=\"table text-center\"><thead><tr><th><center></center></th><th><center>Имя игрока</center></th><th><center>Ранг</center></th><th><center>LVL</center></th><th><center>Статус</center></th></tr></thead><tbody>{$player}</tbody></table></div></div></div>";

	}

	static public function objectid ( $objectid, $param, $params ) {
		
		$db = new db;
		$db->query("SET NAMES UTF8");
		$query = $db->super_query("SELECT * FROM `inventar` WHERE `id` = '{$objectid}' LIMIT 1");
		if ( $params == "user" ) {
			
			if ( $query['realobjekt'] == 19374 ) return "<a href=\"#\" class=\"links thumbnail col-xs-2 col-md-2\"><img  src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/shop/0.png\"></a>";
			else return "<a href=\"#{$params}{$param}\" class=\"links thumbnail col-xs-2 col-md-2\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/shop/{$query['realobjekt']}.png\"></a>";

		}
	}
	
	static public function objectuser ( $objectid, $param, $params ) {
		
		$db = new db;
		$db->query("SET NAMES UTF8");
		$query = $db->super_query("SELECT * FROM `inventar` WHERE `id` = '{$objectid}' LIMIT 1");
		if ( $params == "user" ) {
			
			if ( $query['realobjekt'] == 19374 ) return "<div class=\"bar\" id=\"\">Пусто</div>";
			else return "<div class=\"bar\" id=\"{$params}{$param}\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/shop/{$query['realobjekt']}.png\" width=\"50\"><br />{$query['descriptionobjekt']}</div>";

		}
		
	}

	static public function banlog( $pages = 1 ) {

		$db = new db;
		$player = "";
		$prevp = "";
		$ptwoleft = "";
		$poneleft = "";
		$poneright= "";
		$ptworight = "";
		$nextp = "";

		if ( $pages <= 0 ) $pages = 1;

		$users_on_page = "30";
		$db->query("SET NAMES UTF8");
		$count = $db->super_query("SELECT 
										COUNT(id) as count 
									FROM 
										`banlog`
									WHERE 
										`id` > '0'
									LIMIT 1");

		$total = ceil ( $count['count']/$users_on_page );

		if ( !ctype_digit ( $pages ) or $pages > $total ) $pages = "1";

		$first = $pages*$users_on_page-$users_on_page; 

		$result = $db->query( "SELECT 
									*
								FROM 
									`banlog`
								WHERE 
									`id` > '0' 
								ORDER BY 
									`id` 
								DESC LIMIT {$first}, {$users_on_page}" );

		if ( $db->num_rows( $result ) > 0 ) {

			if ( $total > 1 ) {

				if ( ( $pages-2 ) > 0 ) $ptwoleft = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/banlog&param=" . ( $pages-2 ) . "\">" . ( $pages-2 ) . "</a></li>";
				else $ptwoleft = null;

				#одна назад
				if ( ( $pages-1 ) > 0 ) {

					$poneleft = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/banlog&param=" . ( $pages-1 ) . "\">" . ( $pages-1 ) . "</a></li>";
					$ptemp = ($pages-1);

				} else {

					$poneleft = null;
					$ptemp = null;

				}

				#две вперед
				if ( ( $pages+2 ) <= $total ) $ptworight="<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/banlog&param=" . ( $pages+2 ) . "\">" . ( $pages+2 ) . "</a></li>";
				else $ptworight = null;

				#одна вперед
				if ( ( $pages+1 ) <= $total ) {

					$poneright = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/banlog&param=" . ( $pages+1 ) . "\">" . ( $pages+1 ) . "</a></li>";
					$ptemp2 = ($pages+1);

				} else {

					$poneright = null;
					$ptemp2 = null;

				}

				# в начало
				if ( $pages != 1 && $ptemp != 1 && $ptemp != 2 ) $prevp = "<li id=\"datatable_tabletools_previous\" tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button previous\"><a href=\"" . APP_URL . "/banlog&param=1\">В Начало</a></li>";
				else $prevp = null;

				#в конец (последняя)
				if ( $pages != $total && $ptemp2 != ( $total-1 ) && $ptemp2 != $total ) $nextp = "<li id=\"datatable_tabletools_ellipsis\" class=\"paginate_button disabled\" aria-controls=\"datatable_tabletools\" tabindex=\"0\"><a href=\"#\">…</a></li><li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/banlog&param={$total}\">В Конец</a></li>";
				else $nextp = null;
			}
			while ( $user = $db->get_row( $result ) ) {
				
				$aid = $db->super_query("SELECT `name` FROM `members` WHERE `member_id` = '{$user['aid']}' LIMIT 1");
				$tid = $db->super_query("SELECT `name` FROM `members` WHERE `member_id` = '{$user['tid']}' LIMIT 1");
				$player .= "<tr><td><center>{$user['id']}</center></td><td><center><a href=\"" . APP_URL . "/profuser&uid={$user['tid']}\" target=\"_blank\">{$tid['name']}</a></center></td><td><center>{$aid['name']}</center></td><td><center>" . date ( "d.m.Y в H:i" , $user['bdate'] ) . "</center></td><td><center>" . date ( "d.m.Y в H:i" , $user['udate'] ) . "</center></td><td><center>{$user['ip']}</center></td><td><center>{$user['reason']}</center></td></tr>";
				
			}
		} else $player .= "";

		return "<div class=\"row\">
					<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
						<div class=\"table-responsive\">
							<table class=\"table text-center\">
								<thead>
									<tr>
										<th><center>Номер блокировки</center></th>
										<th><center>Имя игрока</center></th>
										<th><center>Администратор</center></th>
										<th><center>Дата блокировки</center></th>
										<th><center>Дата разблокировки</center></th>
										<th><center>IP - Адрес</center></th>
										<th><center>Причина</center></th>
									</tr>
								</thead>
								<tbody>
									{$player}
								</tbody>
							</table>
							<div class=\"dt-toolbar-footer\">
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
									<div id=\"datatable_tabletools_paginate\" class=\"dataTables_paginate paging_simple_numbers\">
										<ul class=\"pagination pagination-sm\">
											{$prevp}{$ptwoleft}{$poneleft}  
											<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button active\"><a href=\"#\">{$pages}</a></li>  
											{$poneright}{$ptworight}{$nextp}
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>";

	}

	static public function databaseadmin( $pages = 1 ) {

		$db = new db;
		$player = "";
		$prevp = "";
		$ptwoleft = "";
		$poneleft = "";
		$poneright= "";
		$ptworight = "";
		$nextp = "";

		if ( $pages <= 0 ) $pages = 1;

		$users_on_page = "30";
		$db->query("SET NAMES UTF8");
		$count = $db->super_query("SELECT COUNT(id) as count FROM `police` WHERE `id` > '0' LIMIT 1");
		
		$total = ceil ( $count['count']/$users_on_page );

		if ( !ctype_digit ( $pages ) or $pages > $total ) $pages = "1";

		$first = $pages*$users_on_page-$users_on_page; 
		
		$result = $db->query( "SELECT * FROM `police` WHERE `id` > '0' ORDER BY `id` DESC LIMIT {$first}, {$users_on_page}" );
		
		if ( $db->num_rows( $result ) > 0 ) {
		
			if ( $total > 1 ) {

				if ( ( $pages-2 ) > 0 ) $ptwoleft = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/databaseadmin&params=" . ( $pages-2 ) . "\">" . ( $pages-2 ) . "</a></li>";
				else $ptwoleft = null;

				#одна назад
				if ( ( $pages-1 ) > 0 ) {
				
					$poneleft = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/databaseadmin&params=" . ( $pages-1 ) . "\">" . ( $pages-1 ) . "</a></li>";
					$ptemp = ($pages-1);
					
				} else {
				
					$poneleft = null;
					$ptemp = null;
					
				}

				#две вперед
				if ( ( $pages+2 ) <= $total ) $ptworight="<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/databaseadmin&params=" . ( $pages+2 ) . "\">" . ( $pages+2 ) . "</a></li>";
				else $ptworight = null;

				#одна вперед
				if ( ( $pages+1 ) <= $total ) {
				
					$poneright = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/databaseadmin&params=" . ( $pages+1 ) . "\">" . ( $pages+1 ) . "</a></li>";
					$ptemp2 = ($pages+1);
					
				} else {
				
					$poneright = null;
					$ptemp2 = null;
					
				}

				# в начало
				if ( $pages != 1 && $ptemp != 1 && $ptemp != 2 ) $prevp = "<li id=\"datatable_tabletools_previous\" tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button previous\"><a href=\"" . APP_URL . "/databaseadmin&params=1\">В Начало</a></li>";
				else $prevp = null;

				#в конец (последняя)
				if ( $pages != $total && $ptemp2 != ( $total-1 ) && $ptemp2 != $total ) $nextp = "<li id=\"datatable_tabletools_ellipsis\" class=\"paginate_button disabled\" aria-controls=\"datatable_tabletools\" tabindex=\"0\"><a href=\"#\">…</a></li><li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/databaseadmin&params={$total}\">В Конец</a></li>";
				else $nextp = null;
			}
			while ( $user = $db->get_row( $result ) ) {
			
				$players = $db->super_query("SELECT `name`, `member_id`, `Char` FROM `members` WHERE `member_id` = '{$user['userid']}' LIMIT 1");

				if ( $user['toid'] == -1 ) $name = "Информация получена с камер видеонаблюдения";
				else {
				
					$userid = $db->super_query("SELECT `name` FROM `members` WHERE `member_id` = '{$user['toid']}' LIMIT 1");
					$name = $userid['name'];
					
				}
				$date = mktime( date("H" , $user['date'] ), date("i", $user['date']), 0, date("m" , $user['date'])  , date("d" , $user['date']), date("Y" , $user['date'] )-20);
				switch ( $user['city'] ) {
				
					case 4: $city = "Полиция г. Los Santos"; break;
					case 5: $city = "Полиция г. San Fierro"; break;
					case 6: $city = "Полиция г. Las Venturas"; break;
					case 11: $city = "ФБР"; break;
					default: $city = "-";
					
				}
				$player .= "<tr><td><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/avatars/{$players['Char']}.png\" width=\"35\"></td><td><a href=\"" . APP_URL . "/databaseadmin&param={$players['member_id']}\" rel=\"tooltip\" data-placement=\"top\" data-original-title=\"Посмотреть досье {$players['name']}.\" data-html=\"true\">{$players['name']}</a></td><td>{$name}</td><td>{$city}</td><td>{$user['reason']}</td><td>{$user['value']}</td><td>" . date( "d.m.Y в H:i" , $date ) . "</td></tr>";
			}
			
		} else $player .= "";
		
		return "<div class=\"row\">
					<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
						<div class=\"table-responsive\">
							<table class=\"table text-center\">
								<thead>
									<tr>
										<th><center></center></th>
										<th><center>Имя преступника</center></th>
										<th><center>Офицер</center></th>
										<th><center>Подразделение</center></th>
										<th><center>Нарушение</center></th>
										<th><center>Ур. Розыска</center></th>
										<th><center>Дата</center></th>
									</tr>
								</thead>
								<tbody>
									{$player}
								</tbody>
							</table>
							<div class=\"dt-toolbar-footer\">
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
									<div id=\"datatable_tabletools_paginate\" class=\"dataTables_paginate paging_simple_numbers\">
										<ul class=\"pagination pagination-sm\">
											{$prevp}{$ptwoleft}{$poneleft}  
											<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button active\"><a href=\"#\">{$pages}</a></li>  
											{$poneright}{$ptworight}{$nextp}
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>";

	}
	
	static public function database( $pages = 1 ) {

		$db = new db;
		$player = "";
		$prevp = "";
		$ptwoleft = "";
		$poneleft = "";
		$poneright= "";
		$ptworight = "";
		$nextp = "";

		if ( $pages <= 0 ) $pages = 1;

		$users_on_page = "30";
		$db->query("SET NAMES UTF8");
		$count = $db->super_query("SELECT COUNT(member_id) as count FROM `members` WHERE `WantedPoints` > '0' LIMIT 1");
		
		$total = ceil ( $count['count']/$users_on_page );

		if ( !ctype_digit ( $pages ) or $pages > $total ) $pages = "1";

		$first = $pages*$users_on_page-$users_on_page; 
		
		$result = $db->query( "SELECT * FROM `members` WHERE `WantedPoints` > '0' ORDER BY `member_id` DESC LIMIT {$first}, {$users_on_page}" );
		
		if ( $db->num_rows( $result ) > 0 ) {
		
			if ( $total > 1 ) {

				if ( ( $pages-2 ) > 0 ) $ptwoleft = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/database&params=" . ( $pages-2 ) . "\">" . ( $pages-2 ) . "</a></li>";
				else $ptwoleft = null;

				#одна назад
				if ( ( $pages-1 ) > 0 ) {
				
					$poneleft = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/database&params=" . ( $pages-1 ) . "\">" . ( $pages-1 ) . "</a></li>";
					$ptemp = ($pages-1);
					
				} else {
				
					$poneleft = null;
					$ptemp = null;
					
				}

				#две вперед
				if ( ( $pages+2 ) <= $total ) $ptworight="<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/database&params=" . ( $pages+2 ) . "\">" . ( $pages+2 ) . "</a></li>";
				else $ptworight = null;

				#одна вперед
				if ( ( $pages+1 ) <= $total ) {
				
					$poneright = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/database&params=" . ( $pages+1 ) . "\">" . ( $pages+1 ) . "</a></li>";
					$ptemp2 = ($pages+1);
					
				} else {
				
					$poneright = null;
					$ptemp2 = null;
					
				}

				# в начало
				if ( $pages != 1 && $ptemp != 1 && $ptemp != 2 ) $prevp = "<li id=\"datatable_tabletools_previous\" tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button previous\"><a href=\"" . APP_URL . "/database&params=1\">В Начало</a></li>";
				else $prevp = null;

				#в конец (последняя)
				if ( $pages != $total && $ptemp2 != ( $total-1 ) && $ptemp2 != $total ) $nextp = "<li id=\"datatable_tabletools_ellipsis\" class=\"paginate_button disabled\" aria-controls=\"datatable_tabletools\" tabindex=\"0\"><a href=\"#\">…</a></li><li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/database&params={$total}\">В Конец</a></li>";
				else $nextp = null;
			}
			while( $user = $db->get_row($result)) {
				
				$edit = $db->super_query("SELECT `date` FROM `police` WHERE `userid` = '{$user['member_id']}' ORDER BY `id` DESC LIMIT 1");
				$date = mktime( date("H" , $edit['date'] ), date("i", $edit['date']), 0, date("m" , $edit['date'])  , date("d" , $edit['date']), date("Y" , $edit['date'] )-20);
				
				switch($user['WantedPoints']) {
					case 1: $image = "<img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\">"; break;
					case 2: $image = "<img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\">"; break;
					case 3: $image = "<img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\">"; break;
					case 4: $image = "<img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\">"; break;
					case 5: $image = "<img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\">"; break;
					case 6: $image = "<img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\"><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/police/1.png\">"; break;
				}
				$player .= "<tr>
								<td>
									<img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/avatars/{$user['Char']}.png\" width=\"35\">
								</td>
								<td>
									<a href=\"" . APP_URL . "/database&param={$user['member_id']}\" rel=\"tooltip\" data-placement=\"top\" data-original-title=\"Посмотреть досье {$user['name']}.\" data-html=\"true\">{$user['name']}</a>
								</td>
								<td>
									{$image}
								</td>
								<td>
									<a href=\"" . APP_URL . "/database&param={$user['member_id']}\" rel=\"tooltip\" data-placement=\"top\" data-original-title=\"Посмотреть досье {$user['name']}.\" data-html=\"true\">Посмотреть</a>
								</td>
								<td>
									" . date( "d.m.Y в H:i" , $date ) . "
								</td>
							</tr>";
							
				
			}
			/*while ( $user = $db->get_row( $result ) ) {
			
				$players = $db->super_query("SELECT `name`, `member_id`, `Char` FROM `members` WHERE `member_id` = '{$user['userid']}' LIMIT 1");

				if ( $user['toid'] == -1 ) $name = "Информация получена с камер видеонаблюдения";
				else {
				
					$userid = $db->super_query("SELECT `name` FROM `members` WHERE `member_id` = '{$user['toid']}' LIMIT 1");
					$name = $userid['name'];
					
				}
				$date = mktime( date("H" , $user['date'] ), date("i", $user['date']), 0, date("m" , $user['date'])  , date("d" , $user['date']), date("Y" , $user['date'] )-20);
				switch ( $user['city'] ) {
				
					case 4: $city = "Полиция г. Los Santos"; break;
					case 5: $city = "Полиция г. San Fierro"; break;
					case 6: $city = "Полиция г. Las Venturas"; break;
					case 11: $city = "ФБР"; break;
					default: $city = "-";
					
				}
				$player .= "<tr><td><img src=\"" . APP_URL . "/" . template_dir . "/" . template . "/img/avatars/{$players['Char']}.png\" width=\"35\"></td><td><a href=\"" . APP_URL . "/database&param={$players['member_id']}\" rel=\"tooltip\" data-placement=\"top\" data-original-title=\"Посмотреть досье {$players['name']}.\" data-html=\"true\">{$players['name']}</a></td><td>{$name}</td><td>{$city}</td><td>{$user['reason']}</td><td>{$user['value']}</td><td>" . date( "d.m.Y в H:i" , $date ) . "</td></tr>";
			}*/
			
		} else $player .= "";
		
		return "<div class=\"row\">
					<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
						<div class=\"table-responsive\">
							<table class=\"table text-center\">
								<thead>
									<tr>
										<th style=\"width: 3%\"></th>
										<th style=\"width: 20%\"><center>Имя преступника</center></th>
										<th><center>Уровень розыска</center></th>
										<th><center>Досье</center></th>
										<th><center>Дата редактирования</center></th>
									</tr>
								</thead>
								<tbody>
									{$player}
								</tbody>
							</table>
							<div class=\"dt-toolbar-footer\">
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
									<div id=\"datatable_tabletools_paginate\" class=\"dataTables_paginate paging_simple_numbers\">
										<ul class=\"pagination pagination-sm\">
											{$prevp}{$ptwoleft}{$poneleft}  
											<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button active\"><a href=\"#\">{$pages}</a></li>  
											{$poneright}{$ptworight}{$nextp}
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>";

	}

	static public function donatepoint( $pages = 1 ) {

		$db = new db;
		$player = "";
		$prevp = "";
		$ptwoleft = "";
		$poneleft = "";
		$poneright= "";
		$ptworight = "";
		$nextp = "";

		if ( $pages <= 0 ) $pages = 1;

		$users_on_page = "30";
		$db->query("SET NAMES UTF8");
		$count = $db->super_query("SELECT 
										COUNT(member_id) as count 
									FROM 
										`members`
									WHERE 
										`member_id` > '0'
									LIMIT 1");

		$total = ceil ( $count['count']/$users_on_page );

		if ( !ctype_digit ( $pages ) or $pages > $total ) $pages = "1";

		$first = $pages*$users_on_page-$users_on_page; 

		$result = $db->query( "SELECT 
									*
								FROM 
									`members`
								WHERE 
									`DonateMOther` >= '1' 
								ORDER BY 
									`DonateMOther` 
								DESC LIMIT {$first}, {$users_on_page}" );

		if ( $db->num_rows( $result ) > 0 ) {

			if ( $total > 1 ) {

				if ( ( $pages-2 ) > 0 ) $ptwoleft = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/donatepoint&param=" . ( $pages-2 ) . "\">" . ( $pages-2 ) . "</a></li>";
				else $ptwoleft = null;

				#одна назад
				if ( ( $pages-1 ) > 0 ) {

					$poneleft = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/donatepoint&param=" . ( $pages-1 ) . "\">" . ( $pages-1 ) . "</a></li>";
					$ptemp = ($pages-1);

				} else {

					$poneleft = null;
					$ptemp = null;

				}

				#две вперед
				if ( ( $pages+2 ) <= $total ) $ptworight="<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/donatepoint&param=" . ( $pages+2 ) . "\">" . ( $pages+2 ) . "</a></li>";
				else $ptworight = null;

				#одна вперед
				if ( ( $pages+1 ) <= $total ) {

					$poneright = "<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/donatepoint&param=" . ( $pages+1 ) . "\">" . ( $pages+1 ) . "</a></li>";
					$ptemp2 = ($pages+1);

				} else {

					$poneright = null;
					$ptemp2 = null;

				}

				# в начало
				if ( $pages != 1 && $ptemp != 1 && $ptemp != 2 ) $prevp = "<li id=\"datatable_tabletools_previous\" tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button previous\"><a href=\"" . APP_URL . "/donatepoint&param=1\">В Начало</a></li>";
				else $prevp = null;

				#в конец (последняя)
				if ( $pages != $total && $ptemp2 != ( $total-1 ) && $ptemp2 != $total ) $nextp = "<li id=\"datatable_tabletools_ellipsis\" class=\"paginate_button disabled\" aria-controls=\"datatable_tabletools\" tabindex=\"0\"><a href=\"#\">…</a></li><li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button\"><a href=\"" . APP_URL . "/donatepoint&param={$total}\">В Конец</a></li>";
				else $nextp = null;
			}
			while ( $user = $db->get_row( $result ) ) $player .= "<tr><td><center><a href=\"" . APP_URL . "/profuser&uid={$user['member_id']}\" target=\"_blank\">{$user['member_id']}</a></center></td><td><center>{$user['name']}</center></td><td><center>{$user['DonateMOther']}</center></td><td><center>{$user['Level']}</center></td></tr>";

		} else $player .= "";

		return "<div class=\"row\">
					<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
						<div class=\"table-responsive\">
							<table class=\"table text-center\">
								<thead>
									<tr>
										<th><center>Номер аккаунта</center></th>
										<th><center>Имя игрока</center></th>
										<th><center>Сумма</center></th>
										<th><center>Уровень</center></th>
									</tr>
								</thead>
								<tbody>
									{$player}
								</tbody>
							</table>
							<div class=\"dt-toolbar-footer\">
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
									<div id=\"datatable_tabletools_paginate\" class=\"dataTables_paginate paging_simple_numbers\">
										<ul class=\"pagination pagination-sm\">
											{$prevp}{$ptwoleft}{$poneleft}  
											<li tabindex=\"0\" aria-controls=\"datatable_tabletools\" class=\"paginate_button active\"><a href=\"#\">{$pages}</a></li>  
											{$poneright}{$ptworight}{$nextp}
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>";

	}
	
}