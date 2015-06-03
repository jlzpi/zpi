<?php include("header.php"); ?>


	<script type="text/javascript" src="../js/loadPic.js"></script>

	<script type="text/javascript" src="../js/sendPic.js"></script>
	<script type="text/javascript" src="../js/deletePic.js"></script>
	<script type="text/javascript" src="../js/loadThumbsToDelete.js"></script>

	<h3>Wgraj obrazek</h3><br>
	<form action="" method="post">
					
					<input type="file" name="picture" id="chooser">
					<div id="fileFromInput"></div>
					<input type="hidden" name="pictureURL" id="pictureURL"/><br>
					<input type="submit">
				
	</form>


	<h3>Usuń obrazek</h3><br>
	
	<input type="submit" value="Usuń zaznaczone" id="deletePic">
	<br>
	<div id="images2"></div>
	
<?php include("footer.php"); ?>

