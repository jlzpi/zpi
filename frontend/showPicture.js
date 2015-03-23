window.onload = function showPic() {
	$.ajax({
		type: 'GET',
		url: '../backend/web/app_dev.php/api/getQuestionToDisplay.json',
		dataType: 'json',
		success: function(json) {
			if (json['FindNotNull']) {
				document.getElementById('question').innerHTML = json['Question'];
				document.getElementById('picture').src = json['PictureDir'];
				document.getElementById('picture').style.display = 'block';
			}
			else {
				alert('Nie znaleziono obrazka.');
			}
		}
	});
}