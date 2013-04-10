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
$missions = get_missions();

echo '<pre>';
print_r($missions);
echo '</pre>';
?>

<table>
	<tr>
		<th>ID</th>
		<th>Nom</th>
		<th>Description</th>
		<th>Adresse</th>
		<th>Prix (consommateur)</th>
		<th>Prix (business)</th>
	</tr>


</table>

</body>

</html>