var dir = "../../files/pictures";

var fileextension = [".png", ".jpg"];
$.ajax({
    //This will retrieve the contents of the folder if the folder is configured as 'browsable'
    url: dir,
    success: function (data) {
        //Lsit all png file names in the page
        $(data).find("a:contains(" + (fileextension[0]) + "), a:contains(" + (fileextension[1]) + ")").each(function () {
            var filename = this.href;//.replace(window.location.host, "").replace("http:///", "");
            var n = filename.lastIndexOf('/');
			var result = filename.substring(n);
			//console.log();
			var img=document.createElement("img");
			img.className+=" thumb";
			img.src=dir+result;
			
			var opt = $('<input type="checkbox" class="chb" name="kategorie"/>');
			$(opt).val(dir+result);
			$("#images2").append(opt);
			$("#images2").append(img);//$("<img class='thumb' src="+dir+result+ "></img>"));
        	$("#images2").append("<br/>")

        });
		/*$(".thumb").on("click", function(e){ 
			$(".thumb").removeClass("big");
			e.target.className+=" big";
			$("#pictureURL").attr('value',e.target.src);
			console.log("click "+$("#pictureURL").val());
		});*/
    }
});