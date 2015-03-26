function myFunction() {
	var list = document.getElementById("list");
	var idCategory = list.options[list.selectedIndex].name;
	var src = 'showPicture.html?category=' + idCategory;
	
    $(location).attr('href', src);
}

$(document).ready(function() {
	$('#choose').click(function() {
		myFunction();
	});
});