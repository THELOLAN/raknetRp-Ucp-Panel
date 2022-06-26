<?php 
if(!defined('RUCP')) die("Hacking attempt!");

if($member['member_id'])
{
	if($member['Admin'] > 0)
	{
		if($_SESSION['auth'] == 1)
		{
			setcookie("admins", 1, time()+3600, "/", "raknet.ru");
			if($member['Admin'] >= 6)
			{
				$adminnav = "<li>
								<a href=\"/param/del\"><i class=\"fa fa-edit\"></i> <span class=\"nav-label\">Удаление аккаунтов(в разработке)</span> </a>
							</li>";
			}
			$style->content("{nav}", "<li class=\"nav-header\">
										<div class=\"dropdown profile-element\"> 
											<span>
												<img alt=\"image\" class=\"img-circle\" src=\"http://ucp.raknet.ru/template/raknet/img/avatars/{$member['Char']}.png\" width=\"48\" height=\"48\"/>
											</span>
											<a data-toggle=\"dropdown\" class=\"dropdown-toggle\" href=\"#\">
												<span class=\"clear\"> 
													<span class=\"block m-t-xs\"> 
														<strong class=\"font-bold\">{$member['prefix']}{$member['name']}{$member['suffix']}</strong>
													</span> 
													<span class=\"text-muted text-xs block\">Администратор {$member['Admin']} LVL <b class=\"caret\"></b></span> 
												</span> 
											</a>
										</div>
										<div class=\"logo-element\">
											IN+
										</div>
									</li>
									<li>
										<a href=\"\"><i class=\"fa fa-home\"></i> <span class=\"nav-label\">Главная</span> </a>
									</li>
									<li>
										<a href=\"/getban/my\"><i class=\"fa fa-database\"></i> <span class=\"nav-label\">Мои блокировки</span> </a>
									</li>
									<li>
										<a href=\"/getban/all\"><i class=\"fa fa-database\"></i> <span class=\"nav-label\">История блокировок</span> </a>
									</li>
									<li>
										<a href=\"/bio\"><i class=\"fa fa-info\"></i> <span class=\"nav-label\">Проверка биографий</span> </a>
									</li>
									<li>
										<a href=\"/user/view\"><i class=\"fa fa-user\"></i> <span class=\"nav-label\">Просмотр профиля</span> </a>
									</li>
									<li>
										<a href=\"#\"><i class=\"fa fa-bar-chart-o\"></i> <span class=\"nav-label\">Мониторинг</span><span class=\"fa arrow\"></span></a>
										<ul class=\"nav nav-second-level\">
											<li>
												<a href=\"/getinfo/biz\">Бизнесов</a>
											</li>
											<li>
												<a href=\"/getinfo/azs\">АЗС</a>
											</li>
											<li>
												<a href=\"/getinfo/house\">Домов</a>
											</li>
										</ul>
									</li>
									{$adminnav}");
			switch($page[0])
			{
				case "getban": require_once("page/getban.php"); break;
				case "getinfo": require_once("page/getinfo.php"); break;
				case "user": require_once("page/user.php"); break;
				case "param": require_once("page/del.php"); break;
				case "bio": require_once("page/bio.php"); break;
				case "": require_once("page/index.php"); break;
				default: require_once("page/index.php");
			}
		}
		else
		{
			$style->content("{nav}", "");
			switch($page[0])
			{
				case "": require_once("page/auth.php"); break;
				default: require_once("page/auth.php");
			}
		}
	}
}
//var_dump($member);