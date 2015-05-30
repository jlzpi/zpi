$.ajax({
	type: 'GET',
	url: ApiUrl+'getQuestionsFromCategoryToDisplay/' + getGET('category'),
	dataType: 'json'
}).done(function(json) {
	var questions = json.Questions;
	var directories = json.PictureDir;
	var ids = json.IDs;
	var lessonLength = json.Length;
	var index = 0;
	
	var questionAnswers = {};
	
	$(document).ready(function() {
				
		$('#question').html(questions[index]);
		$('#picture').attr('src', PictureUrl+directories[index]);
		$('#picture').css('display', 'block');
		$('#buttons').css('display', 'block');
		if(typeof questionAnswers[ids[index]] === 'undefined') {
			questionAnswers[ids[index]] = 2;
		}

		Global.questionId = ids[index];

		$('#next').click(function() {
			if (index < lessonLength - 1) {
				$('#question').html(questions[++index]);
				$('#picture').attr('src', PictureUrl+directories[index]);
				Global.questionId = ids[index];
				resetAnswer();
				if(typeof questionAnswers[ids[index]] === 'undefined') {
					questionAnswers[ids[index]] = 2;
				}
			}
		});
	
		$('#previous').click(function() {
			if (index > 0) {
				$('#question').html(questions[--index]);
				$('#picture').attr('src', PictureUrl+directories[index]);
				Global.questionId = ids[index];
				resetAnswer();
				if(typeof questionAnswers[ids[index]] === 'undefined') {
					questionAnswers[ids[index]] = 2;
				}
			}
		});
			
		$('#finish').click(function() {

			var action = 'finish.html';
			var stats = {
				lesson: json.CategoryName,
				correct: 0,
				wrong: 0,
				notAnswered: lessonLength
			};
			$.each(Global.answered, function(index, val) {
				if(typeof val === 'undefined') {
					stats.notAnswered++;
					questionAnswers[index] = 2;
				}
				else if(val.answerImg == PictureUrl + 'icons/correctAnswer.png') {
					stats.correct++;
					questionAnswers[index] = 1;
				}
				else if(val.answerImg == PictureUrl + 'icons/wrongAnswer.png') {
					stats.wrong++;
					questionAnswers[index] = 0;
				}
				else {
					stats.notAnswered++;
					questionAnswers[index] = 2;
				}
				stats.notAnswered--;
			});
			if(confirm("Jesteś pewny, że chcesz zakończyć lekcję?")) {
				$.ajax({
					type: 'POST',
					url: ApiUrl+'setStatistics',
					data: {
						questionAnswers: JSON.stringify(questionAnswers),
						userId: User.id
					}
				});
				
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