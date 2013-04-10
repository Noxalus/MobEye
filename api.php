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
		VALUES (?,?,?,NOW(),?)');

		$date = new DateTime();
		$date->add(new DateInterval('PT4H'));
	
		$insert->execute(array($id, $_SERVER['HTTP_USER_AGENT'], md5(uniqid(rand(), true)), $date->format('Y-m-d H:i:s')));
		
		return json_encode(array('login' => true));
	}
}

function is_login($cookie)
{
	require_once('db.php');
	
	$query = $db->query("SELECT expires FROM user_tokens WHERE id='" . $cookie . "'");
	
	$dateNow = new DateTime();
	$interval = $dateNow->diff(DateTime::CreateFromFormat('Y-m-d H:i:s', $query->fetch()['expires']));
	
	if ($query->rowCount() == 0 || $interval->invert == 1)
	{
		return json_encode(array('login' => false));
	}
	else
	{
		return json_encode(array('login' => true));
	}
}

function logout($cookie)
{
	require_once('db.php');
	
	$query = $db->exec("DELETE FROM user_tokens WHERE id='" . $cookie . "'");
	
	if ($query)
	{
		return json_encode(array('logout' => true));
	}
	else
	{
		return json_encode(array('logout' => false));
	}
}

function new_user($email_password_first_name_last_name_birth_date_place)
{
	$arg = json_decode($email_password_first_name_last_name_birth_date_place, true);
	
	require_once('db.php');
		
	$insert = $db->prepare('
		INSERT INTO 
		users (
			email, 
			password, 
			first_name, 
			last_name, 
			birth_date,
			place,
			registered_at) 
		VALUES (?,?,?,?,?,?,NOW())');
	

	$result = $insert->execute(array($arg['email'], $arg['password'], $arg['first_name'], $arg['last_name'], $arg['birth_date'], $arg['place']));
	
	if ($result) {
	
		$user_path = 'Users/' . $db->lastInsertId();
		
		if (!file_exists($user_path))
		{
			if(@mkdir ($user_path, 0777, true))
			{
				echo 'Dossier crée !';
			}
			else
			{
				echo 'Problème lors de la création du dossier !';
			}
		}
		return json_encode(array('new_user' => true));
	}
	else {
		return json_encode(array('new_user' => false));
	}
}

function get_missions()
{
	require_once 'functions.php';
	
	$result = GetMissions();
	
	return json_encode($result);
}

function get_user($cookie)
{
	require_once('db.php');
	
	$result = array();
	$query = $db->query("SELECT user_id FROM  user_tokens WHERE id='" . $cookie . "'");
	$user_id = $query->fetch()['user_id'];
	
	$query = $db->query("SELECT * FROM  users WHERE id='" . $user_id . "'");
	
	return json_encode($query->fetchAll());
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
	require('db.php');
	
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
			
			foreach($pictures as $img)
			{
				echo 'TEST<br />';
				echo $img;
				$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);
				$file = uniqid() . '.png';
				$success = file_put_contents($image_path . '/' . $file, $data);
				print $success ? $file : 'Unable to save the file.';
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