window.onload = function chooseCat() {
	$.ajax({
		type: 'GET',
		url: '../backend/web/app_dev.php/api/getCategoriesToDisplay.json',
		dataType: 'json',
		success: function(json) {
			if (json['FindNotNull']) {
				var x = document.getElementById('list');
				var tablica = json['Categories'];
				for (i in tablica) { 
					var option = document.createElement("option");
					option.text = tablica[i];
					option.name = i;
					x.add(option);
				}
			}
			else {
				alert('Nie znaleziono kategorii.');
			}
		}
	});
}