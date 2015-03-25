var tablica;

$.ajax({
	type: 'GET',
	url: ApiUrl + 'getCategoriesToDisplay',
	dataType: 'json',
	success: function(json) {
		if (json['FindNotNull']) {
			tablica = json['Categories'];
		}
		else {
			alert('Nie znaleziono kategorii.');
		}
	},
	error: function(a,b, message) {
		if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
		else alert('Nieznany blad');
	}
});
	
$(document).ready(function chooseCat() {
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