$(document).ready(function showPic() {
	$.ajax({
		type: 'GET',
		url: ApiUrl+'getQuestionToDisplay.json',
		dataType: 'json',
		success: function(json) {
			if (json['FindNotNull']) {
				$('#question').html(json.Question);
				$('#picture').attr('src', PictureUrl+json.PictureDir);
				$('#picture').css('display', 'block');
			}
			else {
				alert('Nie znaleziono obrazka.');
			}
		},
		error: function(syf, costam, message) {
			if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
			else alert('Nieznany blad');
		}
	});
});