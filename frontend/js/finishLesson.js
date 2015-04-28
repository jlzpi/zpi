$(document).ready(function() {
	var stats = getCookie('stats');
	stats = stats=='' ? {} : JSON.parse(stats);
	setCookie('stats','',-1);
	stats.all = stats.correct + stats.wrong + stats.notAnswered;
	
	$('#lesson').html(stats.lesson);
	
	$('#correct').html(stats.correct);
	$('#correctP').html(Math.round(stats.correct*100/stats.all)+'%');
	$('#wrong').html(stats.wrong);
	$('#wrongP').html(Math.round(stats.wrong*100/stats.all)+'%');
	$('#notAnswered').html(stats.notAnswered);
	$('#notAnsweredP').html(Math.round(stats.notAnswered*100/stats.all)+'%');
	$('#all').html(stats.all);
});