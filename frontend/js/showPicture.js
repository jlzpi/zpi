var question;

$.ajax({
	type: 'GET',
	url: ApiUrl+'getQuestionFromCategoryToDisplay/' + getGET('category'),
	dataType: 'json',
	success: function(json) {
		if (json['FindNotNull']) {
			question = json;
		}
		else {
			alert('Nie znaleziono obrazka.');
		}
	},
	error: function(a,b, message) {
		if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
		else alert('Nieznany blad');
	}
});

$(document).ready(function() {
	$('#category').html('Category: ' + question.CategoryName);
	$('#question').html(question.Question);
	$('#picture').attr('src', PictureUrl+question.PictureDir);
	$('#picture').css('display', 'block');
});