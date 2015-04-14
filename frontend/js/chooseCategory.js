function clickShowPicture() {
	var list = document.getElementById("list");
	var idCategory = list.options[list.selectedIndex].name;
	var src = 'showPicture.html?category=' + idCategory;
	
    $(location).attr('href', src);
}

function clickShowTest() {
	var src = 'showTest.html?howMany=' + 4;	
    $(location).attr('href', src);
}

$(document).ready(function() {
	$('#choose').click(function() {
		clickShowPicture();
	});
	$('#test').click(function() {
		clickShowTest();
	});
});