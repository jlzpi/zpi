window.addEventListener("load", func, false);

function func() {
	document.getElementById("choose").addEventListener("click", myFunction);
}

function myFunction() {
	//var list = document.getElementById("list");
	//var idCategory = list.options[list.selectedIndex].name;
	
	window.open('showPicture.html?category=1');
    //$(location).attr('href', 'showPicture.html');
}