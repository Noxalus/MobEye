<?php
function login($email, $password)
{
}

function is_login($cookie)
{

}

function logout($cookie)
{
}

function new_user($email, $password, $first_name, $last_name, $birth_date, $place)
{
}

function get_missions()
{
}

function get_user($cookie)
{
	$date = new DateTime();
	echo $date->format('Y-m-d H:i:s') . '<br />';
	$date->add(new DateInterval('PT2H'));
	echo $date->format('Y-m-d H:i:s');
}

function accept_mission($cookie, $id_mission)
{
}

function send_data($user_id, $mission_id, $mission_text, $pictures)
{
	require_once('db.php');
	
	$query = $db->prepare('SELECT id FROM missions WHERE id = ' . $mission_id);
	$query->execute();
	
	if ($query->rowCount())
	{
		// Crée le dossier pour les images
		$image_path = 'images/' . $user_id . '/' . $mission_id;
		
		if (!file_exists($image_path))
		{
			if(@mkdir ($image_path, 0777, true))
			{
				echo 'Dossier crée !';
			}
			else
			{
				echo 'Problème lors de la création du dossier !';
			}
			
			// On insert dans la base de donnée
			$insert = $db->prepare('INSERT INTO mission_responses (mission_id, text) VALUES (?,?)');
			$insert->execute(array($mission_id, $mission_text));
			
			return json_encode(array('send_data' => false));
		}
	}
	else
	{
		return json_encode(array('send_data' => false));
	}
}

function miss_mission($cookie, $id_mission)
{
}