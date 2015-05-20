Global.buttonIndex = 0;

function chosenPicture(lessonLength, index){
	for(i = 0; i <lessonLength; i++) {
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

function navigationButtons(index, howManyButtons, lessonLength){
	if(howManyButtons != lessonLength) {
		var first = 1 + index - howManyButtons + parseInt(howManyButtons/2);	
		var maxPos = lessonLength - Math.round(howManyButtons/2);

		if(first >= 0 && index>=maxPos){
			first = lessonLength - howManyButtons;	
		}
		else if(first < 0 && index<maxPos){
			first = 0;
		}
		$('#allQuestions').children('button').each(function() {
			$(this).attr('id', first);
			first++;
			$(this).text(first);
		});	
		setAnswerdButton();
	}	
}

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
	var howManyButtons = 6; //ile buttonów ma wyświetlać
	
	if (lessonLength < howManyButtons){
		howManyButtons = lessonLength;
	}
	
	$(document).ready(function() {				
		$('#question').html(questions[index]);
		$('#picture').attr('src', PictureUrl+directories[index]);
		$('#picture').css('display', 'block');
		$('#buttons').css('display', 'block');

		Global.questionId = ids[index];
		
		for(i = 0; i<howManyButtons; i++) {
			var $but = $('<button/>', {
				text: i+1, 
				id: i,
				class: 'buttons',
				click: function(event) { 
					index = parseInt(event.target.id);
					$('#question').html(questions[index]);
					$('#picture').attr('src', PictureUrl+directories[index]);
					Global.questionId = ids[index];					
					navigationButtons(index, howManyButtons, lessonLength);
					Global.buttonIndex = index;
					resetAnswer(); 
					chosenPicture(lessonLength, index); 					
					}
			});
			$('#allQuestions').append($but);
		}
		
		chosenPicture(lessonLength, index);

		$('#next').click(function() {
			if (index < lessonLength - 1) {
				$('#question').html(questions[++index]);
				$('#picture').attr('src', PictureUrl+directories[index]);
				Global.questionId = ids[index];
				navigationButtons(index, howManyButtons, lessonLength);
				Global.buttonIndex = index;
				resetAnswer();
				chosenPicture(lessonLength, index);
			}
		});
	
		$('#previous').click(function() {
			if (index > 0) {
				$('#question').html(questions[--index]);
				$('#picture').attr('src', PictureUrl+directories[index]);
				Global.questionId = ids[index];
				navigationButtons(index, howManyButtons, lessonLength);
				Global.buttonIndex = index;
				resetAnswer();
				chosenPicture(lessonLength, index);
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
				if(typeof val === 'undefined') stats.notAnswered++;
				else if(val.answerImg == PictureUrl + 'icons/correctAnswer.png') stats.correct++;
				else if(val.answerImg == PictureUrl + 'icons/wrongAnswer.png') stats.wrong++;
				else stats.notAnswered++;
				stats.notAnswered--;
			});
			if(confirm("Jesteś pewny, że chcesz zakończyć lekcję?")) {
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