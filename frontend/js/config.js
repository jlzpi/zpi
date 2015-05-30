var ApiUrl = '../../backend/web/app_dev.php/api/';
var PictureUrl = '../../files/';

var User = {
	isStudent: false,
	isTeacher: false,
	username: '',
	id: 0
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

function setCookie(name, value, days) {
    var d = new Date();
    d.setTime(d.getTime() + days*24*60*60*1000);
    var expires = "expires="+d.toUTCString();
    document.cookie = name + "=" + value + "; " + expires;
}
function getCookie(name) {
    var name = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name)==0) return c.substring(name.length, c.length);
    }
    return "";
}

$.holdReady(true);
$.ajax({
	method: 'GET',
	url: ApiUrl + 'getUser',
	dataType: 'json'
}).done(function(data) {
	User.id = data.user.id;
	User.username = data.user.username;
	User.isStudent = $.inArray('ROLE_STUDENT', data.user.roles)!=-1;
	User.isTeacher = $.inArray('ROLE_TEACHER', data.user.roles)!=-1;
}).always(function() {
	$.holdReady(false);
});
