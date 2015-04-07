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
		var q = question.Questions;
		var d = question.PictureDir;
		$('#question').html(q[index]);
		$('#picture').attr('src', PictureUrl+d[index]);
		$('#picture').css('display', 'block');
		
		$('#previous').click(function() {
			if (index > 0){	
				index--;
			}			
			$('#question').html(q[index]);
			$('#picture').attr('src', PictureUrl+d[index]);
			$('#picture').css('display', 'block');
		});
		
		$('#next').click(function() {
			if (index < indexMax){
				index++;
			}			
			$('#question').html(q[index]);
			$('#picture').attr('src', PictureUrl+d[index]);
			$('#picture').css('display', 'block');
		});
	});
	
}).fail(function(a,b,message) {
		if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
		else alert('Nieznany blad');
});