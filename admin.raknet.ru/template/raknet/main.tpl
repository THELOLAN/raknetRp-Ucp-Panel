<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{project} | Admin</title>
		<base href="http://admin.raknet.ru">
		<link href="{template}css/bootstrap.min.css" rel="stylesheet">
		<link href="{template}font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="{template}css/animate.css" rel="stylesheet">
		<link href="{template}css/style.css" rel="stylesheet">
		{style}
		<link rel="shortcut icon" href="http://forum.raknet.ru/favicon.ico" type="image/x-icon">
		<link rel="icon" href="http://forum.raknet.ru/favicon.ico" type="image/x-icon">
	</head>
	<body class="">
		<div id="wrapper">
			<nav class="navbar-default navbar-static-side" role="navigation">
				<div class="sidebar-collapse">
					<ul class="nav" id="side-menu">
						{nav}
					</ul>
				</div>
			</nav>
			<div id="page-wrapper" class="gray-bg">
				<div class="row border-bottom">
					<nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
						<div class="navbar-header">
							<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
							<form role="search" class="navbar-form-custom" action="search_results.html">
								<div class="form-group">
									<input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
								</div>
							</form>
						</div>
					</nav>
				</div>
				<div class="row wrapper border-bottom white-bg page-heading">
					<div class="col-sm-4">
						<h2>{title}</h2>
					</div>
				</div>
				<div class="wrapper wrapper-content animated fadeInRight">
					<div class="row">
						{content}
					</div>
				</div>
				<div class="footer">
					<div>
						<strong>Copyright</strong> {project} &copy; {copyright}
					</div>
				</div>
			</div>
		</div>
		<!-- Mainly scripts -->
		<script src="{template}js/jquery-2.1.1.js"></script>
		<script src="{template}js/bootstrap.min.js"></script>
		<script src="{template}js/plugins/metisMenu/jquery.metisMenu.js"></script>
		<script src="{template}js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<!-- Custom and plugin javascript -->
		<script src="{template}js/inspinia.js"></script>
		<script src="{template}js/plugins/pace/pace.min.js"></script>
		{script}
	</body>
</html>