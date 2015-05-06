Global.isTest = true;

$.ajax({
	type: 'GET',
	url: ApiUrl+'getRandomQuestionsToDisplay',
	dataType: 'json'
}).done(function(json) {
	var questions = json.Questions;
	var directories = json.PictureDir;
	var ids = json.IDs;
	var testLength = json.Length;
	var index = 0;

	$(document).ready(function() {
		$('#userr').html(User.username);
		
		$('#logoutt').click(function() {
			$.ajax({
				method: 'GET',
				url: ApiUrl + 'logout',
				dataType: 'json'
			}).done(function(data) {
				alert('Zostales pomyslnie wylogowany');
				$(location).attr('href', 'login.html');
			}).fail(function(a,b,c) {
				var message = a.responseJSON.error.exception[0].message;
				alert('Blad podczas wylogowania: '+(typeof message === 'undefined'?c:message));
			});
		});
		
		
		$('#question').html(questions[index]);
		$('#picture').attr('src', PictureUrl+directories[index]);
		$('#picture').css('display', 'block');
		$('#buttons').css('display', 'block');
		Global.questionId = ids[index];
		
		for(i = 1; i <=testLength; i++) {
			var $but = $('<button/>', {
				text: i, 
				id: i,
				class: 'buttons',
				click: function(event) { 
					index = event.target.id - 1;
					$('#question').html(questions[index]);
					$('#picture').attr('src', PictureUrl+directories[index]);
					Global.questionId = ids[index];
					resetAnswer(); }
			});
			$('#allQuestions').append($but);
		}

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
			if(confirm("Jesteś pewny, że chcesz zakończyć test?")) {
				setCookie('stats', JSON.stringify(stats), 1);
				location.href = action;
				console.log('test');
			}
		});
	});
}).fail(function(a, b, c) {
	if (typeof a.responseJSON !== 'undefined') {
		var message = a.responseJSON.error.exception[0].message;
		alert('Błąd odczytu obrazków: '+(typeof message === 'undefined'?c:message));
	}
	else {
		alert('Nie jesteś zalogowany jako uczeń');
	}
});