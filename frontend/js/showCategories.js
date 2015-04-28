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
		var x = document.getElementById('categoriesList');
		for (i in tablica) { 		
			var str = tablica[i];
			var src = 'showPicture.html?category=' + i;
			var result = str.link(src);	
			var div = document.createElement('li');

			if (i == getGET('category')){
				div.setAttribute('class', 'choosenCat');
			}

			div.innerHTML = result;
			x.appendChild(div);
		}
		if(typeof Global.isTest !== 'undefined' && Global.isTest) {
			var x = $('#test');
			x.attr('class', 'choosenCat');
		}
	});
	
}).fail(function(a,b, message) {
		if(message == 'Forbidden') alert('Nie jestes zalogowany jako uczen');
		else alert('Nieznany blad');
});
	