var questions;
var current=0;
var zmianaKategorii=false;


	

		$(document).ready(function (e) {
				$("#dalej").click(function (e){
			e.preventDefault();
			console.log(" z "+zmianaKategorii);
			if (zmianaKategorii){
				getQ();
				return;
			}

			console.log(" L "+questions.length);
			if (current+1<questions.length)
				current=current+1;
			loadQ();
			return;
		});

		$("#wstecz").click(function (e){
			e.preventDefault();
			if (zmianaKategorii){
				getQ();
				return;
			}

			if (current-1>=0)
				current=current-1;
			loadQ();
			return;
		});



		$("#nowaOdpowiedz").click(function(e) {
				e.preventDefault();
				addAnswerPanel(null,null);
				return;
		});

			getQ();
		});

function getQ(){

	zmianaKategorii=false;
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
			if (current>=questions.length)
				current=0;
			//console.log(categories);
			
			
			loadQ();
		
	}).fail(function(e) {
		alert("Wystąpił błąd.");
	});

}

function loadQ() {
		console.log("load"+getGET('category'));
				

		$(":radio[value="+getGET('category')+"]").prop("checked",true);	
		
		

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
				getQ();//tocheck2
				//loadQ();//tocheck2
				//usunieto=true;
				//$("#usun").click();

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

			

			var answers=js.question.answers;
			//console.log("ans "+answers);

			$("#answers_and_keys").empty();
			$.each(answers, function(key,val) {
				var answer=val.answer;
				var keywords=val.key_words.split(/ +/);


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

	//var edytowano=false;
		$('#edytuj').prop('onclick',null).off('click');
		$("#edytuj").click(function (e){
			
			
			/*if (edytowano) {
				edytowano=false;
				loadQ();
				return;

			}*/
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

					//console.log("L: "+$(".answer").length);

					for (var i = 0; i < $(".answer").length; i++) {
						var keys="";
						$.each($(".key"+i),function(){
							keys+=$(this).val()+" ";
						});
						keys=keys.substring(0,keys.length-1);

						console.log($(".answer:eq("+i+")").val()+"***"+keys);
						var an= $(".answer:eq("+i+")").val();
						answ[i]={ 
							answer: an,
							keyWords: keys
						};
					};

					//change category
					//zmianaKategorii=true; //tocheck	
					if ($(":radio:checked").val()!=getGET('category')){
						zmianaKategorii=true;
						$.ajax({
							type: 'GET',
							url: ApiUrl + 'panel/changeQuestionCategory/'+id+'/'+$(":radio:checked").val(),
							dataType: 'json'
						}).done(function(json) {

						}).fail(function(json){
							alert("Wystąpił błąd :((");

						});
					}




					$.ajax({
						method: 'POST',
						url: ApiUrl + 'panel/modifyAnswers/'+jsq.questionId,
						data: {
							answers: answ	
						},
						dataType: 'json'
					}).done(function(data) {

						alert("Zmieniono.");
						getQ();//tocheck
						loadQ();
						//edytowano=true;
						//$("#edytuj").click();
						
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
	var divKeysPane=$('<div class="keysPane"></div>')
	divAnswerPane.id="answerPane"+$(".answerPane").length;

	var answerBox=$('<input type="text" class="answer"/>');
	if (answer!=null)
				$(answerBox).val(answer);


				//$(divAnswerPane).append("<p>5) Zmień istniejące odpowiedzi:</p>");

				var usunOdp=$('<button class="accept">Usuń odpowiedź</button>');
				$(usunOdp).on("click", function(e) {
					e.preventDefault();
					$(divAnswerPane).remove();					
				});
				
				$(divAnswerPane).append(answerBox);
				$(divAnswerPane).append(usunOdp);

				
				//$(divAnswerPane).append("<br/>");
				$(divKeysPane).append('<p id="textKey">Dodaj słowo kluczowe do odpowiedzi:</p>');

				var numAnswers=$(".answer").length;
				
				var dodajKlucz=$('<button class="buttons">Dodaj klucz</button>');
				$(dodajKlucz).on("click", function(e) {
					e.preventDefault();
					var keyBox=$('<input type="text" class="keyy key'+numAnswers+'"/>');
					$(divKeysPane).append(keyBox);
					var usunKlucz=$('<button class="accept">Usuń klucz</button>');
					$(usunKlucz).on("click", function(f) {
						f.preventDefault();
						$(keyBox).remove();
						$(usunKlucz).remove();
					});
					$(divKeysPane).append(keyBox);
					$(divKeysPane).append(usunKlucz);

				});

				$(divKeysPane).append(dodajKlucz);
				$(divKeysPane).append('<p>Zmień istniejące słowa kluczowe:</p>');
				
			    $(divAnswerPane).append(divKeysPane);
			if (keywords!=null){
				$.each(keywords, function(k,v) {
					var keyBox=$('<input type="text" class="keyy key'+numAnswers+'"/>');
					$(keyBox).val(v);

					$(divKeysPane).append(keyBox);
					var usunKlucz=$('<button class="accept">Usuń klucz</button>');
					$(usunKlucz).on("click", function(f) {
						f.preventDefault();
						$(keyBox).remove();
						$(usunKlucz).remove();
					});

					$(divKeysPane).append(usunKlucz);

					$(divAnswerPane).append(divKeysPane);
				});
			}

	$("#answers_and_keys").append(divAnswerPane);			
	//$("#answers_and_keys").append("<br/>");


}