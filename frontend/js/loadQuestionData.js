var questions;
var current=0;

$.ajax({
	type: 'GET',
	url: ApiUrl + 'panel/getQuestions/'+getGET('category'),
	dataType: 'json'
}).done(function(json) {
		console.log("done");
		questions = json.questions;
		if (questions.length==0) 
			{
				alert("Brak pytań.");
				return;
			}
		//console.log(categories);
		$("#dalej").click(function (e){
			e.preventDefault();
			
			if (current+1<questions.length)
				current=current+1;
			loadQ();
			return;
		});

		$("#wstecz").click(function (e){
			e.preventDefault();
			if (current-1>=0)
				current=current-1;
			loadQ();
			return;
		});
		
		$(document).ready(loadQ);
	
}).fail(function(e) {
	alert("Wystąpił błąd.");
});


function loadQ() {
		console.log("load");
		

		$(":radio[value="+getGET('category')+"]").attr("checked",true);	
		var question=questions[current];

		var id=question.id;


		var url=PictureUrl+question.picture;
		$("#quest").val(question.question);
		$("#pictureURL").val(question.picture);
		$("#picture").attr("src",url);


		$('#usun').prop('onclick',null).off('click');
		var usunieto=false;
		$("#usun").click(function (e){
			if (usunieto) return;
			e.preventDefault();
			
			$.ajax({
				method: 'GET',
				url: ApiUrl + 'panel/deleteQuestion/'+id,
				data: {
					//answers: asd
				},
				dataType: 'json'
			}).done(function(data) {
				//TODO: alert z potwierdzeniem
				
				alert("Usunięto.");
				usunieto=true;
				$("#usun").click();

			}).fail(function(a,b,c) {
				alert("Nie można było usunąć pytania");
			});
						


		});

		




		console.log("id "+id);
		$.ajax({
				type: 'GET',
				url: ApiUrl + 'panel/getQuestionWithAnswers/'+id,
				dataType: 'json'
		}).done(function(js) {

			$("#nowaOdpowiedz").on("click",function(e) {
				e.preventDefault();
				addAnswerPanel(null,null);
			});

			var answers=js.question.answers;
			//console.log("ans "+answers);

			$("#answers_and_keys").empty();
			$.each(answers, function(key,val) {
				var answer=val.answer;
				var keywords=val.key_words.split(";");


				addAnswerPanel(answer,keywords);

				/*var answerBox=$('<input type="text" class="answer"/>');
				$(answerBox).val(answer);

				$("#answers_and_keys").empty();
				$("#answers_and_keys").append("<p>Odpowiedź:</p>");
				$("#answers_and_keys").append(answerBox);
				$("#answers_and_keys").append("<br/>");
				$("#answers_and_keys").append("<p>Klucze:</p>");

				var numAnswers=$(".anwers").length;
				$.each(keywords, function(k,v) {
					var keyBox=$('<input type="text" class="key'+numAnswers+'"/>');
					$(keyBox).val(v);

					$("#answers_and_keys").append(keyBox);
					$("#answers_and_keys").append("<br/>");
				});
				$("#answers_and_keys").append("<br/>");*/
			});

		})

	.fail(function(e) {
		alert("Wystąpił błąd :(");
	});

	var edytowano=false;
		$('#edytuj').prop('onclick',null).off('click');
		$("#edytuj").click(function (e){
			
			
			if (edytowano) return;

			var qu=$("#quest").val();
			e.preventDefault();
			var URL=$("#pictureURL").val();
			var n = URL.lastIndexOf('/');
			var resultURL = "pictures"+URL.substring(n);

			$.ajax({
				method: 'POST',
				url: ApiUrl + 'panel/changeQuestion/'+id,
				data: {
					
					picture: resultURL,
					question: qu
				},
				dataType: 'json'
			}).done(function(jsq) {
			//AJAX W AJAXIE

					var answ = [];

					console.log("L: "+$(".answer").length);

					for (var i = 0; i < $(".answer").length; i++) {
						var keys="";
						$.each($(".key"+i),function(){
							keys+=$(this).val()+";";
						});
						keys=keys.substring(0,keys.length-1);

						console.log($(".answer:eq("+i+")").val()+"***"+keys);
						var an= $(".answer:eq("+i+")").val();
						answ[i]={ 
							answer: an,
							keyWords: keys
						};
					};

					

					$.ajax({
						method: 'POST',
						url: ApiUrl + 'panel/modifyAnswers/'+jsq.questionId,
						data: {
							answers: answ	
						},
						dataType: 'json'
					}).done(function(data) {

						alert("Zmieniono.");
						edytowano=true;
						$("#edytuj").click();
						
					}).fail(function(a,b,c) {
						alert("Nie można było zmienić pytania :(");
					});


			//KONIEC				

				
			}).fail(function(a,b,c) {
				alert("Nie można było zmienić pytania");
			});
			
		});
}



function addAnswerPanel(answer,keywords) {

	var divAnswerPane=$('<div class="answerPane"></div>')
	divAnswerPane.id="answerPane"+$(".answerPane").length;

	var answerBox=$('<input type="text" class="answer"/>');
	if (answer!=null)
				$(answerBox).val(answer);


				$(divAnswerPane).append("<p>Odpowiedź:</p>");

				var usunOdp=$('<button>Usuń odpowiedź</button>');
				$(usunOdp).on("click", function(e) {
					e.preventDefault();
					$(divAnswerPane).remove();					
				});
				$(divAnswerPane).append(usunOdp);

				$(divAnswerPane).append(answerBox);
				$(divAnswerPane).append("<br/>");
				$(divAnswerPane).append("<p>Klucze:</p>");

				var numAnswers=$(".answer").length;
				
				var dodajKlucz=$('<button>Dodaj klucz</button>');
				$(dodajKlucz).on("click", function(e) {
					e.preventDefault();
					var keyBox=$('<input type="text" class="keyy key'+numAnswers+'"/>');
					$(divAnswerPane).append(keyBox);
					var usunKlucz=$('<button class="deleteKey">Usuń klucz</button>');
					$(usunKlucz).on("click", function(f) {
						f.preventDefault();
						$(keyBox).remove();
						$(usunKlucz).remove();
					});
					$(divAnswerPane).append(keyBox);
					$(divAnswerPane).append(usunKlucz);

				});

				$(divAnswerPane).append(dodajKlucz);
			
			if (keywords!=null){
				$.each(keywords, function(k,v) {
					var keyBox=$('<input type="text" class="keyy key'+numAnswers+'"/>');
					$(keyBox).val(v);

					$(divAnswerPane).append(keyBox);
					var usunKlucz=$('<button class="deleteKey">Usuń klucz</button>');
					$(usunKlucz).on("click", function(f) {
						f.preventDefault();
						$(keyBox).remove();
						$(usunKlucz).remove();
					});

					$(divAnswerPane).append(usunKlucz);

					$(divAnswerPane).append("<br/>");
				});
			}

	$("#answers_and_keys").append(divAnswerPane);			
	$("#answers_and_keys").append("<br/>");


}