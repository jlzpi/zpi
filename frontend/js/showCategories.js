$.ajax({
	type: 'GET',
	url: ApiUrl + 'getCategoriesToDisplay',
	dataType: 'json'
}).done(function(json) {
	var categories = json.Categories;

	$(document).ready(function() {
		var x = $('#categoriesList').get(0);
		
		$.each(categories, function(index, value) {
			var src = 'showPicture.html?category=' + index;
			var result = value.link(src);
			var div = document.createElement('li');
			
			if (index == getGET('category')){
				div.setAttribute('class', 'choosenCat');
			}

			div.innerHTML = result;
			x.appendChild(div);
		});
		
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
	