$.ajax({
	type: 'GET',
	url: ApiUrl+'getRandomQuestionsToDisplay/' + getGET('howMany'),
	dataType: 'json'
}).done(function(json) {
		if (json['FindNotNull']) {
			var question = json;
		}
		else {
			alert('Brak odpowiedniej liczby obrazków');
		}
	
	var index = 0;
	var indexMax = getGET('howMany') - 1;
	
	$(document).ready(function() {
		
		var x = document.getElementById('test');
		x.setAttribute("class", 'choosenCat');
		
		var q = question.Questions;
		var d = question.PictureDir;
		var ids = json.IDs;
		$('#question').html(q[index]);
		$('#picture').attr('src', PictureUrl+d[index]);
		$('#picture').css('display', 'block');
		$('#buttons').css('display', 'block');
		Global.questionId = ids[index];
		Global.isTest = true;
				
		$('#next').click(function() {
			if (index < indexMax){
				index++;
			}			
			$('#question').html(q[index]);
			$('#picture').attr('src', PictureUrl+d[index]);
			$('#picture').css('display', 'block');
			Global.questionId = ids[index];
			resetAnswer();
		});
	});
	
}).fail(function(a,b,message) {
		if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
		else alert('Nieznany blad');
});