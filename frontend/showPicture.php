﻿<!DOCTYPE html>

<html>
	<head>
		<meta charset = "utf-8">
		<title>Wyświetlenie obrazka</title>
		<link rel = "stylesheet" type = "text/css" href = "css/showPicture.css">
		<script type = "text/javascript" src = "jquery-2.1.3.js"></script>
		<script type = "text/javascript" src = "showPicture.js"></script>
		<?php
			echo $_GET['idCat'];
		?>
	</head>

	<body>
		<div id = "question"></div>
		<img id = "picture" height = "512">
	</body>
</html>