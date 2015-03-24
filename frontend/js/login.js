$(document).ready(function() {
	if(typeof User.getUsername() === 'undefined' || !User.getUsername()) {
		$('#login').css('display', 'block');
		$('#logout').css('display', 'none');
	
		$('#loginForm').submit(function(e) {
			e.preventDefault();
			
			$.ajax({
				method: 'POST',
				url: ApiUrl + 'login',
				data: {
					login: $('#loginForm input[name=login]').val(),
					password: $('#loginForm input[name=password]').val()
				},
				dataType: 'json'
			}).done(function(data) {
				if(User.isStudent()) $(location).attr('href', 'chooseCategory.html');
				//else if(User.isTeacher()) $(location).attr('href', '../index.html'); <- to sie jeszcze zmieni jak dojdzie crud dla nauczyciela
				else location.reload(); // <- puki co jest to
			}).fail(function(a,b,c) {
				var message = a.responseJSON.error.exception[0].message;
				alert('Blad podczas logowania: '+message);
			});
			
			return false;
		});
	}
	else {
		$('#login').css('display', 'none');
		$('#logout').css('display', 'block');
		
		$('#user').html(User.getUsername());
		
		$('#logoutButton').click(function() {
			$.ajax({
				method: 'GET',
				url: ApiUrl + 'logout',
				dataType: 'json'
			}).done(function(data) {
				alert('Zostales pomyslnie wylogowany');
				location.reload();
			}).fail(function(a,b,c) {
				var message = a.responseJSON.error.exception[0].message;
				alert('Blad podczas wylogowania: '+(typeof message === 'undefined'?c:message));
			});
		});
	}
});
