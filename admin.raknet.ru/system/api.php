<?php
/*

	SACNRMonitor.php

	Title:		SACNR Monitor PHP API

	Purpose:	Enables easy access to SACNR Monitor's API using
			cURL or file_get_contents (fopen).

			This API is not necessary to access the API, it
			simply makes it easier.

			As of today, 16th of November 2010, there are no
			usage limits for the API. You may make unlimited
			requests to the API. This may be changed at any
			time.

	Last updated:	11th Nov 2010 @ 1:43 AM

	Author:		Blacklite - blacklite@sacnr.com

	License:	GPL - http://www.gnu.org/licenses/gpl-3.0.html

*/
 
if (!class_exists('SACNRMonitor')):
 
class SACNRMonitor {
	
	private $use_curl;
	private $ch;
	private $query_url = 'http://monitor.sacnr.com/api/?';
	
	/*
		Syntax:
			public SACNRMonitor::__construct( bool $use_curl = true )
		
		Description:
			Initializes SACNRMonitor, called automatically by PHP. Set to
			use cURL by default, can be changed by setting $use_curl to false.
			Will issue a notice if the requested method is not available but
			the other one is. Will issue a fatal error if neither method is
			available on your system.
	*/
	public function __construct($use_curl = true) {
		if ($use_curl && !$this->curl()) {
			if ($this->fopen()) {
				$this->error(1);
				$use_curl = false;
			} else {
				$this->error(0);
				return false;
			}
		} else if (!$use_curl && !$this->fopen()) {
			if ($this->curl()) {
				$this->error(2);
				$use_curl = true;
			} else {
				$this->error(0);
				return false;
			}
		}
		$this->use_curl = $use_curl;
	}
	
	/*
		Syntax:
			public SACNRMonitor::__destruct( )
		
		Description:
			Unloads SACNRMonitor. Called automatically by PHP. Will check if
			the cURL handle is initialized and close it if necessary.
	*/
	public function __destruct() {
		if ($this->ch) {
			curl_close($this->ch);
		}
	}
	
	/*
		Functions to get data by ID for actions:
			info
			players
			query
			ad
	*/
	
	public function get_info_by_id($server_id) {
		return $this->get_data_by_id($server_id, 'info');
	}
	
	public function get_players_by_id($server_id) {
		return $this->get_data_by_id($server_id, 'players');
	}
	
	public function get_query_by_id($server_id) {
		return $this->get_data_by_id($server_id, 'query');
	}
	
	public function get_ad_by_id($server_id) {
		return $this->get_data_by_id($server_id, 'ad');
	}
	
	/*
		Functions to get data by IP for actions:
			info
			players
			query
			ad
	*/
	
	public function get_info_by_ip($ip, $port) {
		return $this->get_data_by_ip($ip, $port, 'info');
	}
	
	public function get_players_by_ip($ip, $port) {
		return $this->get_data_by_ip($ip, $port, 'players');
	}
	
	public function get_query_by_ip($ip, $port) {
		return $this->get_data_by_ip($ip, $port, 'query');
	}
	
	public function get_ad_by_ip($ip, $port) {
		return $this->get_data_by_ip($ip, $port, 'ad');
	}
	
	// Private functions (can not be used outside the SACNRMonitor class)
	
	/*
		Syntax:
			private SACNRMonitor::get_data_by_id( string $server_id, string $action )
		
		Description:
			Gets the requested $action for the $server_id.
	*/
	private function get_data_by_id($server_id, $action) {
		return $this->get(array('ServerID' => $server_id, 'Action' => $action));
	}
	
	/*
		Syntax:
			private SACNRMonitor::get_data_by_ip( string $ip, string $port, string $action )
		
		Description:
			Gets the requested $action for the $ip and $port.
	*/
	private function get_data_by_ip($ip, $port, $action) {
		return $this->get(array('IP' => $ip, 'Port' => $port, 'Action' => $action));
	}
	
	/*
		Syntax:
			private SACNRMonitor::get( array $options )
		
		Description:
			Builds the final query URL, and handles errors. $options contains a list
			of querystrings to put into the URL. Eg, array('ServerID' => 123) will
			append &ServerID=123 onto the request URL. Uses SACNRMonitor::get_url()
			to fetch the URL.
	*/
	private function get($options) {
		$urlopt = array();
		foreach($options as $k => $v) {
			$urlopt[] = urlencode($k) . '=' . urlencode($v);
		}
		$url = $this->query_url . implode('&', $urlopt);
		$text = null;
		$response = $this->get_url($url, $text);
		if ($response === false) {
			$this->error(3, $text);
		}
		return $response;
	}
	
	/*
		Syntax:
			private SACNRMonitor::fopen( )
		
		Description:
			Returns true if the file_get_contents method is supported on this system.
	*/
	private function fopen() {
		return ini_get('allow_url_fopen') ? true : false;
	}
	
	/*
		Syntax:
			private SACNRMonitor::curl( )
		
		Description:
			Returns true if the cURL method is supported on this system.
	*/
	private function curl() {
		return function_exists('curl_init');
	}
	
	/*
		Syntax:
			private SACNRMonitor::error( int $e_num, string $ad_text = null )
		
		Description:
			All errors are triggered through this function. Makes it easy to disable
			them if required. $ad_text can be used to display extra information on an
			error.
	*/
	private function error($e_num, $ad_text = null) {
		$error = array(
			array(
				'You must install and enable the cURL module, or enable the PHP option \'allow_url_fopen\' to use this API.',
				E_USER_ERROR
			),
			array(
				'Tried to use cURL, but it was not enabled. Reverting to fopen...',
				E_USER_NOTICE
			),
			array(
				'Tried to use fopen, but it was not enabled. Reverting to cURL...',
				E_USER_NOTICE
			),
			array(
				'The server returned an error while fetching the requested data: '.htmlentities($ad_text),
				E_USER_NOTICE
			)
		);
		call_user_func_array('trigger_error', $error[$e_num]);
	}
	
	/*
		Syntax:
			private SACNRMonitor::get_url( string $url, string &$text )
		
		Description:
			Chooses cURL or file_get_contents to fetch the URL, and returns the
			result, unserialized. &$text will contain the raw result. If the result
			doesn't unserialize correctly (e.g. is boolean FALSE), then $text will
			probably contain the error message.
	*/
	private function get_url($url, &$text) {
		if ($this->use_curl) {
			if (!$this->ch) {
				$this->ch = curl_init();
				curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
			}
			curl_setopt($this->ch, CURLOPT_URL, $url);
			$result = curl_exec($this->ch);
		} else {
			$result = @file_get_contents($url);
		}
		return unserialize($result);
	}
}
 
endif;