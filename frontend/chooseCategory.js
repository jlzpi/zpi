window.addEventListener("load", func, false);

function func() {
	document.getElementById("choose").addEventListener("click", myFunction);
}

function myFunction() {
	var list = document.getElementById("list");
	var idCategory = list.options[list.selectedIndex].name;
	var url = "showPicture.html?idCat=" + idCategory;
	
	//window.location.href = url;
   
   
   	//$.ajax({
		//type: 'GET',
		//url: 'showPicture.html',
		//dataType: 'json',
		//data: {
		//	idCat : idCategory
		//},
		//success: function(json) {
		//	if (json['FindNotNull']) {
		//		var x = document.getElementById('list');
		//		var tablica = json['Categories'];
		//		for (i in tablica) { 
		//			var option = document.createElement("option");
		//			option.text = tablica[i];
		//			option.name = i;
		//			x.add(option);
		//		}
		//	}
		//	else {
		//		alert('Nie znaleziono kategorii.');
		//	}
		//}
	//});

}