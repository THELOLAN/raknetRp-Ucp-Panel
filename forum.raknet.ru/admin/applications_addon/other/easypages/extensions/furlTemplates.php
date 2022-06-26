<?php

$_SEOTEMPLATES = array(
	'easypages'	=> array(
		'app'			=> 'easypages',
		'allowRedirect'	=> 1,
		'out'			=> array( '#app=easypages(?:&page=|&amp;page=|)(.*?)(&|$)#i', 'pages/$1' ),
		'in'			=> array(
			'regex'		=> "#/pages(\/|)(.*?)$#i",
			'matches'	=> array(
				array( 'app', 'easypages' ),
				array( 'page', '$2' )
				),
			),
		),
	'app=easypages'	=> array(
		'app'			=> 'easypages',
		'allowRedirect'	=> 1,
		'out'			=> array( '/app=easypages$/i', 'pages/' ),
		'in'			=> array(
			'regex'		=> "#^/pages$#i",
			'matches'	=> array(
				array( 'app', 'easypages' )
				),
			),
		),
	);

// $_PATHFIX		= "#.*?\/pages\/(.*?)$#";
