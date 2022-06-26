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