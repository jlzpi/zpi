$(document).ready(function() {
	$(document.forms[0]).submit(function(e) {
		e.preventDefault();
		
		if(typeof $('input:file')[0].files[0]==='undefined') return;
		
		var data = new FormData();
		data.append('file', $('input:file')[0].files[0]);
		
		$.ajax({
			type: 'POST',
			url: ApiUrl+'panel/addPicture',
			data: data,
			cache: false,
			contentType: false,
			processData: false
		}).done(function(json) {
			alert('Dodano zdjęcie');
		}).fail(function(a, b, c) {
			if (typeof a.responseJSON !== 'undefined') {
				var message = a.responseJSON.error.exception[0].message;
				alert('Błąd przy wysyłaniu obrazka: '+(typeof message === 'undefined'?c:message));
			}
			else {
				alert('Nie jesteś zalogowany jako nauczyciel');
			}
		});
		
		return false;
	});
});