<?php

if (!empty($_POST))
{
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	
	$is_hidden = (!empty($_POST['is_hidden'])) ? true : false;
	$need_text = (!empty($_POST['need_text'])) ? true : false;
	
	// On insert dans la base de donnée
	require_once('db.php');

	$insert = $db->prepare('
	INSERT INTO 
		missions (
			name, 
			address, 
			resume, 
			price_consumer, 
			price_business, 
			is_hidden, 
			need_text, 
			user_id) 
		VALUES (?,?,?,?,?,?,?,?)');

	$insert->execute(array(
		$_POST['mission_name'], 
		$_POST['mission_address'], 
		$_POST['mission_description'], 
		$_POST['price_consumer'], 
		$_POST['price_business'], 
		$is_hidden, 
		$need_text, 
		0)
	);
	
	echo 'Nouvelle mission ajoutée !';
	
	header('Location: mission_display.php');
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
<title>Backend</title>
<meta charset="UTF-8" />
</head>

<body>

<form action="mission_add.php" method="POST">
	<div>
		<p>
			<label for="mission_name">Nom de la mission:</label>
			<input type="text" name="mission_name" value="Nom de la mission" id="mission_name" />
		</p>
		
		<p>
			<label for="mission_description">Description:</label>
			<input type="text" name="mission_description" value="Description de la mission" id="mission_description" />
		</p>
		
		<p>
			<label for="mission_address">Adresse:</label>
			<input type="text" name="mission_address" value="Adresse de la mission" id="mission_address" />
		</p>
		
		<p>
			<label for="price_consumer">Prix consommateur:</label>
			<input type="text" name="price_consumer" value="Prix consommateur" id="price_consumer" />
		</p>
		
		<p>
			<label for="price_business">Prix business:</label>
			<input type="text" name="price_business" value="Prix business" id="price_business" />
		</p>
		
		<p>
			<label for="is_hidden">Cacher ?</label>
			<input type="checkbox" name="is_hidden" id="is_hidden" />
		</p>
		
		<p>
			<label for="need_text">Nécessite du texte ?</label>
			<input type="checkbox" name="need_text" id="need_text" />
		</p>
		<br />
		
		<input type="submit" value="Ajouter" />
	</div>
</form>

</body>

</html>