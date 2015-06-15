$(document).ready(function() {
	$("#dodajKlucz").on("click", function(e) {
		var newKey=document.createElement("input");
		var numItems = $('.key').length;
		var deleteKey=document.createElement("input");
		deleteKey.type="submit";
		deleteKey.id="delBut"+numItems;
		deleteKey.className="accept";
		$(deleteKey).val("Usuń");//attr("value","Usuń");
		//var t = document.createTextNode("Usuń");       // Create a text node
		//deleteKey.appendChild(t);                                // Append the text to <button>
	 
		$(deleteKey).on("click",function(f) {
			f.preventDefault();
			$("#key"+numItems).remove();
			$("#delBut"+numItems).remove();
		});
		
		
		newKey.type="text";
		newKey.className="key";
		newKey.name="key"+numItems;
		newKey.id="key"+numItems;
		console.log(newKey.name);
		
		var div = document.createElement("div");
		$(div).append(newKey);
		$(div).append(deleteKey);
		$("#keysDiv").append(div);
		
		
		e.preventDefault();
	});
	
	$("#submit").on("click", function(e) {
	
	
		e.preventDefault();
		//alert("kurna");
		var wrong=false;
		var quest=$.trim($("#quest").val());
		
		var answer=$.trim($("#answer").val());
		
		wrong=(quest=="" || answer=="");
		var keys="";
		$('.key').each(function(){
			var key=$.trim($(this).val());
			keys+=key+" "; //co przy wprowadzaniu? ';' ?
			if (key=="") {
				wrong=true;
				return false;
			}
		});
		
		if (wrong) {
			alert("Wprowadź poprawne dane!");	
			return;
		}
	
		var url=$("#pictureURL").val();
		if ($.trim(url)==""){
			alert("Zaznacz obrazek!");	
			return;
		}
		
		var category=$("input:radio[name='kategorie']:checked").val();
		
		var n = url.lastIndexOf('/');
		var result = "pictures"+url.substring(n);
		keys=keys.substring(0,keys.length-1); //usuń ostatnią spację
		console.log("k "+keys+"/");

		var asd = [{
			answer: answer,
			keyWords: keys
		}];
		
		$.ajax({
			method: 'POST',
			url: ApiUrl + 'panel/addQuestionWithAnswer/'+category,
			data: {
				question: quest,
				picture: result,
				answers: asd
			},
			dataType: 'json'
		}).done(function(data) {
			alert("Dodano.");
			
			var numItems = $('.key').length;
			for (var i = numItems; i > 0; i--) {
				$("#key"+i).remove();
				$("#delBut"+i).remove();
			};

			$("#key0").val("");
			
		}).fail(function(a,b,c) {
			//var message = a.responseJSON.error.exception[0].message;
			alert("Nie można było dodać pytania :(");
		});
	});
});