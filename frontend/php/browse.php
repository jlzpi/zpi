<?php include("header.php"); ?>

	<script src="../js/loadCategories.js"></script>
	<script src="../js/loadThumbsToChoose.js"></script>
	<script src="../js/loadQuestionData.js"></script>

	<form action="" method="post">
		<h2>Edytuj wybrane Pytanie:</h2>	
		<div id="buttonContainer">
			<button class="buttons" id="wstecz">Poprzednie</button>
			<button class="buttons" id="edytuj">Zapisz zmiany</button>
			<button class="buttons" id="usun">Usuń pytanie</button>
			<button class="buttons" id="dalej">Następne</button>
		</div>					
			
		<div>			
			<img id="picture"/>
		</div>
					
		<!--<select id="kategorie" name="categories"/>-->
		<input type="hidden" name="pictureURL" id="pictureURL"/>
			
		<p>1) Zmień obrazek:</p>
		<div id="images"></div>

		<p>2) Zmień kategorię:</p>
		<div id = "categories"></div>
		
		<!--<span id="label">Treść pytania: <span>-->
		
		<p>3) Zmień treść pytania:</p>
		<input type="text" name="quest" id="quest"/>
		
		<p>4) Dodaj nową odpowiedź:</p>
		<button class="buttons" id="nowaOdpowiedz">Dodaj</button>
		
		<p>5) Zmień istniejące odpowiedzi:</p>

		<div id="answers_and_keys"></div>
					<!--Treść odpowiedzi:<br/>
					<input type="text" name="answer" id="answer"><br/>
					Słowa kluczowe:<br/>
					<div id="keysDiv">
						<input type="text" name="key0" class="key"><button id="dodajKlucz">Dodaj klucz</button><br/>
					</div>-->
					
					
</form>

<?php include("footer.php"); ?>
