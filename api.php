<?php

<<<<<<< Updated upstream
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
	require_once('db.php');

	$db->update('
	UPDATE missions
	SET is_hidden=1 user_id='."{$cookie}",
	WHERE id_mission='."${id_mission}";
	
	$db->update('
	UPDATE users
	SET mission_in_progress=1
	WHERE id_user='."${cookie}";
}

function send_data($mission_id_mission_text_pictures)
{
}

function miss_mission($cookie, $id_mission)
{
}