<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title>RakNet Role Play - {title}</title>
		<meta name="description" content="SAMP RAKNET RolePlay - популярный проект сетевой игры GTA San Andreas">
		<meta name="author" content="Артур Ялалатдинов CRAZy_STR (http://vk.com/crazy_str)">
		<meta name="keywords" content="{key}">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" media="screen" href="{url}/{template}css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{url}/{template}css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{url}/{template}css/production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{url}/{template}css/production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{url}/{template}css/skins.min.css">
		<link rel="shortcut icon" href="http://forum.raknet.ru/favicon.ico" type="image/x-icon">
		<link rel="icon" href="http://forum.raknet.ru/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="google-site-verification" content="x6TxU4jiHWGtgEWkh4WD1f_160CswGI7xSjmq7Ts7Bk">
		<meta name="mysitecost.ru" content="addurl">
		<meta name="alexaVerifyID" content="YjS16M0dyXOzrsgGFrnB8v6K8Rg">
		{style}
	</head>
	<body class="smart-style-2 container menu-on-top">
		<header id="header">
			<div id="logo-group">
				<span id="logo"> 
					<img src="{url}/{template}img/logo.png" alt="{project}"> 
				</span>
			</div>
			<div class="pull-right">
				<div id="hide-menu" class="btn-header pull-right">
					<span> 
						<a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu">
							<i class="fa fa-reorder"></i>
						</a> 
					</span>
				</div>
				<form action="{url}/search" method="POST" class="header-search pull-right">
					<input id="search-fld" type="text" name="name" placeholder="Поиск игроков">
					<button type="submit">
						<i class="fa fa-search"></i>
					</button>
					<a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search">
						<i class="fa fa-times"></i>
					</a>
				</form>
				<div id="fullscreen" class="btn-header transparent pull-right">
					<span> 
						<a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen">
							<i class="fa fa-arrows-alt"></i>
						</a> 
					</span>
				</div>
			</div>
		</header>
		<aside id="left-panel">
			<nav>
				<ul>
					<li {activeh}>
						<a href="{url}/" title="Главная">
							<i class="fa fa-lg fa-fw fa-home"></i> 
							<span class="menu-item-parent">Главная</span>
						</a>
					</li>
					<li>
						<a href="http://forum.raknet.ru/" target="_blank" title="Форум">
							<i class="fa fa-lg fa-fw fa-group"></i> 
							<span class="menu-item-parent">Форум</span>
						</a>
					</li>
					{nav}
					<li {bio}>
						<a href="{url}/bio" title="Биографии">
							<i class="fa fa-lg fa-fw fa-database"></i> 
							<span class="menu-item-parent">Биографии</span>
						</a>
					</li>
					<li {activet}>
						<a href="#"><i class="fa fa-lg fa-fw fa-child"></i> <span class="menu-item-parent">ТОП</span></a>
						<ul>
							<li>
								<a href="{url}/top/rich">Богачей</a>
							</li>
							<li>
								<a href="{url}/top/level">Уровень</a>
							</li>
						</ul>
					</li>
					<li {activem}>
						<a href="#"><i class="fa fa-lg fa-fw fa-bar-chart-o "></i> <span class="menu-item-parent">Мониторинг</span></a>
						<ul>
							<li>
								<a href="{url}/info/fuel">Карта АЗС</a>
							</li>
							<li>
								<a href="{url}/info/bussines">Карта бизнесов</a>
							</li>
							<li>
								<a href="{url}/info/house">Карта домов</a>
							</li>
							<li>
								<a href="{url}/info/online">Игроки онлайн</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
			<span class="minifyme" data-action="minifyMenu"> 
				<i class="fa fa-arrow-circle-left hit"></i> 
			</span>
		</aside>
		<div id="main" role="main">
			<div id="content">
				<section id="widget-grid" class="">
					<div class="row">
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							{content}
						</article>
					</div>
				</section>
			</div>
		</div>
		<div class="page-footer">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<span class="txt-color-white">{project} &copy; {copyright}</span>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="{url}/{template}js/libs/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="{url}/{template}js/libs/jquery-ui-1.10.4.min.js"></script>
		<script type="text/javascript" src="{url}/{template}js/app.config.js"></script>
		<script src="{url}/{template}js/notification/SmartNotification.min.js"></script>
		<script type="text/javascript" src="{url}/{template}js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="{url}/{template}js/plugin/msie-fix/jquery.mb.browser.min.js"></script>
		<!--[if IE 8]>
		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
		<![endif]-->
		<script type="text/javascript" src="{url}/{template}js/app.js"></script>
		{script}
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
		(function (d, w, c) {
			(w[c] = w[c] || []).push(function() {
				try {
					w.yaCounter26954370 = new Ya.Metrika({id:26954370,
							webvisor:true,
							clickmap:true,
							trackLinks:true,
							accurateTrackBounce:true,
							trackHash:true});
				} catch(e) { }
			});

			var n = d.getElementsByTagName("script")[0],
				s = d.createElement("script"),
				f = function () { n.parentNode.insertBefore(s, n); };
			s.type = "text/javascript";
			s.async = true;
			s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

			if (w.opera == "[object Opera]") {
				d.addEventListener("DOMContentLoaded", f, false);
			} else { f(); }
		})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="//mc.yandex.ru/watch/26954370" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
		<!--LiveInternet counter--><script type="text/javascript"><!--
		document.write("<a href='//www.liveinternet.ru/click' "+
		"target=_blank><img style='display:none;' src='//counter.yadro.ru/hit?t26.6;r"+
		escape(document.referrer)+((typeof(screen)=="undefined")?"":
		";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
		screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
		";h"+escape(document.title.substring(0,80))+";"+Math.random()+
		"' alt='' title='LiveInternet: показано число посетителей за"+
		" сегодня' "+
		"border='0' width='88' height='15'><\/a>")
		//--></script><!--/LiveInternet-->
<!-- Rating@Mail.ru counter -->
<script type="text/javascript">
var _tmr = _tmr || [];
_tmr.push({id: "2252086", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
  ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "topmailru-code");
</script><noscript><div style="position:absolute;left:-10000px;">
<img src="//top-fwz1.mail.ru/counter?id=2252086;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" />
</div></noscript>
<!-- //Rating@Mail.ru counter -->
	</body>
</html>