$(document).ready(function() {
	$('#user').html(User.username);
	var clicked = 0;
	
	$('#logout').click(function() {
		if(++clicked == 1) {
			$.ajax({
				method: 'GET',
				url: ApiUrl + 'logout',
				dataType: 'json'
			}).done(function(data) {
				alert('Zostales pomyslnie wylogowany');
				$(location).attr('href', 'login.html');
				clicked = 0;
			}).fail(function(a,b,c) {
				var message = a.responseJSON.error.exception[0].message;
				alert('Blad podczas wylogowania: '+(typeof message === 'undefined'?c:message));
				clicked = 0;
			});			
		}
	});
});