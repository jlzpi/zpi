 $(document).ready(function() {
    $("input:file").on('change',function(e) {

//    for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
        var file = e.originalEvent.srcElement.files[0];

		
        var img = document.createElement("img");
        var reader = new FileReader();
        reader.onloadend = function() {
			img.src = reader.result;
        }
        reader.readAsDataURL(file);
        $("#fileFromInput").html(img);
   // }
});
    });