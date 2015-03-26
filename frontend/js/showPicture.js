$.ajax({
	type: 'GET',
	url: ApiUrl+'getQuestionFromCategoryToDisplay/' + getGET('category'),
	dataType: 'json'
}).done(function(json) {
		if (json['FindNotNull']) {
			var question = json;
		}
		else {
			alert('Nie znaleziono kategorii.');
		}

	$(document).ready(function() {
		$('#category').html('Category: ' + question.CategoryName);
		$('#question').html(question.Question);
		$('#picture').attr('src', PictureUrl+question.PictureDir);
		$('#picture').css('display', 'block');
	});
	
}).fail(function(a,b,message) {
		if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
		else alert('Nieznany blad');
});