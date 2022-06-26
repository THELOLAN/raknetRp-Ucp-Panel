<?php
if(!defined('RUCP')) die("Hacking attempt!");

$get = isset($page[2]) ? $page[2] : "";
$get = (int)$get;

if($member['member_id'])
{
	if($get == "") $get = 0;
}
else
{
	if($get == "") $get = 0;
}
$style->content("{style}", "");

$style->content("{content}", "<div class=\"row\">
									<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive\">
										" . Bio::viewbio($get) . "
									</div>
								</div>");