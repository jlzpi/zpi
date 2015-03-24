<!DOCTYPE html>

<html>
	<head>
		<meta charset = "utf-8">
		<title>Wyświetlenie obrazka</title>
		<link rel = "stylesheet" type = "text/css" href = "../css/showPicture.css">
		<script type = "text/javascript" src = "../js/jquery-2.1.3.js"></script>
		<script type = "text/javascript" src = "../js/config.js"></script>
		<script type="text/javascript">
			function showPic(categoryId)
			{
				$.ajax({
					type: 'GET',
					url: ApiUrl+'getQuestionFromCategoryToDisplay/' + categoryId + '.json',
					dataType: 'json',
					success: function(json) {
						if (json['FindNotNull']) {
							$('#category').html('Category: ' + json.CategoryName);
							$('#question').html(json.Question);
							$('#picture').attr('src', PictureUrl+json.PictureDir);
							$('#picture').css('display', 'block');
						}
						else {
							alert('Nie znaleziono obrazka.');
						}
					},
					error: function(syf, costam, message) {
						if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
						else alert('Nieznany blad');
					}
				});
			}
		</script>
	</head>

	<body>
		<?php
			echo ('<script type="text/javascript">showPic(' . $_GET['category'] . ');</script>');
		?>
		<div id = "category"></div>
		<div id = "question"></div>
		<img id = "picture">
	</body>
</html>