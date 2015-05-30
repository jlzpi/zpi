$.ajax({
	type: 'GET',
	url: ApiUrl + 'panel/getCategories',
	dataType: 'json'
}).always(function(json) {
	if(typeof json.categories === 'undefined') var categories = [];
	else var categories = json.categories;

	$(document).ready(function() {
		
		var nowa=false;
		/* nowa */
		$("#dodajKategorie").click(function(e){

			if (nowa) {
				return;
			}

			e.preventDefault();
			var val=$.trim($("#nazwaKategorii").val());
			if (val=="") {
				alert("Wprowadź nazwę kategorii.");
				return;
			}
			if ($.inArray(val,categories)!==-1){
				//console.log(val +" > "+categories);
				alert("Kategoria już istnieje.");
				return;
			}

			$.ajax({
				method: 'GET',
				url: ApiUrl + 'panel/addCategory/'+val,
				data: {
				//	name: val
				},
				dataType: 'json'
			}).done(function(data) {
				alert("Dodano.");
				nowa=true;
				$("#dodajKategorie").click();

			}).fail(function(a,b,c) {
				alert("Nie można było dodać kategorii.");
			});
		});
		/* usuwane */

		var usunieto=false;
	$("#submit").click(function(e){

			if (usunieto) {
				return;
			}

			e.preventDefault();
			
			$(".chb:checked").each(function(){
				var catID=$(this).val();
				
				$.ajax({
					method: 'GET',
					url: ApiUrl + 'panel/deleteCategory/'+catID,
					data: {
						//id: catID
					},
					dataType: 'json'
				}).done(function(data) {
					alert('Usunięto.');
					usunieto=true;
					$("#submit").click();

				}).fail(function(a,b,c) {
					alert("Nie można było usunąć kategorii.");
				});
				
				
			});
	});


		$.each(categories, function(index, value) {
			//console.log(index+" >> "+value);
			


			var result = value;//.link(src);
			
			var opt = $('<input type="checkbox" class="chb" name="kategorie"/>');
			var span= $('<span></span>');
			var editBut=$('<input class="editBut" type="submit"/>');
			$(editBut).val("Zmień nazwę");
			var id="edit"+$(".editBut").length;
			$(editBut).id=id;

			var zmiana=false;
			$(editBut).on("click", function(e) {
				//console.log("klik");
				if (zmiana) 
					return;

				e.preventDefault();	
				
				$(".editBut").show();
				$(".decline").remove();
				$(".accept").remove();
				$(".name").remove();

				var button=$(this);

				$(this).hide();

				var newName = $('<input type="text" class="name"/>');
				newName.id="name"+$(".name").length;

				var accept=$('<input class="accept" type="submit"/>');
				$(accept).val("Zapisz zmianę");

				var decline=$('<input class="decline" type="submit"/>');
				$(decline).val("Anuluj");

				$(accept).on("click", function(e) {
					
						var name=$.trim($(newName).val());
						if (name=="") {
							alert("Wprowadź nazwę.");
							return;
						}
						$.ajax({
							method: 'GET',
							url: ApiUrl + 'panel/changeCategory/'+index+"/"+name,
							data: {
								//id: catID
							},
							dataType: 'json'
						}).done(function(data) {
							alert("Zmieniono.");
							zmiana=true;
							$(editBut).click();

						}).fail(function(a,b,c) {
							alert("Nie można było zmienić nazwy kategorii.");
						});



					//$(decline).click();
					
				});

				$(decline).on("click", function(e) {
					$(newName).remove();
					$(accept).remove();
					$(button).show();
					$(this).remove();
				});




				$(this).before(newName);
				$(this).before(accept);
				$(this).before(decline);


			});			

			
			span.html(result);
			
			opt.attr("value", index); //to check
			
			/*if (index == getGET('category')) {
				opt.attr('class', 'choosenCat');
			}*/

			
			$('#submit').before(opt);
			$('#submit').before(span);
			$('#submit').before(editBut);
			$('#submit').before("<br/>");
		});
		
		$(".radio:first").attr("checked",true);		
	});
});
	
