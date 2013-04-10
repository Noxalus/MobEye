<?php

function GetMissions()
{
	require('db.php');
	
	$result = array();
	$query = $db->query('SELECT * FROM missions WHERE is_hidden = 0');
	
	$result = $query->fetchAll();
	
	return $result;
}

function fetchAll($table)
{
	require('db.php');
	
	$result = array();

	$query = $db->query('SELECT * FROM ' . $table);
	
	$result = $query->fetchAll();
	
	return $result;
}

function print_t($array)
{
	echo '<pre>';
	print_r(json_decode($array));
	echo '</pre>';
}

function EncodeImage($path)
{
	$image_file = fopen($path, 'r');
	$image_data = fread($image_file, filesize($path));

	return base64_encode($image_data);
}