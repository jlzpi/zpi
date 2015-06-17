$(document).ready(function() {
	$.ajax({
		type: 'GET',
		url: ApiUrl+'getStatisticsFromCategory/' + getGET('category') + '/' + User.id,
		dataType: 'json'
	}).done(function(json) {
		$('#clear').css('display', 'block');
		$('#statList').css('display', 'block');
		$('#count').html(json.Count);
		$('#notAnswered').html(json.NotAnswered);
		$('#learned').html(json.Learned);
		
		$('#pieChart').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: {
				text: ''
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				type: 'pie',
				name: 'Procent odpowiedzi',
				data: [
					['Poprawne', json.AllCorrect],
					['Niepoprawne', json.AllWrong],
					['Nieudzielone', json.AllNotAnswered]
				]
			}]
		});
		
		$('#clear').click(function() {
			if(confirm('Jesteś pewny, że chcesz wyczyścić statystyki z wybranej kategorii?')) {
				$.ajax({
					type: 'GET',
					url: ApiUrl+'clearStatisticsFromCategory/' + getGET('category') + '/' + User.id
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
			if(typeof message !== 'undefined' && message == 'Nie znaleziono statystyk z wybranej kategorii') {
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