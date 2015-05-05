Global.answered = {};

function resetAnswer() {
	if(typeof Global.answered[Global.questionId] !== 'undefined') {
		if(typeof Global.isTest !== 'undefined' && Global.isTest) {
			$('#send').hide();
		}
		else $('#send').show();
		$('#textarea').val(Global.answered[Global.questionId].textarea);
		$('#answer').html(Global.answered[Global.questionId].answer);
		$('#answerImg').attr('src', Global.answered[Global.questionId].answerImg);
	}
	else {
		$('#textarea').val('');
		$('#answer').html('');
		$('#answerImg').attr('src', '');
		$('#send').show();
	}
}

$(document).ready(function() {
console.log("READY");
	var recognition = new webkitSpeechRecognition();
	var recognizing=false; 
	recognition.continuous = false;
	recognition.lang = "en";
	var url="url('../../files/icons/";
	//recognition.interimResults=true;
	$("#textarea").attr("disabled",false);
	// reset();
	$("#toggleMic").click(function() {
		if (recognizing) {
		
console.log("stop");
			recognition.stop();
			recognizing = false;  
			$("#textarea").attr("disabled",false);
			$("#toggleMic").text("Start speaking");
			$('#toggleMic').css("background-image", url+"mikro.png')");
		}
		else {
		
console.log("start");
			recognition.start();
			recognizing = true;
			$("#textarea").attr("disabled",true);
			$("#toggleMic").text("Stop speaking");
			$('#toggleMic').css("background-image", url+"mikroDis.png')");
		}
	});

	recognition.onresult=function (event) {
	
console.log("res" + event.resultIndex +" - "+event.results.length);
		for (var i = event.resultIndex; i < event.results.length; ++i) {
			if (event.results[i].isFinal) {
				$("#textarea").val($("#textarea").val()+event.results[i][0].transcript);
				console.log(event.results[i][0].transcript);
			}
		}
	};
	
	recognition.onend=function(event) {
		recognition.start();
	}

	$('#send').click(function() {
		if(typeof Global.questionId === 'undefined') {
			alert('wystapil niespodziewany blad');
			return;
		}
		$.ajax({
			method: 'POST',
			url: ApiUrl + 'checkAnswer',
			data: {
				id:		Global.questionId,
				answer:	$('#textarea').val()
			},
			dataType: 'json'
		}).done(function(data) {
			if(data.correct == true) {
				$('#answer').html(data.answer);
				$('#answerImg').attr('src', PictureUrl + 'icons/correctAnswer.png');
			}
			else {
				$('#answer').html(data.answer);
				$('#answerImg').attr('src', PictureUrl + 'icons/wrongAnswer.png');
			}
			Global.answered[Global.questionId] = {
				textarea: $('#textarea').val(),
				answer: $('#answer').html(),
				answerImg: $('#answerImg').attr('src')
			};
			resetAnswer();
		}).fail(function(a,b,c) {
			var message = a.responseJSON.error.exception[0].message;
			alert('Blad: '+message);
		});
	});
});
