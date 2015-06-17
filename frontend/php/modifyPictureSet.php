<?php include("header.php"); ?>

	<script type="text/javascript" src="../js/loadPic.js"></script>

	<script type="text/javascript" src="../js/sendPic.js"></script>
	<script type="text/javascript" src="../js/deletePic.js"></script>
	<script type="text/javascript" src="../js/loadThumbsToDelete.js"></script>

	<h2>Wgraj nowy obrazek:</h2>
	
	<form action="" method="post">	
		<div class="fileUpload">
			<input type="file" name="picture" class="custom-file-input" id="chooser">
		</div>	
		<div id="fileFromInput"></div>
		<input type="hidden" name="pictureURL" id="pictureURL"/>
		<input class="buttons" type="submit" id="sendImage">				
	</form>

	<h2>Usuń istniejące obrazki:</h2>

	<div id="images2"></div>
	<input type="submit" class="buttons" value="Usuń zaznaczone" id="deletePic">
		
<?php include("footer.php"); ?>

