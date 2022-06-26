// Created by ipbforumskins.com

jQuery.noConflict();

jQuery(document).ready(function($){

	$('a[href=#top]').click(function(){
		$('html, body').animate({scrollTop:0}, 400);
        return false;
	});

});