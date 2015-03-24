window.addEventListener("load", func, false);

function func() {
	document.getElementById("choose").addEventListener("click", myFunction);
}

function myFunction() {
	var list = document.getElementById("list");
	var idCategory = list.options[list.selectedIndex].name;
	var src = 'showPicture.php?category=' + idCategory;
	
    $(location).attr('href', src);
}