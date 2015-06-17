$.ajax({
	type: 'GET',
	url: ApiUrl + 'panel/getCategories',
	dataType: 'json'
}).done(function(json) {
	var categories = json.categories;

	$(document).ready(function() {
		$.each(categories, function(index, value) {
			var result = value;//.link(src);
			
			var opt = $('<input type="radio" class="radio" name="kategorie">');		
			opt.attr("value", index); //to check
			opt.attr("id", index);

			var label = $('<label for='+index+'>'+result+'</label>');				
			
			if (index == getGET('category')) {
				opt.attr('class', 'choosenCat');
			}
						
			$('#categories').append(opt);
			$('#categories').append(label);
			$('#categories').append("</br>");		
		});
		
		$(":radio[value="+getGET('category')+"]").attr("checked",true);
	});
}).fail(function(a, b, c) {
	if (typeof a.responseJSON !== 'undefined') {
		var message = a.responseJSON.error.exception[0].message;
		alert('Błąd odczytu kategorii: '+(typeof message === 'undefined'?c:message));
	}
});