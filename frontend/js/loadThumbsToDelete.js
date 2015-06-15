$.ajax({
	type: 'GET',
	url: ApiUrl + 'panel/getPictures',
	dataType: 'json'
}).done(function(data) {
	$(document).ready(function() {
		$.each(data.pictures, function(index, val) {
			var div = document.createElement("div");
			var img = document.createElement("img");
			img.className+="thumb";
			img.src=PictureUrl+'pictures/'+val;
			var opt = document.createElement("input");
			opt.type = "checkbox";
			opt.className = "chb";
			opt.name = "kategorie";
			//var opt = $('<input type="checkbox" class="chb" name="kategorie">');
			$(opt).val(img.src);
			
			div.appendChild(opt);
			div.appendChild(img);			
			$("#images2").append(div);			
			//$("#images2").append(opt);
			//$("#images2").append(img);//$("<img class='thumb' src="+dir+result+ "></img>"));
        	//$("#images2").append("<br>");
		});
	});
}).fail(function(a, b, c) {
	if (typeof a.responseJSON !== 'undefined') {
		var message = a.responseJSON.error.exception[0].message;
		alert('Błąd wczytywania obrazów: '+(typeof message === 'undefined'?c:message));
	}
});