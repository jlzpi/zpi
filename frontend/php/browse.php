<?php include("header.php"); ?>


<script src="../js/loadCategories.js"></script>
<script src="../js/loadThumbsToChoose.js"></script>
<script src="../js/loadQuestionData.js"></script>

<form action="" method="post">
					<h3>Pytanie</h3><br/>					
					
					<img id="picture"/>
					
					<!--<select id="kategorie" name="categories"/>-->
					<input type="hidden" name="pictureURL" id="pictureURL"/>
					
					
					<div id="images">
					Zmień obrazek:<br/>
					</div>

					<br/>
					Kategoria:
					<br/>
					<span id="label">Treść pytania:<span>
					<input type="text" name="quest" id="quest"/><br/>
					<div id="answers_and_keys"></div>
					<!--Treść odpowiedzi:<br/>
					<input type="text" name="answer" id="answer"><br/>
					Słowa kluczowe:<br/>
					<div id="keysDiv">
						<input type="text" name="key0" class="key"><button id="dodajKlucz">Dodaj klucz</button><br/>
					</div>-->
					<button id="wstecz">Poprzednie</button>
					<button id="edytuj">Zapisz zmiany</button>
					<button id="usun">Usuń pytanie</button>
					<button id="dalej">Następne</button>
					
</form>

<?php include("footer.php"); ?>
