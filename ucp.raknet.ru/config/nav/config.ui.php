<?php 
if(!defined('RUCP')) die("Hacking attempt!");

$member = $ipbMemberLoginApi->getMember();

if($member['member_id'])
{
/* 	if($member['Admin'] > 7)
	{
		$chname = explode("_", $member['name']);
		$chat = "<li class=\"chat-users active\">
					<a href=\"#\"><i class=\"fa fa-lg fa-fw fa-comment-o\"><em class=\"bg-color-pink flash animated\">!</em></i> <span class=\"menu-item-parent\">Smart Chat API <sup>beta</sup></span></a>
					<ul style=\"display:block;\">
						<li>
							<div class=\"display-users\">
								<input class=\"form-control chat-user-filter\" placeholder=\"Filter\" type=\"text\">
								<dl>
								  <dt>
									<a href=\"#\" class=\"usr\" 
										data-chat-id=\"cha1\" 
										data-chat-fname=\"{$chname[0]}\" 
										data-chat-lname=\"{$chname[1]}\" 
										data-chat-status=\"busy\" 
										data-chat-alertmsg=\"{$member['name']} is in a meeting. Please do not disturb!\" 
										data-chat-alertshow=\"true\" 
										rel=\"popover-hover\" 
										data-placement=\"right\" 
										data-html=\"true\" 
										data-content=\"
											<div class='usr-card'>
												<img src='{$url}/" . template . "img/avatars/{$member['Char']}.png' alt='{$member['name']}'>
												<div class='usr-card-content'>
													<h3>{$member['name']}</h3>
													<p>Marketing Executive</p>
												</div>
											</div>
										\"> 
										<i></i>{$member['name']}
									</a>
								  </dt>
							</div>
						</li>
					</ul>
				</li>";
	} */
	$style->content("{nav}", "<li {activep}>
								<a href=\"{$url}/user/view/\" title=\"Профиль\">
									<i class=\"fa fa-lg fa-fw fa-user\"></i> 
									<span class=\"menu-item-parent\">Профиль</span>
								</a>
							</li>
							<li {actives}>
								<a href=\"{$url}/settings/\" title=\"Настройки\">
									<i class=\"fa fa-lg fa-fw fa-cog\"></i> 
									<span class=\"menu-item-parent\">Настройки</span>
								</a>
							</li>
							<li {actived}>
								<a href=\"{$url}/pay/\" title=\"Донат\">
									<i class=\"fa fa-lg fa-fw fa-rub\"></i> 
									<span class=\"menu-item-parent\">Донат</span>
								</a>
							</li>
							<li {activef}>
								<a href=\"{$url}/friends\" title=\"Друзья\">
									<i class=\"fa fa-lg fa-fw fa-group\"></i> 
									<span class=\"menu-item-parent\">Друзья</span>
								</a>
							</li>
							<li {activer}>
								<a href=\"#\"><i class=\"fa fa-lg fa-fw fa-shopping-cart\"><em>Акция</em></i> <span class=\"menu-item-parent\">Магазин</span></a>
								<ul>
									<li>
										<a href=\"{$url}/shop\">R-Shop <span class=\"badge pull-right inbox-badge bg-color-green\">-50% На авто</span></a>
									</li>
									<li>
										<a href=\"{$url}/auction/auto\">Транспорт [BETA]</a>
									</li>
									<li>
										<a href=\"{$url}/auction/my\">Мои лоты [BETA]</a>
									</li>
								</ul>
							</li>");
	switch($page[0])
	{
		case "pay": $style->content("{actived}", "class=\"active\""); require_once("page/payment.php"); break;
		case "settings": $style->content("{actives}", "class=\"active\""); require_once("page/settings.php"); break;
		case "auction": $style->content("{activer}", "class=\"active\""); require_once("page/auction.php"); break;
		case "forgot": $style->content("{actives}", "class=\"active\""); require_once("page/forgot.php"); break;
		case "confirm": $style->content("{actives}", "class=\"active\""); require_once("page/confirm.php"); break;
		case "top": $style->content("{activet}", "class=\"active\""); require_once("page/top.php"); break;
		case "friends": $style->content("{activef}", "class=\"active\""); require_once("page/friends.php"); break;
		case "user": $style->content("{activep}", "class=\"active\""); require_once("page/profile.php"); break;
		case "bio": $style->content("{bio}", "class=\"active\""); require_once("page/bio.php"); break;
		case "info": $style->content("{activem}", "class=\"active\""); require_once("page/monitor.php"); break;
		case "index": $style->content("{activeh}", "class=\"active\""); require_once("page/index.php"); break;
		case "shop": $style->content("{activer}", "class=\"active\""); require_once("page/shop.php"); break;
		case "search": require_once("page/search.php"); break;
		case "": $style->content("{activeh}", "class=\"active\""); require_once("page/index.php"); break;
		default: $style->content("{activeh}", "class=\"active\""); require_once("page/index.php");
	}
}
else
{
	$style->content("{nav}", "<li>
								<a href=\"http://forum.raknet.ru/index.php?app=core&module=global&section=login\" title=\"Вход\">
									<i class=\"fa fa-lg fa-fw fa-sign-in\"></i> 
									<span class=\"menu-item-parent\">Вход</span>
								</a>
							</li>");
	switch($page[0])
	{
		case "user": $style->content("{activep}", "class=\"active\""); require_once("page/profile.php"); break;
		case "top": $style->content("{activet}", "class=\"active\""); require_once("page/top.php"); break;
		case "pay": $style->content("{actived}", "class=\"active\""); require_once("page/payment.php"); break;
		case "info": $style->content("{activem}", "class=\"active\""); require_once("page/monitor.php"); break;
		case "index": $style->content("{activeh}", "class=\"active\""); require_once("page/index.php"); break;
		case "bio": $style->content("{bio}", "class=\"active\""); require_once("page/bio.php"); break;
		case "search": require_once("page/search.php"); break;
		case "": $style->content("{activeh}", "class=\"active\""); require_once("page/index.php"); break;
		default: $style->content("{activeh}", "class=\"active\""); require_once("page/index.php");
	}
}