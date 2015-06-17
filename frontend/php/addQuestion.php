<?php include("header.php"); ?>

		<script src="../js/loadThumbsToChoose.js"></script>
		<script src="../js/keyButton.js"></script>
		<script src="../js/loadCategories.js"></script>
						
		<form id="form" action="" method="post">
			
			<h2>Zdefiniuj nowe pytanie:</h2>				
			
			<p>1) Wybierz obrazek:</p>
			<div id="images"></div>
			<!--<img id="picture"/>-->
			
			<p>2) Wybierz kategorię:</p>
			<input type="hidden" name="pictureURL" id="pictureURL">
					
			<div id = "categories">
			</div>
					
			<p>3) Podaj treść pytania:</p>
			<input type="text" name="quest" id="quest">
			
			<p>4) Podaj treść odpowiedzi:</p>
			<input type="text" name="answer" id="answer">
				
			<p>5) Podaj słowo kluczowe:</p>				
			<div id="keysDiv">
				<input type="text" name="key0" id="key0" class="key">
				<button class="accept" id="dodajKlucz">Dodaj klucz</button>
			</div>
				
			<h3>Dodaj nowe pytanie do bazy pytań:</h3>	
			<input class="buttons" type="submit" id="submit">
			
		</form>
					

<?php include("footer.php"); ?>					
