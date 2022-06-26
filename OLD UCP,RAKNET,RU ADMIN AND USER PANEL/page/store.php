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
 Файл: store.php
=====================================================
*/
if(!defined("CRAZY_STR")) die("Hacking attempt!");

$style->content( "{page}" , $lang['page']['store'] );

$style->content( "{style}" , "" );

if ( user::logged() ) {

	$endbantime = "";
	$pnumber = "";
	$param = isset ( $_GET['param'] ) ? $_GET['param'] : "";
	$param = (int)$db->safesql( $param );

	$query = $db->super_query("SELECT * FROM `members` WHERE `member_id` = '{$uid}' LIMIT 1");
	
	if ( $query["BanTime"] > time() ) $endbantime = "{$lang['other']['error']['unblockdate']}: " . date ( "d.m.Y в H:i" , $query['BanTime'] ) . "";
	else $endbantime = "{$lang['other']['error']['noblock']}";
	
	switch ( $param ) {

		default: {
		
			$style->content( "{content}" , "<div class=\"row\" align=\"center\">
												<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">
													<div class=\"thumbnail\">
														<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal\" title=\"{$lang['rshop']['number']['number']}\"><i class=\"fa fa-4x fa-mobile\"></i></a>
														<div class=\"caption\">
															<h3>{$lang['rshop']['number']['number']}</h3>
															<p>{$lang['rshop']['number']['lozung']}</p>
															<p><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal\" title=\"{$lang['rshop']['number']['number']}\" class=\"btn btn-primary\">{$lang['rshop']['number']['buy']}</a>
														</div>
													</div>
												</div>
												<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">
													<div class=\"thumbnail\">
														<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal1\" title=\"{$lang['rshop']['mute']['mute']}\"><i class=\"fa fa-4x fa-child\"></i></a>
														<div class=\"caption\">
															<h3>{$lang['rshop']['mute']['mute']}</h3>
															<p>{$lang['rshop']['mute']['lozung']}</p>
															<p><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal1\" title=\"{$lang['rshop']['mute']['mute']}\" class=\"btn btn-primary\">{$lang['rshop']['mute']['buy']}</a>
														</div>
													</div>
												</div>
												<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">
													<div class=\"thumbnail\">
														<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal2\" title=\"{$lang['rshop']['wanted']['wanted']}\"><i class=\"fa fa-4x fa-database\"></i></a>
														<div class=\"caption\">
															<h3>{$lang['rshop']['wanted']['wanted']}</h3>
															<p>{$lang['rshop']['wanted']['lozung']}</p>
															<p><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal2\" title=\"{$lang['rshop']['wanted']['wanted']}\" class=\"btn btn-primary\">{$lang['rshop']['wanted']['buy']}</a>
														</div>
													</div>
												</div>
												<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">
													<div class=\"thumbnail\">
														<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal3\" title=\"{$lang['rshop']['jail']['jail']}\"><i class=\"fa fa-4x fa-slack\"></i></a>
														<div class=\"caption\">
															<h3>{$lang['rshop']['jail']['jail']}</h3>
															<p>{$lang['rshop']['jail']['lozung']}</p>
															<p><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal3\" title=\"{$lang['rshop']['jail']['jail']}\" class=\"btn btn-primary\">{$lang['rshop']['jail']['buy']}</a>
														</div>
													</div>
												</div>
												<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">
													<div class=\"thumbnail\">
														<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal4\" title=\"{$lang['rshop']['warn']['warn']}\"><i class=\"fa fa-4x fa-exclamation\"></i></a>
														<div class=\"caption\">
															<h3>{$lang['rshop']['warn']['warn']}</h3>
															<p>{$lang['rshop']['warn']['lozung']}</p>
															<p><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal4\" title=\"\" class=\"btn btn-primary\">{$lang['rshop']['warn']['buy']}</a>
														</div>
													</div>
												</div>
												<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">
													<div class=\"thumbnail\">
														<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal5\" title=\"{$lang['rshop']['ban']['ban']}\"><i class=\"fa fa-4x fa-ban\"></i></a>
														<div class=\"caption\">
															<h3>{$lang['rshop']['ban']['ban']}</h3>
															<p>{$lang['rshop']['ban']['lozung']}</p>
															<p><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal5\" title=\"{$lang['rshop']['ban']['ban']}\" class=\"btn btn-primary\">{$lang['rshop']['ban']['buy']}</a>
														</div>
													</div>
												</div>
											</div>
											<div class=\"modal fade\" id=\"myModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
												<div class=\"modal-dialog\">
													<div class=\"modal-content\">
														<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
															<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
														</div>
														<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
															<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">{$lang['rshop']['number']['buynumber']}</h4>
															<form action=\"\" id=\"number_type\" class=\"smart-form client-form\" method=\"POST\">
																<fieldset>
																	<section>
																		<label class=\"label\">{$lang['rshop']['number']['pred']}</label>
																		<label class=\"input\"> 
																			<i class=\"icon-append fa fa-mobile\"></i>
																			<input type=\"text\" id=\"numberInput\" value=\"\" name=\"number\" maxlength=\"8\">
																			<input type=\"hidden\" name=\"uid\" value=\"{$uid}\">
																		</label>
																	</section>
																	<section><div id=\"result\"></div></section>
																</fieldset>
																<footer style=\"background: #fff; border-color: #fff;\">
																	<button type=\"button\" id=\"numberCheck\" class=\"btn btn-primary\">{$lang['rshop']['number']['buy']}</button>
																	<button type=\"button\" class=\"btn btn-primary\" onclick=\"check();\">{$lang['rshop']['number']['info']}</button>
																</footer>
															</form>
														</div>
													</div>
												</div>
											</div>
											<div class=\"modal fade\" id=\"myModal1\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
												<div class=\"modal-dialog\">
													<div class=\"modal-content\">
														<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
															<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
														</div>
														<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
															<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">{$lang['rshop']['mute']['mute']}</h4>
															<form action=\"\" id=\"mute\" class=\"smart-form client-form\" method=\"POST\">
																<fieldset>
																	<div class=\"alert alert-success\"><br /><b>{$lang['rshop']['mute']['cherez']}: {$query['MuteTime']} {$lang['rshop']['mute']['second']}<br /><br /></div>
																	<input type=\"hidden\" name=\"uid\" value=\"{$uid}\">
																	<section><div id=\"muteresult\"></div></section>
																</fieldset>
																<footer style=\"background: #fff; border-color: #fff;\">
																	<button type=\"button\" class=\"btn btn-primary\" name=\"submit\" onclick=\"unmute();\">
																		{$lang['rshop']['mute']['buy']}
																	</button>
																</footer>
															</form>
														</div>
													</div>
												</div>
											</div>
											<div class=\"modal fade\" id=\"myModal2\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
												<div class=\"modal-dialog\">
													<div class=\"modal-content\">
														<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
															<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
														</div>
														<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
															<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">{$lang['rshop']['wanted']['delete']}</h4>
															<form action=\"\" id=\"wantedpoints\" class=\"smart-form client-form\" method=\"POST\">
																<fieldset>
																	<div class=\"alert alert-success\"><br /><b>{$lang['rshop']['wanted']['naake']}: {$query['WantedPoints']} {$lang['rshop']['wanted']['rozisk']}<br /><br /></div>
																	<input type=\"hidden\" name=\"uid\" value=\"{$uid}\">
																	<section><div id=\"wantedresult\"></div></section>
																</fieldset>
																<footer style=\"background: #fff; border-color: #fff;\">
																	<button type=\"button\" class=\"btn btn-primary\" name=\"submit\" onclick=\"unwanted();\">
																		{$lang['rshop']['wanted']['buy']}
																	</button>
																</footer>
															</form>
														</div>
													</div>
												</div>
											</div>
											<div class=\"modal fade\" id=\"myModal3\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
												<div class=\"modal-dialog\">
													<div class=\"modal-content\">
														<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
															<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
														</div>
														<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
															<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">{$lang['rshop']['jail']['exit']}</h4>
															<form action=\"\" id=\"jail\" class=\"smart-form client-form\" method=\"POST\">
																<fieldset>
																	<div class=\"alert alert-success\"><br /><b>{$lang['rshop']['jail']['lozung2']}<br /><br /></div>
																	<input type=\"hidden\" name=\"uid\" value=\"{$uid}\">
																	<section><div id=\"jailresult\"></div></section>
																</fieldset>
																<footer style=\"background: #fff; border-color: #fff;\">
																	<button type=\"button\" class=\"btn btn-primary\" name=\"submit\" onclick=\"unjail();\">
																		{$lang['rshop']['jail']['buy']}
																	</button>
																</footer>
															</form>
														</div>
													</div>
												</div>
											</div>
											<div class=\"modal fade\" id=\"myModal4\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
												<div class=\"modal-dialog\">
													<div class=\"modal-content\">
														<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
															<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
														</div>
														<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
															<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">{$lang['rshop']['warn']['admin']}</h4>
															<form action=\"\" id=\"warn\" class=\"smart-form client-form\" method=\"POST\">
																<fieldset>
																	<div class=\"alert alert-success\"><br /><b>{$lang['rshop']['warn']['naake']}: {$query['Warns']} {$lang['rshop']['warn']['warns']}<br /><br /></div>
																	<input type=\"hidden\" name=\"uid\" value=\"{$uid}\">
																	<section><div id=\"warnresult\"></div></section>
																</fieldset>
																<footer style=\"background: #fff; border-color: #fff;\">
																	<button type=\"button\" class=\"btn btn-primary\" name=\"submit\" onclick=\"unwarn();\">
																		{$lang['rshop']['warn']['down']}
																	</button>
																	<button type=\"button\" class=\"btn btn-primary\" name=\"submit\" onclick=\"warnall();\">
																		{$lang['rshop']['warn']['all']}
																	</button>
																</footer>
															</form>
														</div>
													</div>
												</div>
											</div>
											<div class=\"modal fade\" id=\"myModal5\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
												<div class=\"modal-dialog\">
													<div class=\"modal-content\">
														<div class=\"modal-header\" style=\"background: #fff; border-color: #fff;\">
															<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
														</div>
														<div class=\"modal-body\" style=\"background: #fff; border-color: #fff;\">
															<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"background: #fff; border-color: #fff;\" align=\"center\">{$lang['rshop']['ban']['bans']}</h4>
															<form action=\"\" id=\"ban\" class=\"smart-form client-form\" method=\"POST\">
																<fieldset>
																	<div class=\"alert alert-success\"><br /><b>{$lang['rshop']['ban']['all']}</b>.<br />{$endbantime}<br />{$lang['rshop']['ban']['sum']}<br /><br /></div>
																	<input type=\"hidden\" name=\"uid\" value=\"{$uid}\">
																	<section><div id=\"banresult\"></div></section>
																</fieldset>
																<footer style=\"background: #fff; border-color: #fff;\">
																	<button type=\"button\" class=\"btn btn-primary\" name=\"submit\" onclick=\"unban();\">
																		{$lang['rshop']['ban']['buy']}
																	</button>
																</footer>
															</form>
														</div>
													</div>
												</div>
											</div>" );

		}

	}

}


$style->content( "{script}" , "
		<script type=\"text/javascript\" src=\"{$url}/{$dir}/{$template}/js/notification/SmartNotification.min.js\"></script>
		<script type=\"text/javascript\">
											$(document).ready(function() {
												$('#numberCheck').click(function() {
													if($('#numberInput').val().charAt(0) != '0') {
														$.ajax({
															type: \"POST\",
															url: \"{$url}/lib/other/buynumber.php\",
															data: $(\"#number_type\").serialize(),
															success: function(data) {
																document.getElementById('result').innerHTML = data;
															},
															error: function(data) {
																document.getElementById('result').innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
															}
														});
													} else {
														document.getElementById('result').innerHTML = '<div class=\"alert alert-danger\">Номер не может начинаться с 0</div>';
														$.smallBox({
															title : \"Произошла ошибка\",
															content : \"<i>Номер не может начинаться с 0.</i>\",
															color : \"#C26565\",
															iconSmall : \"fa fa-thumbs-down bounce animated\",
															timeout : 4000
														});
													}
												});
											});
											function check(){
												$.ajax({
													type: \"POST\",
													url: \"{$url}/lib/other/checknumber.php\",
													data: $(\"#number_type\").serialize(),
													success: function(data) {
														document.getElementById(\"result\").innerHTML = data;
													},
													error: function(data) {
														document.getElementById(\"result\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
													}
												});
											};
											function unmute(){
												$.ajax({
													type: \"POST\",
													url: \"{$url}/lib/other/unmute.php\",
													data: $(\"#mute\").serialize(),
													success: function(data) {
														document.getElementById(\"muteresult\").innerHTML = data;
													},
													error: function(data) {
														document.getElementById(\"muteresult\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
													}
												});
											};
											function unwanted(){
												$.ajax({
													type: \"POST\",
													url: \"{$url}/lib/other/wanted.php\",
													data: $(\"#wantedpoints\").serialize(),
													success: function(data) {
														document.getElementById(\"wantedresult\").innerHTML = data;
													},
													error: function(data) {
														document.getElementById(\"wantedresult\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
													}
												});
											};
											function unjail(){
												$.ajax({
													type: \"POST\",
													url: \"{$url}/lib/other/unjail.php\",
													data: $(\"#jail\").serialize(),
													success: function(data) {
														document.getElementById(\"jailresult\").innerHTML = data;
													},
													error: function(data) {
														document.getElementById(\"jailresult\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
													}
												});
											};
											function unwarn(){
												$.ajax({
													type: \"POST\",
													url: \"{$url}/lib/other/unwarn.php\",
													data: $(\"#warn\").serialize(),
													success: function(data) {
														document.getElementById(\"warnresult\").innerHTML = data;
													},
													error: function(data) {
														document.getElementById(\"warnresult\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
													}
												});
											};
											function warnall(){
												$.ajax({
													type: \"POST\",
													url: \"{$url}/lib/other/warnall.php\",
													data: $(\"#warn\").serialize(),
													success: function(data) {
														document.getElementById(\"warnresult\").innerHTML = data;
													},
													error: function(data) {
														document.getElementById(\"warnresult\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
													}
												});
											};
											function unban(){
												$.ajax({
													type: \"POST\",
													url: \"{$url}/lib/other/unban.php\",
													data: $(\"#ban\").serialize(),
													success: function(data) {
														document.getElementById(\"banresult\").innerHTML = data;
													},
													error: function(data) {
														document.getElementById(\"banresult\").innerHTML = '<div class=\"alert alert-danger\">Произошла ошибка при отправке данных</div>';
													}
												});
											};
										</script>" );