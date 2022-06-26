$.root_ = $('body');	
$.navAsAjax = false; 
$.sound_path = "http://ucp.raknet.ru/sound/";
$.sound_on = true; 
var root = this,	
debugState = false,	
debugStyle = 'font-weight: bold; color: #00f;',
debugStyle_green = 'font-weight: bold; font-style:italic; color: #46C246;',
debugStyle_red = 'font-weight: bold; color: #ed1c24;',
debugStyle_warning = 'background-color:yellow',
debugStyle_success = 'background-color:green; font-weight:bold; color:#fff;',
debugStyle_error = 'background-color:#ed1c24; font-weight:bold; color:#fff;',
throttle_delay = 350,
menu_speed = 235,	
menu_accordion = true,	
enableJarvisWidgets = true,
localStorageJarvisWidgets = true,
sortableJarvisWidgets = true,		
enableMobileWidgets = true,	
fastClick = false,
boxList = [],
showList = [],
nameList = [],
idList = [],
chatbox_config = {
	width: 200,
	gap: 35
},
ignore_key_elms = ["#header, #left-panel, #right-panel, #main, div.page-footer, #shortcut, #divSmallBoxes, #divMiniIcons, #divbigBoxes, script"];