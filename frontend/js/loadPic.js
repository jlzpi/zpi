 $(document).ready(function() {
 console.log("re");
    $("input:file").on('change',function(e) {

	console.log("change");
//    for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
        var file = e.originalEvent.srcElement.files[0];

		
        var img = document.createElement("img");
        var reader = new FileReader();
        reader.onloadend = function() {
            console.log("NEW");
			img.src = reader.result;
        }
        reader.readAsDataURL(file);
        $("input:file").after(img);
   // }
});
    });