var ApiUrl = '../../backend/web/app_dev.php/api/';
var PictureUrl = '../../files/';

var User = {
	isStudent: function() {
		var ajax = $.ajax({
			method: 'GET',
			url: ApiUrl+'isStudent',
			dataType: 'json',
			async: false
		});
		return ajax.status == 200 && ajax.responseJSON.result;
	},
	isTeacher: function() {
		var ajax = $.ajax({
			method: 'GET',
			url: ApiUrl+'isTeacher',
			dataType: 'json',
			async: false
		});
		return ajax.status == 200 && ajax.responseJSON.result;
	},
	getUsername: function() {
		var ajax = $.ajax({
			method: 'GET',
			url: ApiUrl+'getUsername',
			dataType: 'json',
			async: false
		});
		return ajax.responseJSON.result;
	}
};