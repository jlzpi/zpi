$.ajax({
	type: 'GET',
	url: ApiUrl + 'getCategoriesToDisplay',
	dataType: 'json'
}).done(function(json) {
	var tablica = json.Categories;

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
}).fail(function(a, b, c) {
	if (typeof a.responseJSON !== 'undefined') {
		var message = a.responseJSON.error.exception[0].message;
		alert('Błąd odczytu kategorii: '+(typeof message === 'undefined'?c:message));
	}
});
	