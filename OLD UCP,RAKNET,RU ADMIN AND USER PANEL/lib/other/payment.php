<?php
if(!defined('CRAZY_STR')) die("Hacking attempt!");

$sum = $db->safesql ( stripslashes ( htmlspecialchars ( $_POST['sum'] ) ) );

if ( $sum > 9999 ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Сумма платежа должна быть не больше 10000 т.с.</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");

elseif ( $sum <= 0 ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Сумма платежа должна быть не меньше 0.</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");

else {

	if ( preg_match ( "/^[1-9]\\d*$/" , $sum ) ) {
		
		if ( $tables['Online'] >= 1 ) $style->content( "{content}" , "<div class=\"alert alert-danger\"><strong>Ошибка:</strong> Данный персонаж находится в игре.</div><script>setTimeout(\"document.location.href='{$url}/payment'\", 2000);</script>");
		
		else {
		
			/*$db->query("INSERT INTO 
							`order` ( userid, item, cost, value , status )
						VALUES
								(
									'{$uid}',
									'1',
									'{$sum}',
									'{$sum}',
									'0'
								)");*/
			if($tables['DonateMOther'] >= 0 && $tables['DonateMOther'] <= 499) {
			
				$card = 'MEMBER CARD 0 %';
				$procent = $sum/100*0;
				$total = $sum-$procent;
				
			} elseif($tables['DonateMOther'] >= 500 && $tables['DonateMOther'] <= 1499) {
			
				$card = 'BRONZE CARD 3 %';
				$procent = $sum/100*3;
				$total = $sum-$procent;
				
			} elseif($tables['DonateMOther'] >= 1500 && $tables['DonateMOther'] <= 2999) {
			
				$card = 'SILVER CARD 5 %';
				$procent = $sum/100*5;
				$total = $sum-$procent;
				
			} elseif($tables['DonateMOther'] >= 3000 && $tables['DonateMOther'] <= 5999) {
			
				$card = 'GOLD CARD 7 %';
				$procent = $sum/100*7;
				$total = $sum-$procent;
				
			} elseif($tables['DonateMOther'] >= 6000) {
			
				$card = 'PLATINUM CARD 10 %';
				$procent = $sum/100*10;
				$total = $sum-$procent;
				
			}
			$order = $uid+time();
			$mrh_login = "RAKNET";
			$mrh_pass1 = "873IUUkakjw9e8s9oihas091";
			$inv_desc = "Пополнение счёта игрового аккаунта {$sname} #{$uid} Транзакция {$order}";
			$in_curr = "";
			$culture = "ru";
			$crc = md5("{$mrh_login}:{$total}:{$order}:{$mrh_pass1}:Shp_item={$sname}");
			$db->query("INSERT INTO 
							`robokassa` ( id_order , userid , Name , itemsCount , money , status , email , odate , tid , status1 )
						VALUES ( 
									'{$order}',
									'{$uid}',
									'{$sname}',
									'{$total}',
									'{$sum}',
									'0',
									'{$tables['email']}',
									'" . date ( "d.m.Y H:i " ) . "',
									'{$crc}',
									'0'
								)");
			$all = $sum*virt;
			$style->content( "{content}" , "<div class=\"row\">
												<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\" align=\"center\">
												</div>
												<div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\" align=\"center\">
													<form action=\"https://merchant.roboxchange.com/Index.aspx\" id=\"login-form\" class=\"smart-form client-form\" method=\"POST\">
														<header style=\"background: #fff; border-color: #fff;\">
															Проверка введёных данных
														</header>
														<fieldset>
															<section>
																<label class=\"label\">{$lang["page"]["payment"]["sum"]}</label>
																<label class=\"input\"> 
																	<i class=\"icon-append fa fa-rub\"></i>
																	<input type=\"text\" value=\"{$sum}\" disabled>
																	<b class=\"tooltip tooltip-top-right\">
																		<i class=\"fa fa-rub txt-color-teal\"></i> {$lang["page"]["payment"]["sum"]}
																	</b>
																</label>
																<label class=\"label\">{$lang["page"]["payment"]["total"]}</label>
																<label class=\"input\"> 
																	<i class=\"icon-append fa fa-dollar\"></i>
																	<input type=\"text\" value=\"{$all}\" disabled>
																	<b class=\"tooltip tooltip-top-right\">
																		<i class=\"fa fa-dollar txt-color-teal\"></i> {$lang["page"]["payment"]["total"]}
																	</b>
																	<input type=\"hidden\" name=\"MrchLogin\" value=\"{$mrh_login}\">
																	<input type=\"hidden\" name=\"OutSum\" value=\"{$total}\">
																	<input type=\"hidden\" name=\"InvId\" value=\"{$order}\">
																	<input type=\"hidden\" name=\"Desc\" value=\"{$inv_desc}\">
																	<input type=\"hidden\" name=\"SignatureValue\" value=\"{$crc}\">
																	<input type=\"hidden\" name=\"Shp_item\" value=\"{$sname}\">
																	<input type=\"hidden\" name=\"IncCurrLabel\" value=\"{$in_curr}\">
																	<input type=\"hidden\" name=\"Culture\" value=\"{$culture}\">
																	<div class=\"alert alert-danger\" align=\"center\">Внимание: Цены указаны без учета НДС</div>
																</label>
															</section>
														</fieldset>
														<footer style=\"background: #fff; border-color: #fff;\">
															<button type=\"submit\" class=\"btn btn-primary\" name=\"submit\">
																{$lang["page"]["payment"]["enter"]}
															</button>
														</footer>
													</form>
												</div>
											</div>" );
			
		}
		
	}

}