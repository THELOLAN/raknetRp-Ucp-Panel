$.intervalArr = [];

var calc_navbar_height = function() {
	var height = null;
	if ($('#header').length)
		height = $('#header').height();
	if (height === null)
		height = $('<div id="header"></div>').height();
	if (height === null)
		return 49;
	// default
	return height;
},
navbar_height = calc_navbar_height, 
shortcut_dropdown = $('#shortcut'),
bread_crumb = $('#ribbon ol.breadcrumb'),
topmenu = false,
thisDevice = null,
ismobile = (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase())),
jsArray = {},
initApp = (function(app) {	
	app.addDeviceType = function() {
		if (!ismobile) {
			$.root_.addClass("desktop-detected");
			thisDevice = "desktop";
			return false; 
		} else {
			$.root_.addClass("mobile-detected");
			thisDevice = "mobile";
			if (fastClick) {
				$.root_.addClass("needsclick");
				FastClick.attach(document.body); 
				return false; 
			}
		}
	};
	app.menuPos = function() {
		if ($.root_.hasClass("menu-on-top") || localStorage.getItem('sm-setmenu')=='top' ) { 
			topmenu = true;
			$.root_.addClass("menu-on-top");
		}
	};
	app.SmartActions = function(){	
		var smartActions = {
			launchFullscreen: function(element){
				if (!$.root_.hasClass("full-screen")) {
					$.root_.addClass("full-screen");
					if (element.requestFullscreen) {
						element.requestFullscreen();
					} else if (element.mozRequestFullScreen) {
						element.mozRequestFullScreen();
					} else if (element.webkitRequestFullscreen) {
						element.webkitRequestFullscreen();
					} else if (element.msRequestFullscreen) {
						element.msRequestFullscreen();
					}
				} else {
					$.root_.removeClass("full-screen");
					if (document.exitFullscreen) {
						document.exitFullscreen();
					} else if (document.mozCancelFullScreen) {
						document.mozCancelFullScreen();
					} else if (document.webkitExitFullscreen) {
						document.webkitExitFullscreen();
					}
				}
		   },
			minifyMenu: function($this){
				if (!$.root_.hasClass("menu-on-top")){
					$.root_.toggleClass("minified");
					$.root_.removeClass("hidden-menu");
					$('html').removeClass("hidden-menu-mobile-lock");
					$this.effect("highlight", {}, 500);
				}
			},
			toggleMenu: function(){
				if (!$.root_.hasClass("menu-on-top")){
					$('html').toggleClass("hidden-menu-mobile-lock");
					$.root_.toggleClass("hidden-menu");
					$.root_.removeClass("minified");
				} else if ( $.root_.hasClass("menu-on-top") && $(window).width() < 979 ) {	
					$('html').toggleClass("hidden-menu-mobile-lock");
					$.root_.toggleClass("hidden-menu");
					$.root_.removeClass("minified");
				}
			}
		};
		$.root_.on('click', '[data-action="launchFullscreen"]', function(e) {	
			smartActions.launchFullscreen(document.documentElement);
			e.preventDefault();
		}); 
		$.root_.on('click', '[data-action="minifyMenu"]', function(e) {
			var $this = $(this);
			smartActions.minifyMenu($this);
			e.preventDefault();
			$this = null;
		}); 
		$.root_.on('click', '[data-action="toggleMenu"]', function(e) {	
			smartActions.toggleMenu();
			e.preventDefault();
		});  
	};
	app.leftNav = function(){
		if (!topmenu) {
			if (!null) {
				$('nav ul').jarvismenu({
					accordion : menu_accordion || true,
					speed : menu_speed || true,
					closedSign : '<em class="fa fa-plus-square-o"></em>',
					openedSign : '<em class="fa fa-minus-square-o"></em>'
				});
			} else {
				alert("Error - menu anchor does not exist");
			}
		}
	};
	app.domReadyMisc = function() {
		if ($("[rel=tooltip]").length) {
			$("[rel=tooltip]").tooltip();
		}
		$('#search-mobile').click(function() {
			$.root_.addClass('search-mobile');
		});
	};
	app.mobileCheckActivation = function(){
		if ($(window).width() < 979) {
			$.root_.addClass('mobile-view-activated');
			$.root_.removeClass('minified');
		} else if ($.root_.hasClass('mobile-view-activated')) {
			$.root_.removeClass('mobile-view-activated');
		}
		if (debugState){
			console.log("mobileCheckActivation");
		}
	} 
	return app;
})({});
initApp.addDeviceType();
initApp.menuPos();
jQuery(document).ready(function() {
	initApp.SmartActions();
	initApp.leftNav();
	initApp.domReadyMisc();
});
(function ($, window, undefined) {
	var elems = $([]),
		jq_resize = $.resize = $.extend($.resize, {}),
		timeout_id, str_setTimeout = 'setTimeout',
		str_resize = 'resize',
		str_data = str_resize + '-special-event',
		str_delay = 'delay',
		str_throttle = 'throttleWindow';
	jq_resize[str_delay] = throttle_delay;
	jq_resize[str_throttle] = true;
	$.event.special[str_resize] = {
		setup: function () {
			if (!jq_resize[str_throttle] && this[str_setTimeout]) {
				return false;
			}
			var elem = $(this);
			elems = elems.add(elem);
			try {
				$.data(this, str_data, {
					w: elem.width(),
					h: elem.height()
				});
			} catch (e) {
				$.data(this, str_data, {
					w: elem.width, // elem.width();
					h: elem.height // elem.height();
				});
			}
			if (elems.length === 1) {
				loopy();
			}
		},
		teardown: function () {
			if (!jq_resize[str_throttle] && this[str_setTimeout]) {
				return false;
			}
			var elem = $(this);
			elems = elems.not(elem);
			elem.removeData(str_data);
			if (!elems.length) {
				clearTimeout(timeout_id);
			}
		},
		add: function (handleObj) {
			if (!jq_resize[str_throttle] && this[str_setTimeout]) {
				return false;
			}
			var old_handler;
			function new_handler(e, w, h) {
				var elem = $(this),
					data = $.data(this, str_data);
				data.w = w !== undefined ? w : elem.width();
				data.h = h !== undefined ? h : elem.height();
				old_handler.apply(this, arguments);
			}
			if ($.isFunction(handleObj)) {
				old_handler = handleObj;
				return new_handler;
			} else {
				old_handler = handleObj.handler;
				handleObj.handler = new_handler;
			}
		}
	};
	function loopy() {
		timeout_id = window[str_setTimeout](function () {
			elems.each(function () {
				var width;
				var height;
				var elem = $(this),
					data = $.data(this, str_data); //width = elem.width(), height = elem.height();
				try {
					width = elem.width();
				} catch (e) {
					width = elem.width;
				}
				try {
					height = elem.height();
				} catch (e) {
					height = elem.height;
				}
				if (width !== data.w || height !== data.h) {
					elem.trigger(str_resize, [data.w = width, data.h = height]);
				}
			});
			loopy();
		}, jq_resize[str_delay]);
	}
})(jQuery, this);
$('#main').resize(function() {
	initApp.mobileCheckActivation();
});
var ie = ( function() {
	var undef, v = 3, div = document.createElement('div'), all = div.getElementsByTagName('i');
	while (div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->', all[0]);
	return v > 4 ? v : undef;
}()); 
jQuery.fn.doesExist = function() {
	return jQuery(this).length > 0;
};
function setup_widgets_mobile() {
	if (enableMobileWidgets && enableJarvisWidgets) {
		setup_widgets_desktop();
	}
}
function loadScript(scriptName, callback) {
	if (!jsArray[scriptName]) {
		jsArray[scriptName] = true;
		var body = document.getElementsByTagName('body')[0],
			script = document.createElement('script');
		script.type = 'text/javascript';
		script.src = scriptName;
		script.onload = callback;
		body.appendChild(script);
	} else if (callback) {
		if (debugState){
			root.root.console.log("This script was already loaded %c: " + scriptName, debugStyle_warning);
		}
		callback();
	}
}
$('body').on('click', function(e) {
	$('[rel="popover"], [data-rel="popover"]').each(function() {
		if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
			$(this).popover('hide');
		}
	});
}); 
$('body').on('hidden.bs.modal', '.modal', function () {
	$(this).removeData('bs.modal');
});
function getParam(name) {
	name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	var regexS = "[\\?&]" + name + "=([^&#]*)";
	var regex = new RegExp(regexS);
	var results = regex.exec(window.location.href);
	if (results == null) {
		return "";
	}
	else
	{
		return results[1];
	}
}
function count(array) {
	var cnt = 0;
	for (var i in array) {
		if (i) {
			cnt++;
		}
	}
	return cnt;
}
function Search(url, name){ $.ajax({type: "POST",url: url,data: {'name': name},success: function(data) {document.getElementById("result").innerHTML = data;},error: function(data) {document.getElementById("result").innerHTML = '<div class="alert alert-danger">Произошла ошибка при отправке данных</div>';}});};
function cName(url, oname, name){ $.ajax({type: "POST",url: url,data: {'oname': oname,'name': name},success: function(data) {changename(data);}});};
function cnumber(url, number){ $.ajax({type: "POST",url: url,data: {'number': number},success: function(data) {checknumbers(data);}});};
function ActivationCode(url, dcode, param, friend){ $.ajax({type: "POST",url: url,data: {'dcode': dcode,'param': param,'friend': friend},success: function(data) {document.getElementById("result").innerHTML = data;}});};
function Likes(url, member_id, pp_member_id){ $.ajax({type: "POST",url: url,data: {'member_id': member_id,'pp_member_id': pp_member_id},success: function(data) {document.getElementById("result").innerHTML = data;}});};
function Vehicle(url, car){ $.ajax({type: "POST",url: url,data: {'car': car},success: function(data) {document.getElementById("resultcar").innerHTML = data;}});};
function BuyCar(url, price, model){ $.ajax({type: "POST",url: url,data: {'price': price,'model': model},success: function(data) {cardata(data);}});};
function LotParam(url, model, param){ $.ajax({type: "POST",url: url,data:{'model': model,'param': param},success: function(data){LotNotifParam(data);}});};
function Lot(url, vehicle, summ){ $.ajax({type: "POST",url: url,data:{'vehicle': vehicle,'summ': summ},success: function(data){lotnotif(data);}});};
function LotNotifParam(param)
{
	switch(param)
	{
		case "1":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Ваш персонаж находится в игре!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "2":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Не шали!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "3":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Не шали!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "4":
		{
			$.smallBox({
				title : "Успех!",
				content : "Вы успешно сняли лот с аукциона",
				color : "#5384AF",
				icon : "fa fa-bell",
				timeout : 6000
			});
			break;
		}
		case "5":
		{
			$.smallBox({
				title : "Успех!",
				content : "Вы успешно продали лот на аукционе",
				color : "#5384AF",
				icon : "fa fa-bell",
				timeout : 6000
			});
			break;
		}
	}
}
function lotnotif(param)
{
	switch(param)
	{
		case "1":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Не шали!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "2":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Это не ваш автомобиль!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "3":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Сумма начальной ставки не может быть меньше 1000$ и больше 5 000 000$!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "4":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Ваш персонаж находится в игре!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "5":
		{
			$.smallBox({
				title : "Успех!",
				content : "Вы успешно выставили лот автомобиль на аукцион",
				color : "#5384AF",
				icon : "fa fa-bell",
				timeout : 6000
			});
			break;
		}
	}
}
function stavka(param)
{
	switch(param)
	{
		case "1":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Не шали!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "2":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Вы не можете повысить ставку на свой лот!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "3":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Ваш персонаж находится в игре!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "4":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Вы уже делали ставку на данный лот!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "5":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "На вашем счету недостаточно средств!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "6":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Введённая вами ставка неможет быть меньше стартовой!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "7":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Введённая вами ставка неможет быть равна стартовой!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "8":
		{
			$.smallBox({
				title : "Цена установлена!",
				content : "- Ставка была установлена, деньги отправились в аукцион на хранение до продажи лота.<br />\
							- Если ваша цена удовлетворит продавца он примет вашу ставку и вы получите автомобиль.<br />\
							- Если ваша цена не удовлетворит продавца ваши деньги будут вам возвращены после окончания лота, их можно будет забрать в городских банкоматах.",
				color : "#5384AF",
				icon : "fa fa-bell",
				timeout : 10000
			});
			break;
		}
	}
}
function cardata(param)
{
	switch(param)
	{
		case "1":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Не шали!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "2":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "На вашем счете недостаточно средств!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "3":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Ваш персонаж находится на сервере!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "4":
		{
			$.smallBox({
				title : "Успех!",
				content : "Вы успешно приобрели автомобиль",
				color : "#5384AF",
				icon : "fa fa-bell",
				timeout : 6000
			});
			break;
		}
		case "5":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Не шали!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
	}
}
function changename(param)
{
	switch(param)
	{
		case "1":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Ваш персонаж находится на сервере!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "2":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Заполните все поля!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "3":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Старое и новое имя не может быть одинаковым!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "4":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Неверное введено текущее имя!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "5":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Это имя уже занято кем-то другим!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "6":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Имя персонажа должно быть не мешьше 3 и больше 20 символов!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "7":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Неверно введено имя персонажа. Пример: Eugen_Petrov!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "8":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "На вашем аккаунте недостаточно средств!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+param,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "9":
		{
			$.smallBox({
				title : "Успех!",
				content : "Вы успешно сменили игровое имя",
				color : "#5384AF",
				icon : "fa fa-bell",
				timeout : 6000
			});
			break;
		}
	}
}
function buynumber(data)
{
	switch(data)
	{
		case "0":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Заполните все поля!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+data,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "1":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Номер должен быть не короче 4 символов и длинее 8!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+data,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "2":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "На вашем счете недостаточно средств!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+data,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "3":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Ваш персонаж находится на сервере!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+data,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "4":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Данный номер уже кем-то используется!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+data,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "5":
		{
			$.smallBox({
				title : "Успех!",
				content : "Вы успешно приобрели короткий номер.",
				color : "#5384AF",
				icon : "fa fa-bell",
				timeout : 6000
			});
			break;
		}
	}
}
function checknumbers(data)
{
	switch(data)
	{
		case "0":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Заполните все поля!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+data,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "1":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Номер должен быть не короче 4 символов и длинее 8!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+data,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "2":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "На вашем счете недостаточно средств!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+data,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "3":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Ваш персонаж находится на сервере!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+data,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		case "4":
		{
			$.bigBox({
				title : "Произошла ошибка",
				content : "Данный номер уже кем-то используется!",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				number : "#"+data,
				timeout : 6000
			});
			e.preventDefault();
			break;
		}
		default:
		{
			document.getElementById("result").innerHTML = "<div class='alert alert-success'>Данный номер свободен, его стоимость составляет: "+data+"</div>";
		}
	}
}
/* 
function wallget(groups, counts){
	var imgs = [];
	var message = [];
	var btn = [];
	$.ajax({
		url: 'http://api.vk.com/method/groups.getById?group_id=' + groups + '&fields=description&v=5.26',
		dataType: 'jsonp',
		success: function(data) {
			var apis = data.response;
			$.ajax({
				url: 'http://api.vk.com/method/wall.get?domain=' + groups + '&count=' + counts + '&v=5.26',
				dataType: 'jsonp',
				success: function(datas) {
					var api = datas.response.items;
					for ( var wal = 0; wal < count( api ); wal++ ) {
						
						if ( api[wal]['attachments'] !== 'undefined' ) {
							
							for ( api[wal]['attachments'] in btn ) 
							{
								console.log(btn);
							}
							
						}
						
						message += "<li class='message'><hr><img src='" + apis[0]['photo_50'] + "'><span class='message-text'><a href='http://vk.com/raknet_official' class='username' target='_blank'>" + apis[0]['name'] + "</a><font color='#4E4747'>" + api[wal]['text'] + "</font></span><<div align='left'><a href='#' style='display: inline-block;'></a> <span class='pull-right'><a href='javascript:void(0);' class='btn btn-success'> <i class='fa fa-mail-reply'></i></a> <a href='javascript:void(0);' class='btn btn-success'> <i class='fa fa-thumbs-up'></i></a> <a href='javascript:void(0);' class='btn btn-success'> <i class='fa fa-comments'></i></a></span></div></li>";
					}
					document.getElementById("wallget").innerHTML = message;
				}
			});
		}
	});
} */
function usersvk(param, param1) {
	var users = [];
	if ( device.desktop() === true ) 
	{
		$.ajax({  
			url: 'http://api.vk.com/method/groups.getMembers?group_id=raknet_official&sort='+ param +'&offset=' + param1 + '&count=72&fields=photo_50&v=5.34',  
			dataType: 'jsonp',  
			success: function(data) 
			{
				var datas = data.response.items;
				for ( var vk = 0; vk < 72; vk++ ) 
				{
					users += "<div class='superbox-list'><a href='http://vk.com/id"+ datas[vk]["id"] +"' target='_blank'><img src='"+ datas[vk]["photo_50"] +"' alt='"+ datas[vk]["first_name"] +" "+ datas[vk]["last_name"] +"' title='"+ datas[vk]["first_name"] +" "+ datas[vk]["last_name"] +"' class='superbox-img'></a></div>";
				}
				document.getElementById("vkphoto").innerHTML = users;
			}
		});
	} 
	else 
	{ 
		document.getElementById("vkphoto").innerHTML = ""; 
	}
}
function money_format(format, number) {
  //  discuss at: http://phpjs.org/functions/money_format/
  // original by: Brett Zamir (http://brett-zamir.me)
  //    input by: daniel airton wermann (http://wermann.com.br)
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //  depends on: setlocale
  //        note: This depends on setlocale having the appropriate
  //        note: locale (these examples use 'en_US')
  //   example 1: money_format('%i', 1234.56);
  //   returns 1: ' USD 1,234.56'
  //   example 2: money_format('%14#8.2n', 1234.5678);
  //   returns 2: ' $     1,234.57'
  //   example 3: money_format('%14#8.2n', -1234.5678);
  //   returns 3: '-$     1,234.57'
  //   example 4: money_format('%(14#8.2n', 1234.5678);
  //   returns 4: ' $     1,234.57 '
  //   example 5: money_format('%(14#8.2n', -1234.5678);
  //   returns 5: '($     1,234.57)'
  //   example 6: money_format('%=014#8.2n', 1234.5678);
  //   returns 6: ' $000001,234.57'
  //   example 7: money_format('%=014#8.2n', -1234.5678);
  //   returns 7: '-$000001,234.57'
  //   example 8: money_format('%=*14#8.2n', 1234.5678);
  //   returns 8: ' $*****1,234.57'
  //   example 9: money_format('%=*14#8.2n', -1234.5678);
  //   returns 9: '-$*****1,234.57'
  //  example 10: money_format('%=*^14#8.2n', 1234.5678);
  //  returns 10: '  $****1234.57'
  //  example 11: money_format('%=*^14#8.2n', -1234.5678);
  //  returns 11: ' -$****1234.57'
  //  example 12: money_format('%=*!14#8.2n', 1234.5678);
  //  returns 12: ' *****1,234.57'
  //  example 13: money_format('%=*!14#8.2n', -1234.5678);
  //  returns 13: '-*****1,234.57'
  //  example 14: money_format('%i', 3590);
  //  returns 14: ' USD 3,590.00'

  // Per PHP behavior, there seems to be no extra padding for sign when there is a positive number, though my
  // understanding of the description is that there should be padding; need to revisit examples

  // Helpful info at http://ftp.gnu.org/pub/pub/old-gnu/Manuals/glibc-2.2.3/html_chapter/libc_7.html and http://publib.boulder.ibm.com/infocenter/zos/v1r10/index.jsp?topic=/com.ibm.zos.r10.bpxbd00/strfmp.htm

  if (typeof number !== 'number') {
    return null;
  }
  var regex = /%((=.|[+^(!-])*?)(\d*?)(#(\d+))?(\.(\d+))?([in%])/g; // 1: flags, 3: width, 5: left, 7: right, 8: conversion

  this.setlocale('LC_ALL', 0); // Ensure the locale data we need is set up
  var monetary = this.php_js.locales[this.php_js.localeCategories['LC_MONETARY']]['LC_MONETARY'];

  var doReplace = function(n0, flags, n2, width, n4, left, n6, right, conversion) {
    var value = '',
      repl = '';
    if (conversion === '%') { // Percent does not seem to be allowed with intervening content
      return '%';
    }
    var fill = flags && (/=./)
      .test(flags) ? flags.match(/=(.)/)[1] : ' '; // flag: =f (numeric fill)
    var showCurrSymbol = !flags || flags.indexOf('!') === -1; // flag: ! (suppress currency symbol)
    width = parseInt(width, 10) || 0; // field width: w (minimum field width)

    var neg = number < 0;
    number = number + ''; // Convert to string
    number = neg ? number.slice(1) : number; // We don't want negative symbol represented here yet

    var decpos = number.indexOf('.');
    var integer = decpos !== -1 ? number.slice(0, decpos) : number; // Get integer portion
    var fraction = decpos !== -1 ? number.slice(decpos + 1) : ''; // Get decimal portion

    var _str_splice = function(integerStr, idx, thous_sep) {
      var integerArr = integerStr.split('');
      integerArr.splice(idx, 0, thous_sep);
      return integerArr.join('');
    };

    var init_lgth = integer.length;
    left = parseInt(left, 10);
    var filler = init_lgth < left;
    if (filler) {
      var fillnum = left - init_lgth;
      integer = new Array(fillnum + 1)
        .join(fill) + integer;
    }
    if (flags.indexOf('^') === -1) { // flag: ^ (disable grouping characters (of locale))
      // use grouping characters
      var thous_sep = monetary.mon_thousands_sep; // ','
      var mon_grouping = monetary.mon_grouping; // [3] (every 3 digits in U.S.A. locale)

      if (mon_grouping[0] < integer.length) {
        for (var i = 0, idx = integer.length; i < mon_grouping.length; i++) {
          idx -= mon_grouping[i]; // e.g., 3
          if (idx <= 0) {
            break;
          }
          if (filler && idx < fillnum) {
            thous_sep = fill;
          }
          integer = _str_splice(integer, idx, thous_sep);
        }
      }
      if (mon_grouping[i - 1] > 0) { // Repeating last grouping (may only be one) until highest portion of integer reached
        while (idx > mon_grouping[i - 1]) {
          idx -= mon_grouping[i - 1];
          if (filler && idx < fillnum) {
            thous_sep = fill;
          }
          integer = _str_splice(integer, idx, thous_sep);
        }
      }
    }

    // left, right
    if (right === '0') { // No decimal or fractional digits
      value = integer;
    } else {
      var dec_pt = monetary.mon_decimal_point; // '.'
      if (right === '' || right === undefined) {
        right = conversion === 'i' ? monetary.int_frac_digits : monetary.frac_digits;
      }
      right = parseInt(right, 10);

      if (right === 0) { // Only remove fractional portion if explicitly set to zero digits
        fraction = '';
        dec_pt = '';
      } else if (right < fraction.length) {
        fraction = Math.round(parseFloat(fraction.slice(0, right) + '.' + fraction.substr(right, 1))) + '';
        if (right > fraction.length) {
          fraction = new Array(right - fraction.length + 1)
            .join('0') + fraction; // prepend with 0's
        }
      } else if (right > fraction.length) {
        fraction += new Array(right - fraction.length + 1)
          .join('0'); // pad with 0's
      }
      value = integer + dec_pt + fraction;
    }

    var symbol = '';
    if (showCurrSymbol) {
      symbol = conversion === 'i' ? monetary.int_curr_symbol : monetary.currency_symbol; // 'i' vs. 'n' ('USD' vs. '$')
    }
    var sign_posn = neg ? monetary.n_sign_posn : monetary.p_sign_posn;

    // 0: no space between curr. symbol and value
    // 1: space sep. them unless symb. and sign are adjacent then space sep. them from value
    // 2: space sep. sign and value unless symb. and sign are adjacent then space separates
    var sep_by_space = neg ? monetary.n_sep_by_space : monetary.p_sep_by_space;

    // p_cs_precedes, n_cs_precedes // positive currency symbol follows value = 0; precedes value = 1
    var cs_precedes = neg ? monetary.n_cs_precedes : monetary.p_cs_precedes;

    // Assemble symbol/value/sign and possible space as appropriate
    if (flags.indexOf('(') !== -1) { // flag: parenth. for negative
      // Fix: unclear on whether and how sep_by_space, sign_posn, or cs_precedes have
      // an impact here (as they do below), but assuming for now behaves as sign_posn 0 as
      // far as localized sep_by_space and sign_posn behavior
      repl = (cs_precedes ? symbol + (sep_by_space === 1 ? ' ' : '') : '') + value + (!cs_precedes ? (
        sep_by_space === 1 ? ' ' : '') + symbol : '');
      if (neg) {
        repl = '(' + repl + ')';
      } else {
        repl = ' ' + repl + ' ';
      }
    } else { // '+' is default
      var pos_sign = monetary.positive_sign; // ''
      var neg_sign = monetary.negative_sign; // '-'
      var sign = neg ? (neg_sign) : (pos_sign);
      var otherSign = neg ? (pos_sign) : (neg_sign);
      var signPadding = '';
      if (sign_posn) { // has a sign
        signPadding = new Array(otherSign.length - sign.length + 1)
          .join(' ');
      }

      var valueAndCS = '';
      switch (sign_posn) {
        // 0: parentheses surround value and curr. symbol;
        // 1: sign precedes them;
        // 2: sign follows them;
        // 3: sign immed. precedes curr. symbol; (but may be space between)
        // 4: sign immed. succeeds curr. symbol; (but may be space between)
        case 0:
          valueAndCS = cs_precedes ? symbol + (sep_by_space === 1 ? ' ' : '') + value : value + (sep_by_space ===
            1 ? ' ' : '') + symbol;
          repl = '(' + valueAndCS + ')';
          break;
        case 1:
          valueAndCS = cs_precedes ? symbol + (sep_by_space === 1 ? ' ' : '') + value : value + (sep_by_space ===
            1 ? ' ' : '') + symbol;
          repl = signPadding + sign + (sep_by_space === 2 ? ' ' : '') + valueAndCS;
          break;
        case 2:
          valueAndCS = cs_precedes ? symbol + (sep_by_space === 1 ? ' ' : '') + value : value + (sep_by_space ===
            1 ? ' ' : '') + symbol;
          repl = valueAndCS + (sep_by_space === 2 ? ' ' : '') + sign + signPadding;
          break;
        case 3:
          repl = cs_precedes ? signPadding + sign + (sep_by_space === 2 ? ' ' : '') + symbol + (sep_by_space ===
            1 ? ' ' : '') + value : value + (sep_by_space === 1 ? ' ' : '') + sign + signPadding + (
            sep_by_space === 2 ? ' ' : '') + symbol;
          break;
        case 4:
          repl = cs_precedes ? symbol + (sep_by_space === 2 ? ' ' : '') + signPadding + sign + (sep_by_space ===
            1 ? ' ' : '') + value : value + (sep_by_space === 1 ? ' ' : '') + symbol + (sep_by_space === 2 ?
            ' ' : '') + sign + signPadding;
          break;
      }
    }

    var padding = width - repl.length;
    if (padding > 0) {
      padding = new Array(padding + 1)
        .join(' ');
      // Fix: How does p_sep_by_space affect the count if there is a space? Included in count presumably?
      if (flags.indexOf('-') !== -1) { // left-justified (pad to right)
        repl += padding;
      } else { // right-justified (pad to left)
        repl = padding + repl;
      }
    }
    return repl;
  };

  return format.replace(regex, doReplace);
}

/* VK.init({
    apiId: 3805816  // ID вашего приложения VK
});

wallGet('raknet_official', 3);

var message = [];
var modal = [];
var attachment = [];
			
function wallGet(groupid, counts) {
	
	VK.Api.call('groups.getById', {group_id: groupid, fields: 'description', v: '5.27'}, function(s) {
		
		VK.Api.call('wall.get', {domain: groupid, count: counts, v: '5.27'}, function(r) {
			
			var api = r.response.items;
			var images = s.response;
			
			for ( var i = 0; i < count ( api ); i++ ) {
				 
				message += "<li class='message'><hr><img src='" + images[0]['photo_50'] + "'><span class='message-text'><a href='http://vk.com/raknet_official' class='username'>" + images[0]['name'] + "</a><font color='#4E4747'>" + api[i]['text'] + "</font></span><hr><div align='left'><a href='javascript:void(0);' data-toggle='modal' data-target='#news"+i+"' class='btn btn-primary'>Подробнее</a><span class='pull-right'><a href='javascript:void(0);' class='btn btn-success'>" + api[i]["reposts"]["count"] + " <i class='fa fa-mail-reply'></i></a> <a href='javascript:void(0);' class='btn btn-success'>" + api[i]["likes"]["count"] + " <i class='fa fa-thumbs-up'></i></a> <a href='javascript:void(0);' class='btn btn-success'>" + api[i]["comments"]["count"] + " <i class='fa fa-comments'></i></a></span></div></li><div class='modal fade' id='news"+i+"' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'><div class='modal-dialog' style='width: 40%;'><div class='modal-content'><div class='modal-header' style='background: #fff; border-color: #fff;'><button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button></div><div class='modal-body' style='background: #fff; border-color: #fff; width: 100%'><h4 class='modal-title' id='myModalLabel' style='background: #fff; border-color: #fff;' align='center'><a href='http://vk.com/raknet_official' class='username'>" + images[0]['name'] + "</a></h4><table class='table table-responsive'><thead><tr style='background: #fff; border-color: #fff; width: 100%'><td><img src='" + images[0]['photo_50'] + "'></td><td>"+api[i]['text']+"</td></tr></thead></table></div></div></div></div>";
				
			}
			return document.getElementById("wallget").innerHTML = message;

		});
	});
	
} */