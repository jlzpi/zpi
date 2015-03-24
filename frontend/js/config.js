var ApiUrl = '../../backend/web/app_dev.php/api/';
var PictureUrl = '../../files/';

var User = {
	isStudent: false,
	isTeacher: false,
	username: ''
};

$.holdReady(true);

$.ajax({
	method: 'GET',
	url: ApiUrl + 'getUser',
	dataType: 'json'
}).done(function(data) {
	User.username = data.user.username;
	User.isStudent = $.inArray('ROLE_STUDENT', data.user.roles)!=-1;
	User.isTeacher = $.inArray('ROLE_TEACHER', data.user.roles)!=-1;
}).always(function() {
	$.holdReady(false);
});
