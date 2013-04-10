<?php

function login($email_password)
{
	$arg = json_decode($email_password, true);
	
	require_once('db.php');
	
	$result = array();
	$query = $db->query("SELECT id FROM  users WHERE email='" . $arg['email'] . "' && password='" .$arg['password'] ."'");
	
	if ($query->rowCount() == 0)
	{
		return json_encode(array('login' => false));
	}
	else
	{
		$id = $query->fetch()['id'];
		
		$db->exec('UPDATE users SET logins = logins + 1 WHERE id=' . $id);
		
		$insert = $db->prepare('
		INSERT INTO 
		user_tokens (
			user_id, 
			user_agent, 
			token, 
			created, 
			expires) 
		VALUES (?,?,?,NOW(),?))');

		$insert->execute(array($id, $_SERVER['HTTP_USER_AGENT'], md5(uniqid(rand(), true))));
		
		return json_encode(array('login' => true));
	}
}

function is_login($cookie)
{
}

function logout($cookie)
{
}

function new_user($email_password_first_name_last_name_birth_date_place)
{
}

function get_missions()
{
	include 'functions';
	
	$result = GetMissions();
	
	return json_encode($result);
}

function get_user($cookie)
{
}

function accept_mission($cookie, $id_mission)
{
	require('db.php');

	$request = '
	UPDATE missions
	SET is_hidden = :is_hidden, user_id = :id_user
	WHERE id = :id_mission';
	
	$requestResult = $db->prepare($request);
	$requestResult->execute(array(
								'is_hidden' => '1',
								'id_user' => $cookie,
								'id_mission' => $id_mission));
								
	$request = '
	UPDATE users
	SET mission_in_progress = :mission_in_progress
	WHERE id = :id_user';
	
	$requestResult = $db->prepare($request);
	$requestResult->execute(array(
								'mission_in_progress' => '1',
								'id_user' => $cookie));
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
	require('db.php');

	$request = '
	UPDATE missions
	SET is_hidden = :is_hidden, user_id = :id_user
	WHERE id = :id_mission';
	
	$requestResult = $db->prepare($request);
	$requestResult->execute(array(
								'is_hidden' => '0',
								'id_user' => '0',
								'id_mission' => $id_mission));
								
	$request = '
	UPDATE users
	SET mission_in_progress = :mission_in_progress
	WHERE id = :id_user';
	
	$requestResult = $db->prepare($request);
	$requestResult->execute(array(
								'mission_in_progress' => '0',
								'id_user' => $cookie));
}