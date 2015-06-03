$(document).ready(function() {
	$.ajax({
		type: 'GET',
		url: ApiUrl+'getStatistics/' + User.id,
		dataType: 'json'
	}).done(function(json) {
		$('#clear').css('display', 'block');
		$('#statList').css('display', 'block');
		$('#count').html('Liczba wszystkich pytań: ' + json.Count);
		$('#notAnswered').html('Liczba pytań bez odpowiedzi: ' + json.NotAnswered);
		$('#learned').html('Liczba opanowanych pytań: ' + json.Learned);
		
		var tab = json.StatsFromCategories;
		
		var categ = new Array();
		var correct = new Array();
		var wrong = new Array();
		var notAnswered = new Array();
		for(var key in tab) {
			categ.push(key);
			correct.push(tab[key]['correct']);
			wrong.push(tab[key]['wrong']);
			notAnswered.push(tab[key]['notAnswered']);
		}
		
		$('#columnChart').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: 'Statystyki z poszczególnych kategorii'
			},
			xAxis: {
				categories: categ,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Liczba odpowiedzi'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Bez odpowiedzi',
				data: notAnswered,
				index: 3
			}, {
				name: 'Niepoprawne',
				data: wrong,
				index: 2
			}, {
				name: 'Poprawne',
				data: correct,
				index: 1
			}]
		});
		
		$('#clear').click(function() {
			if(confirm('Jesteś pewny, że chcesz wyczyścić statystyki ze wszystkich kategorii?')) {
				$.ajax({
					type: 'GET',
					url: ApiUrl+'clearStatistics/' + User.id
				}).done(function() {
					location.reload();
				}).fail(function(a, b, c) {
					alert('Błąd podczas usuwania statystyk');
				});
			}
		});
	}).fail(function(a, b, c) {
		if (typeof a.responseJSON !== 'undefined') {
			var message = a.responseJSON.error.exception[0].message;
			if(typeof message !== 'undefined' && message == 'Nie znaleziono statystyk podanego użytkownika') {
				$('#emptyStats').css('display', 'block');
			}
			else {
				alert('Błąd odczytu obrazków: '+(typeof message === 'undefined'?c:message));
			}
		}
		else {
			alert('Nie jesteś zalogowany jako uczeń');
		}
	});
});