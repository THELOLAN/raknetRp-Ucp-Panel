<?php
$paymentId = isset($_GET['paymentId']) ? $_GET['paymentId'] : "";
echo "
<!DOCTYPE html>
<html>
	<head>
		<title>Произошла ошибка</title>
	</head>
	<body>
		Прозошла ошибка при пополнении счета.
		<br />
		Транзакция: #{$paymentId}
		<br />
		Дата: " . date("d.m.Y H:i", time()) . "
	</body>
</html>";