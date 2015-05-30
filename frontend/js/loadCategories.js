$.ajax({
	type: 'GET',
	url: ApiUrl + 'panel/getCategories',
	dataType: 'json'
}).done(function(json) {
	var categories = json.categories;

	$(document).ready(function() {
		$.each(categories, function(index, value) {
			var result = value;//.link(src);
			
			var opt = $('<input type="radio" class="radio" name="kategorie"/>');
			var span= $('<span></span>');
			
			
			span.html(result);
			
			opt.attr("value", index); //to check
			
			if (index == getGET('category')) {
				opt.attr('class', 'choosenCat');
			}

			
			$('#label').before(opt);
			$('#label').before(span);
			$('#label').before("<br/>");
		});
		
		$(".radio:first").attr("checked",true);		
	});
}).fail(function(a, b, c) {
	if (typeof a.responseJSON !== 'undefined') {
		var message = a.responseJSON.error.exception[0].message;
		alert('Błąd odczytu kategorii: '+(typeof message === 'undefined'?c:message));
	}
});