<?php

function GetMissions()
{
	require_once('db.php');
	
	$result = array();
	$query = $db->query('SELECT * FROM missions WHERE is_hidden = 0');
	
	$result = $query->fetchAll();
	
	return $result;
}

function fetchAll($table)
{
	require_once('db.php');
	
	$result = array();

	$query = $db->query('SELECT * FROM ' . $table);
	
	$result = $query->fetchAll();
	
	return $result;
}

function EncodeImage($path)
{
	$image_file = fopen($path, 'r');
	$image_data = fread($image_file, filesize($path));

	return json_encode(base64_encode($image_data));
}