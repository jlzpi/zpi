$.ajax({
	type: 'GET',
	url: ApiUrl + 'getCategoriesToDisplay',
	dataType: 'json'
}).done(function(json) {
		if (json['FindNotNull']) {
			var tablica = json['Categories'];
		}
		else {
			alert('Nie znaleziono kategorii.');
		}
	
	$(document).ready(function() {
		var x = document.getElementById('list');
		for (i in tablica) { 
			var option = document.createElement("option");
			option.text = tablica[i];
			option.name = i;
			x.add(option);
		}
		$('#list').css('display', 'inline');
		$('#choose').css('display', 'inline');
	});
	
}).fail(function(a,b, message) {
		if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
		else alert('Nieznany blad');
});
	