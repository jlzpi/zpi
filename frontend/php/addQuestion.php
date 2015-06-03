<?php include("header.php"); ?>

		<script src="../js/loadThumbsToChoose.js"></script>
		<script src="../js/keyButton.js"></script>
		<script src="../js/loadCategories.js"></script>
	
					
					<form action="" method="post">
					<h3>Nowe pytanie</h3><br/>					
					Wybierz obrazek
					<div id="images"></div>
					<img id="picture"/>
					Wybierz kategorię:
					
				
					<input type="hidden" name="pictureURL" id="pictureURL"/>
					<br/>
					<span id="label">Treść pytania:</span><br/>
					<input type="text" name="quest" id="quest"/><br/>
					Treść odpowiedzi:<br/>
					<input type="text" name="answer" id="answer"><br/>
					Słowa kluczowe:<br/>
					<div id="keysDiv">
						<input type="text" name="key0" id="key0" class="key"><button id="dodajKlucz">Dodaj klucz</button><br/>
					</div>
					<input type="submit" id="submit">
					</form>
					

<?php include("footer.php"); ?>					
