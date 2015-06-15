$.ajax({
	type: 'GET',
	url: ApiUrl + 'panel/getPictures',
	dataType: 'json'
}).done(function(data) {
	$(document).ready(function() {
		$.each(data.pictures, function(index, val) {
			var img = document.createElement("img");
			var div = document.createElement("div");
			img.className+=" thumb";
			div.className+=" thumbDiv";
			img.src=PictureUrl+'pictures/'+val;
			div.appendChild(img);
			$("#images").append(div);
		});
		
		$(".thumb").on("click", function(e){ 
			$(".thumb").removeClass("big");
			e.target.className+=" big";
			$("#pictureURL").attr('value',e.target.src);
		});
	});
}).fail(function(a, b, c) {
	if (typeof a.responseJSON !== 'undefined') {
		var message = a.responseJSON.error.exception[0].message;
		alert('Błąd wczytywania obrazów: '+(typeof message === 'undefined'?c:message));
	}
});