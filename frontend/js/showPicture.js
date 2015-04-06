const lessonLength = 3;

$.ajax({
	type: 'GET',
	url: ApiUrl+'getQuestionsFromCategoryToDisplay/' + getGET('category') + '/' + lessonLength,
	dataType: 'json'
}).done(function(json) {
	if (json['FindNotNull']) {
		var questions = json.Questions;
		var directories = json.PictureDir;
		var actual = 0;
	}
	else {
		alert('Nie znaleziono kategorii lub zbyt mało obrazków.');
	}

	$(document).ready(function() {
		$('#question').html(questions[actual]);
		$('#picture').attr('src', PictureUrl+directories[actual]);
		$('#picture').css('display', 'block');
		$('#formNavigate').css('display', 'block');
		
		$('#next').click(function() {
			if (actual < lessonLength - 1) {
				$('#question').html(questions[++actual]);
				$('#picture').attr('src', PictureUrl+directories[actual]);
			}
		});

		$('#previous').click(function() {
			if (actual > 0) {
				$('#question').html(questions[--actual]);
				$('#picture').attr('src', PictureUrl+directories[actual]);
			}
		});
	});
	
}).fail(function(a,b,message) {
		if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
		else alert('Nieznany blad');
});