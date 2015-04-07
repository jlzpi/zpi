﻿const lessonLength = 3;

$.ajax({
	type: 'GET',
	url: ApiUrl+'getQuestionsFromCategoryToDisplay/' + getGET('category') + '/' + lessonLength,
	dataType: 'json'
}).done(function(json) {
	if (json['FindNotNull']) {
		var questions = json.Questions;
		var directories = json.PictureDir;
		var index = 0;
		
		$(document).ready(function() {
			$('#question').html(questions[index]);
			$('#picture').attr('src', PictureUrl+directories[index]);
			$('#picture').css('display', 'block');
			$('#buttons').css('display', 'block');
		
			$('#next').click(function() {
				if (index < lessonLength - 1) {
					$('#question').html(questions[++index]);
					$('#picture').attr('src', PictureUrl+directories[index]);
				}
			});
	
			$('#previous').click(function() {
				if (index > 0) {
					$('#question').html(questions[--index]);
					$('#picture').attr('src', PictureUrl+directories[index]);
				}
			});
		});
	}
	else {
		alert('Zbyt mało obrazków.');
	}
	
}).fail(function(a,b,message) {
		if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
		else alert('Nieznany blad');
});