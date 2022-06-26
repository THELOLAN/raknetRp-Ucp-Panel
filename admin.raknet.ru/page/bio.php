<?php
if(!defined('RUCP')) die("Hacking attempt!");


$get = isset($page[2]) ? $page[2] : "";
$get = (int)$get;

if($get == "") $get = 0;

$style->content("{title}", "Проверка биографий");
$style->content("{style}", "
	<link href=\"" . template . "css/plugins/dataTables/dataTables.bootstrap.css\" rel=\"stylesheet\">
	<link href=\"" . template . "css/plugins/dataTables/dataTables.responsive.css\" rel=\"stylesheet\">
	<link href=\"" . template . "css/plugins/dataTables/dataTables.tableTools.min.css\" rel=\"stylesheet\">
	<style>
		body.DTTT_Print {
			background: #fff;
		}
		.DTTT_Print #page-wrapper {
			margin: 0;
			background:#fff;
		}
		button.DTTT_button, div.DTTT_button, a.DTTT_button {
			border: 1px solid #e7eaec;
			background: #fff;
			color: #676a6c;
			box-shadow: none;
			padding: 6px 8px;
		}
		button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
			border: 1px solid #d2d2d2;
			background: #fff;
			color: #676a6c;
			box-shadow: none;
			padding: 6px 8px;
		}
		.dataTables_filter label {
			margin-right: 5px;

		}
	</style>");

$style->content("{content}", "<div class=\"col-lg-12\">
								<div class=\"ibox float-e-margins\">
									<div class=\"ibox-content table-responsive\">
										" . User::bio($get) . "
										"  . User::checkbio() . "
									</div>
								</div>
							</div>");