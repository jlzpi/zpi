$.ajax({
	type: 'GET',
	url: ApiUrl + 'getCategoriesToDisplay',
	dataType: 'json'
}).done(function(json) {
	var categories = json.Categories;
	var pathname = window.location.pathname;
	var file = pathname.slice(pathname.lastIndexOf("/") + 1);

	$(document).ready(function() {
		$.each(categories, function(index, value) {
			if(file == 'finish.html' || file == 'showTest.html') {
				var src = 'showPicture.html?category=' + index;
			}
			else if(file == 'statistics.html') {
				var src = 'categoryStatistics.html?category=' + index;
			}
			else if(file == 'start.html') {
				var src = 'showPicture.html?category=' + index;
			}
			else {
				var src = file + '?category=' + index;
			}
			var result = value.link(src);
			var li = $('<li></li>');
			li.html(result);
			
			if (index == getGET('category')) {
				li.attr('class', 'choosenCat');
			}

			$('#categoriesList').append(li);
		});
		
		if(typeof Global.isTest !== 'undefined' && Global.isTest || Global.isAllStatictics) {
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
	