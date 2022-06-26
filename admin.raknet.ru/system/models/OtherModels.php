<?php
class Param
{
	static public function get_real_ip()
	{
		if ( isset( $_SERVER['HTTP_X_REAL_IP'] ) )
		return $_SERVER['HTTP_X_REAL_IP'];
		return $_SERVER['REMOTE_ADDR'];
	}
	
	static public function Online($param)
	{
		switch($param)
		{
			case 1: $param = "<button type=\"button\" class=\"btn btn-success\">ONLINE</button>"; break;
			default: $param = "<button type=\"button\" class=\"btn btn-danger\">OFFLINE</button>";
		}
		return $param;
	}
	
	static public function gender($param)
	{
		if($param == 0) return "Женский";
		else return "Мужской";
	}
	
	static public function queryparam()
	{
		return array (
			"`A`.`Admin` as Admins",
			"`A`.`member_id`",
			"`A`.`name`",
			"`A`.`email`",
			"`A`.`BanTime`",
			"`A`.`DonateMREAL`",
			"`A`.`DonateRank`",
			"`A`.`DonateMOther`",
			"`A`.`Cash`",
			"`A`.`Bank`",
			"`A`.`Char`",
			"`A`.`S_DesertEagle`",
			"`A`.`S_AK47`",
			"`A`.`S_M4`",
			"`A`.`S_MP5`",
			"`A`.`S_ShotGun`",
			"`A`.`Level`",
			"`A`.`Italy`",
			"`A`.`Ispan`",
			"`A`.`Japan`",
			"`A`.`Russia`",
			"`A`.`Nemec`",
			"`A`.`CarLic`",
			"`A`.`Exp`",
			"`A`.`Sex`",
			"`A`.`Job`",
			"`A`.`Pnumber`",
			"`A`.`Mobile`",
			"`A`.`Member`",
			"`A`.`Rank`",
			"`A`.`Online`",
			"`A`.`P0`",
			"`A`.`P1`",
			"`A`.`P2`",
			"`A`.`P3`",
			"`A`.`P4`",
			"`A`.`P5`",
			"`A`.`P6`",
			"`A`.`P7`",
			"`A`.`P8`",
			"`A`.`P9`",
			"`A`.`P10`",
			"`A`.`P11`",
			"`A`.`P12`",
			"`A`.`P13`",
			"`A`.`P14`",
			"`A`.`P15`",
			"`A`.`P16`",
			"`A`.`P17`",
			"`A`.`P18`",
			"`A`.`P19`",
			"`A`.`P20`",
			"`A`.`P21`",
			"`A`.`P22`",
			"`A`.`P23`",
			"`A`.`P24`",
			"`A`.`P25`",
			"`A`.`P26`",
			"`A`.`P27`",
			"`A`.`P28`",
			"`A`.`P29`",
			"`A`.`P30`",
			"`A`.`P31`",
			"`A`.`P32`",
			"`A`.`P33`",
			"`A`.`P34`",
			"`A`.`P35`",
			"`A`.`P36`",
			"`A`.`P37`",
			"`A`.`P38`",
			"`A`.`P39`",
			"`A`.`P40`",
			"`A`.`P41`",
			"`A`.`P42`",
			"`A`.`P43`",
			"`A`.`P44`",
			"`A`.`P45`",
			"`A`.`P46`",
			"`A`.`P47`",
			"`A`.`code`",
			"`A`.`date`",
			"`B`.`C0`",
			"`B`.`C1`",
			"`B`.`C2`",
			"`B`.`C3`",
			"`B`.`C4`",
			"`B`.`C5`",
			"`B`.`C6`",
			"`B`.`C7`",
			"`B`.`C8`",
			"`B`.`C9`",
			"`B`.`C10`",
			"`B`.`C11`",
			"`B`.`C12`",
			"`B`.`C13`",
			"`B`.`C14`",
			"`B`.`C15`",
			"`B`.`C16`",
			"`B`.`C17`",
			"`B`.`C18`",
			"`B`.`C19`",
			"`B`.`C20`",
			"`B`.`C21`",
			"`B`.`C22`",
			"`B`.`C23`",
			"`B`.`C24`",
			"`B`.`C25`",
			"`B`.`C26`",
			"`B`.`C27`",
			"`B`.`C28`",
			"`B`.`C29`",
			"`B`.`C30`",
			"`B`.`C31`",
			"`B`.`C32`",
			"`B`.`C33`",
			"`B`.`C34`",
			"`B`.`C35`",
			"`B`.`C36`",
			"`B`.`C37`",
			"`B`.`C38`",
			"`B`.`C39`",
			"`B`.`C40`",
			"`B`.`C41`",
			"`B`.`C42`",
			"`B`.`C43`",
			"`B`.`C44`",
			"`B`.`C45`",
			"`B`.`C46`",
			"`B`.`Model`",
			"`B`.`C47`",
			"`D`.`ID` as HID",
			"`D`.`Owned` as HOwned",
			"`D`.`H0`",
			"`D`.`H1`",
			"`D`.`H2`",
			"`D`.`H3`",
			"`D`.`H4`",
			"`D`.`H5`",
			"`D`.`H6`",
			"`D`.`H7`",
			"`D`.`H8`",
			"`D`.`H9`",
			"`D`.`H10`",
			"`D`.`H11`",
			"`D`.`H12`",
			"`D`.`H13`",
			"`D`.`H14`",
			"`D`.`H15`",
			"`D`.`H16`",
			"`D`.`H17`",
			"`D`.`H18`",
			"`D`.`H19`",
			"`D`.`H20`",
			"`D`.`H21`",
			"`D`.`H22`",
			"`D`.`H23`",
			"`D`.`H24`",
			"`D`.`H25`",
			"`D`.`H26`",
			"`D`.`H27`",
			"`D`.`H28`",
			"`D`.`H29`",
			"`D`.`H30`",
			"`D`.`H31`",
			"`D`.`H32`",
			"`D`.`H33`",
			"`D`.`H34`",
			"`D`.`H35`",
			"`D`.`H36`",
			"`D`.`H37`",
			"`D`.`H38`",
			"`D`.`H39`",
			"`D`.`H40`",
			"`D`.`H41`",
			"`D`.`H42`",
			"`D`.`H43`",
			"`D`.`H44`",
			"`D`.`H45`",
			"`D`.`H46`",
			"`D`.`H47`",
			"`C`.`Owned` as COwned",
			"`C`.`Cash` as CCash",
			"`C`.`Message` as CMESSAGE",
			"`E`.`Message` as EMESSAGE",
			"`E`.`id` as EID",
			"`E`.`Owned` as EOwned",
			"`E`.`Cash` as ECash"
		);
	}
	static public function job($param) 
	{
		switch($param) 
		{
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
		}
		return $param;
	}
	static public function frac($param, $params) 
	{
		switch($param) 
		{
			case 0: $param = "-"; break;
			case 1: $param = "Мэрия Лос Сантоса"; break;
			case 2: $param = "Мэрия Сан Фиерро"; break;
			case 3: $param = "Мэрия Лас Вентурас"; break;
			case 4: $param = "LSPD"; break;
			case 5: $param = "SFPD"; break;
			case 6: $param = "LVPD"; break;
			case 7: $param = "ЦБЛС"; break;
			case 8: $param = "ЦБСФ"; break;
			case 9: $param = "Армия `Авианосец`"; break;
			case 10: $param = "Армия `Зона 51`"; break;
			case 11: 
			{
				if($params == 1) $param = "FBI";
				else $param = "-";
			}
			break;
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
	
	static public function rank($member, $rank, $param) 
	{
		switch($member) 
		{
			case 0: 
			{
				switch($rank) 
				{
					case 0: $rank = "-"; break;
					default: $rank = "-";
				}
				break;
			}
			case 1:
			case 2:
			case 3: 
			{
				switch($rank) 
				{
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
			case 6: 
			{
				switch($rank)
				{
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
			case 8: 
			{
				switch($rank) 
				{
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
			case 9:
			{
				switch($rank) 
				{
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
			case 10: 
			{
				switch($rank) 
				{
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
			case 11: 
			{
				if($param == 1)
				{
					switch($rank) 
					{
						case 1: $rank = "-"; break;
						case 2: $rank = "-"; break;
						case 3: $rank = "-"; break;
						case 4: $rank = "-"; break;
						case 5: $rank = "-"; break;
						case 6: $rank = "-"; break;
						case 7: $rank = "-"; break;
						case 8: $rank = "-"; break;
						case 9: $rank = "-"; break;
						case 10: $rank = "-"; break;
						case 11: $rank = "-"; break;
						default: $rank = "-";
					}
					break;
				}
				else
				{
					switch($rank) 
					{
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
			}
			case 12: 
			{
				switch($rank) 
				{
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
			case 13: 
			{
				switch($rank) 
				{
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
			case 14: 
			{
				switch($rank) 
				{
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
			case 15: 
			{
				switch($rank) 
				{
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
			case 16: 
			{
				switch($rank) 
				{
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
			case 17: 
			{
				switch ($rank)
				{
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
			case 18: 
			{
				switch($rank) 
				{
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
			case 19: 
			{
				switch($rank) 
				{
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
			case 20: 
			{
				switch($rank) 
				{
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
			case 22: 
			{
				switch($rank) 
				{
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
			case 23: 
			{
				switch($rank) 
				{
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
}