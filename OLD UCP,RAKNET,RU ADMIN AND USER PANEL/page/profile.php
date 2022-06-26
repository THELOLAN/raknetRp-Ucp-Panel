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
 Файл: profile.php
=====================================================
*/

if(!defined('CRAZY_STR')) die("Hacking attempt!");

$style->content ( "{page}" , $lang['page']['profile']['profile'] );

$style->content ( "{style}" , "<style>
.bar {
  display: none;
}
</style>" );

if ( user::logged() ) {

	$veh = "";
	$hinventory = "";
	$biz = "";
	$azs = "";
	$donate = "";
	$donates = "";
	$rand = mt_rand(10,15);

/* 	LEFT JOIN 
									`vehicles_player` as B
								ON
									( `B`.`Owned` = `A`.`member_id` ) */
	
	$tables = $db->super_query("SELECT
									" . implode ( "," , $queryparam ) . "
								FROM
									`members` as A
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
									`A`.`member_id` = '{$uid}'
								LIMIT 1");

	if ( isset ( $_POST['pucode'] ) ) {

		$pucode = $db->safesql($_POST['pucode']);
		if ( $pucode == "" ) $style->content ("{content}", "<div class=\"alert alert-danger\">Введите код безопасности</div><script>setTimeout(\"document.location.href='{$url}/profile'\", 2000);</script>");
		elseif ( $pucode != $tables['code'] ) {

			session_destroy();
			$style->content ("{content}", "<div class=\"alert alert-danger\">Неверно введён код безопасности</div><script>setTimeout(\"document.location.href='{$url}/'\", 2000);</script>");

		} else {

			$_SESSION["codes"] = true;
			$style->content ("{content}", "<div class=\"alert alert-success\">Добро пожаловать, {$sname}</div><script>setTimeout(\"document.location.href='{$url}/profile'\", 2000);</script>");
			
		}

	} else {

		if ( $codes == false && $tables['code'] > "" ) {

			$style->content ( "{content}" , "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\"></div>
										<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6\">
												<form action=\"\" method=\"POST\" class=\"smart-form client-form\">
													<fieldset>
														<section>
															<label class=\"label\">Введите код безопасности</label>
															<label class=\"input\"> 
																<input type=\"password\" name=\"pucode\" id=\"pincode\" value=\"\" readonly=\"readonly\" maxlength=\"10\" autocomplete=\"off\">
															</label>
														</section>
													</fieldset>
													<fieldset>
														<div class=\"col-xs-4 col-sm-4 col-md-4 col-lg-4\"></div>
														<div class=\"row\">
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('1');\">1</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('2');\">2</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('3');\">3</div>
														</div>
														<div class=\"col-xs-4 col-sm-4 col-md-4 col-lg-4\"></div>
														<div class=\"row\">
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('4');\">4</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('5');\">5</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('6');\">6</div>
														</div>
														<div class=\"col-xs-4 col-sm-4 col-md-4 col-lg-4\"></div>
														<div class=\"row\">
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('7');\">7</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('8');\">8</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('9');\">9</div>
														</div>
														<div class=\"col-xs-4 col-sm-4 col-md-4 col-lg-4\"></div>
														<div class=\"row\">
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-danger\" onClick=\"pinremove();\">X</div>
															<div class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-primary\" onClick=\"pinappend('0');\">0</div>
															<button class=\"col-xs-1 col-sm-1 col-md-1 col-lg-1 btn btn-lg btn-success\" type=\"submit\" name=\"submit\"><i class=\"fa fa-check\"></i></button>
														</div>
													</fieldset>
												</form>
											</div>" );

		} else {

			if ( isset ( $_POST['next'] ) ) require_once ("lib/other/payment.php");
			elseif ( isset ( $_GET['param'] ) ) {

				$param = (int)$_GET['param'];
				$param = $db->safesql($param);

				if ( $param >= 0 ) 
				{
					$robo = $db->query("SELECT * FROM `robokassa` WHERE `userid` = '{$uid}' AND `status1` = '1' ORDER BY `id` DESC");
					$unit = $db->query("SELECT * FROM `unitpay_payments` WHERE `account` = '{$sname}' AND `status` = '1' ORDER BY `id` DESC");
					while ( $robokassa = $db->get_row( $robo ) ) $donate .= "<tr><td><center>{$robokassa['id_order']}</center></td><td><center>{$robokassa['itemsCount']}</center></td><td><center>{$robokassa['money']}</center></td><td><center>{$robokassa['odate']}</center></td></tr>";
					while ( $unitpay = $db->get_row( $unit ) ) $donates .= "<tr><td><center>{$unitpay['unitpayId']}</center></td><td><center>{$unitpay['sum']}</center></td><td><center>{$unitpay['itemsCount']}</center></td><td><center>{$unitpay['dateComplete']}</center></td></tr>";
					
					$style->content( "{content}" , "<div class=\"row\">
														<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\"></div>
														<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
															<ul id=\"myTab1\" class=\"nav nav-tabs bordered\">
																<li class=\"active\">
																	<a href=\"#donate1\" data-toggle=\"tab\">UnitPay</a>
																</li>
																<li>
																	<a href=\"#donate2\" data-toggle=\"tab\">ROBOKASSA</a>
																</li>
															</ul>
															<div id=\"myTabContent1\" class=\"tab-content padding-10\">
																<div class=\"tab-pane fade\" id=\"donate2\">
																	<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">
																		<img src=\"https://partner.robokassa.ru/Content/images/robo_main_logo.png\">
																	</h4>
																	<form action=\"\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
																		<fieldset>
																			<section>
																				<label class=\"label\">{$lang['page']['payment']['sum']}</label>
																				<label class=\"input\"> 
																					<i class=\"icon-append fa fa-rub\"></i>
																					<input onkeyup=\"price();\" id=\"rur\" type=\"text\" name=\"sum\" maxlength=\"4\">
																					<b class=\"tooltip tooltip-top-right\">
																						<i class=\"fa fa-rub txt-color-teal\"></i> {$lang['page']['payment']['sum']}
																					</b>
																				</label>
																				<label class=\"label\">{$lang['page']['payment']['total']}</label>
																				<label class=\"input\"> 
																					<i class=\"icon-append fa fa-dollar\"></i>
																					<input id=\"total\" type=\"text\" disabled>
																					<b class=\"tooltip tooltip-top-right\">
																						<i class=\"fa fa-dollar txt-color-teal\"></i> {$lang['page']['payment']['total']}
																					</b>
																				</label>
																			</section>
																		</fieldset>
																		<footer style=\"background: #fff; border-color: #fff;\">
																			<button type=\"submit\" class=\"btn btn-primary\" name=\"next\">
																				{$lang['button']['next']}
																			</button>
																		</footer>
																	</form>
																</div>
																<div class=\"tab-pane fade in active\" id=\"donate1\">
																	<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\"><img src=\"https://unitpay.ru/images/f8ede98.png\"></h4>
																	<form action=\"https://unitpay.ru/pay/12277-8b69d\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
																		<fieldset>
																			<section>
																				<label class=\"label\">{$lang['page']['payment']['sum']}</label>
																				<label class=\"input\"> 
																					<i class=\"icon-append fa fa-rub\"></i>
																					<input onkeyup=\"prices();\" id=\"rurs\" type=\"text\" name=\"sum\" maxlength=\"4\">
																					<b class=\"tooltip tooltip-top-right\">
																						<i class=\"fa fa-rub txt-color-teal\"></i> {$lang['page']['payment']['sum']}
																					</b>
																				</label>
																				<label class=\"label\">{$lang['page']['payment']['total']}</label>
																				<label class=\"input\"> 
																					<i class=\"icon-append fa fa-dollar\"></i>
																					<input id=\"totals\" type=\"text\" disabled>
																					<input type=\"hidden\" name=\"desc\" value=\"Пополнение счёта игрового аккаунта {$sname} #{$uid}\">
																					<input type=\"hidden\" name=\"account\" value=\"{$sname}\">
																					<b class=\"tooltip tooltip-top-right\">
																						<i class=\"fa fa-dollar txt-color-teal\"></i> {$lang['page']['payment']['total']}
																					</b>
																				</label>
																			</section>
																		</fieldset>
																		<footer style=\"background: #fff; border-color: #fff;\">
																			<button type=\"submit\" class=\"btn btn-primary\" name=\"submit\">
																				{$lang['button']['next']}
																			</button>
																		</footer>
																	</form>
																</div>
															</div>
															<br />
															<br />
														</div>
														<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
															<center><h4>История платежей:</h4></center>
															<br />
															<br />
														</div>
														<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
															<h4>UNITPAY</h4>
															<section id=\"tables\" style=\"height: 15em; overflow: auto;\">
																<table class=\"table table-bordered table-striped table-hover\">
																	<thead>
																		<tr>
																			<th><center>№ Транзакции</center></th>
																			<th><center>Сумма</center></th>
																			<th><center>Рублей</center></th>
																			<th><center>Дата</center></th>
																		</tr>
																	</thead>
																	<tbody>
																		{$donates}
																	</tbody>
																</table>
															</section>
														</div>
														<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
															<h4>ROBOKASSA</h4>
															<section id=\"tables\" style=\"height: 15em; overflow: auto;\">
																<table class=\"table table-bordered table-striped table-hover\">
																	<thead>
																		<tr>
																			<th><center>№ Транзакции</center></th>
																			<th><center>Сумма</center></th>
																			<th><center>Рублей</center></th>
																			<th><center>Дата</center></th>
																		</tr>
																	</thead>
																	<tbody>
																		{$donate}
																	</tbody>
																</table>
															</section>
														</div>
														<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
															<center><h4>{$lang['page']['profile']['allrub']}: {$tables['DonateMOther']} руб.</h4></center>
														</div>
													</div>" );
				} 
				else $style->content("{content}","<div class=\"alert alert-danger\">БУУУУУУУУУУУУУУ</div><embed src=\"http://prison-fakes.ru/s/swf/{$rand}.swf\" width=\"100%\" height=\"100%\">");

			} else {

				$nxtlevel = $tables['Level']+1;
				$expamount = $nxtlevel*4;

				$fmsg = "";
				
				if ( $tables["Admins"] > "0" && $admins == null ) $style->content( "{content}" , "<script>setTimeout(\"document.location.href='{$url}/alogin'\", 2000);</script>" );
				else { 

					$friends = $db->query("SELECT `friends_friend_id` FROM `profile_friends` WHERE `friends_member_id` = '{$uid}'");
					while ( $friend = $db->get_row ( $friends ) ) {
					
						$fname = $db->super_query("SELECT `name`, `Char`, `Pnumber` FROM `members` WHERE `member_id` = '{$friend['friends_friend_id']}' LIMIT 1");
						
						if ( !$fname['name'] ) {
						
							$fnames = "Игрок удалён";
							$fnumber = "Игрок удалён";
						
						} else {

							$fnames = $fname['name'];
							$fnumber = $fname['Pnumber'];					
						
						}
						$fmsg .= "<tr>
									<td>
										<center><img src=\"{$url}/{$dir}/{$template}/img/avatars/{$fname['Char']}.png\" width=\"35\"></center>
									</td>
									<td>
										{$fnames}
									</td>
									<td>
										<center>{$fnumber}</center>
									</td>
								</tr>";
					
					}
				
					$ban = $db->super_query("SELECT * FROM `banlog` WHERE `tid` = '{$uid}' ORDER BY `id` DESC LIMIT 1");
					$adminname = $db->super_query("SELECT `name` FROM `members` WHERE `member_id` = '{$ban['aid']}' LIMIT 1");

					$automobil = $db->query("SELECT * FROM `vehicles_player` WHERE `Owned` = '{$uid}'");
					while($auto = $db->get_row($automobil))
					{
						
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

					
					$inventory = "";
					for ( $i = 0; $i < 48; $i++ ) $inventory .= user::objectid ( $tables["P{$i}"], $i, "user" );

					$bar = "";
					for ( $i = 0; $i < 48; $i++ ) $bar .= user::objectuser ( $tables["P{$i}"], $i, "user" );
					
					$oldname = "";
					$oname = $db->query("SELECT `Oldname` FROM `name` WHERE `userid` = '{$uid}' LIMIT 10");
					while($onames = $db->get_row($oname)) {
						$oldname .= $onames['Oldname'] . "<br />";
					}
					
					$auth = $db->super_query("SELECT `time` FROM `smember_log` WHERE `userid` = '{$uid}' ORDER BY `id` DESC LIMIT 1");
					
					switch($tables['Online']) 
					{
						case 0: 
						{
							$ontext = "<font color=\"gray\" size=\"3\">Сейчас вне сети</font>";
							$styles = "box-shadow: 0 0 10px gray;";
							$tiptime = "Был в сети: " . other::times($auth['time']) . "";
						}
						break;
						case 1: 
						{
							$ontext = "<font color=\"green\" size=\"3\">Играет</font>";
							$styles = "box-shadow: 0 0 10px green;";
							$tiptime = "";
						}
						break;
						case 2: 
						{
							$ontext = "<font color=\"green\" size=\"3\">В сети</font>";
							$styles = "box-shadow: 0 0 10px blue;";
							$tiptime = "";
						}
						break;
					}
					
					
					$style->content ( "{content}" , "
													<div class=\"row\">
														<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
															<div class=\"jarviswidget jarviswidget-color-darken\" id=\"wid-id-0\">
																<center><img src=\"{$url}/{$dir}/{$template}/img/avatars/{$tables['Char']}.png\" rel=\"tooltip\" data-placement=\"top\" data-original-title=\"{$sname}<br />\" data-html=\"true\"></center>
																<br />
																
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
																		
																		{$CarLic}
																		{$sbiz}
																		{$biz}
																		<tr>
																			<td><b>{$lang['page']['profile']['number']}:</b></td>
																			<td><b>{$tables['Pnumber']}</b></td>
																		</tr>
																		<tr>
																			<td><b>{$lang['page']['profile']['balance']}:</b></td>
																			<td><b>" . number_format ( $tables['Mobile'] ) . "<font color=\"green\">$</font></b></td>
																		</tr>
																		<tr>
																			<td><b>{$lang['page']['profile']['friends']}:</b></td>
																			<td><b><a href=\"#\" data-toggle=\"modal\" data-target=\"#myFriend{$uid}\" title=\"{$lang['page']['profile']['friends']}\">посмотреть</a></b></td>
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
																	<a href=\"#s1\" data-toggle=\"tab\"><i class=\"fa fa-user\"></i> {$lang['page']['profile']["player"]}</a>
																</li>
																<li>
																	<a href=\"#s2\" data-toggle=\"tab\"><i class=\"fa fa-car\"></i> {$lang['page']['profile']["auto"]}</a>
																</li>
																<li>
																	<a href=\"#s3\" data-toggle=\"tab\"><i class=\"fa fa-home\"></i> {$lang['page']['profile']["house"]}</a>
																</li>
															</ul>
															<div id=\"myTabContent1\" class=\"tab-content\">
																<div class=\"tab-pane fade in active\" id=\"s1\">
																	{$inventory}
																</div>
																<div class=\"tab-pane fade\" id=\"s2\">
																	{$veh}
																</div>
																<div class=\"tab-pane fade\" id=\"s3\">
																	{$hinventory}
																</div>
															</div>
														</div>
													</div>
													<div class=\"modal fade\" id=\"myFriend{$uid}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
														<div class=\"modal-dialog\">
															<div class=\"modal-content\">
																<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
																	<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
																</div>
																<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
																	<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">{$lang['page']['profile']['friends']}</h4>
																	<p>
																		<div class=\"table-responsive\" style=\"height: 400px; overflow: auto;\">
																			<table class=\"table\">
																				<thead>
																					<tr>
																						<th><center></center></th>
																						<th>
																						{$lang['page']['profile']['name']}
																						</th>
																						<th>
																							<center>{$lang['page']['profile']['number']}</center>
																						</th>
																					</tr>
																				</thead>
																				<tbody>
																					{$fmsg}
																				</tbody>
																			</table>
																		</div>
																	</p>
																</div>
															</div>
														</div>
													</div>" );
				}

			}

		}
	}
	
}

$style->content ( "{script}" , "
<script>
$(function() {
	$('.links').on('click', function(e) {
		e.preventDefault();
		$('.bar').each(function() {
			$(this).css('display', 'none');
		});
		var block = $(this).attr('href');
		$(block).css('display', 'block');
	});
});
</script>
<script type=\"text/javascript\">
function price() {
	var rur = $(\"#rur\").val(); 
	var total = 0;
	if(rur > 0) total = " . virt . " * rur;
	$(\"#total\").val(total);
}
function prices() {
	var rur = $(\"#rurs\").val(); 
	var total = 0;
	if(rur > 0) total = " . virt . " * rur;
	$(\"#totals\").val(total);
}
function pinappend(value) {

	var pincode = document.getElementById(\"pincode\");

	pincode.value = (pincode.value + value).substring(0, 10);

};
function pinremove(value) {

	var pincode = document.getElementById(\"pincode\");

	pincode.value = pincode.value.substring(0, pincode.value.length - 1);

};
</script>" );