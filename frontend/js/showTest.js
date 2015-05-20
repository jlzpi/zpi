Global.isTest = true;
Global.buttonIndex = 0;

function chosenPicture(testLength, index){
	for(i = 0; i <testLength; i++) {
		if (i === index){
			var id = "#" + i;
			$(id).css("border", "2px solid #990000");
		}
		else {
			var id = "#" + i;
			$(id).css("border", "none");
		}
	}	
}

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
		
		$('#question').html(questions[index]);
		$('#picture').attr('src', PictureUrl+directories[index]);
		$('#picture').css('display', 'block');
		$('#buttons').css('display', 'block');
		Global.questionId = ids[index];
				
		for(i = 0; i<testLength; i++) {
			var $but = $('<button/>', {
				text: i+1, 
				id: i,
				class: 'buttons',
				click: function(event) { 
					index = parseInt(event.target.id);
					$('#question').html(questions[index]);
					$('#picture').attr('src', PictureUrl+directories[index]);
					Global.questionId = ids[index];
					Global.buttonIndex = index;
					resetAnswer(); 
					chosenPicture(testLength, index); }
			});
			$('#allQuestions').append($but);
		}
		
		chosenPicture(testLength, index);

		$('#next').click(function() {
			if (index < testLength - 1) {
				$('#question').html(questions[++index]);
				$('#picture').attr('src', PictureUrl+directories[index]);
				Global.questionId = ids[index];
				Global.buttonIndex = index;
				resetAnswer();
				chosenPicture(testLength, index);
			}
		});
		
		$('#previous').click(function() {
			if (index > 0) {
				$('#question').html(questions[--index]);
				$('#picture').attr('src', PictureUrl+directories[index]);
				Global.questionId = ids[index];
				Global.buttonIndex = index;
				resetAnswer();
				chosenPicture(testLength, index);
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