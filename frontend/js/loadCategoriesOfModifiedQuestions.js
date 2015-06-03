$.ajax({
	type: 'GET',
	url: ApiUrl + 'panel/getCategories',
	dataType: 'json'
}).done(function(json) {
	var categories = json.categories;

	$(document).ready(function() {
		$.each(categories, function(index, value) {
			var src = 'browse.php?category=' + index;
			var result = value.link(src);
			var li = $('<li></li>');
			li.html(result);

			$('#categoriesList').append(li);
		});
	});
}).fail(function(a, b, c) {
	if (typeof a.responseJSON !== 'undefined') {
		var message = a.responseJSON.error.exception[0].message;
		alert('Błąd odczytu kategorii: '+(typeof message === 'undefined'?c:message));
	}
});
	