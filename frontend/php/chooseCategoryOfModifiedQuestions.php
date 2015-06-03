<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Kurs angielskiego - lekcja</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" type="text/css" href="../css/tp.css">

		<script type="text/javascript" src="../js/jquery-2.1.3.js"></script>
		<script type="text/javascript" src="../js/config.js"></script>

		<script type="text/javascript" src="../js/logout.js"></script>
		<script type="text/javascript" src="../js/loadCategoriesOfModifiedQuestions.js"></script>
	</head>

	<body> 
		<div id="wrapper">
			<div id="logoutContainer">
				<div id="blockOuter">
					<div>Jesteś zalogowany jako: <a href="#" id="user" class="white"></a></div>
					<div><a href="#" id="logout" class="white">Wyloguj</a></div>
				</div>
			</div>
		
			<div id="menu">
				<ul>
					<li>
						<a href="teacherPane.php">Home</a>
					</li>
					<li>
						<a href="addQuestion.php">Dodaj pytanie</a>
					</li>
					<li>
						<a href="modifyPictureSet.php">Obrazki</a>
					</li>
					<li>
						<a href="modifyCategoriesSet.php">Kategorie</a>
					</li>
					<li>
						<a href="chooseCategoryOfModifiedQuestions.php">Edytuj pytania</a>
					</li>
				</ul>
			</div>
			<div id="header" class="ribboncontainer">
				<div class="ribbon"><h1>Interaktywna nauka angielskiego</h1></div>
			</div>
			<div id="container">
				<div id="page">
				<div id="content">	
					<h3>Wybierz kategorię, z której chcesz modyfikować pytania:</h3>
					<ul id="categoriesList"></ul>

<?php include("footer.php"); ?>