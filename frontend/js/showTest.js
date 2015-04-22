const testLength = 3;

Global.isTest = true;

$.ajax({
	type: 'GET',
	url: ApiUrl+'getRandomQuestionsToDisplay/' + testLength,
	dataType: 'json'
}).done(function(json) {
	if (json['FindNotNull']) {
		var question = json;
	}
	else {
		alert('Brak odpowiedniej liczby obrazków');
	}
	
	var questions = json.Questions;
	var directories = json.PictureDir;
	var ids = json.IDs;
	var index = 0;

	$(document).ready(function() {
		$('#question').html(questions[index]);
		$('#picture').attr('src', PictureUrl+directories[index]);
		$('#picture').css('display', 'block');
		$('#buttons').css('display', 'block');
		Global.questionId = ids[index];

		$('#next').click(function() {
			if (index < testLength - 1) {
				$('#question').html(questions[++index]);
				$('#picture').attr('src', PictureUrl+directories[index]);
				Global.questionId = ids[index];
				resetAnswer();
			}
		});
		
		$('#previous').click(function() {
			if (index > 0) {
				$('#question').html(questions[--index]);
				$('#picture').attr('src', PictureUrl+directories[index]);
				Global.questionId = ids[index];
				resetAnswer();
			}
		});
		
		$('#finish').click(function() {
			var action = 'finish.html';
			var stats = {
				lesson: 'test',
				correct: 0,
				wrong: 0,
				notAnswered: testLength
			};
			$.each(Global.answered, function(index, val) {
				if(typeof val === 'undefined') stats.notAnswered++;
				else if(val.answerImg == PictureUrl + 'icons/correctAnswer.png') stats.correct++;
				else if(val.answerImg == PictureUrl + 'icons/wrongAnswer.png') stats.wrong++;
				else stats.notAnswered++;
				stats.notAnswered--;
			});
			if(confirm("Jesteś pewny, że chcesz zakończyć lekcję")) {
				setCookie('stats', JSON.stringify(stats), 1);
				location.href = action;
				console.log('test');
			}
		});
	});
	
}).fail(function(a,b,message) {
		if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
		else alert('Nieznany blad');
});