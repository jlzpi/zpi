<?php include("header.php"); ?>

		<script src="../js/loadCategoriesCheckBox.js"></script>
		
		<form action="" method="post">
			<h2>Dodaj nową kategorię:</h2>
			<input type="text" id="nazwaKategorii" required/>
			<input type="submit" class="buttons" id="dodajKategorie"/>				
		</form>
				
		<form action="" method="post">
			<h2>Usuń/edytuj kategorię:</h2>
			<input type="submit" class="buttons" id="submit" value="Usuń zaznaczone"/>
		</form>

<?php include("footer.php"); ?>
