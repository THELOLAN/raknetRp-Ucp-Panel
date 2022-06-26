<?php
if(!defined('RUCP')) die("Hacking attempt!");

$get = isset($page[2]) ? $page[2] : "";
$get = (int)$get;

if($get == "")
{
		$style->content("{content}", "<div class=\"col-lg-12\">
										<div class=\"ibox float-e-margins\">
											<div class=\"ibox-content table-responsive\">
												<form role=\"form\" class=\"form-inline\">
													<div class=\"form-group\">
														<label for=\"exampleInputEmail2\" class=\"sr-only\">Имя игрока</label>
														<input type=\"text\" placeholder=\"Имя игрока (маска) Sadler или Alec\" id=\"name\" class=\"form-control\">
													</div>
													<div class=\"form-group\">
														<label for=\"exampleInputPassword2\" class=\"sr-only\">Номер аккаунта</label>
														<input type=\"text\" placeholder=\"Или номер аккаунта точный поиск\" id=\"userid\" class=\"form-control\">
													</div>
													<button class=\"btn btn-white\" type=\"button\" onClick=\"Search('/user.php', $('#name').val(), $('#userid').val());\">Искать</button>
												</form>
												<table class=\"table\">
													<thead>
														<tr>
															<th>
																Имя игрока
															</th>
															<th>
																Номер аккаунта
															</th>
															<th>
																Уровень
															</th>
														</tr>
													</thead>
													<tbody id=\"result\">
													</tbody>
												</table>
											</div>
										</div>
									</div>");
}
else
{
	$style->content("{content}", "<div class=\"col-lg-12\">
									<div class=\"ibox float-e-margins\">
										<div class=\"ibox-content table-responsive\">
										" . User::view($get) . "
									</div>
								</div>
								</div>");
}
$style->content("{title}", "Просмотр профиля");
$style->content("{style}", "");

$style->content("{script}", "
<script type=\"text/javascript\">

function Search(url, name, userid)
{
	$.ajax({
		type: \"POST\",
		url: url,
		data:
		{
			'name': name,
			'userid': userid
		},
		success: function(data)
		{
			document.getElementById(\"result\").innerHTML = data;
		}
	});
};
</script>
    <script src=\"" . template . "js/plugins/dataTables/jquery.dataTables.js\"></script>
    <script src=\"" . template . "js/plugins/dataTables/dataTables.bootstrap.js\"></script>
    <script src=\"" . template . "js/plugins/dataTables/dataTables.responsive.js\"></script>
    <script src=\"" . template . "js/plugins/dataTables/dataTables.tableTools.min.js\"></script>
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                responsive: true,
                \"dom\": 'T<\"clear\">lfrtip',
                \"tableTools\": {
                    \"sSwfPath\": \"" . template . "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf\"
                }
            });
        });
    </script>
	");