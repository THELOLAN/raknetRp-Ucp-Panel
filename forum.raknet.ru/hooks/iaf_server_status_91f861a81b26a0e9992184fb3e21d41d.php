<?php
/*
$script['author'] = 'IAF (IandroidFan)';
$script['name'] = '(IAF34) ACP Server Status';
$script['version'] = '0.0.3';
print_r($script);
*/

	class iaf_server_status extends cp_skin_mycp {
	
	public function mainTemplate( $content, $ipsNewsData=array(), $nagEntries=array(), $stats=array() ) {
	
	 //Enabled?
	 if ($this->settings['iaf_server_status_display'] == '1') {
	 
		//Setting Up vars...
		$part = explode(',', $this->settings['iaf_server_status_data']);
		$css = "/*CSS from Bootstrap*/.progress{height:20px;margin-bottom:20px;overflow:hidden;background-color:#f5f5f5;border-radius:4px;-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,.1);box-shadow:inset 0 1px 2px rgba(0,0,0,.1)}.progress-bar{float:left;width:0;height:100%;font-size:12px;line-height:20px;color:#fff;text-align:center;background-color:#337ab7;-webkit-box-shadow:inset 0 -1px 0 rgba(0,0,0,.15);box-shadow:inset 0 -1px 0 rgba(0,0,0,.15);-webkit-transition:width .6s ease;-o-transition:width .6s ease;transition:width .6s ease}.progress-striped .progress-bar,.progress-bar-striped{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);-webkit-background-size:40px 40px;background-size:40px 40px}.progress.active .progress-bar,.progress-bar.active{-webkit-animation:progress-bar-stripes 2s linear infinite;-o-animation:progress-bar-stripes 2s linear infinite;animation:progress-bar-stripes 2s linear infinite}.progress-bar-success{background-color:#5cb85c}.progress-striped .progress-bar-success{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent)}.progress-bar-info{background-color:#5bc0de}.progress-striped .progress-bar-info{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent)}.progress-bar-warning{background-color:#f0ad4e}.progress-striped .progress-bar-warning{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent)}.progress-bar-danger{background-color:#d9534f}.progress-striped .progress-bar-danger{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent)}.progress{background-image:-webkit-linear-gradient(top,#ebebeb 0,#f5f5f5 100%);background-image:-o-linear-gradient(top,#ebebeb 0,#f5f5f5 100%);background-image:-webkit-gradient(linear,left top,left bottom,from(#ebebeb),to(#f5f5f5));background-image:linear-gradient(to bottom,#ebebeb 0,#f5f5f5 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffebebeb', endColorstr='#fff5f5f5', GradientType=0);background-repeat:repeat-x}.progress-bar{background-image:-webkit-linear-gradient(top,#337ab7 0,#286090 100%);background-image:-o-linear-gradient(top,#337ab7 0,#286090 100%);background-image:-webkit-gradient(linear,left top,left bottom,from(#337ab7),to(#286090));background-image:linear-gradient(to bottom,#337ab7 0,#286090 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff337ab7', endColorstr='#ff286090', GradientType=0);background-repeat:repeat-x}.progress-bar-success{background-image:-webkit-linear-gradient(top,#5cb85c 0,#449d44 100%);background-image:-o-linear-gradient(top,#5cb85c 0,#449d44 100%);background-image:-webkit-gradient(linear,left top,left bottom,from(#5cb85c),to(#449d44));background-image:linear-gradient(to bottom,#5cb85c 0,#449d44 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5cb85c', endColorstr='#ff449d44', GradientType=0);background-repeat:repeat-x}.progress-bar-info{background-image:-webkit-linear-gradient(top,#5bc0de 0,#31b0d5 100%);background-image:-o-linear-gradient(top,#5bc0de 0,#31b0d5 100%);background-image:-webkit-gradient(linear,left top,left bottom,from(#5bc0de),to(#31b0d5));background-image:linear-gradient(to bottom,#5bc0de 0,#31b0d5 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5bc0de', endColorstr='#ff31b0d5', GradientType=0);background-repeat:repeat-x}.progress-bar-warning{background-image:-webkit-linear-gradient(top,#f0ad4e 0,#ec971f 100%);background-image:-o-linear-gradient(top,#f0ad4e 0,#ec971f 100%);background-image:-webkit-gradient(linear,left top,left bottom,from(#f0ad4e),to(#ec971f));background-image:linear-gradient(to bottom,#f0ad4e 0,#ec971f 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff0ad4e', endColorstr='#ffec971f', GradientType=0);background-repeat:repeat-x}.progress-bar-danger{background-image:-webkit-linear-gradient(top,#d9534f 0,#c9302c 100%);background-image:-o-linear-gradient(top,#d9534f 0,#c9302c 100%);background-image:-webkit-gradient(linear,left top,left bottom,from(#d9534f),to(#c9302c));background-image:linear-gradient(to bottom,#d9534f 0,#c9302c 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffd9534f', endColorstr='#ffc9302c', GradientType=0);background-repeat:repeat-x}.progress-bar-striped{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent)}";
		
		//Uptime
		if (in_array('uptime', $part)) {
		$uptime_raw = explode(' ', file_get_contents("/proc/uptime"));
		$uptime_raw = $uptime_raw[0];
		$uptime_full = round($uptime_raw);
		$uptime_secs = $uptime_full % 60;
		$uptime_mins = round(($uptime_full - $uptime_secs) / 60 % 60);
		$uptime_hrs = round(($uptime_full / 60) - $uptime_mins - ($uptime_secs / 60)) / 60;
		$stat = array(
		'uptime' => $uptime_hrs . ' ч. ' . $uptime_mins . ' м. ' . $uptime_secs . ' с.',
		);
		}
		
		if (in_array('ram', $part) OR in_array('swap', $part)) {
		//RAM
		$meminfo = file("/proc/meminfo");
		for ($i = 0; $i < count($meminfo); $i++) {
		list($item, $data) = explode(":", $meminfo[$i]);
		$item = chop($item);
		$data = chop($data);
		if ($item == "MemTotal") { $total_mem = round($data /1024);	}
		if ($item == "MemFree") { $free_mem = round($data / 1024); }
		if ($item == "SwapTotal") { $total_swap = round($data / 1024); }
		if ($item == "SwapFree") { $free_swap = round($data / 1024); }
		}
		$used_mem = ( $total_mem - $free_mem ); 
		$used_swap = ( $total_swap - $free_swap );
		$percent_free = round( $free_mem / $total_mem * 100 );
		$percent_used = 100 - $percent_free;
		if ($total_swap != 0) { 
			$percent_swap = round( ( $total_swap - $free_swap ) / $total_swap * 100 ); 
			$percent_swap_free = 100 - $percent_swap;
		} else { 
			$percent_swap = "N/A"; 
			$percent_swap_free = "N/A"; 
		}
		}
		
		//Output
		$info = "<div style='width: 69%;' class='left' id='dashboard'>
		<style type='text/css'>{$css}</style>
		<div class='acp-box'>
		<h3>{$this->lang->words['iaf_server_status_title']}</h3>
		<div style='padding:5px'>";
		if (in_array('uptime', $part)) {
		$info .= "<p><b>{$this->lang->words['iaf_server_status_uptime']}</b> <i>{$stat['uptime']}</i></p>
		<br>";
		}
		if (in_array('ram', $part)) {
		$info .= "<p><b>{$this->lang->words['iaf_server_status_ram']}</b></p>
		<p><i><b>{$this->lang->words['iaf_server_status_all']}</b> - {$total_mem}Мб; <b>{$this->lang->words['iaf_server_status_free']}</b> - {$free_mem}Мб ({$percent_free}%); <b>{$this->lang->words['iaf_server_status_used']}</b> - {$used_mem}Мб ({$percent_used}%);</i></p>
		<br>
		<div class='progress'><div class='progress-bar progress-bar-danger' style='width: {$percent_used}%'></div><div class='progress-bar progress-bar-success' style='width: {$percent_free}%'></div></div>";
		}
		if (in_array('swap', $part)) {
		$info .= "<p><b>{$this->lang->words['iaf_server_status_swap']}</b></p>
		<p><i><b>{$this->lang->words['iaf_server_status_all']}</b> - {$total_swap}Мб; <b>{$this->lang->words['iaf_server_status_free']}</b> - {$free_swap}Мб ({$percent_swap_free}%); <b>{$this->lang->words['iaf_server_status_used']}</b> - {$used_swap}Мб ({$percent_swap}%);</i></p>
		<br>
		<div class='progress'><div class='progress-bar progress-bar-danger' style='width: {$percent_swap}%'></div><div class='progress-bar progress-bar-success' style='width: {$percent_swap_free}%'></div></div>";
		}
		$info .= "</div>
		</div><br>";
	
		//Get ACP Template
		$template = parent::mainTemplate( $content, $ipsNewsData, $nagEntries, $stats );
		
		$template2 = str_replace("<div style='width: 69%;' class='left' id='dashboard'>", $info, $template);
		
		//Returning Template
		return $template2;
	} else {
	$template = parent::mainTemplate( $content, $ipsNewsData, $nagEntries, $stats );
	return $template;
	}
	}
}
