<?php
session_start();
if( isset ( $_POST['proverka'] ) ) {

	if ( $_POST['proverka'] == "" && $_SESSION['proverka'] == 1 ) echo "Заполните все поля!<form action=\"http://{$_SERVER['HTTP_HOST']}/proverka.php\" method=\"POST\"><a href=\"#\" onclick=\"document.getElementById('security').src='http://{$_SERVER['HTTP_HOST']}/security.php?'+Math.random(); return false;\"><img id=\"security\" src=\"http://{$_SERVER['HTTP_HOST']}/security.php\"></a><br /><label>Введите код с картинки</label><br /><input type=\"text\" value=\"\" name=\"proverka\"><br /><input type=\"submit\" name=\"submit\" value=\"Я не бот\"></form>";
	elseif ( $_POST['proverka'] != $_SESSION['code'] && $_SESSION['proverka'] == 1 ) echo "неверно введён код<form action=\"http://{$_SERVER['HTTP_HOST']}/proverka.php\" method=\"POST\"><a href=\"#\" onclick=\"document.getElementById('security').src='http://{$_SERVER['HTTP_HOST']}/security.php?'+Math.random(); return false;\"><img id=\"security\" src=\"http://{$_SERVER['HTTP_HOST']}/security.php\"></a><br /><label>Введите код с картинки</label><br /><input type=\"text\" value=\"\" name=\"proverka\"><br /><input type=\"submit\" name=\"submit\" value=\"Я не бот\"></form>";
	else {
		$_SESSION['proverka'] = 0;
		echo "<script>setTimeout(\"document.location.href='http://{$_SERVER['HTTP_HOST']}/{$_SESSION['query']}'\", 0);</script>";
	}
}