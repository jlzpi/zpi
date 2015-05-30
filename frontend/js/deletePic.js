$(document).ready(function() {
	$('#deletePic').click(function(e) {
		var img = {};
		$('#images2 input.chb:checked').each(function(index, val) {
			img[index] = $(val.value.split('/')).get(-1);
		});
		
		if($('#images2 input.chb:checked').length<1) return;
		
		$.ajax({
			type: 'POST',
			url: ApiUrl+'panel/deletePictures',
			data: {
				pictures: img
			},
			dataType: 'json'
		}).done(function(json) {
			alert('Usunięto zdjęcia');
			location.reload(); //takie na glupa
		}).fail(function(a, b, c) {
			if (typeof a.responseJSON !== 'undefined') {
				var message = a.responseJSON.error.exception[0].message;
				alert('Błąd przy usuwaniu obrazka: '+(typeof message === 'undefined'?c:message));
			}
			else {
				alert('Nie jesteś zalogowany jako nauczyciel');
			}
		});
	});
});