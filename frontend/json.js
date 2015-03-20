window.onload = function logowanie() {
	var sciezka="../backend/web/app_dev.php/api/zaloguj.json";
	//$.getJSON(sciezka, { format: "json"})
	//.done(function(data){
	//	$("#odpowiedz").html(data.info);
	//}
	
	//$('#odpowiedz').html('test');
	
	$.ajax({
		method: 'POST',
		url: sciezka,
		data: { login: 'ola', haslo: 'mojehaslo' }
	})
	.done(function(data) {
		$('#odpowiedz').html(data.info);
	});
}
	