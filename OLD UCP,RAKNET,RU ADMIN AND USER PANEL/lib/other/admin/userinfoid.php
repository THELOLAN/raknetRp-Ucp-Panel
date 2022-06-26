<?php
session_start();
error_reporting ( 0 );
ini_set( 'display_errors', 0 );
define ( 'CRAZY_STR' , true );
$admins = isset ( $_SESSION["admins"] ) ? $_SESSION["admins"] : null;
if ( $admins == 1 ) {

	require_once ( "../../init.php" );
	require_once ( "../../classes/mysql.class.php" );
	require_once ( "../../classes/func.global.php" );
	
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
	if($currentlang == "") require_once ( "../../language/ru.php" );
	else require_once ( "../../language/{$currentlang}.php" );
	
	//require_once ( "../../language/ru.php" );
	require_once ( "../../config/queryparam.php" );
	require_once ( "../../vehicle.php" );
	$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
	$db->query ( "SET NAMES UTF8" );

	$vtext = "";
	$htext = "";
	$biz = "";
	$azs = "";
	
	$userid = isset ( $_POST['userid'] ) ? $_POST['userid'] : null;
	$userid = (int)$userid;

			$tables = $db->super_query("SELECT
											" . implode ( "," , $queryparam ) . "
										FROM
											`members` as A
										LEFT JOIN 
											`vehicles_player` as B
										ON
											( `B`.`Owned` = `A`.`member_id` )
										LEFT JOIN
											`bizzes` as C
										ON
											( `C`.`Owned` = `A`.`member_id` )
										LEFT JOIN
											`house` as D
										ON
											( `D`.`Owned` = `A`.`member_id` )
										LEFT JOIN
											`bizzes_zapravki` as E
										ON
											( `E`.`Owned` = `A`.`member_id` )
										WHERE
											`A`.`member_id` = '{$userid}'
										LIMIT 1");
			/*LOGS*/

			$loginlog = "";
			$namelog = "";
			$banlog = "";
			$veh = "";
			$hinventory = "";
			$inventory = "";
			$login = $db->query("SELECT * FROM `smember_log` WHERE `userid` = '{$tables['member_id']}' ORDER BY `id` DESC");
			while ( $log = $db->get_row( $login ) ) $loginlog .= "<tr><td>{$log['id']}</td><td>{$log['name']}</td><td>{$log['userid']}</td><td>{$log['browser']}</td><td>{$log['ip']}</td><td>" . date( "d.m.Y в H:i" , $log['time'] ) . "</td></tr>";

			$names = $db->query("SELECT * FROM `name` WHERE `userid` = '{$tables['member_id']}' ORDER BY `id` DESC");
			while ( $namlog = $db->get_row( $names ) ) $namelog .= "<tr><td>{$namlog['id']}</td><td>{$namlog['userid']}</td><td>{$namlog['Newname']}</td><td>{$namlog['Oldname']}</td><td>{$namlog['Email']}</td><td>" . date( "d.m.Y в H:i" , $namlog['vremya'] ) . "</td></tr>";

			$block = $db->query("SELECT * FROM `banlog` WHERE `tid` = '{$tables['member_id']}' ORDER BY `id` DESC");
			while ( $blocks = $db->get_row( $block ) ) {

				$adminnames = $db->super_query("SELECT `name` FROM `members` WHERE `member_id` = '{$blocks['aid']}' LIMIT 1");
				$banlog .= "<tr>
								<td>{$blocks['id']}</td>
								<td>{$tables['name']}</td>
								<td>{$adminnames['name']}</td>
								<td>" . date ( "d.m.Y в H:i" , $blocks['bdate'] ) . "</td>
								<td>" . date ( "d.m.Y в H:i" , $blocks['udate'] ) . "</td>
								<td>{$blocks['ip']}</td>
								<td>{$blocks['reason']}</td>
							</tr>";

			}

			/*end logs*/
			$nxtlevel = $tables['Level']+1;
			$expamount = $nxtlevel*4;

			if ( !$tables["Model"] ) {

				$veh = "";
				$car = "";
				$cartext = "";

			} else {

				$car = "<center>
							<img src=\"{$url}/{$dir}/{$template}/img/cars/{$tables['Model']}.png\" width=\"100%\" rel=\"tooltip\" data-placement=\"bottom\" 
							data-original-title=\"{$lang['page']['profile']['auto']}: {$vehicles[$tables['Model']]}<br />
													{$lang['page']['profile']['typeauto']}: {$vehicletype[$tables['Model']]}\" data-html=\"true\">
						</center>";
				$cartext = "<tr>
								<td><b>{$lang['page']['profile']['auto']}:</b></td>
								<td><b>{$vehicles[$tables['Model']]}({$tables['Model']})</b></td>
							</tr>";

				for ( $i = 0; $i < 48; $i++ ) $veh .= user::objectid ( $tables["C{$i}"], $i, "user" );
			
			}

			if ( $tables["HOwned"] != $tables['member_id'] ) $house = "";
			else {

				for ( $i = 0; $i < 48; $i++ ) $hinventory .= user::objectid ( $tables["H{$i}"], $i, "user" );
				$house = "<tr><td><b>{$lang['page']['profile']['house']}:</b></td><td><b>№{$tables["HID"]}</b></td></tr>";

			}
			
			if ( $tables["EOwned"] != $tables['member_id'] ) $sbiz = "";
			else $sbiz = "<tr><td><b>{$lang['page']['profile']['azs']}:</b></td><td><b>{$tables["EMESSAGE"]} / <font color=\"green\">$</font>{$tables['ECash']}</b></td></tr>";

			if ( $tables["COwned"] != $tables['member_id'] ) $biz = "";
			else $biz = "<tr><td><b>{$lang['page']['profile']['biz']}:</b></td><td><b>{$tables["CMESSAGE"]} / <font color=\"green\">$</font>{$tables['CCash']}</b></td></tr>";
			
			if ( $tables['Italy'] == 5000 ) $Italy = "<tr><td><b>{$lang['page']['profile']['Italy']}:</b></td><td><b>Владеет</b></td></tr>";
			else $Italy = "<tr><td><b>{$lang['page']['profile']['Italy']}:</b></td><td><b>Не владеет</b></td></tr>";
			
			if ( $tables['Ispan'] == 5000 ) $Ispan = "<tr><td><b>{$lang['page']['profile']['Ispan']}:</b></td><td><b>Владеет</b></td></tr>";
			else $Ispan = "<tr><td><b>{$lang['page']['profile']['Ispan']}:</b></td><td><b>Не владеет</b></td></tr>";
			
			if ( $tables['Japan'] == 5000 ) $Japan = "<tr><td><b>{$lang['page']['profile']['Japan']}:</b></td><td><b>Владеет</b></td></tr>";
			else $Japan = "<tr><td><b>{$lang['page']['profile']['Japan']}:</b></td><td><b>Не владеет</b></td></tr>";
			
			if ( $tables['Russia'] == 5000 ) $Russia = "<tr><td><b>{$lang['page']['profile']['Russia']}:</b></td><td><b>Владеет</b></td></tr>";
			else $Russia = "<tr><td><b>{$lang['page']['profile']['Russia']}:</b></td><td><b>Не владеет</b></td></tr>";
			
			if ( $tables['Nemec'] == 5000 ) $Nemec = "<tr><td><b>{$lang['page']['profile']['Nemec']}:</b></td><td><b>Владеет</b></td></tr>";
			else $Nemec = "<tr><td><b>{$lang['page']['profile']['Nemec']}:</b></td><td><b>Не владеет</b></td></tr>";
			
			if ( $tables['CarLic'] == 1 ) $CarLic = "<tr><td><b>{$lang['page']['profile']['CarLic']}:</b></td><td><b>Имеется</b></td></tr>";
			else $CarLic = "<tr><td><b>{$lang['page']['profile']['CarLic']}:</b></td><td><b>Не имеется</b></td></tr>";

			for ( $i = 0; $i < 48; $i++ ) $inventory .= user::objectid ( $tables["P{$i}"], $i, "user" );
			
			//$obshee = $tables['date']/3600;
			
			echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">{$endbantime}</div>
				<ul id=\"myTabs\" class=\"nav nav-tabs\">
					<li class=\"active\">
						<a href=\"#a1{$userid}\" data-toggle=\"tab\"> Игрок</a>
					</li>
					<li>
						<a href=\"#a2{$userid}\" data-toggle=\"tab\"> История авторизаций</a>
					</li>
					<li>
						<a href=\"#a3{$userid}\" data-toggle=\"tab\"> История имён</a>
					</li>
					<li>
						<a href=\"#a4{$userid}\" data-toggle=\"tab\"> История блокировок</a>
					</li>
				</ul>
				<div id=\"myTabContents\" class=\"tab-content\">
					<div class=\"tab-pane fade in active\" id=\"a1{$userid}\">
						<div class=\"row\">
							<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
								<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-0\">
									<center><img src=\"{$url}/{$dir}/{$template}/img/avatars/{$tables['Char']}.png\" rel=\"tooltip\" data-placement=\"top\" data-original-title=\"{$sname}<br />\" data-html=\"true\"></center>
									<br />
									{$car}
								</div>
							</div>
							<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
								<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-1\">
									<table class=\"table-responsive table\" style=\"font-size: 14px;\">
										<tbody>
											<tr>
												<td><b>{$lang['page']['profile']['name']}:</b></td>
												<td><b>{$tables['name']}</b></td>
											</tr>
											<tr>
												<td><b>{$lang['page']['profile']['level']}:</b></td>
												<td><b>{$tables['Level']}</b></td>
											</tr>
											<tr>
												<td><b>{$lang['page']['profile']['exp']}:</b></td>
												<td><b>{$tables['Exp']}/{$expamount}</b></td>
											</tr>
											<tr>
												<td><b>{$lang['page']['profile']['sex']}:</b></td>
												<td><b>{$sex[$tables['Sex']]}</b></td>
											</tr>
											<tr>
												<td><b><a href=\"{$url}/profile&param=1\">{$lang['page']['profile']['allrub']}:</a></b></td>
												<td><b><a href=\"{$url}/profile&param=1\">{$tables["DonateMOther"]}</a> руб.</b></td>
											</tr>															
											<tr>
												<td><b>{$lang['page']['profile']['vip']}:</b></td>
												<td><b>" . other::VIP( $tables['DonateRank'] ) . "</b></td>
											</tr>
											<tr>
												<td><b>{$lang['page']['profile']['id']}:</b></td>
												<td><b>#{$tables['member_id']}</b></td>
											</tr>
											<tr>
												<td><b>{$lang['page']['profile']['job']}:</b></td>
												<td><b>" . user::job( $tables['Job'] ) . "</b></td>
											</tr>
											<tr>
												<td><b>{$lang['page']['profile']['member']}:</b></td>
												<td><b>" . user::fprofile( $tables['Member'] ) . "</b></td>
											</tr>
											<tr>
												<td><b>{$lang['page']['profile']['rank']}:</b></td>
												<td><b>" . user::frank( $tables['Member'], $tables['Rank'] ) . "</b></td>
											</tr>
											<tr>
												<td><b>{$lang['page']['profile']['cash']}:</b></td>
												<td><b>" . number_format ( $tables['Cash'] ) . "<font color=\"green\">$</font></b></td>
											</tr>
											<tr>
												<td><b>{$lang['page']['profile']['bank']}:</b></td>
												<td><b>" . number_format ( $tables['Bank'] ) . "<font color=\"green\">$</font></b></td>
											</tr>
											{$house}
											{$cartext}
											{$CarLic}
											{$sbiz}
											{$biz}
											<tr>
												<td><b>{$lang['page']['profile']["number"]}:</b></td>
												<td><b>{$tables['Pnumber']}</b></td>
											</tr>
											<tr>
												<td><b>{$lang['page']['profile']["balance"]}:</b></td>
												<td><b>" . number_format ( $tables['Mobile'] ) . "<font color=\"green\">$</font></b></td>
											</tr>
											<tr>
												<td>
												</td>
												<td>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<table class=\"table\">
								<tr>
									<td>
									</td>
								</tr>
							</table>
							<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
								<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-2\">
									<table class=\"table-responsive table\" style=\"font-size: 14px;\">
										<tbody>
											<tr>
												<td>
													<h4>{$lang['page']['profile']["language"]}</h4>
												</td>
												<td>
												</td>
											</tr>
											{$Italy}
											{$Ispan}
											{$Japan}
											{$Russia}
											{$Nemec}
											<tr>
												<td>
													<h4>{$lang['page']['profile']["gun"]}</h4>
												</td>
												<td>
												</td>
											</tr>
											<tr>
												<td>
													<b>Deagle:</b>
												</td>
												<td>
													<b>{$tables['S_DesertEagle']}%</b>
												</td>
											</tr>
											<tr>
												<td>
													<b>ShotGun:</b>
												</td>
												<td>
													<b>{$tables['S_ShotGun']}%</b>
												</td>
											</tr>
											<tr>
												<td>
													<b>MP5:</b>
												</td>
												<td>
													<b>{$tables['S_MP5']}%</b>
												</td>
											</tr>
											<tr>
												<td>
													<b>AK47:</b>
												</td>
												<td>
													<b>{$tables['S_AK47']}%</b>
												</td>
											</tr>
											<tr>
												<td>
													<b>M4A1:</b>
												</td>
												<td>
													<b>{$tables['S_M4']}%</b>
												</td>
											</tr>
											<tr>
												<td>
												</td>
												<td>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
								<ul id=\"myTab1\" class=\"nav nav-tabs\">
									<li class=\"active\">
										<a href=\"#s1{$userid}\" data-toggle=\"tab\"><i class=\"fa fa-user\"></i> Игрок</a>
									</li>
									<li>
										<a href=\"#s2{$userid}\" data-toggle=\"tab\"><i class=\"fa fa-car\"></i> Автомобиль</a>
									</li>
									<li>
										<a href=\"#s3{$userid}\" data-toggle=\"tab\"><i class=\"fa fa-home\"></i> Дом</a>
									</li>
								</ul>
								<div id=\"myTabContent1\" class=\"tab-content\">
									<div class=\"tab-pane fade in active\" id=\"s1{$userid}\">
										{$inventory}
									</div>
									<div class=\"tab-pane fade\" id=\"s2{$userid}\">
										{$veh}
									</div>
									<div class=\"tab-pane fade\" id=\"s3{$userid}\">
										{$hinventory}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class=\"tab-pane fade\" id=\"a2{$userid}\">
						<h2>Login history</h2>
						<div class=\"row\">
							<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
								<div class=\"table-responsive\" style=\"height: 400px; overflow: auto;\">
									<table class=\"table text-center\">
										<thead>
											<tr>
												<th><center>Номер авторизации</center></th>
												<th><center>Имя пользователя</center></th>
												<th><center>Номер аккаунта</center></th>
												<th><center>Клиент</center></th>
												<th><center>IP</center></th>
												<th><center>Дата входа</center></th>
											</tr>
										</thead>
										<tbody>
											{$loginlog}
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class=\"tab-pane fade\" id=\"a3{$userid}\">
						<h2>Name history</h2>
						<div class=\"row\">
							<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
								<div class=\"table-responsive\" style=\"height: 400px; overflow: auto;\">
									<table class=\"table text-center\">
										<thead>
											<tr>
												<th><center>Номер смены</center></th>
												<th><center>Номер аккаунта</center></th>
												<th><center>Новое имя</center></th>
												<th><center>Старое имя</center></th>
												<th><center>E-Mail</center></th>
												<th><center>Дата смены</center></th>
											</tr>
										</thead>
										<tbody>
											{$namelog}
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class=\"tab-pane fade\" id=\"a4{$userid}\">
						<h2>Blocked history</h2>
						<div class=\"row\">
							<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
								<div class=\"table-responsive\" style=\"height: 400px; overflow: auto;\">
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
											{$banlog}
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>";
	$db->close();

} 
else echo "<h1>Бу</h1><embed src=\"http://ucp.raknet.ru/boo_file.swf\" width=\"100%\" height=\"100%\">";