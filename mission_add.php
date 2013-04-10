<?php

if (!empty($_POST))
{
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	
	// On insert dans la base de donnée
	require_once('db.php');
	
	$db = new PDO('mysql:host=localhost;dbname=mobeyes', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$insert = $pdo->prepare('
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
		$_POST['is_hidden'], 
		$_POST['need_text'], 
		0)
	);
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
<title>Backend</title>
<meta charset="UTF-8" />
</head>

<body>

<form action="mission_display.php" method="POST">
	<div>
		<p>
			<label for="mission_name">Nom de la mission:</label>
			<input type="text" name="mission_name" value="COUCOU" id="mission_name" />
		</p>
		
		<p>
			<label for="mission_description">Description:</label>
			<input type="text" name="mission_description" value="COUCOU" id="mission_description" />
		</p>
		
		<p>
			<label for="mission_address">Adresse:</label>
			<input type="text" name="mission_address" value="COUCOU" id="mission_address" />
		</p>
		
		<p>
			<label for="price_consumer">Prix consommateur:</label>
			<input type="text" name="price_consumer" value="COUCOU" id="price_consumer" />
		</p>
		
		<p>
			<label for="price_business">Prix business:</label>
			<input type="text" name="price_business" value="COUCOU" id="price_business" />
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