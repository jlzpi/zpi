var ApiUrl = '../../backend/web/app_dev.php/api/';
var PictureUrl = '../../files/';

var User = {
	isStudent: false,
	isTeacher: false,
	username: ''
};

var Global = {};

function getGET(param) {
    var pageURL = window.location.search.substring(1);
    var URLVariables = pageURL.split('&');
    for (var i=0; i<URLVariables.length; i++) {
        var parameterName = URLVariables[i].split('=');
        if (parameterName[0] == param) {
            return parameterName[1];
        }
    }
}

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
