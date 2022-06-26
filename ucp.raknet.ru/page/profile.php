<?php
if(!defined('RUCP')) die("Hacking attempt!");

$get = isset($page[2]) ? $page[2] : "";
$get = (int)$get;

if($member['member_id'])
{
	if($get == "") $get = $member['member_id'];
}
else
{
	if($get == "") $get = 3;
}

$style->content("{style}", "");
$style->content("{content}", "<div class=\"row\">
								<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
									" . User::view($get) . "
								</div>
							</div>");
$style->content("{script}", "<script type=\"text/javascript\">
			$(\".carousel.slide\").carousel({
				interval : 4000,
				cycle : true
			});
		</script>");