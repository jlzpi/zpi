<?php include("header.php"); ?>


		<script src="../js/loadCategoriesCheckBox.js"></script>
		

		<form action="" method="post">
					<h3>Dodaj kategorię</h3><br/>
					<input type="text" id="nazwaKategorii" required/><br/>
					<input type="submit" id="dodajKategorie"/>
				
		</form>
				
		<form action="" method="post">
					<h3>Usuń/edytuj kategorię</h3><br/>
					<input type="submit" id="submit" value="Usuń zaznaczone"/>
		</form>

<?php include("footer.php"); ?>
