<?php
include('functions.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<title>Backend</title>
<meta charset="UTF-8" />
</head>

<body>

<?php
$missions = GetMissions();

/*
echo '<pre>';
print_r($missions);
echo '</pre>';
*/

?>

<h1>Liste des missions</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Nom</th>
		<th>Description</th>
		<th>Adresse</th>
		<th>Prix (consommateur)</th>
		<th>Prix (business)</th>
		<th>Nécessite du texte</th>
	</tr>
	<?php
	foreach($missions as $mission)
	{
	?>
	<tr style="text-align: center;">
		<td><?php echo $mission['id'] ?></td>
		<td><?php echo $mission['name'] ?></td>
		<td><?php echo $mission['resume'] ?></td>
		<td><?php echo $mission['address'] ?></td>
		<td><?php echo $mission['price_consumer'] ?>€</td>
		<td><?php echo $mission['price_business'] ?>€</td>
		<td><?php echo ($mission['need_text']) ? 'Oui' : 'Non'; ?></td>
	</tr>
	<?php
	}
	?>
</table>

<p>
	<a href="mission_add.php">Ajouter une mission</a>
</p>

</body>

</html>